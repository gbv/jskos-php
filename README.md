# jskos - JSKOS data model in PHP

[![Latest Stable Version](https://poser.pugx.org/gbv/jskos/v/stable)](https://packagist.org/packages/gbv/jskos)
[![License](https://poser.pugx.org/gbv/jskos/license)](https://packagist.org/packages/gbv/jskos)
[![Total Downloads](https://poser.pugx.org/gbv/jskos/downloads)](https://packagist.org/packages/gbv/jskos)

[![Build Status](https://img.shields.io/travis/gbv/jskos-php.svg)](https://travis-ci.org/gbv/jskos-php)
[![Coverage Status](https://coveralls.io/repos/gbv/jskos-php/badge.svg?branch=master)](https://coveralls.io/r/gbv/jskos-php)

**jskos** is a PHP library for easy processing of knowledge organization systems (KOS) as classifications, thesauri, and authority files given in [JSKOS data format](http://gbv.github.io/jskos/). JSKOS is a JSON format based on [Simple Knowledge Organisation System (SKOS)](http://www.w3.org/TR/skos-reference).

# Requirements

JSKOS-PHP requires PHP 7.0 or PHP 7.1. No additional libraries are required.

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

# Usage and examples

The [jskos-php-examples repository](https://github.com/gbv/jskos-php-examples)
contains several examples, including wrappers of existing terminology services
(Wikidata, GND...) to JSKOS-API.

The examples can be tried online at <https://jskos-php-examples.herokuapp.com>.

# Contributung

See `CONTRIBUTUNG.md` for technical details.

Bugs and feature request are [tracked on GitHub](https://github.com/gbv/jskos-php/issues).

# Author and License

Jakob Voß <jakob.voss@gbv.de>

JSKOS-PHP is licensed under the LGPL license - see `LICENSE.md` for details.

# See also

JSKOS is created as part of project coli-conc: <https://coli-conc.gbv.de/>.

The current specification of JSKOS is available at <http://gbv.github.io/jskos/>.

Additional PHP packages for JSKOS processing:

* [jskos-http](https://packagist.org/packages/gbv/jskos-http)
* [jskos-rdf](https://packagist.org/packages/gbv/jskos-rdf)
