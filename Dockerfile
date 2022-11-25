FROM php:8.1-cli

RUN apt-get update \
     && apt-get install -y libzip-dev \
     && docker-php-ext-install zip
RUN apt-get install sqlite3
# INSTALL COMPOSER
RUN curl -s https://getcomposer.org/installer | php
RUN alias composer='php composer.phar'

RUN mkdir XMLConverter
COPY ./app/ ./XMLConverter/app/
COPY README.md composer.json application.php ./XMLConverter/
COPY ./resources/ ./XMLConverter/resources/
WORKDIR ./XMLConverter/

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install
RUN mkdir database
RUN /usr/bin/sqlite3 ./database/sqlite_database.db
CMD /bin/bash
