<?php

require_once './classes/DbConnector.php';
require_once './config/Security.php';
require_once './config/Logger.php';

Security::configureSession();

// Redirect if already logged in
if (isset($_SESSION['email']) || isset($_COOKIE['u_name'])) {
    header("location:dashboard.php");
    exit();
}

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location:login.php");
    exit();
}

// Verify CSRF token
if (!isset($_POST['csrf_token']) || !Security::verifyCSRFToken($_POST['csrf_token'])) {
    Logger::security("CSRF token validation failed for login attempt", ['ip' => $_SERVER['REMOTE_ADDR']]);
    $_SESSION['error_message'] = "Invalid request. Please try again.";
    header("location:login.php");
    exit();
}

// Sanitize input
$email = Security::sanitizeInput($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validate inputs
if (empty($email) || empty($password)) {
    $_SESSION['error_message'] = "Please enter both email and password.";
    header("location:login.php");
    exit();
}

// Check rate limiting
$rateLimitCheck = Security::checkRateLimit('login_' . $email);
if (is_array($rateLimitCheck) && isset($rateLimitCheck['locked'])) {
    $minutes = ceil($rateLimitCheck['remaining_time'] / 60);
    Logger::security("Login attempt blocked due to rate limiting", ['email' => $email, 'ip' => $_SERVER['REMOTE_ADDR']]);
    $_SESSION['error_message'] = "Too many failed login attempts. Please try again in {$minutes} minutes.";
    header("location:login.php");
    exit();
}

try {
    $dbcon = new DbConnector();
    $con = $dbcon->getConnection();

    $query = "SELECT * FROM users WHERE email = ?";
    $pstmt = $con->prepare($query);
    $pstmt->bindValue(1, $email);
    $pstmt->execute();

    $row = $pstmt->fetch(PDO::FETCH_OBJ);
    
    if (!empty($row)) {
        if (password_verify($password, $row->password)) {
            // Successful login - reset rate limit
            Security::resetRateLimit('login_' . $email);
            
            // Regenerate session ID to prevent session fixation
            Security::regenerateSession();
            
            // Set session variables
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $row->name;
            $_SESSION['user_id'] = $row->id;
            $_SESSION['username'] = $row->username;

            // Set secure "Remember Me" cookie if requested
            if (isset($_POST['checkbox'])) {
                Security::setSecureCookie('u_name', $row->username, time() + (86400 * 30)); // 30 days
                Security::setSecureCookie('name', $row->name, time() + (86400 * 30));
            }

            // Log successful login
            Logger::activity($row->id, 'LOGIN', 'Successful login');
            Logger::info("User logged in successfully", ['user_id' => $row->id, 'email' => $email]);

            $_SESSION['success_message'] = "Welcome back, " . htmlspecialchars($row->name) . "!";
            header("location:dashboard.php");
            exit();
        } else {
            // Invalid password
            Security::incrementRateLimit('login_' . $email);
            Logger::security("Failed login attempt - invalid password", ['email' => $email, 'ip' => $_SERVER['REMOTE_ADDR']]);
            $_SESSION['error_message'] = "Invalid email or password. Please try again.";
            header("location:login.php");
            exit();
        }
    } else {
        // User not found
        Security::incrementRateLimit('login_' . $email);
        Logger::security("Failed login attempt - user not found", ['email' => $email, 'ip' => $_SERVER['REMOTE_ADDR']]);
        $_SESSION['error_message'] = "Invalid email or password. Please try again.";
        header("location:login.php");
        exit();
    }
} catch (PDOException $ex) {
    Logger::error("Login database error: " . $ex->getMessage(), ['email' => $email]);
    $_SESSION['error_message'] = "System error. Please try again later.";
    header("location:login.php");
    exit();
} catch (Exception $ex) {
    Logger::error("Login error: " . $ex->getMessage(), ['email' => $email]);
    $_SESSION['error_message'] = "An error occurred. Please try again.";
    header("location:login.php");
    exit();
}
?>
