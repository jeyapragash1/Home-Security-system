<?php

/**
 * Logger Class
 * Centralized error and activity logging
 */

class Logger {
    private static $logDir = null;

    /**
     * Initialize log directory
     */
    private static function init() {
        if (self::$logDir === null) {
            self::$logDir = dirname(__DIR__) . '/logs';
            
            if (!is_dir(self::$logDir)) {
                mkdir(self::$logDir, 0755, true);
            }
        }
    }

    /**
     * Write log message
     */
    private static function write($level, $message, $context = []) {
        self::init();
        
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' | Context: ' . json_encode($context) : '';
        
        $logMessage = "[{$timestamp}] [{$level}] {$message}{$contextStr}" . PHP_EOL;
        
        $filename = self::$logDir . '/' . date('Y-m-d') . '.log';
        
        file_put_contents($filename, $logMessage, FILE_APPEND);
    }

    /**
     * Log error
     */
    public static function error($message, $context = []) {
        self::write('ERROR', $message, $context);
    }

    /**
     * Log warning
     */
    public static function warning($message, $context = []) {
        self::write('WARNING', $message, $context);
    }

    /**
     * Log info
     */
    public static function info($message, $context = []) {
        self::write('INFO', $message, $context);
    }

    /**
     * Log debug
     */
    public static function debug($message, $context = []) {
        if (Config::get('APP_DEBUG', false) === 'true') {
            self::write('DEBUG', $message, $context);
        }
    }

    /**
     * Log security event
     */
    public static function security($message, $context = []) {
        self::write('SECURITY', $message, $context);
        
        // Also write to separate security log
        $filename = self::$logDir . '/security-' . date('Y-m-d') . '.log';
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' | Context: ' . json_encode($context) : '';
        $logMessage = "[{$timestamp}] {$message}{$contextStr}" . PHP_EOL;
        file_put_contents($filename, $logMessage, FILE_APPEND);
    }

    /**
     * Log user activity
     */
    public static function activity($userId, $action, $details = '') {
        $message = "User {$userId} - {$action}";
        if ($details) {
            $message .= " - {$details}";
        }
        
        self::write('ACTIVITY', $message);
        
        // Also write to separate activity log
        $filename = self::$logDir . '/activity-' . date('Y-m-d') . '.log';
        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        $logMessage = "[{$timestamp}] [IP: {$ip}] {$message}" . PHP_EOL;
        file_put_contents($filename, $logMessage, FILE_APPEND);
    }
}
