#!/usr/bin/env bash
set -e

echo "*****************************"
echo "Start the docker container"
echo "Environment: ${APP_ENV}"
echo "Role: ${CONTAINER_ROLE}"
echo "*****************************"

if [ "${CONTAINER_ROLE}" = "app" ]; then

    echo "Starting the app through octane->roadrunner"

    if [ "${APP_ENV}" != "local" ]; then

        echo "Since it production we will cache files - use php artisan optimize:clear in local"
        echo "Caching Laravel files" 
        php artisan optimize
        php artisan view:cache
        php artisan event:cache

    else

        composer install --no-interaction --prefer-dist --optimize-autoloader
        composer dump-autoload

    fi

    echo "Run database migration"
    php artisan migrate --force

    exec /usr/bin/supervisord -c /code/infrastructure/supervisor/octane.conf

elif [ "${CONTAINER_ROLE}" = "scheduler" ]; then

    echo "Starting the scheduler"
    exec /usr/bin/supervisord -c /code/infrastructure/supervisor/scheduler.conf

elif [ "${CONTAINER_ROLE}" = "horizon" ]; then

    echo "Starting horizon to manage queues"
    exec /usr/bin/supervisord -c /code/infrastructure/supervisor/horizon.conf

else
    echo "Could not match the container role \"${CONTAINER_ROLE}\""
    exit 1
fi
