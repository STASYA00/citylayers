# Deployment for the developers

## Connecting to the production server

```sh
ssh [SERVER] -l [USERNAME] -p [PORT]
```

Here is a short description of the installation on this server.

## Domain names

There is currently 1 domain name registered for you on this server:

1. citylayers.visualculture.tuwien.ac.at

The name points to the directory /var/www/citylayers by default (see apache configs).

## Directories

The directory /var/www/citylayers is linked as public_html in the user directory of the citylayers user.

The directory /etc/php/8.1 is linked as php in the user directory of the citylayers user.

The directory /etc/apache2/sites-available/ is linked as webserver in the user directory of the citylayers user.

## sudo rights

The following sudo rights are allowed on this server for the user citylayers.

### Rights management

```sh
sudo chown -R www-data:www-data /var/www/citylayers/* # change owner
sudo chmod * /var/www/citylayers/* # change rights
sudo chown -R citylayers:www-data /var/www/citylayers/* # take back ownership
```

### Web server management

```sh
sudo systemctl restart apache2 # restart web server
sudo systemctl reload apache2 # reload web server config
sudo systemctl status apache2 # query status of web server
sudo a2enmod <module> # activate Apache module (e.g. mime, ssl, etc.)
sudo a2dismod <module> # deactivate Apache module
```

### Page configurations

```sh
sudo nano /etc/apache2/sites-available/cl_<config>.conf # edit the configuration
sudo apache2ctl -t # syntax check of the configuration
sudo a2ensite cl_<config> # activate the configuration
sudo a2dissite cl_<config> # deactivate the configuration
```
### PHP

```sh
sudo nano /etc/php/8.1/* # edit the PHP configuration
sudo php -v # check the PHP version
```

### MYSQL

```sh
sudo /usr/sbin/service mysql status # view the status of the MySQL server
sudo /usr/sbin/service mysql reload # reload the configs
sudo /usr/sbin/service mysql restart # restart the SQL server

sudo /usr/bin/mysql * # mysql CLI
sudo /usr/bin/mysqldump * # MYSQL dump
```

### SSL

The SSL certificate can now be integrated. The files required for this are in the system
and have the necessary permissions for Apache2 to read and use them.

```sh
/etc/ssl/certs/web.visualculture.pem # Public key
/etc/ssl/private/web.visualculture.key # Private key
```

The certificate is a multidomain certificate and covers the following domain names that are relevant to you:

```sh
citylayers.visualculture.tuwien.ac.at
```

### Connecting to MYSQL on the server:

```sh
sudo mysql -u root -p
```
and enter MYSQL password 

### Possible issues and their resolution

#### Mixed content

If the browser refuses to upload ```.css``` and ```.js``` files with 'Mixed content..' warning, you can

1. Add `Header always set Content-Security-Policy "upgrade-insecure-requests;"` to `citylayers.conf` and `citylayers-ssl.conf`, see [this](https://tecadmin.net/setting-up-upgrade-insecure-requests-in-apache/) for reference
2. Add 
```html
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">```
to the header of the html file.
```

#### Logging from server

```php
$output = is_array($postData) ? 'true' : 'false';;
if (is_array($output)){
    echo "<script>console.log('Debug');</script>";
    $output = implode(',', $output);}

echo "<script>console.log('Debug Objects: " . $output . "' );</script>";

```