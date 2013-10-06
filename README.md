# PHP Project Starter

This application provides an opinionated template outlining directory structure,
dotfiles, build systems, and services connections that can be used to start a
PHP project more efficiently using common conventions. It also provides a
command line tool that generates a skeleton project using the template so you
can be up and running in seconds.

## Installation

This project is most often used as a standalone application. Follow Composer's
[Installation](https://github.com/composer/composer/blob/master/doc/00-intro.md#installation---nix)
and [Usage](https://github.com/composer/composer/blob/master/doc/00-intro.md#using-composer)
guides to pull in the required dependencies.

Otherwise this library can be installed with [Composer](http://getcomposer.org/)
by adding it as a dependency to your composer.json file.

```json
{
    "require": {
        "cpliakas/php-project-starter": "*"
    }
}
```

Please refer to [Composer's documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction)
for installation and usage instructions.

## Tools and Services

Tools and services that this builder expects the PHP project being started to
embrace.

### Dependency Management

* [Composer](http://getcomposer.org/)

### Build & CI

* [PHPUnit](https://github.com/sebastianbergmann/phpunit/)
* [Apache Ant](http://ant.apache.org/)
* [Jenkins](http://jenkins-ci.org/)
* [Travis CI](https://travis-ci.org/)

### Code Quality

* [PHPLOC](https://github.com/sebastianbergmann/phploc)
* [PHP Depend](http://pdepend.org/)

### Services

* [GitHub](https://github.com/)
* [Packagist](https://packagist.org/)
* [Coveralls](https://coveralls.io/)
* [Badge Poser](https://poser.pugx.org/)

### Conventions

* [Template for Jenkins Jobs for PHP Projects](http://jenkins-php.org/)

## Directory Structure

@todo

## Command Line

@todo
