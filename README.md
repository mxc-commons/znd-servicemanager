# mxc-servicemanager

mxc-services master:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-services.svg?branch=master)](https://secure.travis-ci.org/mxc-commons/mxc-services)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-services/badge.svg?branch=master)](https://coveralls.io/github/mxc-commons/mxc-services?branch=master)
mxc-services develop:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-services.svg?branch=develop)](https://secure.travis-ci.org/mxc-commons/mxc-services)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-services/badge.svg?branch=develop)](https://coveralls.io/github/mxc-commons/mxc-services?branch=develop)

The badges above show the status of the associated repo mxc-services, where all development is done.

## Version

Version 0.2.0 created on 2018-02-16 by Frank Hein, maxence operations GmbH, Germany

## Introduction

mxc-servicemanager is a component compatible to [zend-servicemanager  3.3](https://github.com/zendframework/zend-servicemanager "zend-servicemanager").
Different from zend-servicemanager this component does not support 5.6.

For mxc-servicemanager we refactored several parts of zend-servicemanager for better performance. This includes configuration and setup, factory caching and service resolution.
This repository gets fed from the [mxc-services](https://github.com/mxc-commons/mxc-services "mxc-services") repository, which is a zend-servicemanager fork. All development and testing is done there.

This package provides only the files of mxc-services, which were subject to change. Rationale behind that is that code review and verification of the changes for you is easier to do.

A major design constraint is zend-servicemanager compatibility. Changes to master and develop branches of zend-servicemanager will get merged into mxc-servicemanager.

Our motivation to do this is our need for a fast servicemanager component and our commitment to open source.


- [File issues, ask and discuss at the issues section of mxc-services](https://github.com/mxc-commons/mxc-services/issues)
- [Online documentation of zend-servicemanager](https://docs.zendframework.com/zend-servicemanager)

## Features / Goals

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

Goal of our activities is to exploit PHP capabilities as far as possible for performance enhancements without giving up on backwards compatibility to
zend-servicemanager 3.3.2 (currently). We are working on optimizing the PHP implementation in order to find out what the particular requirements for
maximum speed actually are. Another thing we want to learn about is how to streamline service manager configuration in order to ease comprehension and
effectivity.

Based on what we learn we plan to provide a PHP core component or extension library implemented in C, which will combine the functionality and
compatibility of the PHP implementation with the performance of a C implementation. Work on that will not start before 07-2018. Please do not expect stable or even visible results early.

Please refer to the "State of Progress" and "Benchmark Comparison" sections at the end of this file for details on our current achievements towards the goals.

## Installation

To install mxc-servicemanager:

1. Add a dependency to mxc-servicemanager to your composer.json


    ```json
    "require": {
        "mxc-commons/mxc-servicemanager": "^0.0"
    }
    ```

2. Configure PSR-4 compliant autoloading of the namespace MxcCommons\ServiceManager. If you use the recommended way of composer based autoloading, add this configuration to your composer.json

    ```json
    "autoload": {
        "psr-4": {
            "MxcCommons\\ServiceManager\\": "src/"
        }
    },
    ```

3. Run composer update

You can now use MxcCommons\ServiceManager in your project.

## Using in zendframework based projects

If you want to tranparently replace the servicemanager component your application uses with mxc-servicemanager, we can not currently provide a managed way to accomplish that.

The easiest way to achieve that is to replace ServiceManager.php and AbstractPluginManager.php  in the zend-servicemanager/src directory with the class files provided in this repo.
Change the the namespace of both files from MxcCommons\ServiceManager to Zend\Servicemanager, and your done.

## License

mxc-servicemanager is provided under the New BSD License. See `license.txt`.

## Discussion

Platform for discussion of all things related to this fork is the [issues section of mxc-commons/mxc-services](https://github.com/mxc-commons/mxc-services/issues).

## Tests & Benchmarks

The classes provided here are unit tested with [Sebastian Bergmann's PHPUnit](https://github.com/sebastianbergmann/phpunit) unit testing framework.
In order to run the tests and benchmarks you need to clone mxc-services to your project and work there. Please refer to the documentation on how
to use PHPUnit.

We benchmark using the [PHPBench](https://github.com/phpbench/phpbench) framework.

If you want to run tests and benchmarks, you will have to clone [mxc-services](https://github.com/mxc-commons/mxc-services "mxc-services") and do that there.

## State Of Progress

Please refer to the [change log](CHANGELOG.md) for a list of changes and enhancements.

## Benchmark Comparisons

Please refer to the current release documentation or to the [CHANGELOG.md](CHANGELOG.md), which contains a comprehensive benchmark comparison for
each version.

## What's next?

Tests:

1. Extend the current testsuite to include mxc-servicemanager standalone usage (MxcCommons namespace)
2. Provide integration test suite for mxc-servicemanager acting as zend-servicemanager.

Enhancements:

1. Refactor ConfigAbstractFactory for performance.
2. Refactor ReflectionAbstractFactory for performance.
3. Provide benchmark tests for all features currently left out.
4. Provide benchmarks modelling real world use cases (abstract factories centric app, arbitrary app, config based app, setters api based app, ...).
5. Remove white box unit tests, that test that features are implemented in a particular way, if this implementation changes.
6. Provide benchmarks which respect internal staging (i.e. configuration array only, aliases resolved, factories called, ...).
7. Deploy benchmark suite with mxc-servicemanager
8. Deploy test suite with mxc-servicemanager
9. Investigating: Introduce service configuration pre-compiler (transform provided service manager configuration to working config (member vars) once on first request)
10. Investigating: Introduce ServiceManager pre-compiler
    (automatically and dynamically provide a service manager implementation which is optimized to support only the features actually used by the application)



Provide comparison benchmarks on every single step.

