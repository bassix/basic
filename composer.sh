#!/bin/bash

# Include bash base scripts
. bin/_base.sh
. bin/_colors.sh

cd web
composer --no-progress --optimize-autoloader ----classmap-authoritative --prefer-dist --ignore-platform-reqs --verbose "$@"
cd ..
