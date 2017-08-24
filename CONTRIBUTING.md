## Getting started

### Clone the code repository

The source code of jskos-php is managed in a git repository with master copy
at <https://github.com/gbv/jskos-php>. Clone and checkout the repository into
a local directory, for instance like this:

    $ git clone git@github.com:gbv/jskos-php.git
    $ cd jskos-php

### Install composer

Install [composer](https://getcomposer.org/). For instance download it into
the current directory:

    $ php -r "readfile('https://getcomposer.org/installer');" | php

This way composer needs to be called via `php composer.phar`. To execute it as
`composer`, make it executable move it to a directory included in your `PATH`.

Composer may also be available as system package, for instance Ubuntu >= 15.10:
    
    $ sudo apt-get install composer

### Install dependencies

Most development dependencies are listed in `composer.json`. Install them
locally: 

    $ composer install 

You may need to enable PHP extension curl:

    $ sudo apt-get install php5-curl

### Run unit tests

Unit tests are located in `tests/`, based on [PHPUnit](https://phpunit.de/). Run via:

    $ composer test

To also check code coverage you may need to enable PHP extension xdebug:

    $ sudo apt-get install php5-xdebug

The tests include a check for conformance to [PSR-2 Coding
Style](http://www.php-fig.org/psr/psr-2/). To clean up the code, run:

    $ composer style

### Build API documentation

    $ composer doc

### Class hierarchy

* trait Constructor
* trait StringContainer

* class PrettyJsonSerializable
    * DataType (uses Constructor)
        * Resource
            * Item
                * Concept
                * ConceptScheme
                * Concordance
                * Access
                * Registry
            * Mapping
    * Container
        * Listing (uses StringContainer)
        * Set
        * LanguageMap (uses Constructor)
            * LanguageMapOfStrings (uses StringContainer)
            * LanguageMapOfLists

### Create examples

Sample JSKOS servers can be placed in `examples/`. You can directly serve the
directory for testing:

    $ php -S localhost:8080 -t examples/ 

### Releases

Just use git tags.
