# mxc-servicemanager

master:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager.svg?branch=master)](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-servicemanager/badge.svg?branch=master)](https://coveralls.io/github/mxc-commons/mxc-servicemanager?branch=master)
develop:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager.svg?branch=develop)](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-servicemanager/badge.svg?branch=develop)](https://coveralls.io/github/mxc-commons/mxc-servicemanager?branch=develop)

## Version

Release 0.4.1 created on 2018-02-20 by Frank Hein, maxence operations GmbH, Germany.

This version is based on Zend Service Manager 3.3.2 and can be used as substitute for zend-servicemanager 3.x versions.

## Introduction

mxc-servicemanager is a component compatible to [zend-servicemanager  3.3](https://github.com/zendframework/zend-servicemanager "zend-servicemanager").
Different from zend-servicemanager this component does not support 5.6.

For mxc-servicemanager we refactored several parts of zend-servicemanager for better performance. This includes configuration and setup, factory caching and service resolution.

A major design constraint is zend-servicemanager compatibility. Changes to master and develop branches of zend-servicemanager will get merged into mxc-servicemanager.

Our motivation to do this is our need for a fast servicemanager component and our commitment to open source.


- [File issues, ask and discuss at the issues section of mxc-servicemanager](https://github.com/mxc-commons/mxc-servicemanager/issues)
- [Online documentation of zend-servicemanager](https://docs.zendframework.com/zend-servicemanager)

## Features / Goals

* Speed up service manager configuration via configure() (almost done)
* Speed up service manager configuration via the APIs: (done with 0.1.0)
    * addAbstractFactory
    * addDelegator
    * addInitializer
    * mapLazyService
    * setAlias
    * setFactory
    * setInvokableClass
    * setService
    * setShared
* Speed up service delivery for (done with 0.2.0)
    * aliases
    * delegators
    * invokables
    * abstract factories
* Speed up service manager assets
    * ConfigAbstractFactory (done with 0.4.0)
    * ReflectionAbstractFactory

Goal of our activities is to exploit PHP capabilities as far as possible for performance enhancements without giving up on backwards compatibility to
zend-servicemanager 3.3.2 (currently). We are working on optimizing the PHP implementation in order to find out what the particular requirements for
maximum speed actually are. Another thing we want to learn about is how to streamline service manager configuration in order to ease comprehension and
effectivity.

Based on what we learn we plan to provide a PHP core component or extension library implemented in C, which will combine the functionality and
compatibility of the PHP implementation with the performance of a C implementation. Work on that will not start before 07-2018. Please do not expect stable or even visible results early.

Please refer to the "State of Progress" and "Benchmark Comparison" sections at the end of this file for details on our current achievements towards the goals.

## Installation

To install mxc-servicemanager:

1. Remove dependencies to zend-servicemanager from your project.

1. Add a dependency to mxc-servicemanager to your composer.json


    ```json
    "require": {
        "mxc-commons/mxc-servicemanager": "^0.4"
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

Enhancements:

1. Refactor ReflectionAbstractFactory.
2. Provide benchmarks modelling real world use cases (abstract factories centric app, arbitrary app, config based app, setters api based app, ...).
3. Remove white box unit tests, that test that features are implemented in a particular way, if this implementation changes.
4. Investigating: Introduce service configuration pre-compiler (transform provided service manager configuration to working config (member vars) once on first request)
5. Investigating: Introduce ServiceManager pre-compiler
    (automatically and dynamically provide a service manager implementation which is optimized to support only the features actually used by the application)
6. Provide tests and benchmarks for all features and changes provided by this fork.
