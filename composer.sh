#!/bin/bash

# Include bash base scripts
. bin/_base.sh
. bin/_colors.sh

cd public
composer "$@" --optimize-autoloader --classmap-authoritative
cd ..
