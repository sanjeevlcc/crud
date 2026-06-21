#!/bin/bash

sudo apt update -y
sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql -y

sudo systemctl start apache2
sudo systemctl enable apache2
sudo systemctl start mysql
sudo systemctl enable mysql

sudo mysql -u root -e "CREATE DATABASE IF NOT EXISTS restaurant_crud;"

sudo mysql -u root -e "
DROP USER IF EXISTS 'restaurant_user'@'localhost';
CREATE USER 'restaurant_user'@'localhost' IDENTIFIED BY 'apple123';
GRANT ALL PRIVILEGES ON restaurant_crud.* TO 'restaurant_user'@'localhost';
FLUSH PRIVILEGES;
"

sudo mysql -u root -e "
USE restaurant_crud;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(20) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    items TEXT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT IGNORE INTO users (username, password)
VALUES ('admin', SHA2('admin123', 256));
"

sudo mkdir -p /var/www/html/restaurant_crud
sudo chown -R $USER:$USER /var/www/html/restaurant_crud

cp *.php /var/www/html/restaurant_crud/

echo "--------------------------------------"
echo "Restaurant CRUD setup completed"
echo "URL: http://YOUR-IP/restaurant_crud/login.php"
echo "Username: admin"
echo "Password: admin123"
echo "--------------------------------------"
