FROM php:5.6-apache

MAINTAINER Delve Labs Inc. <info@delvelabs.ca>

RUN apt-get update \
    && apt install locales \
    && locale-gen en_CA en_CA.UTF-8 en_US en_US.UTF-8 \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/log/*

ENV LANG en_US.UTF-8
ENV LC_ALL en_US.UTF-8

# Disable dialog selection for packages
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update \
    && apt-get upgrade -y \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# add the php.ini for date timezone error
COPY ./src/wivet.php.ini /usr/local/etc/php/conf.d/wivet.php.ini

# Copy wivet's source code
COPY ./src/www/ /var/www/html/

RUN chown www-data:www-data -R * && \
    chmod 777 /var/www/html/offscanpages/statistics/
