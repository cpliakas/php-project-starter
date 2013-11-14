# PHP Project Starter

This application provides an opinionated template outlining directory structure,
dotfiles, build systems, and services connections that can be used to start a
PHP project more efficiently using common conventions. It also provides a
command line tool that generates a skeleton project from the template so you
can be up and running with your new project in seconds.

## Using The CLI Tool (Recommended)

* Download PHP Project Starter with Composer
  * `mkdir php-project-starter && cd php-project-starter`
  * `curl -sS https://getcomposer.org/installer | php`
  * `php composer.phar require cpliakas/php-project-starter:*`
* Create the project
  * `vendor/bin/php-project --label="My Project" --copyright-holders="Chris Pliakas" cpliakas/my-project ../path/to/working-copy`
* [Make a new repository](https://help.github.com/articles/create-a-repo#make-a-new-repository-on-github) on GitHub matching the `{{ project.name }}`, push code
  * `cd ../path/to/working-copy`
  * `git push -u origin master`
* Configure third party services
  * Packagist: Follow the [Publish It](https://packagist.org/) section
  * Travis CI: Follow steps one and two of the [Getting Started](http://about.travis-ci.org/docs/user/getting-started/#Step-one%3A-Sign-in) documentation
  * Coveralls: Follow the [Getting Started](https://coveralls.io/docs) documentation

## Manually Starting From The Template

* Initialize your new project's repository:
  * `mkdir myproj`: Creates a directory for your project
  * `cd myproj`: Changes the current working directory to your project
  * `git init`: Sets up the necessary Git files
* Pull in the template:
  * `git remote add starter https://github.com/cpliakas/php-project-starter`
  * `git filter-branch --prune-empty --subdirectory-filter template starter`
* Replace the template variables in each file:
  * `{{ project.name }}`: The project's name in `vendor/project` format
  * `{{ project.label }}`: The project's display name, e.g. `My Project`
  * `{{ project.description }}`: The project's longer description
  * `{{ project.namespace }}`: PSR-0 namespace, e.g. `MyProject`, `SubProject\\MyComponent`
  * `{{ copyright.year }}`: Usually the current year or range of years
  * `{{ copyright.holders }}`: Usually the vendor's real name
* [Make a new repository](https://help.github.com/articles/create-a-repo#make-a-new-repository-on-github) on GitHub matching the `{{ project.name }}`, push code
  * `git push -u origin master`
* Configure third party services
  * Packagist: Follow the [Publish It](https://packagist.org/) section
  * Travis CI: Follow steps one and two of the [Getting Started](http://about.travis-ci.org/docs/user/getting-started/#Step-one%3A-Sign-in) documentation
  * Coveralls: Follow the [Getting Started](https://coveralls.io/docs) documentation

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

```
.
|-- src/
|-- test/
|-- .coveralls.yml
|-- .editorconfig
|-- .gitignore
|-- .travis.yml
|-- build.xml
|-- composer.json
|-- phpunit.xml
|-- LICENSE
`-- README.md

```
