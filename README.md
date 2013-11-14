# PHP Project Starter

This application provides an opinionated template outlining directory structure,
dotfiles, build systems, and services connections that can be used to start a
PHP project more efficiently using common conventions. It also provides a
command line tool that generates a skeleton project from the template so you
can be up and running with your new project in seconds.

## Usage

#### Install The Command Line Tool

The following is a copy-pasta snippet to download Composer and install the PHP
Project Starter tool with its dependencies.

```
mkdir php-project-starter && cd php-project-starter
curl -sS https://getcomposer.org/installer | php
php composer.phar require cpliakas/php-project-starter:*
```

Run `vendor/bin/php-project --help` to see all options supported by the command
line tool and ensure that installation succeeded.

#### Create A New Project

```
vendor/bin/php-project \
  --label="My Project" \
  --description="A longer description for My Project" \
  --namespace="My\Project" \
  cpliakas/my-project \
  ../path/to/working-copy
```

#### Make A Repository On GitHub

[Make a new repository](https://help.github.com/articles/create-a-repo#make-a-new-repository-on-github)
matching the project name (e.g. `cpliakas/my-project`) and push your code. Note
that the remote repository is already set.

```
cd ../path/to/working-copy
git push -u origin master
```

#### Configure Other Services
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
