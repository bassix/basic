#!/bin/bash

# Include bash base scripts
. bin/_base.sh
. bin/_colors.sh

cd web
composer install --dev
./vendor/bin/phpunit tests
cd ..
