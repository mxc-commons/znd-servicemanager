# mxc-servicemanager

master:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager.svg?branch=master)](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-servicemanager/badge.svg?branch=master)](https://coveralls.io/github/mxc-commons/mxc-servicemanager?branch=master)
develop:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager.svg?branch=develop)](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-servicemanager/badge.svg?branch=develop)](https://coveralls.io/github/mxc-commons/mxc-servicemanager?branch=develop)

## Version

Release 0.5.0 created on 2018-02-27 by Frank Hein, maxence operations GmbH, Germany.

This version is based on Zend Service Manager 3.3 and can be used to substitute zend-servicemanager 3.x versions.

## Introduction

mxc-servicemanager is a component compatible to [zend-servicemanager  3.3](https://github.com/zendframework/zend-servicemanager "zend-servicemanager").
Different from zend-servicemanager this component does not support PHP 5.6.

For mxc-servicemanager we refactored several parts of zend-servicemanager for better performance. This includes configuration and setup, factory caching and service resolution.

A major design constraint is zend-servicemanager compatibility. Changes to master and develop branches of zend-servicemanager will get merged into mxc-servicemanager.

We provide a permanent fork, because we do not want to provide a fast service manager only, we also want to provide it fastly.


- [File issues, ask and discuss at the issues section of mxc-servicemanager](https://github.com/mxc-commons/mxc-servicemanager/issues)
- [Online documentation of zend-servicemanager](https://docs.zendframework.com/zend-servicemanager)

## Features / Goals

* Speed up service manager configuration via configure() (done)
* Speed up service manager configuration via the APIs: (done)
    * addAbstractFactory
    * addDelegator
    * addInitializer
    * mapLazyService
    * setAlias
    * setFactory
    * setInvokableClass
    * setService
    * setShared
* Speed up service delivery for (done)
    * aliases
    * delegators
    * invokables
    * abstract factories
* Speed up service manager assets
    * ConfigAbstractFactory (done)
    * ReflectionAbstractFactory (todo)

Please refer to the "State of Progress" and "Benchmark Comparison" sections at the end of this file for status details.

## Installation

To install mxc-servicemanager:

1. Remove dependencies to zend-servicemanager from your project.

1. Add a dependency to mxc-servicemanager to your composer.json


    ```json
    "require": {
        "mxc-commons/mxc-servicemanager": "^0.5"
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

mxc-servicemanager is provided under the New BSD License. See `license.txt`.

## Discussion

Platform for discussion of all things related to this fork is the [issues section of mxc-commons/mxc-servicemanager](https://github.com/mxc-commons/mxc-servicemanager/issues).

## Tests & Benchmarks

The classes provided here are unit tested with [Sebastian Bergmann's PHPUnit](https://github.com/sebastianbergmann/phpunit) unit testing framework.
We benchmark using the [PHPBench](https://github.com/phpbench/phpbench) framework.

Please refer to the according documentation for details how to use that tools.

## State Of Progress

Please refer to the [change log](CHANGELOG.md) for a list of changes and enhancements.

## Benchmark Comparisons

Please refer to the current release documentation or to the [CHANGELOG.md](CHANGELOG.md), which contains a comprehensive benchmark comparison for
each version.

## What's next?

1. Investigate provision of a lightweight alternative to lazy_services.
2. Finalize benchmark suite
3. Investigating: Introduce service configuration pre-compiler (transform provided service manager configuration to working config (member vars) once on first request)
