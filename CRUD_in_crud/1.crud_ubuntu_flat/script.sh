#!/bin/bash

sudo apt update -y

sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql -y

echo "--------- completed package installations ------"

sudo systemctl start apache2
sudo systemctl enable apache2
sudo systemctl start mysql
sudo systemctl enable mysql

echo "--------- services started ------"

sudo mysql -u root -e "CREATE DATABASE IF NOT EXISTS crud_app;"

sudo mysql -u root -e "
CREATE USER IF NOT EXISTS 'crud_user'@'localhost' IDENTIFIED BY 'apple123';
GRANT ALL PRIVILEGES ON crud_app.* TO 'crud_user'@'localhost';
FLUSH PRIVILEGES;
"

echo "--------- database user created ------"

sudo mysql -u root -e "
USE crud_app;

CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mobile VARCHAR(15) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    address TEXT NOT NULL,
    image VARCHAR(255),
    salary DECIMAL(10,2) NOT NULL
);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT IGNORE INTO users (username, password)
VALUES ('admin', SHA2('admin123', 256));
"

echo "--------- database tables created ------"

sudo mkdir -p /var/www/html/crud_app
sudo chown -R $USER:$USER /var/www/html/crud_app

cp *.php /var/www/html/crud_app/

mkdir -p /var/www/html/crud_app/uploads
chmod 777 /var/www/html/crud_app/uploads

echo "--------- project copied successfully ------"
echo "Open: http://YOUR-IP/crud_app/"
