# 🏠 Sentinel Safe - Home Security System

<div align="center">

![Sentinel Safe Logo](images/logo.png)

**Advanced Home Security & Visitor Management System**

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange.svg)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.3-purple.svg)](https://getbootstrap.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

[Features](#features) • [Installation](#installation) • [Usage](#usage) • [Technologies](#technologies) • [Contact](#contact)

</div>

---

## 📋 Table of Contents

- [About](#about)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Security Features](#security-features)
- [Database Schema](#database-schema)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

---

## 🎯 About

**Sentinel Safe** is a comprehensive home security system designed to provide peace of mind through advanced visitor monitoring and management. Built with modern web technologies, it offers real-time tracking, detailed reporting, and an intuitive interface for both homeowners and security personnel.

Whether you're managing a residential property, gated community, or commercial facility, Sentinel Safe delivers professional-grade security features in an easy-to-use package.

### Why Sentinel Safe?

- ✅ **Real-time Monitoring** - Track all visitors as they enter and exit
- ✅ **Comprehensive Records** - Maintain detailed visitor logs with timestamps
- ✅ **Instant Alerts** - Get notified of reported or suspicious visitors
- ✅ **PDF Reports** - Generate professional visitor reports
- ✅ **User-Friendly** - Intuitive dashboard with actionable insights
- ✅ **Secure** - Enterprise-grade security with CSRF protection, XSS prevention, and more

---

## ✨ Features

### 🔐 Authentication & Security
- **Secure User Registration** - Password strength validation and encryption
- **Protected Login System** - Rate limiting to prevent brute force attacks
- **CSRF Protection** - All forms protected against cross-site request forgery
- **XSS Prevention** - Input sanitization and output escaping
- **Session Management** - Secure session handling with HttpOnly cookies

### 👥 Visitor Management
- **Add Visitors** - Quick and easy visitor registration
- **Edit Records** - Update visitor information as needed
- **Delete Entries** - Remove outdated or incorrect records
- **Search & Filter** - Find visitors by name, date, or status
- **Status Tracking** - Monitor check-in, check-out, and reported visitors

### 📊 Dashboard & Analytics
- **Statistics Overview** - Total visitors, monthly trends, and status breakdown
- **Visual Charts** - Easy-to-read data visualization
- **Quick Actions** - Access frequently used features instantly
- **Activity Monitoring** - Track all system activities

### 📄 Reporting & Export
- **PDF Generation** - Create professional visitor reports
- **Export Data** - Download visitor records for external use
- **Custom Reports** - Filter and generate reports by date range

### 📧 Notifications
- **Email Alerts** - Automatic notifications for visitor check-ins
- **Emergency Alerts** - Instant notifications for reported visitors
- **SMTP Integration** - Professional email delivery system

### 📝 Logging & Audit
- **Activity Logs** - Track all user actions
- **Security Logs** - Monitor authentication events
- **Error Logs** - Debug and troubleshoot issues
- **Daily Rotation** - Automatic log file management

---

## 🛠️ Technologies Used

### Backend
- **PHP 8.2+** - Server-side scripting language
- **MySQL / MariaDB** - Relational database management
- **PDO** - Secure database abstraction layer
- **FPDF** - PDF generation library

### Frontend
- **HTML5 / CSS3** - Modern web standards
- **Bootstrap 5.3.3** - Responsive UI framework
- **JavaScript** - Client-side interactivity
- **Font Awesome** - Icon library
- **AOS** - Scroll animations

### Security
- **Bcrypt** - Password hashing algorithm
- **CSRF Tokens** - Request validation
- **Input Validation** - Data sanitization framework
- **Rate Limiting** - Brute force protection

---

## 📥 Installation

### Prerequisites

Before installing Sentinel Safe, ensure you have:

- **Web Server** - Apache 2.4+ or Nginx
- **PHP** - Version 8.2 or higher
- **MySQL** - Version 5.7+ or MariaDB 10.4+
- **Composer** (optional) - For dependency management

### Step-by-Step Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/jeyapragash1/Home-Security-system.git
   cd Home-Security-system
   ```

2. **Configure Web Server**
   
   **For XAMPP/WAMP:**
   - Copy the project folder to `htdocs` directory
   - Start Apache and MySQL services
   
   **For Linux:**
   ```bash
   sudo cp -r Home-Security-system /var/www/html/
   sudo chown -R www-data:www-data /var/www/html/Home-Security-system
   ```

3. **Create Database**
   
   Open phpMyAdmin or MySQL command line:
   ```sql
   CREATE DATABASE home_security_system;
   ```

4. **Import Database Schema**
   ```bash
   mysql -u root -p home_security_system < database_query/home-security-system.sql
   ```

5. **Configure Environment**
   
   Create a `.env` file in the project root:
   ```env
   # Database Configuration
   DB_HOST=localhost
   DB_NAME=home_security_system
   DB_USER=root
   DB_PASS=your_password
   
   # Application Settings
   APP_NAME="Sentinel Safe"
   APP_ENV=development
   APP_DEBUG=true
   
   # Session Settings
   SESSION_LIFETIME=7200
   
   # Email Configuration (Optional)
   SMTP_HOST=smtp.gmail.com
   SMTP_PORT=587
   SMTP_USER=your_email@gmail.com
   SMTP_PASS=your_app_password
   SMTP_FROM_EMAIL=your_email@gmail.com
   SMTP_FROM_NAME="Sentinel Safe"
   ```

6. **Set Permissions**
   ```bash
   chmod 755 -R .
   chmod 777 logs/
   ```

7. **Access the Application**
   
   Open your browser and navigate to:
   ```
   http://localhost/Home-Security-system/
   ```

8. **Create Your Account**
   - Click "Sign Up" on the homepage
   - Fill in your details with a strong password
   - Login and start managing visitors!

---

## ⚙️ Configuration

### Environment Variables

The `.env` file contains all configuration options:

| Variable | Description | Default |
|----------|-------------|---------|
| `DB_HOST` | Database host address | localhost |
| `DB_NAME` | Database name | home_security_system |
| `DB_USER` | Database username | root |
| `DB_PASS` | Database password | - |
| `APP_ENV` | Environment (development/production) | development |
| `APP_DEBUG` | Enable debug mode | true |
| `SESSION_LIFETIME` | Session timeout (seconds) | 7200 |
| `SMTP_HOST` | Email server host | smtp.gmail.com |
| `SMTP_PORT` | Email server port | 587 |

### Email Configuration (Optional)

To enable email notifications:

1. Enable SMTP in your email provider
2. Generate an app-specific password (for Gmail)
3. Update `.env` with your SMTP credentials
4. Test email functionality in the dashboard

---

## 🚀 Usage

### For Homeowners

1. **Sign Up** - Create your account
2. **Login** - Access your dashboard
3. **Add Visitors** - Register incoming visitors
4. **Monitor** - View real-time statistics
5. **Report** - Flag suspicious visitors
6. **Export** - Generate PDF reports

### For Security Personnel

1. **Check-In Visitors** - Log arrivals with timestamps
2. **Update Status** - Mark visitors as checked-out
3. **Search Records** - Find specific visitor information
4. **Generate Reports** - Create daily/monthly summaries
5. **Review Alerts** - Check reported visitor notifications

### Common Tasks

#### Adding a Visitor
1. Navigate to dashboard
2. Click "Add New Visitor"
3. Fill in visitor details (name, purpose, contact)
4. Submit the form
5. Visitor receives automatic email notification

#### Generating Reports
1. Go to "Visitor Data" page
2. Select date range or filters
3. Click "Export PDF"
4. Download or print the report

#### Searching Visitors
1. Use the search bar on the dashboard
2. Enter visitor name, date, or status
3. View filtered results
4. Click on any entry to edit

---

## 🔒 Security Features

Sentinel Safe implements industry-standard security practices:

### Authentication Security
- ✅ Bcrypt password hashing with cost factor 12
- ✅ Password strength requirements (8+ chars, uppercase, lowercase, number, special char)
- ✅ Rate limiting (5 failed attempts = 15-minute lockout)
- ✅ Session regeneration on login
- ✅ Secure cookie flags (HttpOnly, Secure, SameSite)

### Input Protection
- ✅ CSRF token validation on all forms
- ✅ XSS prevention via output escaping
- ✅ SQL injection protection with prepared statements
- ✅ Input sanitization and validation
- ✅ Type-safe database queries

### Data Protection
- ✅ Environment-based configuration (.env)
- ✅ No hardcoded credentials in code
- ✅ Secure session storage
- ✅ Comprehensive audit logging
- ✅ IP address tracking

### Best Practices
- ✅ OWASP Top 10 compliance
- ✅ Separation of concerns
- ✅ Error handling without information disclosure
- ✅ Regular security updates
- ✅ Code review and testing

---

## 🗄️ Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Visitors Table
```sql
CREATE TABLE visitors (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    nic VARCHAR(20),
    contact VARCHAR(15),
    address TEXT,
    purpose VARCHAR(255),
    date DATE NOT NULL,
    time TIME NOT NULL,
    status ENUM('checked_in', 'checked_out', 'reported') DEFAULT 'checked_in',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

---

## 🤝 Contributing

We welcome contributions to Sentinel Safe! Here's how you can help:

### How to Contribute

1. **Fork the Repository**
   ```bash
   git clone https://github.com/jeyapragash1/Home-Security-system.git
   ```

2. **Create a Feature Branch**
   ```bash
   git checkout -b feature/amazing-feature
   ```

3. **Make Your Changes**
   - Write clean, documented code
   - Follow existing code style
   - Add comments where necessary

4. **Test Thoroughly**
   - Test all new features
   - Ensure no existing functionality breaks
   - Check for security vulnerabilities

5. **Commit Your Changes**
   ```bash
   git commit -m "Add amazing feature"
   ```

6. **Push to Your Fork**
   ```bash
   git push origin feature/amazing-feature
   ```

7. **Open a Pull Request**
   - Describe your changes clearly
   - Reference any related issues
   - Wait for review and feedback

### Code Guidelines

- Use consistent indentation (4 spaces)
- Comment complex logic
- Follow PSR-12 coding standards for PHP
- Validate all user inputs
- Write secure, OWASP-compliant code

---

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

### MIT License Summary

✅ Commercial use  
✅ Modification  
✅ Distribution  
✅ Private use  

❌ Liability  
❌ Warranty  

---

## 📞 Contact

**Jeyapragash**

- 📧 Email: [kishojeyapragash15@gmail.com](mailto:kishojeyapragash15@gmail.com)
- 🐙 GitHub: [@jeyapragash1](https://github.com/jeyapragash1)
- 💼 LinkedIn: [Connect with me](https://www.linkedin.com/in/jeyapragash)

### Support

If you encounter any issues or have questions:

1. **Check Documentation** - Review this README thoroughly
2. **Search Issues** - Look for similar problems in GitHub Issues
3. **Open an Issue** - Create a detailed bug report or feature request
4. **Email Support** - Contact directly for urgent matters

---

## 🙏 Acknowledgments

Special thanks to:

- **Bootstrap Team** - For the amazing UI framework
- **FPDF Library** - For PDF generation capabilities
- **Font Awesome** - For beautiful icons
- **AOS Library** - For smooth scroll animations
- **Open Source Community** - For continuous inspiration and support

---

## 📊 Project Stats

- **Lines of Code:** 5,000+
- **Files:** 40+
- **Languages:** PHP, JavaScript, CSS, SQL
- **Security Features:** 10+
- **Active Development:** Yes
- **Last Updated:** January 2026

---

## 🚀 Roadmap

### Planned Features

- [ ] Mobile app (Android/iOS)
- [ ] Real-time notifications with WebSockets
- [ ] Facial recognition integration
- [ ] QR code visitor check-in
- [ ] Multi-language support
- [ ] Advanced analytics dashboard
- [ ] API for third-party integrations
- [ ] Two-factor authentication (2FA)

---

<div align="center">

### ⭐ Star this repository if you find it helpful!

**Made with ❤️ by Jeyapragash**

[⬆ Back to Top](#-sentinel-safe---home-security-system)

</div>
