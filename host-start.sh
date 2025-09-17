#!/bin/bash

apache2stat=$(sudo service apache2 status)

if [[ $apache2stat == *"active (running)"* ]]; then
    echo "Apache2 is running"
else
    echo "Apache2 is not running"
fi

#sudo /etc/init.d/apache2 start
sudo systemctl start apache2

#sudo /etc/init.d/mysql start
sudo systemctl start mysql

#sudo /etc/init.d/mariadb start
sudo systemctl start mariadb

#sudo /etc/init.d/postgresql start
sudo systemctl start postgresql

#sudo /etc/init.d/mongodb start
sudo systemctl start mongodb

#sudo /etc/init.d/memcached start
sudo systemctl start memcached
