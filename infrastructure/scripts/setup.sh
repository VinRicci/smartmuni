#!/usr/bin/env bash
set -e

echo "*****************************"
echo "Setup the docker container"
echo "Environment: ${APP_ENV}"
echo "Role: ${CONTAINER_ROLE}"
echo "*****************************"

# Opcache
echo "Opcache configuration"
cp /code/infrastructure/opcache/200_opcache.ini /usr/local/etc/php/conf.d/

# General PHP settings
echo "General php ini settings"
cp /code/infrastructure/php-ini/300_plex.ini /usr/local/etc/php/conf.d/

# Root CA Certificates
echo "Root CA Certificates installed in OS"
cp /code/infrastructure/ssl/ca-certificates.crt /etc/ssl/certs/ca-certificates.crt

# Ensure Timezone is Guatemala
echo "Timezone should be Guatemala"
ln -snf /usr/share/zoneinfo/America/Guatemala /etc/localtime && echo America/Guatemala > /etc/timezone

# Install the composer binary
echo "Installing composer..."
/code/infrastructure/scripts/composer.sh

# Run installations in the image only if we're not in local development
echo "Running composer install and npm install"
if [ "${APP_ENV}" = "local" ]; then
    echo "Since development composer runs without the --no-dev parameter"
    composer install --no-interaction --prefer-dist --optimize-autoloader
    composer dump-autoload
else
    echo "Composer production install"
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
fi

# Get the Road Runner binary
echo "Installing the road runner binary"
/code/vendor/bin/rr get-binary

echo "npm install"
npm install
npm run build
