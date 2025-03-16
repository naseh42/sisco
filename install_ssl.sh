#!/bin/bash

# نصب Certbot
sudo apt install -y certbot python3-certbot-apache

# دریافت گواهی SSL و تنظیم Apache
sudo certbot --apache --non-interactive --agree-tos -m your-email@example.com -d yourdomain.com

# راه‌اندازی مجدد Apache
sudo systemctl restart apache2