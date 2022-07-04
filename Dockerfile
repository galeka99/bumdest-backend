# GET LATEST COMPOSER IMAGE
FROM composer:latest as composer_stage
# GET LATEST NODEJS
FROM node:latest as node_stage
# GET NGINX IMAGE
FROM trafex/php-nginx:latest

# SET TIMEZONE
RUN ln -snf /usr/share/zoneinfo/Asia/Jakarta /etc/localtime && echo 'Asia/Jakarta' > /etc/timezone

# COPYING COMPOSER BINARY
COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

# COPYING NODEJS BINARY
COPY --from=node_stage /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node_stage /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

WORKDIR /var/www/html
COPY . /var/www/html
RUN rm -rf /var/www/html/vendor
RUN rm -rf /var/www/html/.env
RUN composer install
RUN npm install
RUN npm run production