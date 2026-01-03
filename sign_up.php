<!DOCTYPE html>
<?php
require './classes/DbConnector.php';
require './config/Security.php';
require './config/Validator.php';
require './config/Logger.php';

Security::configureSession();

$errors = [];
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !Security::verifyCSRFToken($_POST['csrf_token'])) {
        $errors[] = "Invalid request. Please try again.";
        Logger::security("CSRF token validation failed for signup", ['ip' => $_SERVER['REMOTE_ADDR']]);
    } else {
        // Sanitize inputs
        $name = Security::sanitizeInput($_POST['name'] ?? '');
        $username = Security::sanitizeInput($_POST['username'] ?? '');
        $email = Security::sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validate inputs
        $validator = new Validator();
        
        $validator->required('name', $name, 'Name');
        $validator->required('username', $username, 'Username');
        $validator->required('email', $email, 'Email');
        $validator->required('password', $password, 'Password');
        
        if (!empty($email) && !$validator->email('email', $email, 'Email')) {
            // Email validation failed
        }
        
        // Validate password strength
        if (!empty($password)) {
            $passwordErrors = Security::validatePassword($password);
            if (!empty($passwordErrors)) {
                foreach ($passwordErrors as $error) {
                    $validator->addError('password', $error);
                }
            }
        }
        
        // Check password confirmation
        if ($password !== $confirmPassword) {
            $validator->addError('confirm_password', 'Passwords do not match');
        }

        if ($validator->passes()) {
            try {
                $dbcon = new DbConnector();
                $con = $dbcon->getConnection();

                // Check if email already exists
                if (!$validator->unique('email', $email, 'users', 'email', $con, null, 'Email')) {
                    // Email already exists
                } elseif (!$validator->unique('username', $username, 'users', 'username', $con, null, 'Username')) {
                    // Username already exists
                } else {
                    // Hash password
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Insert new user
                    $query = "INSERT INTO users (name, username, email, password) VALUES (?, ?, ?, ?)";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(1, $name);
                    $stmt->bindParam(2, $username);
                    $stmt->bindParam(3, $email);
                    $stmt->bindParam(4, $hashedPassword);

                    if ($stmt->execute()) {
                        Logger::activity($con->lastInsertId(), 'SIGNUP', 'New user registered');
                        Logger::info("New user registered successfully", ['username' => $username, 'email' => $email]);
                        
                        $_SESSION['success_message'] = "Registration successful! You can now log in.";
                        header("Location: login.php");
                        exit();
                    } else {
                        $errors[] = "Registration failed. Please try again.";
                        Logger::error("User registration failed", ['username' => $username, 'email' => $email]);
                    }
                }
            } catch (PDOException $ex) {
                $errors[] = "Database error. Please try again later.";
                Logger::error("Registration database error: " . $ex->getMessage());
            }
        }
        
        $errors = array_merge($errors, array_values($validator->getErrors()));
    }
}
?>

<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Sign Up - Sentinel Safe</title>
        <link rel="stylesheet" href="css/login.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
        <style>
            .password-requirements {
                font-size: 0.85rem;
                color: #6c757d;
                margin-top: 5px;
            }
            .password-requirements ul {
                margin: 5px 0;
                padding-left: 20px;
            }
        </style>
    </head>

    <body>
        <div class="row vh-100 g-0">
            <!--left side-->
            <div class="col-lg-6 position-relative d-none d-lg-block">
                <p class="text-white position-absolute top-50 start-50 translate-middle fs-1 fw-bold text-center">
                    <a href="index.php" class="sentinel-safe-link">Sentinel Safe</a>
                </p>
                <p class="text-white position-absolute top-50 start-50 translate-middle fs-5 text-center mt-5">Your Gateway to Home Security</p>
                <div class="bg-holder" alt="" style="background-image: url('images/in.jpg');"></div>
            </div>

            <!--right side-->
            <div class="col-lg-6 d-flex align-items-center justify-content-center" style="padding: 20px">
                <div class="col-12 col-sm-8 col-lg-6">
                    <div class="text-center mb-4 mt-3">
                        <h3 class="fw-bold">Sign up</h3>
                        <p class="text-secondary">Create your account.</p>
                    </div>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo Security::escape($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!--form-->
                    <form action="<?php echo Security::escape($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <?php echo Security::csrfField(); ?>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo isset($_POST['name']) ? Security::escape($_POST['name']) : ''; ?>" 
                                   required autocomplete="name">
                        </div>
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?php echo isset($_POST['username']) ? Security::escape($_POST['username']) : ''; ?>" 
                                   required autocomplete="username">
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo isset($_POST['email']) ? Security::escape($_POST['email']) : ''; ?>" 
                                   required autocomplete="email">
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   required autocomplete="new-password">
                            <div class="password-requirements">
                                <small>Password must contain:</small>
                                <ul>
                                    <li>At least 8 characters</li>
                                    <li>One uppercase letter (A-Z)</li>
                                    <li>One lowercase letter (a-z)</li>
                                    <li>One number (0-9)</li>
                                    <li>One special character (!@#$%^&*)</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                   required autocomplete="new-password">
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Sign up</button>
                    </form>

                    <div class="text-center">
                        <small>Already have an account? <a href="login.php" class="fw-bold" style="text-decoration: none;">Login</a></small>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>

</html>
