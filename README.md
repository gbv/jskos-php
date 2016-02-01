# jskos - access and serve JSKOS data and services

[![Build Status](https://img.shields.io/travis/gbv/jskos-php.svg)](https://travis-ci.org/gbv/jskos-php)
[![Coverage Status](https://coveralls.io/repos/gbv/jskos-php/badge.png?branch=master)](https://coveralls.io/r/satooshi/php-coveralls)
[![Latest Stable Version](https://img.shields.io/packagist/v/gbv/jskos-php.svg)](https://packagist.org/packages/gbv/jskos-php)

**jskos** is a PHP library for easy processing of knowledge organization systems (KOS) as classifications, thesauri, and authority files given in [JSKOS data format](http://gbv.github.io/jskos/). JSKOS is a JSON format based on [Simple Knowledge Organisation System (SKOS)](http://www.w3.org/TR/skos-reference).

# Installation

## With composer

Install the latest version with

~~~bash
composer require gbv/jskos
~~~

This will automatically create `composer.json` for your project (unless it already exists) and add jskos as dependency. Composer also generates `vendor/autoload.php` to get autoloading of all dependencies: 

~~~php
require_once __DIR__ . '/vendor/autoload.php'

$concept = new JSKOS\Concept( [ "uri" => "http://example.org" ] );
echo $concept;
~~~

## Manually

Download the jskos library directory `src` and put it in a directory of your choice. Then enable autoloading for its classes by pointing to this directory: 

~~~php
spl_autoload_register(function($class) {
    # location of JSKOS library relative to this file
    static $JSKOS = '../src/';
    $class = explode('\\',$class);
    if ($class[0] == 'JSKOS') {
        require_once __DIR__."/$JSKOS$class[1].php";
    }
});

$concept = new JSKOS\Concept( [ "uri" => "http://example.org" ] );
echo $concept;
~~~

# About

## Requirements

* JSKOS-PHP works with PHP 5.6 or above.

## Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/gbv/jskos-php/issues)

## Author

Jakob Voß <jakob.voss@gbv.de>

## License

JSKOS-PHP is licensed under the LGPL license - see `LICENSE.md` for details.

## See alse

JSKOS is created as part of project coli-conc: <https://coli-conc.gbv.de/>.

The current specification of JSKOS is available at <http://gbv.github.io/jskos/>.

The current specification of JSKOS API is available at <http://gbv.github.io/jskos-api/>.

