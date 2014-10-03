# PHP Project Starter

[![Build Status](https://travis-ci.org/cpliakas/php-project-starter.svg?branch=master)](https://travis-ci.org/cpliakas/php-project-starter)
[![Code Coverage](https://scrutinizer-ci.com/g/cpliakas/php-project-starter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cpliakas/php-project-starter/?branch=master)
[![HHVM Status](http://hhvm.h4cc.de/badge/cpliakas/php-project-starter.svg)](http://hhvm.h4cc.de/package/cpliakas/php-project-starter)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cpliakas/php-project-starter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cpliakas/php-project-starter/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/cpliakas/php-project-starter/v/stable.svg)](https://packagist.org/packages/cpliakas/php-project-starter)
[![License](https://poser.pugx.org/cpliakas/php-project-starter/license.svg)](https://packagist.org/packages/cpliakas/php-project-starter)

PHP Project Starter is a command line tool that allows developers to quickly
create PHP applications that use common conventions and best-in-breed
development tools. The goals of this application are to guide developers towards
best practices and get them from zero-to-CI in seconds.

The applications created by this tool have an opinionated directory structure,
build system, and pre-configured set of service connections with badges ready to
go. Refer to the [Tools And Conventions](#tools-and-conventions) and
[Directory Structure](#directory-structure) sections below for more details.

See the examples below for repositories created by the PHP Project Starter tool:

* [Git Wrapper](https://github.com/cpliakas/git-wrapper)
* [HMAC Request Signer](https://github.com/acquia/hmac-request)

## Usage

#### Install The Command Line Tool

##### Download Via Browser

Download `php-project.phar` from [https://github.com/cpliakas/php-project-starter/releases/latest](https://github.com/cpliakas/php-project-starter/releases/latest),

##### Download Via Command Line

`curl -O http://www.chrispliakas.com/php-project-starter/download/latest/php-project.phar`

##### Test It Out!

Run `php php-project.phar --help` to see all options supported by the command
line tool and ensure that installation succeeded.

It is also common practice to place the `php-project.phar` file in a location
that makes it easier to access, for example `/usr/local/bin`, and renaming it
to `php-project`. Ensure the file is executable by running `chmod 755` so that
you don't have to prefix the command with `php`.

#### Create A New Project

```
php php-project.phar new \
  --label="My Project" \
  --description="A longer description for My Project" \
  --namespace="My\Project" \
  cpliakas/my-project
```

Pass the `--jenkins-url` option to post a job to Jenkins that consumes the
build artifacts.

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
  * Scritinizer CI: Follow the [Getting Started](https://scrutinizer-ci.com/docs/) documentation

#### Keeping Up-To-Date

Run the following command to update PHP Project Starter to the latest stable
version:

`php php-project.phar self-update`

## Using Apache Ant

Running `ant` in the newly created project's root directory will download
Composer, install development dependencies, run PHPUnit, and generate a code
coverage report and software metrics in the `./build` directory.

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

Common command line options that set Ant properties are listed below:

* `-Dcomposer.noselfupdate=1`: Do not run `composer self-update` during the build
* `-Dcomposer.noupdate=1`: Do not run `composer update` during the build

## Tools And Conventions

Tools and conventions that this template expects the PHP project being started
to embrace.

### Dependency Management

* [Composer](http://getcomposer.org/)

### Build & CI

* [Apache Ant](http://ant.apache.org/)
* [Jenkins](http://jenkins-ci.org/)
* [PHPUnit](https://github.com/sebastianbergmann/phpunit/)
* [Scrutinizer CI](https://scrutinizer-ci.com/)
* [Travis CI](https://travis-ci.org/)

### Code Quality

* [PHP Analyzer](https://scrutinizer-ci.com/docs/tools/php/php-analyzer/)
* [PHP Coding Standards Fixer](https://github.com/fabpot/PHP-CS-Fixer)
* [PHP Depend](http://pdepend.org/)
* [PHPCPD](https://github.com/sebastianbergmann/phpcpd)
* [PHPLOC](https://github.com/sebastianbergmann/phploc)
* [PHPMD](http://phpmd.org/)

### Services

* [Badge Poser](https://poser.pugx.org/)
* [GitHub](https://github.com/)
* [Packagist](https://packagist.org/)
* [Scrutinizer CI](https://scrutinizer-ci.com/)
* [Travis CI](https://travis-ci.org/)

### Conventions

* [EditorConfig](http://editorconfig.org/)
* [The MIT License (MIT)](http://opensource.org/licenses/MIT)
* [PHP Standards Recommendations (PSR)](http://www.php-fig.org/)
* [Template for Jenkins Jobs for PHP Projects](http://jenkins-php.org/)

## Directory Structure

### PHP Project

```
.
|-- src/
|-- test/
|-- .editorconfig
|-- .gitignore
|-- .scrutinizer.yml
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
    |   |-- pmd-cpd.xml
    |   `-- pmd.xml
    |-- pdepend/
    |   |-- dependencies.svg
    |   `-- overview-pyramid.svg
    `-- composer.phar
