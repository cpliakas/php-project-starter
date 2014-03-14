# PHP Project Starter

[![Latest Stable Version](https://poser.pugx.org/cpliakas/php-project-starter/v/stable.png)](https://packagist.org/packages/cpliakas/php-project-starter)

PHP Project Starter is a command line tool that allows developers to quickly
create PHP applications that use common conventions and best-in-breed
development tools. The goals of this application are to guide developers towards
best practices and get them from zero-to-CI in seconds.

The applications created by this tool have an opinionated directory structure,
build system, and pre-configured set of services connections. Refer to the
[Tools And Conventions](#tools-and-conventions) and [Directory Structure](#directory-structure)
sections below for more details.

## Usage

#### Install The Command Line Tool

```
curl -sLO https://github.com/cpliakas/php-project-starter/releases/download/0.2.8/php-project.phar
```

Run `php php-project.phar --help` to see all options supported by the command
line tool and ensure that installation succeeded.

It is also common practice to place the `php-project.phar` file in a location
that makes it easier to access, for example `/usr/local/bin`, and renaming it
to `php-project`. Ensure the file is executable by running `chmod 755` so that
you don't have to prefix the command with `php`.

#### Create A New Project

```
php php-project.phar \
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
  * Coveralls: Follow the [Getting Started](https://coveralls.io/docs) documentation

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
* [EditorConfig](http://editorconfig.org/)

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
    |   |-- pmd-cpd.xml
    |   `-- pmd.xml
    |-- pdepend/
    |   |-- dependencies.svg
    |   `-- overview-pyramid.svg
    `-- composer.phar
