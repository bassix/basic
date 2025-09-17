#!/bin/bash

#sudo /etc/init.d/apache2 stop
sudo systemctl stop apache2

#sudo /etc/init.d/mysql stop
sudo systemctl stop mysql

#sudo /etc/init.d/mariadb stop
sudo systemctl stop mariadb

#sudo /etc/init.d/postgresql stop
sudo systemctl stop postgresql

#sudo /etc/init.d/mongodb stop
sudo systemctl stop mongodb

#sudo /etc/init.d/memcached stop
sudo systemctl stop memcached
