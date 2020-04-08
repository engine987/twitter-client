FROM phpdockerio/php71-fpm:latest

RUN apt-get update \
    && apt-get -y --no-install-recommends install iputils-ping dialog apt-utils php7.1-mysql php7.1-intl php7.1-mbstring php7.1-xml php7.1-gd php7.1-sqlite php7.1-xdebug \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN echo "xdebug.remote_enable=1\n" >> /etc/php/7.1/cli/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_handler=dbgp\n" >> /etc/php/7.1/cli/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_mode=req\n" >> /etc/php/7.1/cli/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_host=10.254.254.254\n" >> /etc/php/7.1/cli/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_port=9001\n" >> /etc/php/7.1/cli/conf.d/20-xdebug.ini
RUN echo "xdebug.idekey=xdbg\n" >> /etc/php/7.1/cli/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_autostart=1\n" >> /etc/php/7.1/cli/conf.d/20-xdebug.ini

# Brighte setup
RUN mkdir -p /var/www/app

WORKDIR "/var/www/app"

EXPOSE 9000