FROM fazy/apache-symfony
ADD . /app
 
RUN    apt-get update \
    && apt-get -yq install \
        mysql-server \
        php5-mysql \
    && rm -rf /var/lib/apt/lists/*
 
RUN curl -s https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN service mysql start
