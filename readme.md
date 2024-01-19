# basic

This repository holds a basic web application for a default website with some default pages to be deployed on an empty webserver with php enabled.

## Structure & Philosophy

This project is based on following structure:

* `/`: Inside the root folder there are many helper scripts to make the handling of relevant task much easier
    * `./env.sh`: Creates a `.env` file with application and database relevant settings.
    * `./docker-compose.sh`: Starts a full environment with **Docker** and **Docker Compose**.
    * `./adminer.sh`: Downloads the latest version of **[Adminer](https://www.adminer.org/)** into the public directory.
* `/public`: The location of the main page application and the root of **Composer**
* **[`/docs`](docs/readme.md)**: A collection of documents with further information about work as a web developer and the environments
* `/docker`: All relevant configurations for the **Docker** and **Docker Compose** environment

The following main dependencies are used inside this project:

* The **[Git](https://git-scm.com/)** version control system is used for the source code management
* The main programing language is **[PHP](https://www.php.net/)** minimum version [8.2](https://www.php.net/ChangeLog-8.php#PHP_8_2)
* The main database is **[MariaDB](https://mariadb.org/)** minimum version [10.5](https://mariadb.org/download/?t=mariadb&p=mariadb&r=10.5.23)
* For database administration **[Adminer](https://www.adminer.org/)** is used
* The **[Composer](https://getcomposer.org/)** is used as the main dependency manager for **PHP**
* The **[Node.js](https://nodejs.org/en/)** JavaScript runtime is used for the frontend development
* The **[Docker](https://www.docker.com/)** and **[Docker Compose](https://docs.docker.com/compose/)** container virtualization is used for the development environment

Further information of the philosophy and fundamental arrangement:

* **[GitFlow](https://nvie.com/posts/a-successful-git-branching-model/)** or the more recent **[GitHub flow](https://docs.github.com/en/get-started/quickstart/github-flow)** is the base process for the branching model and workflow.
* **[Branch naming conventions](https://deepsource.io/blog/git-branch-naming-conventions/)** are used got **Git** branches to organize ongoing work to ensure that software delivery stays effective. The **Git** workflows depend extensively on using branches effectively — and naming a new branch is something most important.
* **[Semantic versioning (aka SemVer)](https://semver.org/)** keeps the software ecosystem healthy, reliable, and secure, every time you make fixes, minor changes or significant updates to a software this reflects this changes in the updated version number.

## Get Started

To get this project you need to get a local copy of this repository first:

```shell
git clone git@github.com:bassix/basic.git bassix-basic
cd bassix-basic
```

(_Optional_) **[GitLab](https://gitlab.com/bassix/basic/)** alternative and fallback repository copy:

```shell
git clone git@gitlab.com:bassix/basic.git bassix-basic
cd bassix-basic
```

**Note:** read how to install **[Git](docs/02-tools/git.md)**.

Initialize **GIT flow** before development and contribution:

```bash
echo "main" | DEBUG=yes git flow init -f &>/dev/null
```

**Note:** read how to install **[Git-Flow](docs/02-tools/git.md#git-flow)**.

## Serve Application

This application is developed to be agnostic to the environment running on. For development there are three different ways to create a running environment:

1. [**PHP** built in web server](#php-builtin-server)
2. [**Apache2** web server with **PHP** module](#apache2-with-php)
3. [**Docker** and **Docker Compose** environment](#docker-and-docker-compose)

### Configuration

Before the application can be served it should be configured:

1. `.env`: The environment configuration, is based on `.env.dist`.

    **Note:** use the `./env.sh` helper script.

2. `app/.config/config.php`: The environment configuration, is based on `app/.config/config.dist.php`.

    **Note:** use the `./config.sh` helper script.

**Note:** the environment has default parameters, and it can be started without any configuration.

### PHP

For development purpose the easiest way to serve the website is to use the PHP integrated web server:

```shell
php -S 127.0.0.1:8000 -t public
```

Alternative, run the development server in the background and write the output to a log file:

```shell
nohup php -S 127.0.0.1:8000 -t public > phpd.log 2>&1 &
```

Show the last 100 rows and follow the log file:

```shell
tail -fn 100 phpd.log
```

Enter the application:

* The **basic** web page: [http://localhost:8000](http://localhost:8000)
* The **Adminer**: [http://localhost:8000/adminer.php](http://localhost:8000/adminer.php)

### Apache2 with PHP

Drafts for the configuration:

* `conf/apache2/000-default.conf`: The **Apache2** default configuration for **HTTP**
* `conf/apache2/000-default-ssl.conf`: The **Apache2** default configuration for **HTTPS**

For further details howto install and configure the Apache2 web server correct is described inside [`doc/apache2.md`](doc/apache2.md).

Enter the application:

* The **basic** web page: [http://localhost/](http://localhost/)
* The **Adminer**: [http://localhost/adminer.php](http://localhost/adminer.php)

### Docker and Docker Compose

Build and start the small and simple environment:

```shell
docker-compose up -d
```

Access the application:

* The **basic** web page: [http://localhost/](http://localhost/)
* The **Adminer**: [http://localhost/adminer.php](http://localhost/adminer.php)

Build and start the development environment with all containers incl. **Adminer** and **PHPMyAdmin**:

```shell
docker-compose -p basic -f docker-compose.yml -f docker-compose.dev.yml up -d --build --force-recreate
```

Check if all containers are running correctly:

```shell
docker-compose -p basic ps
```

Access the application:

* The **basic** web page: [http://localhost:8080](http://localhost:8080)
* The **Adminer**:
  * Internal: [http://localhost:8080/adminer.php](http://localhost:8080/adminer.php)
  * Dedicated app: [http://localhost:8081](http://localhost:8081)
* The **PHPMyAdmin**: [http://localhost:8082](http://localhost:8082)

## Development

The development of this application is based on following tools:

* **[PHP](https://www.php.net/)** is the main programing language
* **[Composer](https://getcomposer.org/)** is used as the main dependency manager for **PHP**
* **[PHP Coding Standards Fixer (PHP CS Fixer)](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)** is a tool to automatically fix PHP coding standards issues
* **[PHPStan](https://phpstan.org/)** is a static code analysis tool for **PHP**
* **[PHPUnit](https://phpunit.de/)** is a programmer-oriented testing framework for **PHP**

### PHP Coding Standards Fixer (PHP CS Fixer)

**[PHP Coding Standards Fixer (PHP CS Fixer)](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)** is a tool to automatically fix PHP coding standards issues. It is a standalone CLI tool that you can use on your projects regardless of the framework you use.

```shell
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php -v --using-cache=no --allow-risky=yes src
```

## PHPStan

**[PHPStan](https://phpstan.org/)** is a static code analysis tool for **PHP**.

```shell
vendor/bin/phpstan analyse src tests --level=max
```

## PHPUnit

**[PHPUnit](https://phpunit.de/)** is a programmer-oriented testing framework for **PHP**.

```shell
vendor/bin/phpunit --configuration phpunit.xml.dist
```

## Concepts and Inspiration

Not everything is invented here, so here are some links to other projects tah inspired this project and implementation:

* A very lightweight template engine with PHP: https://codeshack.io/lightweight-template-engine-php/
