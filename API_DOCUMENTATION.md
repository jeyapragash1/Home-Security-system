# API Documentation

## Overview

While Sentinel Safe is primarily a server-side rendered application, this document outlines the internal processing endpoints and their expected inputs/outputs.

## Authentication Endpoints

### POST /loginProcess.php

**Description**: Authenticates a user and creates a session.

**Request Body**:
```php
[
    'email' => 'user@example.com',
    'password' => 'SecurePass123!',
    'checkbox' => '1',  // Optional: Remember me
    'csrf_token' => 'generated_token'
]
```

**Success Response**:
- Redirect to `dashboard.php`
- Session variables set: `email`, `name`, `user_id`, `username`
- Optional: Secure cookies set (if "Remember Me" checked)

**Error Responses**:
- Invalid credentials → Redirect to `login.php` with error message
- Rate limit exceeded → Redirect to `login.php` with lockout message
- CSRF validation failed → Redirect to `login.php` with error

**Rate Limiting**:
- Max attempts: 5
- Lockout duration: 15 minutes

**Security**:
- ✅ CSRF token required
- ✅ Rate limiting enabled
- ✅ Password verification (bcrypt)
- ✅ Session regeneration
- ✅ Audit logging

---

### POST /sign_up.php

**Description**: Creates a new user account.

**Request Body**:
```php
[
    'name' => 'John Doe',
    'username' => 'johndoe',
    'email' => 'john@example.com',
    'password' => 'SecurePass123!',
    'confirm_password' => 'SecurePass123!',
    'csrf_token' => 'generated_token'
]
```

**Password Requirements**:
- Minimum 8 characters
- At least 1 uppercase letter
- At least 1 lowercase letter
- At least 1 number
- At least 1 special character

**Success Response**:
- Redirect to `login.php` with success message

**Error Responses**:
- Validation errors → Display on same page
- Email already exists → Error message
- Username already exists → Error message
- Password mismatch → Error message
- Weak password → Error with requirements

**Security**:
- ✅ CSRF token required
- ✅ Email uniqueness check
- ✅ Username uniqueness check
- ✅ Password strength validation
- ✅ Input sanitization
- ✅ Bcrypt hashing

---

### GET /logout.php

**Description**: Destroys user session and logs out.

**Success Response**:
- Redirect to `index.php`
- Session destroyed
- Cookies cleared

---

## Visitor Management Endpoints

### POST /saveVisitor.php

**Description**: Creates a new visitor record.

**Authentication**: Required (session)

**Request Body**:
```php
[
    'name' => 'Jane Smith',
    'date' => '2026-01-03',
    'time' => '14:30',
    'reason' => 'Meeting with homeowner',
    'action' => 'checked_in',  // Options: checked_in, checked_out, reported
    'csrf_token' => 'generated_token'
]
```

**Validation Rules**:
- `name`: Required, max 255 characters
- `date`: Required, valid date (Y-m-d format)
- `time`: Required, valid time (H:i format)
- `reason`: Required, max 300 characters
- `action`: Required, must be one of: checked_in, checked_out, reported

**Success Response**:
- Redirect to `visitorData.php` with success message
- Email notification sent (for reported or checked_in)
- Activity logged

**Error Responses**:
- Validation failed → Redirect with error message
- Database error → Redirect with generic error
- Unauthorized → Redirect to login

**Email Notifications**:
- Sent for: `checked_in`, `reported`
- Not sent for: `checked_out`

**Security**:
- ✅ CSRF token required
- ✅ Authentication required
- ✅ Input validation
- ✅ Input sanitization
- ✅ Audit logging

---

### POST /editProcess.php

**Description**: Updates an existing visitor record.

**Authentication**: Required (session)

**Request Body**:
```php
[
    'visitorId' => 123,
    'name' => 'Jane Smith',
    'date' => '2026-01-03',
    'time' => '14:30',
    'reason' => 'Updated reason',
    'action_taken' => 'checked_out',
    'csrf_token' => 'generated_token'
]
```

**Success Response**:
- Redirect to `editVisitor.php` with success message
- Activity logged

**Error Responses**:
- Invalid data → Redirect with error
- Visitor not found → Redirect with error
- Unauthorized → Redirect to login

**Security**:
- ✅ CSRF token required
- ✅ Authentication required
- ✅ Input validation
- ✅ Audit logging

---

### GET /deleteVisitor.php

**Description**: Deletes a visitor record.

**Authentication**: Required (session)

**Query Parameters**:
```
?id=123
```

**Success Response**:
- Redirect to `editVisitor.php` with success message
- Activity logged

**Error Responses**:
- Invalid ID → Redirect with error
- Visitor not found → Redirect with error
- Unauthorized → Redirect to login

**Security**:
- ⚠️ Note: Should use POST with CSRF token (enhancement needed)
- ✅ Authentication required
- ✅ Audit logging

---

## Data Retrieval Methods

### Visitor::getAllVisitors($con)

**Description**: Retrieves all visitors ordered by date and time.

**Parameters**:
- `$con` (PDO): Database connection object

**Returns**: Array of visitor records or `false` on error

**Example Response**:
```php
[
    [
        'visitorId' => 1,
        'name' => 'John Doe',
        'date' => '2026-01-03',
        'time' => '14:30:00',
        'reason' => 'Delivery',
        'action_taken' => 'checked_in'
    ],
    // ... more records
]
```

---

### Visitor::getVisitorsPaginated($con, $limit, $offset, $search, $filter)

**Description**: Retrieves paginated visitors with optional search and filter.

**Parameters**:
- `$con` (PDO): Database connection
- `$limit` (int): Number of records per page (default: 10)
- `$offset` (int): Starting record (default: 0)
- `$search` (string|null): Search term for name or reason
- `$filter` (string|null): Filter by action_taken

**Returns**: Array of visitor records

**Example Usage**:
```php
$visitors = Visitor::getVisitorsPaginated($con, 20, 0, 'delivery', 'checked_in');
```

---

### Visitor::getTotalVisitorsCount($con, $search, $filter)

**Description**: Gets total count of visitors (for pagination).

**Parameters**:
- `$con` (PDO): Database connection
- `$search` (string|null): Search term
- `$filter` (string|null): Filter by action_taken

**Returns**: Integer count

---

### Visitor::searchVisitors($con, $searchTerm)

**Description**: Searches visitors by name or reason.

**Parameters**:
- `$con` (PDO): Database connection
- `$searchTerm` (string): Search query

**Returns**: Array of matching visitor records

---

### Dashboard Statistics Methods

#### Visitor::getCheckedInCount($con)
Returns count of checked-in visitors for current month.

#### Visitor::getCheckedOutCount($con)
Returns count of checked-out visitors for current month.

#### Visitor::getReportedCount($con)
Returns count of reported visitors for current month.

#### Visitor::getTotalVisitorsCountMonthly($con)
Returns total visitors for current month.

#### Visitor::getRecentVisitors($con, $limit)
Returns most recent visitors (default: 10).

---

## Email Service

### EmailService::sendVisitorNotification($toEmail, $visitorData)

**Description**: Sends email notification for new visitor.

**Parameters**:
```php
[
    'toEmail' => 'homeowner@example.com',
    'visitorData' => [
        'name' => 'John Doe',
        'date' => '2026-01-03',
        'time' => '14:30',
        'reason' => 'Delivery',
        'action_taken' => 'checked_in'
    ]
]
```

**Returns**: Boolean (true on success, false on failure)

---

### EmailService::sendEmergencyAlert($toEmail, $message)

**Description**: Sends emergency alert email.

**Parameters**:
- `$toEmail` (string): Recipient email
- `$message` (string): Alert message

**Returns**: Boolean

**Email Template**: Red header, urgent styling, timestamp included

---

## Security Utilities

### Security::generateCSRFToken()

**Description**: Generates or retrieves CSRF token for current session.

**Returns**: String (32-byte hex token)

---

### Security::verifyCSRFToken($token)

**Description**: Verifies provided CSRF token against session token.

**Parameters**:
- `$token` (string): Token to verify

**Returns**: Boolean

---

### Security::escape($string)

**Description**: Escapes string for safe HTML output (XSS prevention).

**Parameters**:
- `$string` (string): String to escape

**Returns**: String (HTML-safe)

---

### Security::sanitizeInput($data)

**Description**: Sanitizes input data (removes tags, trims).

**Parameters**:
- `$data` (string|array): Input to sanitize

**Returns**: Sanitized string or array

---

### Security::validatePassword($password)

**Description**: Validates password strength.

**Parameters**:
- `$password` (string): Password to validate

**Returns**: Array of error messages (empty if valid)

---

### Security::checkRateLimit($identifier, $maxAttempts, $timeWindow)

**Description**: Checks if rate limit exceeded for identifier.

**Parameters**:
- `$identifier` (string): Unique identifier (e.g., 'login_user@email.com')
- `$maxAttempts` (int): Maximum attempts allowed (default: 5)
- `$timeWindow` (int): Time window in seconds (default: 900)

**Returns**: 
- `true` if allowed
- `['locked' => true, 'remaining_time' => seconds]` if locked

---

## Logging

### Logger::error($message, $context)
Logs error-level messages.

### Logger::warning($message, $context)
Logs warning-level messages.

### Logger::info($message, $context)
Logs info-level messages.

### Logger::security($message, $context)
Logs security events to both general and security-specific logs.

### Logger::activity($userId, $action, $details)
Logs user activities with IP address.

**Example**:
```php
Logger::activity(123, 'ADD_VISITOR', 'Added visitor: John Doe');
Logger::security('Failed login attempt', ['email' => 'user@example.com', 'ip' => '192.168.1.1']);
```

---

## Configuration

### Config::get($key, $default)

**Description**: Retrieves configuration value from .env file.

**Parameters**:
- `$key` (string): Configuration key
- `$default` (mixed): Default value if key not found

**Returns**: Configuration value

**Example**:
```php
$dbHost = Config::get('DB_HOST', 'localhost');
$appDebug = Config::get('APP_DEBUG', 'false');
```

---

## Error Codes

### HTTP Status Codes
- `200` - Success
- `302` - Redirect (used for all POST operations)
- `401` - Unauthorized (redirects to login)
- `403` - Forbidden (CSRF validation failed)
- `429` - Too Many Requests (rate limit exceeded)
- `500` - Internal Server Error

### Application Error Messages
- "Invalid request. Please try again." - CSRF validation failed
- "Too many failed login attempts." - Rate limit exceeded
- "Invalid email or password." - Authentication failed
- "All fields are required." - Validation failed
- "System error. Please try again later." - Database error

---

## Best Practices

### For Form Submissions
```php
<form method="POST" action="saveVisitor.php">
    <?php echo Security::csrfField(); ?>
    <!-- form fields -->
</form>
```

### For Output Display
```php
<p><?php echo Security::escape($userInput); ?></p>
```

### For Database Queries
```php
$stmt = $con->prepare("SELECT * FROM visitors WHERE name = ?");
$stmt->bindParam(1, $name);
$stmt->execute();
```

### For Logging
```php
Logger::activity($userId, 'ACTION_NAME', 'Description');
Logger::security('Security event', ['ip' => $_SERVER['REMOTE_ADDR']]);
```

---

## Rate Limiting

### Login Attempts
- **Limit**: 5 attempts per email
- **Window**: 15 minutes (900 seconds)
- **Reset**: Automatic after successful login
- **Storage**: PHP sessions

### Future Enhancements
- IP-based rate limiting
- API rate limiting
- Distributed rate limiting (Redis/Memcached)

---

## Changelog Endpoint Versions

| Endpoint | v1.0 | v2.0 |
|----------|------|------|
| loginProcess.php | Basic | + CSRF, Rate Limit, Logging |
| sign_up.php | Basic | + CSRF, Validation, Logging |
| saveVisitor.php | Basic | + CSRF, Email, Logging |
| editProcess.php | Basic | + CSRF, Logging |
| deleteVisitor.php | Basic | + Logging |

---

**Last Updated**: January 3, 2026  
**API Version**: 2.0.0
