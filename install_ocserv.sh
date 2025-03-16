#!/bin/bash

# به‌روزرسانی سیستم
sudo apt update && sudo apt upgrade -y

# نصب Ocserv
sudo apt install -y ocserv

# پیکربندی Ocserv
sudo sed -i 's/^#tcp-port.*/tcp-port = 443/' /etc/ocserv/ocserv.conf
sudo sed -i 's/^#udp-port.*/udp-port = 443/' /etc/ocserv/ocserv.conf
sudo sed -i 's/^#max-clients.*/max-clients = 100/' /etc/ocserv/ocserv.conf
sudo sed -i 's/^#max-same-clients.*/max-same-clients = 2/' /etc/ocserv/ocserv.conf
sudo sed -i 's/^#default-domain.*/default-domain = yourdomain.com/' /etc/ocserv/ocserv.conf
sudo sed -i 's/^auth = "pam"/auth = "plain\[\/etc\/ocserv\/ocpasswd\]"/' /etc/ocserv/ocserv.conf

# راه‌اندازی سرویس Ocserv
sudo systemctl enable ocserv
sudo systemctl restart ocserv

# اضافه کردن کاربر آزمایشی
sudo ocpasswd -c /etc/ocserv/ocpasswd testuser