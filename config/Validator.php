<?php

/**
 * Validator Class
 * Input validation helper
 */

class Validator {
    
    private $errors = [];
    private $data = [];

    /**
     * Validate required field
     */
    public function required($field, $value, $fieldName = null) {
        if (empty($value) && $value !== '0') {
            $this->errors[$field] = ($fieldName ?? $field) . " is required";
            return false;
        }
        return true;
    }

    /**
     * Validate email
     */
    public function email($field, $value, $fieldName = null) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = ($fieldName ?? $field) . " must be a valid email address";
            return false;
        }
        return true;
    }

    /**
     * Validate minimum length
     */
    public function minLength($field, $value, $min, $fieldName = null) {
        if (strlen($value) < $min) {
            $this->errors[$field] = ($fieldName ?? $field) . " must be at least {$min} characters";
            return false;
        }
        return true;
    }

    /**
     * Validate maximum length
     */
    public function maxLength($field, $value, $max, $fieldName = null) {
        if (strlen($value) > $max) {
            $this->errors[$field] = ($fieldName ?? $field) . " must not exceed {$max} characters";
            return false;
        }
        return true;
    }

    /**
     * Validate date format
     */
    public function date($field, $value, $format = 'Y-m-d', $fieldName = null) {
        $d = DateTime::createFromFormat($format, $value);
        if (!$d || $d->format($format) !== $value) {
            $this->errors[$field] = ($fieldName ?? $field) . " must be a valid date";
            return false;
        }
        return true;
    }

    /**
     * Validate time format
     */
    public function time($field, $value, $format = 'H:i', $fieldName = null) {
        $t = DateTime::createFromFormat($format, $value);
        if (!$t || $t->format($format) !== $value) {
            $this->errors[$field] = ($fieldName ?? $field) . " must be a valid time";
            return false;
        }
        return true;
    }

    /**
     * Validate that value is in array
     */
    public function inArray($field, $value, $array, $fieldName = null) {
        if (!in_array($value, $array)) {
            $this->errors[$field] = ($fieldName ?? $field) . " has an invalid value";
            return false;
        }
        return true;
    }

    /**
     * Validate unique value in database
     */
    public function unique($field, $value, $table, $column, $con, $excludeId = null, $fieldName = null) {
        try {
            $query = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = ?";
            if ($excludeId) {
                $query .= " AND id != ?";
            }
            
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $value);
            
            if ($excludeId) {
                $stmt->bindParam(2, $excludeId);
            }
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['count'] > 0) {
                $this->errors[$field] = ($fieldName ?? $field) . " is already taken";
                return false;
            }
            
            return true;
        } catch (PDOException $ex) {
            Logger::error("Validation unique check failed: " . $ex->getMessage());
            return false;
        }
    }

    /**
     * Get all errors
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Check if validation passed
     */
    public function passes() {
        return empty($this->errors);
    }

    /**
     * Check if validation failed
     */
    public function fails() {
        return !empty($this->errors);
    }

    /**
     * Get first error message
     */
    public function getFirstError() {
        return !empty($this->errors) ? reset($this->errors) : null;
    }

    /**
     * Add custom error
     */
    public function addError($field, $message) {
        $this->errors[$field] = $message;
    }
}
