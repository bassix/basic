# Composer

**[Composer](https://getcomposer.org/)** is a popular dependency management tool for **[PHP](https://www.php.net/)**, created mainly to facilitate installation and updates for project dependencies. It will check which other packages a specific project depends on and install them for you, using the appropriate versions according to the project requirements. Composer is also commonly used to bootstrap new projects based on popular **[PHP](https://www.php.net/)** frameworks, such as **[Symfony](https://symfony.com/)** and **[Laravel](https://laravel.com/)**.

All public available packages can be found on **[packagist.org](https://packagist.org/)**.

The easiest and the recommended way to install **Git** is to install it using the apt package management tool from Ubuntu’s default repositories:

```shell
sudo apt update
sudo apt install composer
```

## Manual installation

Composer provides its own installation script that you can download, verify and then run.

For manual installation the PHP extension `php-cli` is required:

```shell
sudo apt install php-cli
```

First, it is best to change to the home directory, download the installer and run the installer:

```shell
cd ~
wget -qO composer-setup.php https://getcomposer.org/installer
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer 
rm composer-setup.php
```
