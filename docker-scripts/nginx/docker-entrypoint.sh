#!/bin/bash

set -e

echo ">> DOCKER-ENTRYPOINT: GENERATING SSL CERT"

cd /var/www/app
chmod a+x webroot/js webroot/css webroot/img webroot/font

nginx -c /etc/nginx/nginx.conf -g "daemon off;"

exec "$@"