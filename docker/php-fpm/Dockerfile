FROM phpdockerio/php71-fpm:latest

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.1-mcrypt php7.1-mysql php7.1-intl php7.1-mbstring php7.1-sqlite3 php7.1-memcached\
    && phpenmod memcached \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
COPY docker/php-fpm/php-ini-overrides.ini /etc/php/7.1/fpm/conf.d/99-overrides.ini
WORKDIR "/var/www/myapp"
# Setup the Composer installer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');"
COPY composer.json composer.lock ./
RUN php composer.phar install --no-dev
COPY Config/  ./Config/
COPY Controller/ ./Controller/
COPY logs/ ./logs/
COPY Model/ ./Model/
COPY View/ ./View/
COPY webroot/ ./webroot/
RUN mkdir -p tmp/cache && chmod -R 777 tmp
