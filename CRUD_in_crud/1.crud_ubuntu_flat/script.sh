


sudo apt update -y
sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql -y



sudo systemctl start apache2
sudo systemctl enable apache2
sudo systemctl start mysql
sudo systemctl enable mysql


echo "CREATE DATABASE crud_app; 
      CREATE USER 'crud_user'@'localhost' IDENTIFIED BY 'apple123'; 
      GRANT ALL PRIVILEGES ON crud_app.* TO 'crud_user'@'localhost'; 
      FLUSH PRIVILEGES;" | sudo mysql  

sudo mkdir /var/www/html/crud_app
sudo chown -R $USER:$USER /var/www/html/crud_app
cd /var/www/html/crud_app



echo "CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mobile VARCHAR(15) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    address TEXT NOT NULL,
    image VARCHAR(255),
    salary DECIMAL(10,2) NOT NULL
);" | sudo mysql -u root 







echo "CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);" | sudo mysql -u root crud_app


echo "INSERT INTO users (username, password) VALUES ('admin', SHA2('admin123', 256));" | sudo mysql -u root  crud_app











