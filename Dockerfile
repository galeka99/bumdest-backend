# GET LATEST COMPOSER IMAGE
FROM composer:latest as composer_stage
# GET LATEST NODEJS
FROM node:latest as node_stage
# GET NGINX IMAGE
FROM trafex/php-nginx:latest

# COPYING COMPOSER BINARY
COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

# COPYING NODEJS BINARY
COPY --from=node_stage /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node_stage /usr/local/bin/node /usr/local/bin/node
COPY --from=node_stage /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

WORKDIR /app
COPY . /app
RUN rm -rf /app/vendor
RUN rm -rf /app/.env
RUN composer install
RUN npm install
RUN npm run production

COPY --chown=nginx /app /var/www/html