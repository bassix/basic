#!/bin/bash

# Include bash base scripts
. bin/_base.sh
. bin/_colors.sh

## Build adminer.php

./adminer.sh

## Composer install prod packages

./composer.sh install --no-dev

## Copy to targets

if [ ! -f ".distribute" ]; then
    echo "The \".distribute\" config file does not exist!"
    exit 1
fi

# @todo MacOS is not on bash 4.0 and function doesn't exist!

#mapfile -t targets < .distribute
#readarray -t targets < .distribute
targets=($(cat ".distribute"))

for target in "${targets[@]}"
do
    if [ -d "$target" ]
    then
        read -p "Do you want to run \"rsync ./web/ $target\" (y/n)? " doRsync
        if [ "$doRsync" == "y" ]
        then
            rsync -avhr \
                --numeric-ids \
                --exclude 'config.php' \
                --exclude '*.dist.*' --exclude '**/*.dist.*' \
                --exclude 'tests' --exclude '**/tests' \
                --exclude 'var/cache' --exclude '**/var/cache' \
                --exclude 'php-cs-fixer' --exclude '**/php-cs-fixer' \
                --include '*/' \
                --include '.htaccess' --include '**/.htaccess' \
                --include '.init.php' \
                --include '*.php' --include '**/*.php' \
                --include '*.html' --include '**/*.html' \
                --include '*.html.tpl' --include '**/*.html.tpl' \
                --include '*.css' --include '**/*.css' \
                --include '*.js' --include '**/*.js' \
                --include '*.png' --include '**/*.png' \
                --include '*.jpg' --include '**/*.jpg' \
                --include '*.svg' --include '**/*.svg' \
                --include '*.ico' --include '**/*.ico' \
                --include '*.otf' --include '**/*.otf' \
                --include '*.ttf' --include '**/*.ttf' \
                --include '*.woff' --include '**/*.woff' \
                --include '*.woff2' --include '**/*.woff2' \
                --exclude '*' \
                --delete \
            ./app/ "$target"
        else
            echo "rsync to \"$target\" aborted!"
        fi
    else
        echo "The configured target \"$target\" does not exist!"
    fi
done

#--exclude 'var/*.sqlite3' \
#--exclude 'log/*.log' \
#--exclude '.*' --exclude '**/.*' \

## Composer install dev packages

./composer.sh install --dev
