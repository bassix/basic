#!/bin/bash

# Include bash base scripts
. bin/_base.sh
. bin/_colors.sh

echo ""
echo "Test the Let's Encrypt well-known acme challenge:"
echo ""
wget --no-check-certificate -S -O/dev/null "http://$1/.well-known/acme-challenge/foo"

echo ""
echo "Test the http to https redirect:"
echo ""
wget --no-check-certificate -S -O/dev/null "http://$1/"
