# Changelog

This changelog tracks features and fixes of jskos PHP library.

## Unreleased

* Fix Acess-Control-Expose-Headers header

## 0.0.8

### Added

* Conform to [PSR-2 coding style](http://www.php-fig.org/psr/psr-2/) and ensure
  conformance via test

* New static method primaryTypes for automatically setting JSKOS 'type' field.

* Server now uses a [PSR-3 logger interface](http://www.php-fig.org/psr/psr-3/)
  If [package psr/log](https://packagist.org/packages/psr/log) is not loaded, 
  Server defines a minimal subset of PSR-3.

* Several other extensions to Server.

