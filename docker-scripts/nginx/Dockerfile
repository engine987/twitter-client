FROM phpdockerio/nginx:latest

COPY ./nginx/docker-entrypoint.sh /opt/docker-entrypoint.sh 
COPY ./nginx/nginx.conf /etc/nginx/nginx.conf

RUN set -x \
	&& apk add --no-cache \
			bash \
			shadow && \
			chmod u+rx,g+rx,o+rx,a-w /opt/docker-entrypoint.sh && \
            usermod -u 10777 nginx && \
            groupmod -g 10777 nginx && \
            chown -R nginx:nginx /opt/ && \
            mkdir -p /nginx/tmp/ && \
            chown -R nginx:nginx /nginx/ && \
            mkdir -p /var/www/app && \
            chown -R nginx:nginx /var/www/app && \
            mkdir -p /var/www/app/logs && \
            chown -R nginx:nginx /var/www/app/logs

USER nginx

VOLUME ["/var/www/app"]
WORKDIR /var/www/app
ENTRYPOINT ["/opt/docker-entrypoint.sh"]