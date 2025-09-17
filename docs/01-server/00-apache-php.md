# Webserver with Apache and PHP

The main common and widespread web server combination is **Apache2** with **PHP**. This section describes the installation and configuration of the **Apache2** web server with **PHP** addon.

## PHP

Add `ondrej/php` which has all relevant **[PHP](https://www.php.net/)** package and other required **[PHP](https://www.php.net/)** extensions.

```shell
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

This **PPA** can be added to your system manually by copying the lines below and adding them to your system’s software sources.

Once the PPA repository has been added, install **PHP 8.3** on your server:

```shell
sudo apt-get install php8.3
```

Install **PHP 8.3** with extensions:

```shell
sudo apt install php8.3 php8.3-cli php8.3-fpm php8.3-pdo php8.3-mysql php8.3-pgsql php8.3-sqlite3 php8.3-intl php8.3-gd php8.3-dom php8.3-xml php8.3-zip php8.3-bz2 php8.3-bcmath php8.3-curl php8.3-soap
```

Install general **PHP** extensions:

```shell
sudo apt-get install php-common php-mysql php-curl php-gd php-pear php-imagick php-imap php-json php-memcache php-memcached php-mongodb php-pspell php-tidy php-xml php-xmlrpc php-json php-pgsql
```

## Apache2

In the first step we will install the **Apache2** as our web server with PHP as interpreter: 

```shell
sudo apt install apache2 libapache2-mod-php
```

Now the main **Apache2** mods can be activated:

```shell
sudo a2enmod deflate ssl headers rewrite setenvif mime filter expires negotiation
```

**Note:** By default, the **Apache2** web server use `systemd`, so it's registered as a service. It starts automatically during the boot, and it's running in the background permanently. To be more efficient with CPU, RAM and battery resources, it is better to disable this service and start it only when needed.

(_optional_) Disable the **Apache2** service:

```shell
sudo systemctl disable apache2
```

Now you can start and stop the **Apache2** server if required with following commands:

```shell
sudo systemctl stop apache2
sudo systemctl start apache2
```

Open firewall for **Apache2**:

```shell
sudo ufw allow "Apache Full"
```

### Configuration

By default, the **Apache2** user is `www-data` but if we want to work on our projects, so it's better to run the **Apache2** as the local user (**note:** not suitable for production!).

Now get the username:

```shell
id -u -n
```

Also get the primary user group name:

```shell
id -g -n
```

Change the project directory `/vaw/www` to current user and group:

```shell
sudo chown username:groupname /var/www -R
```

As a short command:

```shell
sudo chown $(id -u -n):$(id -g -n) /var/www -R
```

Now change the Apache2 running user:

```shell
sudo nano /etc/apache2/envvars
```

Change the user and group:

```shell
export APACHE_RUN_USER=username
export APACHE_RUN_GROUP=groupname
```

Restart the Apache2 server:

```shell
sudo systemctl restart apache2
# Alternative, restart the service
sudo service apache2 restart
# Alternative, restart the init.d
sudo /etc/init.d/apache2 restart
```

#### Default configuration

With the Apache2 installation we get a default configuration inside `/etc/apache2/sites-available/`.

## Project Setup

Now we can start to configure the main project directory to be served. 

In the first step we need to figure out the full path of the project directory. For example, we want to create a new project called `basic` inside the `/var/www` directory:

```shell
pwd
```

The output should be something like this: `/var/www/basic`

In the next step we create a **Apache2** configuration for our new domain as a virtual host:

```shell
sudo nano /etc/apache2/sites-available/basic.conf
```

Enter current configuration:

```apacheconf
<VirtualHost *:80>
    ServerName basic.lan
    ServerAdmin webmaster@basic.lan
    DocumentRoot /var/www/basic/web
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Activate the new **Apache2** web server configuration for the new project:

```shell
sudo a2ensite basic
```

Restart the **Apache2** web server to activate the new project configuration:

```shell
sudo systemctl restart apache2
# Alternative, restart the service
sudo service apache2 restart
# Alternative, restart the init.d
sudo /etc/init.d/apache2 restart
```

## Hosting

For a better separation of this related app we will also register a domain:

```shell
sudo echo "127.0.0.1    basic.lan" >> /etc/hosts
```
