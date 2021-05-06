FROM quay.io/aptible/ubuntu:18.04

# RUN apt-get update && apt-get -y install apache2 php7.2 curl vim mysql-server && echo '<?php phpinfo();' > /var/www/html/test.php

RUN apt-get update && apt-get -y install apache2 php7.2 curl vim mysql-server php7.2-mysql && rm /var/www/html/index.html && rmdir /var/www/html

COPY html /var/www/html
COPY html/php.ini /etc/php/7.2/apache2/conf.d/99-x-custom.ini

# install agent
RUN curl -L 'https://github.com/elastic/apm-agent-php/releases/download/v1.0.1/apm-agent-php_1.0.1_all.deb' > /tmp/apm-agent-php_1.0.1_all.deb && dpkg -i /tmp/apm-agent-php_1.0.1_all.deb

CMD service apache2 start && \
    service mysql start && \
    mysql -u root -e 'create database testdrive' && \
    mysql -u root testdrive < /var/www/html/db-init.sql && \
    /var/www/html/yii-1.1.23.445827/testdrive/protected/yiic migrate --interactive=0 && \
    tail -f /var/log/apache2/*.log
