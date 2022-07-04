# GET LATEST COMPOSER IMAGE
FROM composer:latest as composer_stage
# GET LATEST NODEJS
FROM node:latest-slim as node_stage
# GET PHP 8.1 IMAGE
FROM php:8.1

# INSTALLING DEPENDENCIES
RUN apt-get update && apt-get install -y git curl libpng-dev libonig-dev libxml2-dev zip unzip

# CLEAR CACHE
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# INSTALL PHP EXTENSIONS
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# COMBINING NODE
COPY --from=node_stage /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node_stage /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# GET LATEST COMPOSER
COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app
RUN rm -rf /app/vendor
RUN rm -rf /app/.env
RUN composer install
RUN npm install
RUN npm run production

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
EXPOSE 8000