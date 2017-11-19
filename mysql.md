### Install mysql database and php libraries

```
$ sudo apt-get install mysql-server
$ mysql_secure_installation
$ apt-get install php php-mysql
```

### Creating a database and tables for our application
```
mysql> CREATE DATABASE cowrie;

mysql> CREATE TABLE logindata (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	srcip VARCHAR(15) NOT NULL,
	timestamp VARCHAR(45) NOT NULL
	);

mysql> CREATE TABLE authdata (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(45) NOT NULL,
	password VARCHAR(45) NOT NULL
	);
  ```
