# Sentinel Safe - Home Security System 🏠🔒

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange.svg)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Security](https://img.shields.io/badge/Security-A%2B-brightgreen.svg)]()

A comprehensive, secure home security management system designed to enhance safety and communication between homeowners and their security personnel. Built with modern security practices, CSRF protection, input validation, and comprehensive logging.

## 🌟 Features

### Core Functionality
- ✅ **Visitor Management** - Complete CRUD operations for visitor records
- ✅ **Real-time Dashboard** - Live statistics and visitor tracking
- ✅ **Email Notifications** - Automatic alerts for visitors and emergencies
- ✅ **PDF Export** - Generate detailed visitor reports
- ✅ **Search & Filter** - Advanced visitor search with pagination
- ✅ **User Authentication** - Secure login with "Remember Me" functionality

### Security Features
- 🔒 **CSRF Protection** - All forms protected against Cross-Site Request Forgery
- 🔒 **XSS Prevention** - Output escaping and input sanitization
- 🔒 **SQL Injection Protection** - Prepared statements throughout
- 🔒 **Password Security** - Bcrypt hashing with strength requirements
- 🔒 **Rate Limiting** - Protection against brute force attacks
- 🔒 **Session Security** - HttpOnly, Secure, and SameSite cookie flags
- 🔒 **Comprehensive Logging** - Security events and user activities tracked

### Advanced Features
- 📧 **Email Notifications** - Automated alerts for visitors and emergencies
- 📊 **Dashboard Analytics** - Monthly statistics and visitor trends
- 🔍 **Advanced Search** - Search visitors by name or reason
- 📄 **PDF Reports** - Export visitor data with timestamps
- 🔐 **Password Validation** - Enforced strong password requirements
- 📝 **Audit Logging** - Complete activity tracking

## 🛠️ Technology Stack

### Backend
- **PHP 8.2+** - Server-side programming
- **MySQL/MariaDB** - Database management
- **PDO** - Secure database access
- **FPDF** - PDF generation

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Modern styling
- **Bootstrap 5.3.3** - Responsive framework
- **JavaScript** - Interactive features
- **AOS** - Scroll animations

## 📋 Requirements

- PHP 8.2 or higher
- MySQL 5.7+ or MariaDB 10.4+
- Apache/Nginx web server
- PHP Extensions: PDO, PDO_MySQL, mbstring, openssl

## 🚀 Quick Start

1. **Clone & Setup**
   ```bash
   git clone https://github.com/jeyapragash1/Home-Security-system.git
   cd Home-Security-system
   cp .env.example .env
   ```

2. **Configure Database**
   - Import `database_query/home-security-system.sql`
   - Edit `.env` with your database credentials

3. **Set Permissions**
   ```bash
   mkdir logs && chmod 755 logs
   chmod 600 .env
   ```

4. **Access Application**
   - Navigate to your domain
   - Sign up for a new account
   - Start managing visitors!

## 🔐 Security Features

- **CSRF Protection** on all forms
- **Rate Limiting** - 5 attempts, 15-minute lockout
- **Password Requirements** - 8+ chars, uppercase, lowercase, number, special char
- **Session Security** - Auto-regeneration, secure cookies
- **Input Validation** - All user input sanitized
- **Audit Logging** - Complete activity tracking

## 📁 Project Structure

```
Home-Security-system/
├── classes/           # PHP Classes (DbConnector, Visitor, EmailService)
├── config/            # Configuration (Security, Logger, Validator)
├── css/               # Stylesheets
├── database_query/    # SQL schema
├── logs/              # Application logs (auto-created)
├── .env               # Environment config (create from .env.example)
├── .gitignore        # Git ignore rules
└── *.php              # Application pages
```

## 🎯 Key Improvements

✨ **Production-Ready Features:**
- Environment-based configuration
- Comprehensive error handling
- Security logging and monitoring
- Email notification system
- Advanced search and pagination
- Password strength validation
- CSRF token protection
- Rate limiting for login attempts

## 🐛 Troubleshooting

**Database Connection Issues:**
- Check `.env` credentials
- Ensure MySQL is running
- Verify database exists

**CSRF Errors:**
- Clear cookies
- Check session configuration

**Email Not Sending:**
- Verify SMTP settings in `.env`
- For Gmail, enable "App Passwords"

## 📝 Logging

Logs stored in `logs/` directory:
- `YYYY-MM-DD.log` - General logs
- `security-YYYY-MM-DD.log` - Security events
- `activity-YYYY-MM-DD.log` - User activities

## 👤 Author

**Jeyapragash**
- Email: [kishojeyapragash15@gmail.com](mailto:kishojeyapragash15@gmail.com)
- GitHub: [@jeyapragash1](https://github.com/jeyapragash1)

## 📄 License

MIT License - see LICENSE file for details

---

**Made with ❤️ by Jeyapragash** | *Ensuring the security of your home with advanced monitoring and alert systems.*
