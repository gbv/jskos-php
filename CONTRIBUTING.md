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

For optional generation of code documentation and releases and you further
need [doxygen](http://doxygen.org/). Please install as usual to your operating
system, for instance on Ubuntu:

    $ sudo apt-get install doxygen

### Run unit tests

The code is checked with [PHP Parallel Lint](https://github.com/JakubOnderka/PHP-Parallel-Lint) and [PHPUnit](https://phpunit.de/):

    $ composer test

Unit tests are located in `tests/`.

### Generate documentation

Code documentation can be generated into `doc/` if Doxygen is installed:

    $ composer doc

The result will in HTML for preview and in XML for further processing.
 
