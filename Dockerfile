# https://laravel.com/docs/10.x/deployment#server-requirements
# https://github.com/mlocati/docker-php-extension-installer#supported-php-extensions
FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    curl \
    git \
    libcurl4-openssl-dev \
    libicu-dev \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    supervisor \
    zip

RUN docker-php-ext-install \
    bcmath \
    ctype \
    curl \
    dom \
    fileinfo \
    gd \
    intl \
    mysqli \
    opcache \
    pcntl \
    pdo_mysql \
    sockets \
    xml \
    zip \
    exif

# Redis
RUN pecl install redis && \
    docker-php-ext-enable redis

# Nova 4 requires Node 14. We upgrade NPM to make the install a little faster
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
    apt install -y nodejs && \
    npm install -g npm@latest

# Providing defaults in case not sent by user
ARG APP_ENV=production
ENV APP_ENV=${APP_ENV}
ENV CONTAINER_ROLE=${CONTAINER_ROLE}

COPY ./ /code
WORKDIR /code

RUN chmod +x /code/infrastructure/scripts/*

# Run setup composer install and npm install and copy main files
RUN /code/infrastructure/scripts/setup.sh

# We use start.sh to select if its app, scheduler or horizon
CMD ["/code/infrastructure/scripts/start.sh"]
