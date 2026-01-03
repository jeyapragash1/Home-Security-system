# Changelog

All notable changes to Sentinel Safe will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-01-03

### 🎉 Major Release - Production-Ready Security Update

This is a complete security overhaul transforming the project from a basic prototype to a production-ready, enterprise-grade security system.

### ✨ Added

#### Security Features
- **CSRF Protection**: All forms now include CSRF tokens to prevent Cross-Site Request Forgery attacks
- **Rate Limiting**: Login attempts limited to 5 per 15 minutes to prevent brute force attacks
- **Session Security**: Implemented HttpOnly, Secure, and SameSite cookie flags
- **Password Validation**: Enforced strong password requirements (8+ chars, uppercase, lowercase, number, special char)
- **Session Regeneration**: Session IDs regenerated on login to prevent session fixation
- **XSS Prevention**: All output properly escaped using htmlspecialchars()
- **Input Sanitization**: Comprehensive input validation and sanitization across all forms
- **SQL Injection Protection**: Enhanced prepared statements with proper parameter binding

#### Configuration & Infrastructure
- **Environment Configuration**: Created `.env` system for secure credential management
- **Config Class**: Centralized configuration loader for environment variables
- **Security Helper**: Comprehensive security utility class with common security functions
- **Logger System**: Multi-level logging (ERROR, WARNING, INFO, DEBUG, SECURITY, ACTIVITY)
- **Validator Class**: Reusable input validation with multiple validation rules

#### Features
- **Email Notifications**: Automated email alerts for visitor check-ins and emergencies
- **EmailService Class**: Professional email templates for notifications
- **Advanced Search**: Search visitors by name or reason with pagination support
- **Pagination System**: Efficient data retrieval with limit/offset pagination
- **Audit Logging**: Complete activity tracking for security and compliance
- **User Activity Logs**: Separate log files for user actions and security events

#### Documentation
- **Comprehensive README**: Professional project documentation with badges and detailed setup
- **SETUP_GUIDE.md**: Step-by-step installation instructions for all platforms
- **SECURITY.md**: Security policy, vulnerability reporting, and best practices
- **CHANGELOG.md**: Version history and detailed change tracking
- **.env.example**: Template configuration file with all options documented
- **.gitignore**: Proper exclusion of sensitive files and directories

### 🔒 Security Improvements

- **Database Connection**: Moved credentials from code to environment variables
- **PDO Attributes**: Added proper error mode, fetch mode, and disabled emulated prepares
- **Error Handling**: Implemented try-catch blocks throughout with proper error logging
- **Secure Cookies**: Added HttpOnly, Secure, and SameSite flags to all cookies
- **Password Hashing**: Already using bcrypt, now with configurable cost factor
- **Login Protection**: Implemented rate limiting with configurable thresholds
- **CSRF Validation**: Server-side token validation on all POST requests
- **Type Safety**: Proper type casting for database parameters

### 🐛 Fixed

- **Empty Style Attribute**: Removed empty `style=""` from image tag in index.php
- **Session Management**: Fixed session handling and cookie security
- **Error Messages**: Changed to generic messages that don't expose system details
- **Database Errors**: Improved error handling to prevent information disclosure
- **Case Sensitivity**: Fixed inconsistent file naming (visitor.php vs Visitor.php)
- **Authentication Flow**: Proper redirection and session verification
- **Cookie Expiration**: Fixed "Remember Me" functionality with proper expiration time (30 days)

### 🔄 Changed

#### Code Organization
- **DbConnector Class**: Complete rewrite with environment-based configuration
- **Visitor Class**: Added comprehensive logging and new search/pagination methods
- **Login Process**: Enhanced with CSRF protection, rate limiting, and better error handling
- **Sign Up Process**: Added password validation, email uniqueness check, and security logging
- **Save Visitor**: Implemented CSRF protection, input validation, and email notifications

#### User Experience
- **Error Messages**: Improved user-friendly error messages with specific validation feedback
- **Success Messages**: Added success notifications throughout the application
- **Form Labels**: Enhanced form accessibility with proper labels and autocomplete
- **Password Requirements**: Visual display of password rules during registration
- **Remember Me**: Changed from 30 seconds to 30 days (practical duration)

#### Performance
- **Database Queries**: Optimized with proper indexing and limit clauses
- **Pagination**: Implemented efficient data retrieval for large datasets
- **Session Management**: Improved session configuration and cleanup

### 📚 Documentation Updates

- Enhanced README with installation instructions, features list, and troubleshooting
- Created comprehensive setup guide for all platforms
- Added security policy and vulnerability reporting process
- Documented all environment variables and configuration options
- Added code comments and PHPDoc blocks throughout

### 🏗️ Infrastructure

- **Logs Directory**: Auto-created logs folder with proper permissions
- **Environment Files**: `.env.example` template for easy setup
- **Git Ignore**: Comprehensive .gitignore for security and cleanliness
- **Error Logging**: Separate log files for different log levels
- **Activity Tracking**: IP address logging and user action tracking

### 🎯 Code Quality

- **Consistent Naming**: Standardized class and method names
- **Error Handling**: Try-catch blocks throughout
- **Code Comments**: Added descriptive comments and documentation
- **Separation of Concerns**: Better organization of business logic
- **DRY Principle**: Eliminated code duplication with reusable classes

## [1.0.0] - 2024-08-06

### Initial Release

#### Features
- Basic visitor management (CRUD operations)
- Simple dashboard with visitor statistics
- PDF export functionality
- User authentication (login/signup)
- MySQL database integration
- Responsive design with Bootstrap

#### Security (Basic)
- Password hashing with bcrypt
- Prepared statements for database queries
- Session-based authentication

#### Known Issues (Addressed in 2.0.0)
- No CSRF protection
- Hardcoded database credentials
- No input validation
- No rate limiting
- Basic error handling
- No logging system

---

## Migration Guide from 1.x to 2.0

### Database
No schema changes required. The 2.0 version is backward compatible with the existing database structure.

### Configuration
1. Create `.env` file from `.env.example`
2. Move database credentials from `DbConnector.php` to `.env`
3. Configure email settings (optional)

### Code Changes
- Update all form submissions to include CSRF tokens
- Update file includes to use new config structure
- Clear all sessions and cookies (users will need to log in again)

### Security
- All users will need to reset passwords if they don't meet new requirements
- Existing sessions will be invalidated
- Cookie security flags will require HTTPS in production

---

## Upgrade Instructions

### From 1.x to 2.0

1. **Backup everything**
   ```bash
   mysqldump -u root -p home-security-system > backup.sql
   cp -r /path/to/project /path/to/project-backup
   ```

2. **Pull latest changes**
   ```bash
   git pull origin main
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   # Edit .env with your settings
   ```

4. **Create logs directory**
   ```bash
   mkdir logs
   chmod 755 logs
   chmod 600 .env
   ```

5. **Clear sessions**
   - Delete all session files
   - Users will need to log in again

6. **Test thoroughly**
   - Test login/signup
   - Test visitor management
   - Verify email notifications
   - Check logs are being written

---

## Version Support

| Version | Release Date | Support Status | End of Life |
|---------|-------------|----------------|-------------|
| 2.0.x   | 2026-01-03  | ✅ Supported   | TBD         |
| 1.x.x   | 2024-08-06  | ❌ Unsupported | 2026-01-03  |

---

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## Security

See [SECURITY.md](SECURITY.md) for our security policy and how to report vulnerabilities.

---

**Note**: This changelog focuses on security improvements and production readiness. For detailed commit history, see the Git log.
