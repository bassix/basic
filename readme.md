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
