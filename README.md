# mxc-servicemanager

master:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager.svg?branch=master)](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-servicemanager/badge.svg?branch=master)](https://coveralls.io/github/mxc-commons/mxc-servicemanager?branch=master)
develop:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager.svg?branch=develop)](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-servicemanager/badge.svg?branch=develop)](https://coveralls.io/github/mxc-commons/mxc-servicemanager?branch=develop)

## Version

Version 0.3.0 created on 2018-02-17 by Frank Hein, maxence operations GmbH, Germany.

This version is based on Zend Service Manager 3.3.2.

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
        "mxc-commons/mxc-servicemanager": "^0.2"
    }
    ```

2. Configure PSR-4 compliant autoloading of the namespace MxcCommons\ServiceManager. If you use the recommended way of composer based autoloading, add this configuration to your composer.json

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

## Minimum footprint version

If you want to use mxc-servicemanager without need to replace zend-servicemanager, you may use this repo, too. If you prefer not to replace dependencies to
zend-servicemanager and want a minimum footprint installation living in the MxcCommons namespace, you might want to have a look at [mxc-servicemanager-s](https://github.com/mxc-commons/mxc-servicemanager-s). That repo only
installs files different from zend-servicemanager and puts them into the MxcCommons namespace. mxc-servicemanager-s has a dependency to zend-servicemanager while this repo has not.

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

1. Refactor ConfigAbstractFactory for performance.
2. Refactor ReflectionAbstractFactory for performance.
3. Investigating: Provide benchmark tests for all features currently left out.
4. Provide benchmarks modelling real world use cases (abstract factories centric app, arbitrary app, config based app, setters api based app, ...).
5. Remove white box unit tests, that test that features are implemented in a particular way, if this implementation changes.
6. Provide benchmarks which respect internal staging (i.e. configuration array only, aliases resolved, factories called, ...).
7. Deploy test suite with mxc-servicemanager
8. Investigating: Introduce service configuration pre-compiler (transform provided service manager configuration to working config (member vars) once on first request)
9. Investigating: Introduce ServiceManager pre-compiler
    (automatically and dynamically provide a service manager implementation which is optimized to support only the features actually used by the application)


Ongoing: Provide comparison benchmarks for each release.

