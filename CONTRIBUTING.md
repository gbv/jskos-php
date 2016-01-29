## Getting started

### Install composer

Install [composer](https://getcomposer.org/). For instance download it into
the current directory:

    $ php -r "readfile('https://getcomposer.org/installer');" | php

If installed globally, replace `php composer.phar` with `composer` in the
following examples.

## Install dependencies

Dependencies are listed in `composer.json`. 

    $ php composer.phar install 

## Testing

The code is checked with [PHP Parallel Lint](https://github.com/JakubOnderka/PHP-Parallel-Lint) and [PHPUnit](https://phpunit.de/):

    $ php composer.phar test

Unit tests are located in `tests/`.

## Create documentation

Please document code with [doxygen](http://www.stack.nl/~dimitri/doxygen/).

