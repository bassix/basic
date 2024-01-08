#!/bin/bash

# Include bash base scripts
. bin/_base.sh
. bin/_colors.sh

adminer_install()
{
  wget https://www.adminer.org/latest-de.php -O public/adminer.php
}

if [[ -f "public/adminer.php" ]]
then
    echo "${underline}${green}Adminer already exists!${reset}"

    read -p "${orange}Overwrite the current Adminer version (y/n)? ${reset}"
    if [[ "$REPLY" == "y" ]]
    then
        adminer_install
    else
        exit;
    fi
else
    echo "${underline}${green}Adminer not found, downloading latest version!${reset}"
    adminer_install
fi

### Installation as sub module
#git submodule update --init --recursive --remote
#cd adminer
#make initialize
#make compile
#mv adminer.php ../app
#cd ..
