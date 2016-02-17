# jskos - access and serve JSKOS data and services

[![Build Status](https://img.shields.io/travis/gbv/jskos-php.svg)](https://travis-ci.org/gbv/jskos-php)
[![Coverage Status](https://coveralls.io/repos/gbv/jskos-php/badge.png?branch=master)](https://coveralls.io/r/gbv/jskos-php)
[![Latest Stable Version](https://img.shields.io/packagist/v/gbv/jskos.svg)](https://packagist.org/packages/gbv/jskos)

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
require_once __DIR__ . '/vendor/autoload.php'

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

