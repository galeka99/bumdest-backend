# GET LATEST NODEJS
FROM node:latest as node_stage
# GET PHP 8.1 IMAGE
FROM wyveo/nginx-php-fpm:php81

# SET TIMEZONE
RUN ln -snf /usr/share/zoneinfo/Asia/Jakarta /etc/localtime && echo 'Asia/Jakarta' > /etc/timezone

# COMBINING NODE
COPY --from=node_stage /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node_stage /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

WORKDIR /var/www/html
COPY . /var/www/html
RUN rm -rf /var/www/html/vendor
RUN rm -rf /var/www/html/.env
RUN chmod 777 -R storage/
RUN composer install --optimize-autoloader --no-interaction --no-progress
RUN npm install
RUN npm run production

RUN rm -rf /etc/nginx/conf.d/default.conf
COPY ./nginx.conf /etc/nginx/conf.d/default.conf