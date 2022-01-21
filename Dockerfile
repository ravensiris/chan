FROM php:8.1.1-fpm as pgsql_exts
RUN apt-get update
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql
WORKDIR /
RUN mkdir extensions && find -iname '*pgsql.so' -exec cp {} extensions \;

FROM bitnami/php-fpm:8.1.1-prod as builder
COPY . /app
WORKDIR /app
RUN mkdir -p /app/storage/logs && chmod 777 /app/storage/ -R
RUN composer install

FROM bitnami/php-fpm:8.1.1-prod
COPY --from=pgsql_exts extensions/pdo_pgsql.so /opt/bitnami/php/lib/php/extensions/
COPY --from=pgsql_exts extensions/pgsql.so /opt/bitnami/php/lib/php/extensions/
COPY --from=builder /app /app
RUN echo 'extension="/opt/bitnami/php/lib/php/extensions/pdo_pgsql.so"' >> /opt/bitnami/php/etc/php.ini && echo 'extension="/opt/bitnami/php/lib/php/extensions/pgsql.so"' >> /opt/bitnami/php/etc/php.ini
RUN sed -E '/;clear_env/s/;//g' /opt/bitnami/php/etc/php-fpm.d/www.conf -i
#    && sed -E '/listen/s/9000/${PORT}/g' /opt/bitnami/php/etc/php-fpm.d/www.conf -i
WORKDIR /app
