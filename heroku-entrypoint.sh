#!/usr/bin/env bash

export NGINX_HTTP_PORT_NUMBER=$PORT

set -a
# Convert DATABASE_URL
eval $(echo $DATABASE_URL | gawk '{match($0,/(.*):\/\/(.*):(.*)@(.*):(.*)\/(.*)/,m); print export "DB_CONNECTION="m[1];print export "DB_USERNAME="m[2];print "DB_PASSWORD="m[3];print export "DB_HOST="m[4];print export "DB_PORT="m[5];print export "DB_DATABASE="m[6]}')

case $DB_CONNECTION in
    "postgres")
        export DB_CONNECTION="pgsql"
    ;;
esac

/opt/bitnami/scripts/nginx/entrypoint.sh /opt/bitnami/scripts/nginx/run.sh &
exec php-fpm -F --pid /opt/bitnami/php/tmp/php-fpm.pid -y /opt/bitnami/php/etc/php-fpm.conf
