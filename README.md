# PHP Project Starter

This application provides an opinionated template outlining directory structure,
dotfiles, build systems, and services connections that can be used to start a
PHP project more efficiently using common conventions. It also provides a
command line tool that generates a skeleton project from the template so you
can be up and running with your new project in seconds.

## Using The CLI Tool (Recommended)

@todo

## Manually Starting From The Template

* Initialize your new project's repository:
  * `mkdir myproj`: Creates a directory for your project
  * `cd myproj`: Changes the current working directory to your project
  * `git init`: Sets up the necessary Git files
* Pull in the template:
  * `git remote add starter https://github.com/cpliakas/php-project-starter`
  * `git filter-branch --prune-empty --subdirectory-filter template starter`
* Replace the template variables:
  * `{{ project.name }}`: The project's name in `vendor/project` format
  * `{{ project.label }}`: The project's display name, e.g. `My Project`
  * `{{ project.description }}`: The project's longer description
  * `{{ project.namespace }}`: PSR-0 namespace, e.g. `MyProject`, `SubProject\\MyComponent`
  * `{{ copyright.year }}`: Usually the current year or range of years
  * `{{ copyright.holders }}`: Usually the vendor's real name

## Tools And Conventions

Tools and conventions that this template expects the PHP project being started
to embrace.

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
* [PHP Standards Recommendations (PSR)](http://www.php-fig.org/)
* [The MIT License (MIT)](http://opensource.org/licenses/MIT)

## Directory Structure

@todo
