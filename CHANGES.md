# Changelog

This changelog tracks features and fixes of jskos PHP library.

## ...

* Add Registry type URI
* Normalize JSON serialization of LanguageMaps (#12)

## 0.3.3

* Fix method Set->findURI to actually return an index
* Add optional types parameter to jsonLDSerialize
* Add support of Item field location

## 0.3.2

* Add helper method Resource::guessClassFromTypes
* Include default type URI for resources

## 0.3.1

* Fix method LanguageMapOfLists->contains
* Add unit tests

## 0.3.0

* Rename method jsonSerializeRoot to jsonLDSerialize
* Remove ConceptType
* Move Page to package jskos-http
* Add missing Item field editorialNote
* Rename method findMember to contains and make public

## 0.2.0

* Move Service and Server to module jskos-http
* Remove API documentation with Doxygen
* Remove implicit json_decode
* Rename Object to Resource

## 0.1.7

* Move Client to module of its own
* Fix initialization of non-closed sets
* Remove json_decode

## 0.1.6

* Ensure Sets and Listings don't contain duplicate values

## 0.1.5

* Move startDate, endDate, relatedDate, and location from Concept to Item

## 0.1.4

* Add new JSKOS Object Access, used in Concept Schemes, Registries, and Concordances
* Fix Registry license field

## 0.1.3

* Add data types LanguageMapOfStrings and LanguageMapOfLists

## 0.1.2

* Extent Sets and List with map and implode

## 0.1.1

* Require PHP 7
* Enforce autoloading
* Add JSKOS Sets and Lists
* Add strict field validation

## 0.0.13

* Add ConfiguredService helper class

## 0.0.12

* Add Access-Control-Allow-Origin header in JSKOS Server

## 0.0.11

* Align with JSKOS 0.1.2: fields extend, location, license

## 0.0.10

* Add URISpaceService

## 0.0.9

### Added

* Improve preprocessing of request by Server before it is passed to Service

### Fixed

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

