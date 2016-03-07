# jskos - access and serve JSKOS data and services

[![Latest Stable Version](https://poser.pugx.org/gbv/jskos/v/stable)](https://packagist.org/packages/gbv/jskos)
[![License](https://poser.pugx.org/gbv/jskos/license)](https://packagist.org/packages/gbv/jskos)
[![Total Downloads](https://poser.pugx.org/gbv/jskos/downloads)](https://packagist.org/packages/gbv/jskos)

[![Build Status](https://img.shields.io/travis/gbv/jskos-php.svg)](https://travis-ci.org/gbv/jskos-php)
[![Coverage Status](https://coveralls.io/repos/gbv/jskos-php/badge.svg?branch=master)](https://coveralls.io/r/gbv/jskos-php)
[![Coding Style](https://img.shields.io/badge/coding style-PRS--2-green.svg)](http://www.php-fig.org/psr/psr-2/)
[![Logger Interface](https://img.shields.io/badge/logger interface-PRS--3-green.svg)](http://www.php-fig.org/psr/psr-3/)

**jskos** is a PHP library for easy processing of knowledge organization systems (KOS) as classifications, thesauri, and authority files given in [JSKOS data format](http://gbv.github.io/jskos/). JSKOS is a JSON format based on [Simple Knowledge Organisation System (SKOS)](http://www.w3.org/TR/skos-reference).

# Requirements

JSKOS-PHP works with PHP 5.6 or above. No additional libraries are required.

# Installation

## With composer

Install the latest version with

~~~bash
composer require gbv/jskos
~~~

This will automatically create `composer.json` for your project (unless it already exists) and add jskos as dependency. Composer also generates `vendor/autoload.php` to get autoloading of all dependencies: 

~~~php
require_once __DIR__ . '/vendor/autoload.php';

$concept = new JSKOS\Concept( [ "uri" => "http://example.org" ] );
echo $concept->json();
~~~

## Manually with autoloading

Download the jskos library directory `src` and put it in a directory of your choice. Then enable autoloading for its classes by pointing to this directory: 

~~~php
spl_autoload_register(function($class) {
    static $JSKOS = '../src/'; # location relative to this file
    $class = explode('\\',$class);
    if ($class[0] == 'JSKOS') {
        require_once __DIR__."/$JSKOS$class[1].php";
    }
});

$concept = new JSKOS\Concept( [ "uri" => "http://example.org" ] );
echo $concept->json();
~~~

## Manually without autoloading

Download the jskos library directory `src` and put it in a directory of your choice. Then include file `JSKOS.php` which includes all library files:

~~~php
require_once 'src/JSKOS.php';

$concept = new JSKOS\Concept( [ "uri" => "http://example.org" ] );
echo $concept->json();
~~~

# Usage

API documentation is published at <http://gbv.github.io/jskos-php/>.

The `examples/` directory contains some examples to start with. To quickly run them as server scripts call:

    $ php -S localhost:8080 -t examples/

## Examples

* [wikidata.php](https://github.com/gbv/jskos-php/blob/master/examples/wikidata.php) - basic wrapper to Wikidata

# Contributung

See `CONTRIBUTUNG.md` for technical details.

Bugs and feature request are [tracked on GitHub](https://github.com/gbv/jskos-php/issues).

# Author and License

Jakob Voß <jakob.voss@gbv.de>

JSKOS-PHP is licensed under the LGPL license - see `LICENSE.md` for details.

# See alse

JSKOS is created as part of project coli-conc: <https://coli-conc.gbv.de/>.

The current specification of JSKOS is available at <http://gbv.github.io/jskos/>.

The current specification of JSKOS API is available at <http://gbv.github.io/jskos-api/>.

