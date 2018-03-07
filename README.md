# mxc-servicemanager

master:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager.svg?branch=master)](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-servicemanager/badge.svg?branch=master)](https://coveralls.io/github/mxc-commons/mxc-servicemanager?branch=master)
develop:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager.svg?branch=develop)](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-servicemanager/badge.svg?branch=develop)](https://coveralls.io/github/mxc-commons/mxc-servicemanager?branch=develop)

## Version

Release 0.7.1 created on 2018-03-07 by Frank Hein, maxence operations GmbH, Germany.

This version is based on Zend Service Manager 3.x and is backwards compatible with it.
## Introduction

mxc-servicemanager is a component compatible to [zend-servicemanager  3.x](https://github.com/zendframework/zend-servicemanager "zend-servicemanager"). It can be used to substitute zend-servicemanager 3.x versions.
Different from zend-servicemanager this component does not support PHP 5.6.

For mxc-servicemanager we refactored several parts of zend-servicemanager for better performance. This includes configuration and setup, factory caching and service resolution.

mxc-servicemanager will be kept compatible to zend-servicemanager. Changes to master and develop branches of zend-servicemanager will get merged into mxc-servicemanager as appropriate and applicable.

- [File issues, ask and discuss at the issues section of mxc-servicemanager](https://github.com/mxc-commons/mxc-servicemanager/issues)
- [Online documentation of zend-servicemanager](https://docs.zendframework.com/zend-servicemanager)

## Features

* Speed up service manager configuration via configure()
* Speed up service manager configuration via the APIs:
    * addAbstractFactory
    * addDelegator
    * addInitializer
    * mapLazyService
    * setAlias
    * setFactory
    * setInvokableClass
    * setService
    * setShared
* Speed up service delivery for
    * aliases
    * delegators
    * invokables
    * abstract factories
* Speed up service manager assets
    * ConfigAbstractFactory
* Comprehensive benchmark suite

## Installation

To install mxc-servicemanager:

1. Remove dependencies to zend-servicemanager from your project.

1. Add a dependency to mxc-servicemanager to your composer.json

    ```json
    "require": {
        "mxc-commons/mxc-servicemanager": "^0.7"
    }
    ```

2. Configure PSR-4 compliant autoloading of the namespace Zend\ServiceManager. If you use the recommended way of composer based autoloading, add this configuration to your composer.json

    ```json
    "autoload": {
        "psr-4": {
            "Zend\\ServiceManager\\": "src/"
        }
    },
    ```

3. Run composer update

Now you can use Zend\ServiceManager the way you are used to use it. zend-servicemanager is transparently replaced by mxc-servicemanager. mxc-servicemanager
instances get created by `new Zend\ServiceManager\ServiceManager` as before.

## License

mxc-servicemanager is provided under the New BSD License. See [`LICENSE.md`](LICENSE.md).

## Discussion

Platform for discussion of all things related to this fork is the [issues section of mxc-commons/mxc-servicemanager](https://github.com/mxc-commons/mxc-servicemanager/issues).

## Status

Please refer to the [`CHANGELOG.md`](CHANGELOG.md) for a list of changes and enhancements. A comprehensive benchmark comparison is included for
each version. A brief description of the benchmark tests is provided in [`BENCHMARKS.md`](BENCHMARKS.md).

## Credits

This work is based on [zend-servicemanager](https://github.com/zendframework/zend-servicemanager), which is part of the [Zend Framework](https://github.com/zendframework/zendframework). This work would not have been possible without the work of Matthew Weier O'Phinney (@weierophinney) and the numerous people contributing to Zend Framework.

Unit tests are done using  [Sebastian Bergmann's PHPUnit](https://github.com/sebastianbergmann/phpunit) unit testing framework (@sebastianbergmann).

Benchmarks are done using [Daniel Leech's PHPBench](https://github.com/phpbench/phpbench) benchmark framework (@dantleech).


