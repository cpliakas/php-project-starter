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
  /path/to/working-copy
```

#### Make A Repository On GitHub

[Make a new repository](https://help.github.com/articles/create-a-repo#make-a-new-repository-on-github)
matching the project name (e.g. `cpliakas/my-project`) and push your code. Note
that the `origin` remote is already set in the repository.

```
cd ../path/to/working-copy
git push -u origin master
```

#### Configure Other Services

  * Packagist: Follow the [Publish It](https://packagist.org/) section
  * Travis CI: Follow steps one and two of the [Getting Started](http://about.travis-ci.org/docs/user/getting-started/#Step-one%3A-Sign-in) documentation
  * Coveralls: Follow the [Getting Started](https://coveralls.io/docs) documentation

#### Using Apache Ant

Running `ant` in the project's root directory will download Composer, install
development dependencies, run PHPUnit, and generate a code coverage report and
software metrics in the `./build` directory.

The main targets can be found by running `ant -p` and are listed below:

* `clean`: Cleanup build artifacts
* `clean-src`: Cleanup dependency source code
* `clean-all`: Cleanup build artifacts and dependency source code
* `composer`: Run composer update
* `lint`: Perform syntax check of sourcecode files
* `pdepend`: Calculate software metrics using PHP_Depend
* `phpcpd`: Find duplicate code using PHPCPD
* `phploc`: Measure project size using PHPLOC
* `phpmd`: Perform mess detection using PHPMD, print human readable output.
* `phpmd-ci`: Perform mess detection using PHPMD, creating a log file for the CI server
* `phpunit`: Run unit tests with PHPUnit

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
* [PHPMD](http://phpmd.org/)
* [PHPCPD](https://github.com/sebastianbergmann/phpcpd)

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

### PHP Project

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
|-- phpmd.xml
|-- phpunit.xml
|-- LICENSE
`-- README.md

```

### Build Artifacts

```
.
`-- build/
    |-- coverage/
    |   `--index.html
    |-- logs/
    |   |-- clover.xml
    |   |-- jdepend.xml
    |   |-- junit.xml
    |   |-- phploc.csv
    |   `-- pmd.xml
    |-- pdepend/
    |   |-- dependencies.svg
    |   `-- overview-pyramid.svg
    `-- composer.phar
