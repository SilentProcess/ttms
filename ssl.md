Enable ssl:

```
~$ sudo a2enmod ssl
~$ service apache2 restart
~$ sudo mkdir /etc/apache2/ssl
```

Create key and cert:
```
~$ sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/apache2/ssl/apache.key -out /etc/apache2/ssl/apache.crt
```

Add info:
```
Country Name (2 letter code) [AU]:FI
State or Province Name (full name) [Some-State]:Hunaja-Suomi
Locality Name (eg, city) []:Hunajakaupunki
Organization Name (eg, company) [Internet Widgits Pty Ltd]:Hunajapojat OY
Organizational Unit Name (eg, section) []:Hunaja-OU
Common Name (e.g. server FQDN or YOUR name) []:Hunajamestari #2
Email Address []:hunaja@hunajapurkki.hunaja
```

Edit default-ssl.conf
```
~$ sudo nano /etc/apache2/sites-available/default-ssl.conf
```

Change these lines:
```
SSLCertificateFile /etc/apache2/ssl/apache.crt
SSLCertificateKeyFile /etc/apache2/ssl/apache.key
```

Activate changes:
```
~$ sudo a2ensite default-ssl.conf
~$ sudo service apache2 restart
```

Allow https through firewall:
```
~$ ufw allow 443
```
Redirect http to https:

```
NameVirtualHost *:80
<VirtualHost *:80>
   ServerName {insert site name}
   DocumentRoot /var/www/html 
   Redirect permanent / https://{insert site name}
</VirtualHost>
```
