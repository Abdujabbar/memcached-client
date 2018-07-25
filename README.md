memcached-client
====================================

This is another client class of memcached.


Requirements
====================================
- memcached
- php >= 7


Running tests
====================================
First you need run

`
composer update
`

on root directory

then you can run tests

`
./vendor/bin/phpunit --colors --bootstrap=./src/bootstrap.php ./tests/
`


Travis ci status
==================================

[![Build Status](https://api.travis-ci.org/Abdujabbor/memcached-client.svg?branch=master)](https://github.com/Abdujabbor/memcached-client)
