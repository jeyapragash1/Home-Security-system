# Sentinel Safe - Complete Setup Guide

## Prerequisites

Before starting, ensure you have:
- PHP 8.2 or higher installed
- MySQL 5.7+ or MariaDB 10.4+ installed
- Apache or Nginx web server
- Git (for cloning the repository)

## Step-by-Step Installation

### 1. Download the Project

**Option A: Using Git**
```bash
git clone https://github.com/jeyapragash1/Home-Security-system.git
cd Home-Security-system
```

**Option B: Download ZIP**
1. Download ZIP from GitHub
2. Extract to your web server directory (e.g., `htdocs` for XAMPP)

### 2. Database Setup

**Using phpMyAdmin:**
1. Open phpMyAdmin (usually http://localhost/phpmyadmin)
2. Click "New" to create a database
3. Name it `home-security-system`
4. Select the database
5. Click "Import" tab
6. Choose file: `database_query/home-security-system.sql`
7. Click "Go"

**Using MySQL Command Line:**
```bash
mysql -u root -p
CREATE DATABASE IF NOT EXISTS `home-security-system`;
USE `home-security-system`;
SOURCE database_query/home-security-system.sql;
EXIT;
```

### 3. Environment Configuration

1. **Copy the example environment file:**
   ```bash
   cp .env.example .env
   ```

2. **Edit .env file** with your settings:
   ```env
   # Database Configuration
   DB_HOST=localhost
   DB_NAME=home-security-system
   DB_USER=root
   DB_PASS=your_mysql_password

   # Application
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=http://localhost/Home-Security-system

   # Email (Optional - for notifications)
   SMTP_HOST=smtp.gmail.com
   SMTP_PORT=587
   SMTP_USER=your.email@gmail.com
   SMTP_PASS=your_app_password
   SMTP_FROM=noreply@sentinelsafe.com
   ```

### 4. Set Permissions

**On Linux/Mac:**
```bash
# Create logs directory
mkdir logs

# Set permissions
chmod 755 logs/
chmod 600 .env
```

**On Windows:**
- Right-click `logs` folder → Properties → Security
- Ensure web server user has write permissions

### 5. Web Server Configuration

#### For XAMPP (Windows/Mac/Linux):

1. Place project in `htdocs` folder
2. Start Apache and MySQL from XAMPP Control Panel
3. Access: `http://localhost/Home-Security-system/`

#### For WAMP (Windows):

1. Place project in `www` folder
2. Start WAMP server
3. Access: `http://localhost/Home-Security-system/`

#### For Production (Apache):

Create `.htaccess` in project root:
```apache
# Force HTTPS
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>

# Protect sensitive files
<FilesMatch "\.(env|log|sql)$">
    Require all denied
</FilesMatch>

# Block directory listing
Options -Indexes

# Custom error pages
ErrorDocument 404 /404.html
ErrorDocument 500 /500.html
```

### 6. Email Configuration (Optional)

**For Gmail:**
1. Enable 2-Factor Authentication on your Gmail account
2. Generate App Password:
   - Go to Google Account → Security
   - Select "App passwords"
   - Generate password for "Mail"
3. Use this password in `.env` file for `SMTP_PASS`

**For Other Email Providers:**
- Update `SMTP_HOST`, `SMTP_PORT` accordingly
- Use appropriate authentication credentials

### 7. First Run

1. **Access the application:**
   ```
   http://localhost/Home-Security-system/
   ```

2. **Create your first account:**
   - Click "Sign Up"
   - Fill in all required fields
   - Password must meet security requirements:
     - At least 8 characters
     - 1 uppercase letter
     - 1 lowercase letter
     - 1 number
     - 1 special character

3. **Log in:**
   - Use your email and password
   - Optional: Check "Remember Me"

4. **Start using the system:**
   - Add visitors from the dashboard
   - View visitor statistics
   - Export reports to PDF

## Verification Checklist

- [ ] Database created and schema imported
- [ ] `.env` file configured with correct credentials
- [ ] `logs/` directory created with write permissions
- [ ] Web server running (Apache/Nginx)
- [ ] Can access homepage
- [ ] Can create user account
- [ ] Can log in successfully
- [ ] Can add visitor records
- [ ] Dashboard displays statistics

## Common Issues & Solutions

### Issue: "Can't connect to database"
**Solution:**
- Check `.env` credentials match your MySQL setup
- Ensure MySQL service is running
- Verify database `home-security-system` exists

### Issue: "Permission denied" for logs
**Solution:**
```bash
chmod 755 logs/
chown www-data:www-data logs/  # Linux
```

### Issue: "CSRF token mismatch"
**Solution:**
- Clear browser cookies
- Check PHP sessions are working
- Ensure `session.save_path` is writable

### Issue: "Email not sending"
**Solution:**
- Verify SMTP settings in `.env`
- Check firewall/port 587 is open
- For Gmail, use App Password (not regular password)

### Issue: "Blank page or errors"
**Solution:**
- Enable debug mode in `.env`: `APP_DEBUG=true`
- Check `logs/` directory for error details
- Verify PHP version is 8.2+
- Check PHP extensions: PDO, PDO_MySQL

## Security Recommendations

### For Development:
```env
APP_ENV=development
APP_DEBUG=true
SESSION_SECURE=false
```

### For Production:
```env
APP_ENV=production
APP_DEBUG=false
SESSION_SECURE=true
```

### Additional Security:
1. **Enable HTTPS** - Use Let's Encrypt for free SSL
2. **Change default database password**
3. **Set strong SESSION_SECRET** in `.env`
4. **Regular backups** of database
5. **Keep PHP and MySQL updated**

## Updating the Application

```bash
# Backup database first
mysqldump -u root -p home-security-system > backup.sql

# Pull latest changes
git pull origin main

# Clear any cached sessions
rm -rf sessions/*

# Check for new environment variables
diff .env .env.example
```

## Support

If you encounter issues:
1. Check this setup guide
2. Review error logs in `logs/` directory
3. Enable debug mode temporarily
4. Contact: kishojeyapragash15@gmail.com

## Next Steps

After successful installation:
1. Customize email templates in `classes/EmailService.php`
2. Adjust timezone in `.env` if needed
3. Configure backup schedule for database
4. Review security logs regularly
5. Set up monitoring/alerts for production

---

**Congratulations! Your Sentinel Safe system is ready to use!** 🎉
