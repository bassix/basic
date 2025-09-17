#!/bin/bash

# Include bash base scripts
. bin/_base.sh
. bin/_colors.sh
. bin/_env.sh

# get action
action="$1"

# get the database dump file name
_file="$2"

if [[ -z "${_file}" ]]
then
    _file="${DB_NAME}.sql"
fi

if [[ ! -d ${_dirBackup} ]]
then
    mkdir -p ${_dirBackup}
    chmod 775 ${_dirBackup}
    echo "${orange}The backup directory created at \"${_dirBackup}\"${reset}"
fi

echo "${green}Current MariaDB configuration will be used:${reset}"
echo "${blue} » host: ${DB_HOST}; user: ${DB_USER}; password: ${DB_PASSWORD}; database: ${DB_NAME}${reset}"

if [[ "$action" == "backup" ]]
then
    read -p "${orange}Backup MariaDB (y/n)? ${reset}"
    if [[ "$REPLY" == "y" ]]
    then
        if [[ -f ${_dirBackup}/${_file} ]]
        then
            _now=$(date +"%Y%m%d_%H%M%S")
            _fileBackup="${DB_NAME}~${_now}.sql"

            read -p "${orange}Old MariaDB dump file \"${_file}\" at \"${_dirBackup}\" directory found! Create a copy to \"${_fileBackup}\" (y/n)? ${reset}"
            if [[ "$REPLY" == "y" ]]
            then
                cp ${_dirBackup}/${_file} ${_dirBackup}/${_fileBackup}
                echo "${underline}${green}Old MariaDB dump file \"${_file}\" stored to \"${_fileBackup}\" at \"${_dirBackup}\" directory${reset}"
            fi
        fi

        read -p "${orange}Create new MariaDB dump to file \"${_file}\" at \"${_dirBackup}\" directory (y/n)? ${reset}"
        if [[ "$REPLY" == "y" ]]
        then
            if [[ "$(docker ps -a | grep basic_db)" ]]
            then
                docker exec basic_db /usr/bin/mysqldump --extended-insert=FALSE -u ${DB_USER} -p${DB_PASSWORD} ${DB_NAME} > ${_dirBackup}/${_file}
            else
                mysqldump --extended-insert=FALSE -h ${DB_HOST} -u ${DB_USER} -p${DB_PASSWORD} ${DB_NAME} > ${_dirBackup}/${_file}
            fi
            echo "${underline}${green}The MariaDB dump file \"${_file}\" at \"${_dirBackup}\" directory was created${reset}"
        fi
    fi
elif [[ "$action" == "restore" ]]
then
    if [[ -f ${_dirBackup}/${_file} ]]
    then
        read -p "${orange}Restore the MariaDB dump file \"${_file}\" at \"${_dirBackup}\" directory (y/n)? ${reset}"
        if [[ "$REPLY" == "y" ]]
        then
            if [[ "$(docker ps -a | grep basic_db)" ]]
            then
                cat ${_dirFixtures}/drop-tables.sql | docker exec -i basic_db /usr/bin/mysql -u ${DB_USER} -p${DB_PASSWORD} ${DB_NAME}
                cat ${_dirBackup}/${_file} | docker exec -i basic_db /usr/bin/mysql -u ${DB_USER} -p${DB_PASSWORD} ${DB_NAME}
            else
                mysql -A -h ${DB_HOST} -u ${DB_USER} -p${DB_PASSWORD} ${DB_NAME} < ${_dirFixtures}/drop-tables.sql
                mysql -A -h ${DB_HOST} -u ${DB_USER} -p${DB_PASSWORD} ${DB_NAME} < ${_dirBackup}/${_file}
            fi
            echo "${underline}${green}The MariaDB dump file \"${_file}\" at \"${_dirBackup}\" directory was restored${reset}"
        fi
    else
        echo -e "${underline}${red}The MariaDB dump file \"${_file}\" at \"${_dirBackup}\" directory not found!${reset}"
    fi
else
    echo -e "${bold}Options: backup | restore${reset}"
fi
