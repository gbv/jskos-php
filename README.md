# JSKOS-PHP - access and serve JSKOS data and services

[![Build Status](https://img.shields.io/travis/gbv/jskos-php.svg)](https://travis-ci.org/gbv/jskos-php)
[![Latest Stable Version](https://img.shields.io/packagist/v/gbv/jskos-php.svg)](https://packagist.org/packages/gbv/jskos-php)

*This is an early draft of a PHP library for processing JSKOS data*.

# Installation

Install the latest version with

~~~bash
composer require gbv/jskos-php
~~~

To add the package as a dependency to your project, create a `composer.json` like the following:

~~~json
{
    "require": {
        "gbv/jskos-php": "*"
    }
}
~~~

# Basic Usage

~~~php
<?php

use JSKOS;

...

?>
~~~

## About

### Requirements

* JSKOS-PHP works with PHP 5.6 or above.

### Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/gbv/jskos-php/issues)

### Author

Jakob Voß <jakob.voss@gbv.de>

### License

JSKOS-PHP is licensed under the LGPL license - see `LICENSE.md` for details.

### See alse

JSKOS is created as part of project coli-conc: <https://coli-conc.gbv.de>.

