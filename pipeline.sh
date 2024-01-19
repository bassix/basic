#!/bin/bash

# Include bash base scripts
. bin/_base.sh
. bin/_colors.sh

cd public

echo -e "${underline}${green}» Running pipeline...${reset}"
echo ""
echo -e "${underline}${green}»» Validate composer.json and composer.lock${reset}"
echo ""
composer validate

echo ""
echo -e "${underline}${green}»» Install dependencies${reset}"
echo ""
composer --no-progress --optimize-autoloader --classmap-authoritative --prefer-dist --ignore-platform-reqs --verbose install

echo ""
echo -e "${underline}${green}»» Run PHP coding standards fixer${reset}"
echo ""
php ./vendor/bin/php-cs-fixer check -n

echo ""
echo -e "${underline}${green}»» Run PHPStan static analysis${reset}"
echo ""
php ./vendor/bin/phpstan analyze src tests

echo ""
echo -e "${underline}${green}»» Run PHPUnit tests${reset}"
echo ""
php ./vendor/bin/phpunit tests

cd ..
