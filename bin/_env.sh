#!/bin/sh

if [[ ! -f "${_dirRoot}/.env" ]]
then
    echo "${red}The environment configuration file \".env\" doesn't exist. Please create one first! You can use the ./env.sh helper script ;)${reset}"
    exit 1;
fi

# Load the generated environment file
set -o allexport; source ${_dirRoot}/.env; set +o allexport
