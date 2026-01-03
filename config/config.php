<?php

/**
 * Configuration Loader
 * Loads environment variables from .env file
 */

class Config {
    private static $config = [];
    private static $loaded = false;

    /**
     * Load environment variables from .env file
     */
    public static function load() {
        if (self::$loaded) {
            return;
        }

        $envFile = dirname(__DIR__) . '/.env';
        
        if (!file_exists($envFile)) {
            // Copy example file for first time setup
            $exampleFile = dirname(__DIR__) . '/.env.example';
            if (file_exists($exampleFile)) {
                copy($exampleFile, $envFile);
                chmod($envFile, 0600); // Secure the file
            } else {
                throw new Exception('.env file not found. Please create one from .env.example');
            }
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse KEY=VALUE
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Remove quotes from value
                $value = trim($value, '"\'');
                
                self::$config[$key] = $value;
                
                // Also set as environment variable
                putenv("$key=$value");
            }
        }

        self::$loaded = true;
    }

    /**
     * Get configuration value
     */
    public static function get($key, $default = null) {
        self::load();
        return self::$config[$key] ?? $default;
    }

    /**
     * Check if configuration key exists
     */
    public static function has($key) {
        self::load();
        return isset(self::$config[$key]);
    }
}

// Auto-load configuration
Config::load();
