<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Logger.php';

/**
 * Email Service Class
 * Handles sending email notifications
 */

class EmailService {
    
    private $smtpHost;
    private $smtpPort;
    private $smtpUser;
    private $smtpPass;
    private $fromEmail;
    private $fromName;

    public function __construct() {
        $this->smtpHost = Config::get('SMTP_HOST');
        $this->smtpPort = Config::get('SMTP_PORT');
        $this->smtpUser = Config::get('SMTP_USER');
        $this->smtpPass = Config::get('SMTP_PASS');
        $this->fromEmail = Config::get('SMTP_FROM');
        $this->fromName = Config::get('SMTP_FROM_NAME');
    }

    /**
     * Send visitor notification email
     */
    public function sendVisitorNotification($toEmail, $visitorData) {
        $subject = "New Visitor: {$visitorData['name']}";
        
        $body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #2a2185; color: white; padding: 20px; text-align: center; }
                .content { background-color: #f9f9f9; padding: 20px; }
                .detail { margin: 10px 0; }
                .label { font-weight: bold; }
                .footer { text-align: center; padding: 20px; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Sentinel Safe - Visitor Notification</h2>
                </div>
                <div class='content'>
                    <p>A new visitor has been logged:</p>
                    <div class='detail'><span class='label'>Name:</span> {$visitorData['name']}</div>
                    <div class='detail'><span class='label'>Date:</span> {$visitorData['date']}</div>
                    <div class='detail'><span class='label'>Time:</span> {$visitorData['time']}</div>
                    <div class='detail'><span class='label'>Reason:</span> {$visitorData['reason']}</div>
                    <div class='detail'><span class='label'>Status:</span> {$visitorData['action_taken']}</div>
                </div>
                <div class='footer'>
                    <p>This is an automated notification from Sentinel Safe Home Security System</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        return $this->sendEmail($toEmail, $subject, $body);
    }

    /**
     * Send emergency alert
     */
    public function sendEmergencyAlert($toEmail, $message) {
        $subject = "🚨 EMERGENCY ALERT - Sentinel Safe";
        
        $body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #dc3545; color: white; padding: 20px; text-align: center; }
                .content { background-color: #fff3cd; padding: 20px; border: 2px solid #dc3545; }
                .footer { text-align: center; padding: 20px; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>🚨 EMERGENCY ALERT</h2>
                </div>
                <div class='content'>
                    <p><strong>An emergency has been reported at your property!</strong></p>
                    <p>{$message}</p>
                    <p><strong>Time:</strong> " . date('Y-m-d H:i:s') . "</p>
                    <p>Please take immediate action.</p>
                </div>
                <div class='footer'>
                    <p>Sentinel Safe Home Security System</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        return $this->sendEmail($toEmail, $subject, $body);
    }

    /**
     * Send generic email using PHPMailer or basic mail()
     */
    private function sendEmail($to, $subject, $body) {
        try {
            // Headers for HTML email
            $headers = [
                'MIME-Version: 1.0',
                'Content-type: text/html; charset=UTF-8',
                "From: {$this->fromName} <{$this->fromEmail}>",
                'Reply-To: ' . $this->fromEmail,
                'X-Mailer: PHP/' . phpversion()
            ];
            
            $result = mail($to, $subject, $body, implode("\r\n", $headers));
            
            if ($result) {
                Logger::info("Email sent successfully to {$to}");
                return true;
            } else {
                Logger::error("Failed to send email to {$to}");
                return false;
            }
            
        } catch (Exception $e) {
            Logger::error("Email sending error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send password reset email
     */
    public function sendPasswordReset($toEmail, $resetLink) {
        $subject = "Password Reset Request - Sentinel Safe";
        
        $body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #2a2185; color: white; padding: 20px; text-align: center; }
                .content { background-color: #f9f9f9; padding: 20px; }
                .button { background-color: #2a2185; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; margin: 20px 0; }
                .footer { text-align: center; padding: 20px; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Password Reset Request</h2>
                </div>
                <div class='content'>
                    <p>You have requested to reset your password. Click the button below to reset it:</p>
                    <a href='{$resetLink}' class='button'>Reset Password</a>
                    <p>If you didn't request this, please ignore this email.</p>
                    <p>This link will expire in 1 hour.</p>
                </div>
                <div class='footer'>
                    <p>Sentinel Safe Home Security System</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        return $this->sendEmail($toEmail, $subject, $body);
    }
}
