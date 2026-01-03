<?php
require_once 'classes/DbConnector.php';
require_once 'classes/Visitor.php';
require_once 'classes/EmailService.php';
require_once 'config/Security.php';
require_once 'config/Validator.php';
require_once 'config/Logger.php';

Security::configureSession();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    Logger::security("Unauthorized access attempt to saveVisitor.php", ['ip' => $_SERVER['REMOTE_ADDR']]);
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['error_message'] = "Invalid request method";
    header("Location: visitorData.php");
    exit();
}

// Verify CSRF token
if (!isset($_POST['csrf_token']) || !Security::verifyCSRFToken($_POST['csrf_token'])) {
    Logger::security("CSRF token validation failed for visitor save", [
        'user_id' => $_SESSION['user_id'] ?? 'unknown',
        'ip' => $_SERVER['REMOTE_ADDR']
    ]);
    $_SESSION['error_message'] = "Invalid request. Please try again.";
    header("Location: visitorData.php");
    exit();
}

// Sanitize inputs
$name = Security::sanitizeInput($_POST['name'] ?? '');
$date = Security::sanitizeInput($_POST['date'] ?? '');
$time = Security::sanitizeInput($_POST['time'] ?? '');
$reason = Security::sanitizeInput($_POST['reason'] ?? '');
$action = Security::sanitizeInput($_POST['action'] ?? '');

// Validate inputs
$validator = new Validator();

$validator->required('name', $name, 'Visitor name');
$validator->maxLength('name', $name, 255, 'Visitor name');

$validator->required('date', $date, 'Date');
$validator->date('date', $date, 'Y-m-d', 'Date');

$validator->required('time', $time, 'Time');
$validator->time('time', $time, 'H:i', 'Time');

$validator->required('reason', $reason, 'Reason');
$validator->maxLength('reason', $reason, 300, 'Reason');

$validator->required('action', $action, 'Action');
$validator->inArray('action', $action, ['checked_in', 'checked_out', 'reported'], 'Action');

if ($validator->fails()) {
    $_SESSION['error_message'] = $validator->getFirstError();
    Logger::warning("Visitor validation failed", ['errors' => $validator->getErrors()]);
    header("Location: visitorData.php");
    exit();
}

try {
    $visitor = new Visitor($name, $date, $time, $reason, $action);
    
    $dbcon = new DbConnector();
    $con = $dbcon->getConnection();        

    if ($visitor->addVisitor($con)) {
        $_SESSION['success_message'] = "Visitor data saved successfully";
        
        Logger::activity($_SESSION['user_id'], 'ADD_VISITOR', "Added visitor: {$name}");
        Logger::info("Visitor added successfully", [
            'visitor_name' => $name,
            'action_taken' => $action,
            'user_id' => $_SESSION['user_id']
        ]);
        
        // Send email notification for reported visitors or checked-in visitors
        if ($action === 'reported' || $action === 'checked_in') {
            try {
                $emailService = new EmailService();
                $visitorData = [
                    'name' => $name,
                    'date' => $date,
                    'time' => $time,
                    'reason' => $reason,
                    'action_taken' => $action
                ];
                
                // Get user's email for notification
                $userEmail = $_SESSION['email'] ?? null;
                
                if ($userEmail) {
                    if ($action === 'reported') {
                        $emailService->sendEmergencyAlert(
                            $userEmail,
                            "A suspicious visitor '{$name}' has been reported. Reason: {$reason}"
                        );
                    } else {
                        $emailService->sendVisitorNotification($userEmail, $visitorData);
                    }
                    Logger::info("Email notification sent for visitor", ['action' => $action]);
                }
            } catch (Exception $e) {
                // Log email error but don't fail the request
                Logger::error("Failed to send email notification: " . $e->getMessage());
            }
        }
    } else {
        $_SESSION['error_message'] = "Error saving visitor data";
        Logger::error("Failed to save visitor data", ['visitor_name' => $name]);
    }
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Database error occurred";
    Logger::error("Database error in saveVisitor: " . $e->getMessage());
} catch (Exception $e) {
    $_SESSION['error_message'] = "An error occurred while saving visitor data";
    Logger::error("Error in saveVisitor: " . $e->getMessage());
}

// Redirect back to the visitor data page
header("Location: visitorData.php");
exit();