


#sudo apt update -y
sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql -y



sudo systemctl start apache2
sudo systemctl enable apache2
sudo systemctl start mysql
sudo systemctl enable mysql

sudo mysql -u root -e "show databases;"
sudo mysql -u root -e "CREATE DATABASE crud_app;" 
sudo mysql -u root -e "use crud_app;  CREATE USER 'crud_user'@'localhost' IDENTIFIED BY 'apple123'; GRANT ALL PRIVILEGES ON crud_app.* TO 'crud_user'@'localhost'; FLUSH PRIVILEGES;"


sudo mysql -u root -e "use crud_app; 
    CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mobile VARCHAR(15) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    address TEXT NOT NULL,
    image VARCHAR(255),
    salary DECIMAL(10,2) NOT NULL
);"



echo "use crud_app; CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
); INSERT INTO use users (username, password) VALUES ('admin', SHA2('admin123', 256));" 


sudo mkdir /var/www/html/crud_app
sudo chown -R $USER:$USER /var/www/html/crud_app
cd /var/www/html/crud_app

cp * /var/www/html/crud_app/

mkdir /var/www/html/crud_app/uploads
chmod 777 /var/www/html/crud_app/uploads

