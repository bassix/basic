# Webserver with Apache and PHP

The main common and widespread web server combination is **Apache2** with **PHP**. This section describes the installation and configuration of the **Apache2** web server with **PHP** addon.

## PHP

Add `ondrej/php` which has all relevant **[PHP](https://www.php.net/)** package and other required **[PHP](https://www.php.net/)** extensions.

```bash
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

This **PPA** can be added to your system manually by copying the lines below and adding them to your system’s software sources.

Once the PPA repository has been added, install **PHP 8.1** on your server:

```bash
sudo apt-get install php8.1
```

Install **PHP 8.1** with extensions:

```bash
sudo apt install php8.1 php8.1-cli php8.1-fpm php8.1-pdo php8.1-mysql php8.1-pgsql php8.1-sqlite3 php8.1-intl php8.1-gd php8.1-dom php8.1-xml php8.1-zip php8.1-bz2 php8.1-bcmath php8.1-curl php8.1-soap
```

Install general **PHP** extensions:

```bash
sudo apt-get install php-common php-mysql php-curl php-gd php-pear php-imagick php-imap php-json php-memcache php-memcached php-mongodb php-pspell php-tidy php-xml php-xmlrpc php-json php-pgsql
```

### Version Switch

From **PHP** version **7.4** to **8.1**:

```bash
sudo update-alternatives --set php /usr/bin/php8.1
```

Downgrade from **PHP** version **8.1** to **7.4**:

```bash
sudo update-alternatives --set php /usr/bin/php7.4
```

## Apache2

In the first step we will install the **Apache2** as our web server with PHP as interpreter: 

```shell
sudo apt install apache2 libapache2-mod-php8.1
```

Now the main **Apache2** mods can be activated:

```shell
sudo a2enmod deflate ssl headers rewrite setenvif mime filter expires negotiation
```

**Note:** By default, the **Apache2** web server use systemd, so it's registered as a service. It starts automatically during the boot, and it's running in the background permanently. To be more efficient with CPU, RAM and battery resources, it is better to disable this service and start it only when needed.

(_optional_) Disable the **Apache2** service:

```bash
sudo systemctl disable apache2
```

Now you can start and stop the **Apache2** server if required with following commands:

```bash
sudo systemctl stop apache2
sudo systemctl start apache2
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

### Version Switch

From **PHP** version **7.4** to **8.1**:

```bash
sudo a2dismod php7.4 ; sudo a2enmod php8.1 ; sudo service apache2 restart
```

Downgrade from **PHP** version **8.1** to **7.4**:

```bash
sudo a2dismod php8.1 ; sudo a2enmod php7.4 ; sudo service apache2 restart
```

## Project Setup

Now we can start to configure the main project directory to be served. 

In the first step we need to figure out the full path of the project directory. For example, we want to create a new project called `bassix-basic` inside the `/var/www` directory:

```shell
pwd
```

The output should be something like this: `/var/www/bassix-basic`

In the next step we create a **Apache2** configuration for our new domain as a virtual host:

```shell
sudo nano /etc/apache2/sites-available/bassix-basic.conf
```

Enter current configuration:

```apacheconf
<VirtualHost *:80>
    ServerName bassix-basic.lan
    ServerAdmin webmaster@bassix-basic.lan
    DocumentRoot /var/www/bassix-basic/public
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Activate the new **Apache2** web server configuration for the new project:

```shell
sudo a2ensite bassix-basic
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
sudo echo "127.0.0.1 bassix-basic.lan" >> /etc/hosts
```

Alternative edit the /etc/hosts file and add the new host setting manually:

```shell
sudo nano /etc/hosts
```

Add the following line into the file to activate the domain name and store your changes:

```
127.0.0.1 bassix-basic.lan www.bassix-basic.net
```
