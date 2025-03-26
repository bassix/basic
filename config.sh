#!/bin/bash

# Include bash base scripts
. bin/_base.sh
. bin/_colors.sh
. bin/_env.sh

if test -f "web/config/config.php"
then
    echo "${green}The configuration file \"web/config/config.php\" already exists!${reset}"
    exit
fi

cp web/config/config.dist.php web/config/config.php
sed "/'db'/s/'[^']*'/'${DB}'/2" web/config/config.php; \
sed "/'dbhost'/s/'[^']*'/'${DB_HOST}'/2" web/config/config.php; \
sed "/'dbuser'/s/'[^']*'/'${DB_USER}'/2" web/config/config.php; \
sed "/'dbpassword'/s/'[^']*'/'${DB_PASSWORD}'/2" web/config/config.php; \
sed "/'dbname'/s/'[^']*'/'${DB_NAME}'/2" web/config/config.php;

echo "${green}The configuration file \"web/config/config.php\" has been created.${reset}"

# Get the database host
echo "${orange}Please note: comment out the wished database host in the configuration file.${reset}"
