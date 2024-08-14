#amd64, arm32v7, arm64v8, ppc64le, s390x
ARG UBUNTU_ARCH
FROM $UBUNTU_ARCH/ubuntu:20.04

ARG DEBIAN_FRONTEND=noninteractive

ENV TZ=Asia/Seoul
ENV PHP_VERSION=8.1
ENV NODE_VERSION=18.x
ENV NPM_VERSION=9.8.1
ENV COMPOSER_VERSION=2.5.5
ENV LARAVEL_VERSION=10.10
ENV SERVER_NAME=${SERVER_NAME}
ENV SERVER_ALIAS=${SERVER_ALIAS}

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
        apache2 \
        curl \
        vim \
        zip \
        wget \
        git \
        software-properties-common

RUN add-apt-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y \
        php${PHP_VERSION} \
        php${PHP_VERSION}-cli \
        php${PHP_VERSION}-fpm \
        php${PHP_VERSION}-common \
        php${PHP_VERSION}-mbstring \
        php${PHP_VERSION}-xml \
        php${PHP_VERSION}-mysql \
        php${PHP_VERSION}-curl \
        php${PHP_VERSION}-gd \
        php${PHP_VERSION}-zip \
        php${PHP_VERSION}-bz2 \
        php${PHP_VERSION}-mysqli \
        php${PHP_VERSION}-pdo \
        php${PHP_VERSION}-mongodb \
        libapache2-mod-php${PHP_VERSION}

RUN apt-get install -y \
        libjpeg-turbo8-dev \
        libpng-dev \
        libfreetype6-dev \
        libfontconfig \
        zlib1g \
        libxrender1 \
        libxext6 \
        libx11-6 \
        fontconfig \
        xfonts-75dpi \
        xfonts-base \
        imagemagick \
        libmagickwand-dev \
        libmagickcore-dev

RUN a2enmod rewrite \
    && a2enmod ssl \
    && a2enmod vhost_alias

RUN curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION} | bash -
RUN apt-get update
RUN apt-get install -y nodejs
RUN npm install -g npm@${NPM_VERSION}

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --version=${COMPOSER_VERSION}
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN composer global require laravel/installer
RUN composer require mongodb/laravel-mongodb

#RUN pecl install xdebug
#RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini
#RUN echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/xdebug.ini
#RUN echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini

ENV PATH $PATH:~/.composer/vendor/bin

CMD ["apache2ctl", "-D", "FOREGROUND"]
