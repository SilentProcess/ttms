After finding out that the write-to-mysql.php sometimes writes null bytes into the json logfile, we decided to
use cowries own mysql functionality instead. Here are the steps to make cowrie submit it's data to a mysql database:

###### Grab the MySQL development files
```
$ sudo apt-get install libmysqlclient-dev
```

###### Create a new database user for cowrie
```
mysql -u root -p
> CREATE DATABASE cowrie;
> GRANT ALL ON cowrie.* TO 'cowrie'@'localhost' IDENTIFIED BY 'PASSWORD HERE';
> FLUSH PRIVILEGES;
> exit
```

###### Get the python libraries cowrie uses to interact with the database
```
$ source cowrie/cowrie-env/bin/activate
$ pip install MySQL-python
```

###### Move to the cowrie/doc/sql folder and create the database from mysql.sql -file
```
mysql -u cowrie -p
> USE cowrie;
> source ./doc/sql/mysql.sql;
> exit
```
