#!/bin/bash

# Include bash base scripts
. bin/_base.sh
. bin/_colors.sh
. bin/_env.sh

sudo apt update
sudo make-ssl-cert generate-default-snakeoil -y

# Generate a SSL certificate
# Special feature: we sign the certificate ourselves and it is generated without a passphrase!
# Attention! DO NOT use this script on a production environment! This is only a helper for local development environment!
# @link http://blog.justin.kelly.org.au/how-to-create-a-self-sign-ssl-cert-with-no-pa/
if [[ -f "certs/${APP_SLUG}.key" ]]
then
    echo "${underline}${green}The SSL certificate \"./certs/${APP_SLUG}.key\" for the web server exists!${reset}"
else
    sh -c "sed -e 's#__APP_SLUG__#${APP_SLUG}#g' -e 's#__APP_DOMAIN__#${APP_DOMAIN}#g' openssl/openssl-sample.cnf > openssl/openssl.cnf"

    openssl genrsa -out ./certs/${APP_SLUG}.key 1024
    openssl req -new -key ./certs/${APP_SLUG}.key -out ./certs/${APP_SLUG}.csr -config ./openssl/openssl.cnf -subj "/C=DE/ST=NRW/L=Cologne/O=Wirecard/OU=SUPR/CN=${APP_DOMAIN}"
    openssl x509 -req -days 128 -in ./certs/${APP_SLUG}.csr -signkey ./certs/${APP_SLUG}.key -out ./certs/${APP_SLUG}.crt

    chmod 660 ./certs/${APP_SLUG}.crt
    chmod 660 ./certs/${APP_SLUG}.csr
    chmod 660 ./certs/${APP_SLUG}.key

    echo "${underline}${green}The SSL Cert for the Web-Server created!${reset}"
fi
