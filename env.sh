#!/bin/bash

# Include bash base
. bin/_base.sh

# Include bash colors
. bin/_colors.sh

if test -f ".env"
then
    echo "${underline}${green}The environment file \".env\" already exists!${reset}"

    read -p "${orange}Recreate environment file (y/n)? ${reset}"
    if [[ "$REPLY" == "y" ]]
    then
        rm -f .env
    else
        exit;
    fi
fi

# Get the slug
slug="$1"

if [[ "$slug" == "" ]]
then
    read -p "${orange}Enter environment slug (default: ${_slug}): ${reset}" slug
    slug=${slug:-"${_slug}"}
fi
echo "${green}The environment slug \"${slug}\" will be used.${reset}"

# Fix the slug if wrong given
#slug=${slug// /-}
slug=$(echo "$slug" | tr ' ' '-')
#slug=${slug,,}
slug=$(echo "$slug" | tr '[:upper:]' '[:lower:]')
# Create a session prefix from slug
#spre=${slug//[^[:alpha:]]/}
spre=$(echo "$slug" | tr -cd '[:alpha:]')
#spre=${spre^^}
spre=$(echo "$spre" | tr '[:lower:]' '[:upper:]')

# Get the domain
domain="$2"

if [[ "$domain" == "" ]]
then
    read -p "${orange}Enter your domain (default: ${_domain}): ${reset}" domain
    domain=${domain:-"${_domain}"}
fi
echo "${green}The domain \"${blue}${underline}${domain}${nounderline}${green}\" will be used.${reset}"

# Get the environment type
environment="$2"

if [[ "$environment" == "" ]]
then
    read -p "${orange}Enter your environment type ([dev|prod|test] default: prod): ${reset}" environment
    environment=${environment:-prod}
fi
echo "${green}The environment is running in \"${environment}\" mode.${reset}"

# Read the latest application version from git tags
git_tag_latest=$(git rev-list --tags --max-count=1)
if [ -n "$git_tag_latest" ]; then
    application_version=$(git describe --tags "$git_tag_latest")
else
    application_version="0.0.0"
fi

random_string ()
{
    cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w ${1:-32} | head -n 1
}

mysql_root_password=$(random_string 16)
mysql_user="${slug}"
mysql_password=$(random_string 16)
mysql_database="${slug//-/_}"

postgres_user="${slug}"
postgres_password=$(random_string 16)
postgres_database="${slug//-/_}"

{
    # Add host specific settings...
    echo HOST_UID=`id -u`;
    echo HOST_GID=`id -g`;
    # Environment slug and domain...
    echo ENV_SLUG="${slug}";
    echo ENV_DOMAIN="${domain}";
    # Add Mysql specific settings...
    echo MYSQL_HOST=mariadb;
    echo MYSQL_ROOT_PASSWORD=${mysql_root_password};
    echo MYSQL_USER=${mysql_user};
    echo MYSQL_PASSWORD=${mysql_password}
    echo MYSQL_DATABASE=${mysql_database};
    # Add Postgres specific settings...
    ewho POSTGRES_HOST=postgres;
    echo POSTGRES_USER=${postgres_user};
    echo POSTGRES_PASSWORD=${postgres_password};
    echo POSTGRES_DB=${postgres_database};
    # Add PHP specific settings...
    echo OPCACHE_VALIDATE_TIMESTAMPS=1;
    echo PHP_SESSION_SAVE_PATH=memcached:11211;
    echo PHP_SESSION_NAME="${spre}SESSIONID";
    # Add app specific settings and secrets...
    echo APP_VERSION=${application_version};
    echo BASIC_APP_ENV=${environment};
    echo BASIC_APP_SECRET=$(random_string);
    echo "BASIC_MARIADB_URL=mysql://${mysql_user}:${mysql_password}@mysql:3306/${mysql_database}"
    echo "BASIC_POSTGRES_URL=postgres://${postgres_user}:${postgres_password}@postgres:5432/${postgres_database}"
    echo BASIC_JWT_PASSPHRASE=$(random_string);
} > .env;
