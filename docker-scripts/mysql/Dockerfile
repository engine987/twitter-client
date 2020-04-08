FROM mysql:5.6

RUN chmod -R -775 /docker-entrypoint-initdb.d

COPY ./mysql/config.cnf /etc/mysql/mysql.conf.d/