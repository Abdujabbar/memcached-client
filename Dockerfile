FROM php:7.2-cli

RUN apt-get update

RUN apt-get -y install memcached

RUN apt-get -y install libmemcached-tools


COPY . /app

WORKDIR /app

EXPOSE 11211