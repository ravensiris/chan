FROM bitnami/php-fpm:8.1.1-prod
RUN composer global require laravel/lumen-installer
RUN install_packages php-pgsql
RUN sed -E '/;extension=(pdo_pgsql|pgsql)/s/;//g' -i $(php --ini | grep '/php.ini' | awk '{print $4}')
COPY . /app
WORKDIR /app
CMD php -S 0.0.0.0:$PORT -t public
