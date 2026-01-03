# Security Policy

## Supported Versions

The following versions of Sentinel Safe are currently supported with security updates:

| Version | Supported          |
| ------- | ------------------ |
| 2.0.x   | :white_check_mark: |
| 1.x.x   | :x:                |

## Security Features

Sentinel Safe implements industry-standard security practices:

### Authentication & Authorization
- ✅ Bcrypt password hashing (cost factor: 10)
- ✅ Strong password requirements enforced
- ✅ Rate limiting on login attempts (5 attempts, 15-min lockout)
- ✅ Session management with secure cookies
- ✅ Session ID regeneration on login
- ✅ "Remember Me" with secure cookie flags

### Input Validation & Sanitization
- ✅ CSRF protection on all forms
- ✅ XSS prevention through output escaping
- ✅ SQL injection prevention (prepared statements)
- ✅ Input validation and sanitization
- ✅ Type-safe parameter binding

### Session Security
- ✅ HttpOnly cookie flag
- ✅ Secure flag (HTTPS)
- ✅ SameSite=Strict cookie attribute
- ✅ Session timeout (2 hours)
- ✅ Session regeneration on privilege escalation

### Data Protection
- ✅ Environment-based configuration
- ✅ Credentials stored in .env (not in code)
- ✅ Sensitive files protected (.env, .log, .sql)
- ✅ Database credentials encrypted in transit
- ✅ Comprehensive audit logging

### Logging & Monitoring
- ✅ Security event logging
- ✅ User activity tracking
- ✅ Failed login attempt logging
- ✅ Database error logging
- ✅ Separate security log files

## Reporting a Vulnerability

We take security seriously. If you discover a security vulnerability, please follow responsible disclosure:

### How to Report

**Email:** kishojeyapragash15@gmail.com

**Subject:** [SECURITY] Vulnerability Report - Sentinel Safe

**Include:**
1. Description of the vulnerability
2. Steps to reproduce
3. Potential impact
4. Suggested fix (if available)
5. Your contact information

### What to Expect

- **Acknowledgment:** Within 48 hours
- **Initial Assessment:** Within 7 days
- **Status Updates:** Weekly until resolved
- **Fix Timeline:** 
  - Critical: 7-14 days
  - High: 14-30 days
  - Medium: 30-60 days
  - Low: 60-90 days

### Disclosure Policy

- Please allow us reasonable time to fix the vulnerability before public disclosure
- We will acknowledge your contribution in our security advisories (if desired)
- We do not currently offer a bug bounty program

## Security Best Practices for Users

### For Administrators

1. **Environment Configuration**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   SESSION_SECURE=true
   ```

2. **Strong Passwords**
   - Use unique, complex passwords
   - Enable password managers
   - Rotate passwords regularly

3. **HTTPS Only**
   - Force HTTPS in production
   - Use valid SSL certificates
   - Enable HSTS headers

4. **Regular Updates**
   - Keep PHP updated (8.2+)
   - Update MySQL/MariaDB
   - Monitor security advisories

5. **Access Control**
   - Limit database user permissions
   - Use firewall rules
   - Restrict file permissions
   ```bash
   chmod 600 .env
   chmod 755 logs/
   ```

6. **Backup Strategy**
   - Daily database backups
   - Secure backup storage
   - Test restore procedures

### For End Users

1. **Strong Passwords**
   - Minimum 8 characters
   - Mix of uppercase, lowercase, numbers, special chars
   - Avoid personal information

2. **Account Security**
   - Log out when finished
   - Don't share credentials
   - Report suspicious activity

3. **Device Security**
   - Keep browser updated
   - Use antivirus software
   - Avoid public Wi-Fi for sensitive operations

## Security Headers Recommendation

Add these headers to your web server configuration:

```apache
# Apache .htaccess
<IfModule mod_headers.c>
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-Content-Type-Options "nosniff"
    Header set X-XSS-Protection "1; mode=block"
    Header set Referrer-Policy "strict-origin-when-cross-origin"
    Header set Permissions-Policy "geolocation=(), microphone=(), camera=()"
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
</IfModule>
```

```nginx
# Nginx configuration
add_header X-Frame-Options "SAMEORIGIN" always;
add_header X-Content-Type-Options "nosniff" always;
add_header X-XSS-Protection "1; mode=block" always;
add_header Referrer-Policy "strict-origin-when-cross-origin" always;
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
```

## Known Security Considerations

### Current Limitations

1. **No Two-Factor Authentication (2FA)**
   - Planned for future release
   - Use strong passwords in the meantime

2. **No Password Reset Functionality**
   - Requires database admin intervention
   - Planned for future release

3. **Basic Rate Limiting**
   - Session-based (cleared on browser close)
   - Consider IP-based rate limiting for production

### Mitigations

1. **Monitor Logs**
   - Review `logs/security-*.log` daily
   - Set up alerts for suspicious activity

2. **Database Security**
   - Use dedicated database user with minimal permissions
   - Enable MySQL query logging for audits

3. **Network Security**
   - Use firewall to restrict database access
   - VPN for administrative access

## Security Checklist

Before deploying to production:

- [ ] Change all default credentials
- [ ] Configure HTTPS with valid certificate
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Restrict file permissions (600 for .env, 755 for logs)
- [ ] Enable web server security headers
- [ ] Configure firewall rules
- [ ] Set up database backups
- [ ] Review and secure SMTP credentials
- [ ] Test all forms for CSRF protection
- [ ] Verify rate limiting is working
- [ ] Check logs directory is not web-accessible
- [ ] Remove or protect phpMyAdmin access
- [ ] Enable error logging (not display)

## Compliance

This application follows:
- ✅ OWASP Top 10 security guidelines
- ✅ PHP Security Best Practices
- ✅ CWE/SANS Top 25 mitigations

## Contact

**Security Team:** kishojeyapragash15@gmail.com

**PGP Key:** Available on request

---

**Last Updated:** January 3, 2026

**Version:** 2.0.0
