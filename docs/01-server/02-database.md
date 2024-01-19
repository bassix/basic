# MariaDB

[MariaDB](https://mariadb.org/) is an open-source relational database management system, commonly used as an alternative for [MySQL](https://www.mysql.com/) as the database portion of the popular [LAMP](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-20-04) (Linux, Apache, MySQL, PHP/Python/Perl) stack. It is intended to be a drop-in replacement for [MySQL](https://www.mysql.com/).

First install **MariaBD** on your machine:

```shell
sudo apt install mariadb-client mariadb-server
```

**Note:** By default, the **MariaBD** server use systemd, so it's registered as a service. It starts automatically during the boot, and it's running in the background permanently. To be more efficient with CPU, RAM and battery resources, it is better to disable this service and start it only when needed.

(_optional_) First find out what service is installed:

```shell
systemctl list-unit-files '*mariadb*' '*mysql*'
```

(_optional_) If you see `mariadb.service`, try disabling that one first.

```shell
sudo systemctl disable mariadb
```

Now you can start and stop the **MariaBD** server if required with following commands:

```bash
sudo systemctl stop mariadb
sudo systemctl start mariadb
```

## Create User

By default, the **MariaBD** is only accessible by `root` and we want to create new user to work with the instance.

Connect a  `root` with the database:

```shell
sudo mariadb
```

Now we are logged in as the `root` user, and we can create a superuser (to omit using `root` user):

```sql
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'nopassword';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
```

**Note: Please use a strong password for a production database!**

Logout and now login as the new `admin` user:

```shell
mysql -u admin -p
```

Now create project / application specific database with a related user:

```sql
CREATE DATABASE `basic`;
CREATE USER 'basic'@'localhost' IDENTIFIED BY 'nopassword';
GRANT ALL PRIVILEGES ON `basic`.* TO 'basic'@'localhost' identified by 'nopassword';
FLUSH PRIVILEGES;
```

_**Note:** This commands can be used to create database and user with privilegs for any other project to!_

## Usage examples

1. Drop tables it exits:

    ```sql
    SELECT t.id,tt.title AS todo_title,t.title,t.description,t.created_at,t.updated_at
    FROM todo AS t
    LEFT JOIN todo_type AS tt ON t.type_id=tt.id
    ```

1. Create for example a `todo` table:

    ```sql
    CREATE TABLE IF NOT EXISTS `todo` (
        `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `type_id` BIGINT(20) UNSIGNED NOT NULL,
        `title` VARCHAR(64) NOT NULL,
        `description` VARCHAR(255) DEFAULT '',
        `completed` BOOLEAN,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY(id),
        KEY `fk_todo_type` (`type_id`),
        CONSTRAINT `fk_todo_type` FOREIGN KEY (`type_id`) REFERENCES `todo_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=INNODB;
    CREATE TABLE IF NOT EXISTS `todo_type` (
        `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(64) NOT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY(id)
    ) ENGINE=INNODB;
    ```

1. Select all todo with type:

    ```sql
    SELECT t.id, tt.name AS `type`, t.title, t.description, t.created_at, t.updated_at
    FROM todo AS t
    LEFT JOIN todo_type AS tt ON t.type_id=tt.id
    ```

## Delete Database and User

How to delete or remove a user account and a related database:

1. Connect as `root` to the database server: 

    ```shell
    sudo mariadb
    ```

    Alternative as our "superuser" `admin`:

    ```shell
    mysql -u admin -p
    ```

1. In the first step check the existence of the user:

    ```sql
    SELECT User,Host FROM mysql.user;
    ```

1. List grants for a user:

    ```sql
    SHOW GRANTS FOR 'basic'@'localhost';
    ```

1. Revoke all grants for a user:

    ```sql
    REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'basic'@'localhost';
    FLUSH PRIVILEGES;
    ```

1. Drop the user from the user table:

    ```sql
    DROP USER 'basic'@'localhost';
    ```

1. Delete the database:

    ```sql
    DROP DATABASE basic;
    ```

## Troubleshooting

In case the database is mis-configured or not working, delete the whole service incl. data:

```shell
sudo apt purge mariadb-client mariadb-server
sudo rm -rf /etc/mysql /etc/mariadb 
```
