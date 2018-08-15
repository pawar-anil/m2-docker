FROM ubuntu:16.04
MAINTAINER Anil Pawar "anilpawar1202@gmail.com"
RUN DEBIAN_FRONTEND=noninteractive apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get -y dist-upgrade && \
    DEBIAN_FRONTEND=noninteractive apt-get -yq install net-tools nginx && \
    DEBIAN_FRONTEND=noninteractive apt-get -yq install mysql-client && \
    DEBIAN_FRONTEND=noninteractive apt-get -yq install -y locales && \
    useradd -ms /bin/bash aurora
RUN locale-gen en_US.UTF-8


RUN apt-get update

RUN apt-get -y install php php-fpm php-cli php-curl php-intl php-gd php-mcrypt php-iconv php-xsl php-mbstring php-zip php-pdo php-xml php-json php-mysqli php-mysql php-xmlwriter php-xmlreader php-soap php-mysql git unzip

RUN apt install curl
RUN apt install nano

VOLUME /var/lib/mysql
VOLUME /root/.composer/cache

# Get composer installed to /usr/local/bin/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


#apt-get install wget
#wget https://packages.erlang-solutions.com/erlang-solutions_1.0_all.deb
#dpkg -i erlang-solutions_1.0_all.deb
#apt-get update
#apt-get install erlang erlang-nox
#echo 'deb http://www.rabbitmq.com/debian/ testing main' | sudo tee /etc/apt/sources.list.d/rabbitmq.list
#wget -O- https://www.rabbitmq.com/rabbitmq-release-signing-key.asc | sudo apt-key add -
#apt-get update
#apt-get install rabbitmq-server
#update-rc.d rabbitmq-server defaults
#service rabbitmq-server start





ARG MAGENTO_BASE_URL

ENV DEBUG false

ENV FPM_HOST localhost
ENV FPM_PORT 9000

ENV PHP_MEMORY_LIMIT 8G
ENV MAGENTO_ROOT "/var/www/magento"
ENV COMPOSER_GITHUB_TOKEN "c6b145d97b6febb6ef397488c64ac899c3cb86fa"
ENV COMPOSER_MAGENTO_USERNAME "150bc8dd3132a5a7a5feb9fed67bb864"
ENV COMPOSER_MAGENTO_PASSWORD "babe044872876ba5593f41ccc226b0b6"
ENV MAGENTO_RUN_MODE developer
ENV UPDATE_UID_GID true
ENV PHP_ENABLE_XDEBUG false
ENV ENABLE_SENDMAIL false

ENV M2SETUP_INSTALL_DB true
ENV M2SETUP_BASE_URL "${MAGENTO_BASE_URL:-http://magento2.local}"
ENV M2SETUP_BACKEND_FRONTNAME admin
ENV M2SETUP_ADMIN_FIRSTNAME Admin
ENV M2SETUP_ADMIN_LASTNAME User
ENV M2SETUP_ADMIN_EMAIL dummy@gmail.com
ENV M2SETUP_ADMIN_USER admin
ENV M2SETUP_ADMIN_PASSWORD admin@123
ENV M2SETUP_VERSION 2.2.2
#ENV M2SETUP_USE_SAMPLE_DATA true
ENV MYSQL_ROOT_PASSWORD ${MYSQL_ROOT_PASSWORD}
ENV MYSQL_DATABASE ${MYSQL_DATABASE}
ENV MYSQL_USER ${MYSQL_USER}
ENV MYSQL_PASSWORD ${MYSQL_PASSWORD}
ENV MYSQL_HOST ${MYSQL_HOST}
ENV MYSQL_PORT ${MYSQL_PORT}



ADD bin/* /usr/local/bin/
#ADD m2-module /usr/local/m2-module
ADD etc/php.ini /etc/php/7.0/cli/conf.d/zz-magento.ini
#ADD etc/mail.ini /etc/php/7.0/cli/conf.d/zz-mail.ini
#ADD etc/php-xdebug.ini /etc/php/7.0/cli/conf.d/zz-xdebug-settings.ini
#ADD etc/php-fpm.conf /etc/php/7.0/fpm/pool.d/php-fpm.conf
ADD etc/php-fpm.conf /etc/php/7.0/fpm/php-fpm.conf
#ADD etc/vhost.conf /etc/nginx/sites-available/default
ADD etc/vhost.conf /etc/nginx/conf.d/default.conf



EXPOSE 80

ENTRYPOINT ["/usr/local/bin/installer"]

CMD ["php-fpm7.0", "-F"]