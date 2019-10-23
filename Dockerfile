FROM decyt/nginx-php-fpm:latest

RUN apk --no-cache add php7-simplexml

# Configure nginx
COPY nginx-php-fpm/nginx/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY nginx-php-fpm/php/fpm-pool.conf /etc/php7/php-fpm.d/zzz_custom.conf
COPY nginx-php-fpm/php/php.ini /etc/php7/conf.d/zzz_custom.ini

# Configure supervisord
COPY nginx-php-fpm/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www/html
COPY . /var/www/html/

RUN mkdir -p /var/www/html/tmp && \
	mkdir -p /var/www/html/tmp/cache && \
	mkdir -p /var/www/html/tmp/cache/persistent && \
	mkdir -p /var/www/html/tmp/cache/models && \
	mkdir -p /var/www/html/tmp/logs

RUN chmod 777 /var/www/html/tmp -R

RUN composer install --ignore-platform-reqs

RUN wget https://api.github.com/repos/gpabloandres/siep/commits/master && mv master /var/www/html/webroot/master.json
RUN wget https://api.github.com/repos/gpabloandres/siep/commits/developer && mv developer /var/www/html/webroot/developer.json

#COPY /var/www/html/Plugin/DebugKit/webroot /var/www/html/webroot/debug_kit

EXPOSE 80 443
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
