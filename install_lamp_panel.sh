#!/bin/bash

# نصب Apache, MySQL و PHP
sudo apt install -y apache2 mysql-server php libapache2-mod-php php-mysql

# شروع و فعال‌سازی Apache
sudo systemctl enable apache2
sudo systemctl start apache2

# راه‌اندازی دیتابیس و جدول کاربران
sudo mysql -u root <<MYSQL_SCRIPT
CREATE DATABASE IF NOT EXISTS vpn_users;
USE vpn_users;
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    bandwidth_limit INT NOT NULL,
    time_limit INT NOT NULL
);
MYSQL_SCRIPT

# ساخت فایل PHP مدیریت کاربران
cat <<EOF | sudo tee /var/www/html/index.php
<?php
\$conn = new mysqli("localhost", "root", "", "vpn_users");
if (\$conn->connect_error) {
    die("Connection failed: " . \$conn->connect_error);
}
echo "پنل مدیریت کاربران با موفقیت متصل شد!";
?>
EOF

# تنظیم دسترسی‌ها
sudo chmod -R 755 /var/www/html/
sudo systemctl restart apache2