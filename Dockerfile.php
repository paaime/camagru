FROM php:8.2-apache

# Get the arguments
ARG DBNAME
ARG DBHOST
ARG DBUSER
ARG DBPASS
ARG DBPORT
ARG ROOT

COPY ./camagru/app /var/www/app
COPY ./camagru/public /var/www/html
RUN apt-get update && apt-get upgrade -y
RUN apt-get install msmtp zlib1g-dev libpng-dev libjpeg-dev -y
RUN docker-php-ext-configure gd --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql exif gd
RUN a2enmod rewrite
RUN service apache2 restart
COPY smtpsettings /smtpsettings
RUN mv /smtpsettings ~/.msmtprc
RUN chmod -R 755 /var/www/
RUN chmod 0777 /var/www/html/post_images/
RUN chmod 600 ~/.msmtprc && cp -p ~/.msmtprc /etc/.msmtp_php && chown www-data:www-data /etc/.msmtp_php
RUN touch /var/log/msmtp.log && chown www-data:www-data /var/log/msmtp.log
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN rm -rf /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini-production
RUN echo "sendmail_path = \"/usr/bin/msmtp -C /etc/.msmtp_php --logfile /var/log/msmtp.log -a paime -t\"" >> /usr/local/etc/php/php.ini
RUN sed -i \
    -e "s|__DBNAME__|${DBNAME}|g" \
    -e "s|__DBHOST__|${DBHOST}|g" \
    -e "s|__DBUSER__|${DBUSER}|g" \
    -e "s|__DBPASS__|${DBPASS}|g" \
    -e "s|__DBPORT__|${DBPORT}|g" \
    -e "s|__ROOT__|${ROOT}|g" \
    /var/www/app/core/config.php

EXPOSE 80