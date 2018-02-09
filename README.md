# mxc-services

Master:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-services.svg?branch=master)](https://secure.travis-ci.org/mxc-commons/mxc-services)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-services/badge.svg?branch=master)](https://coveralls.io/github/mxc-commons/mxc-services?branch=master)
Develop:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-services.svg?branch=develop)](https://secure.travis-ci.org/mxc-commons/mxc-services)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-services/badge.svg?branch=develop)](https://coveralls.io/github/mxc-commons/mxc-services?branch=develop)


- File issues, ask and discuss at https://github.com/mxc-commons/mxc-services/issues
- [Online documentation of zend-servicemanager](https://docs.zendframework.com/zend-servicemanager)

## Important Note

Currently initial setup of this project is still going on. Please do not download or use as long as this notice is still part of this file.

## Introduction

mxc-services is a fork of [zend-servicemanager  3.3](https://github.com/zendframework/zend-servicemanager "zend-servicemanager"). We changed the repo name to indicate that this fork
features well maintained master and develop branches which can differ from master and develop branches of zend-servicemanager. An important difference to zend-servicemanager is that we do not
support PHP 5.6. We provide another repository

For mxc-services we refactored several parts of zend-servicemanager for better performance. This includes configuration and setup, factory caching and service resolution. This package was introduced to deliver enhancements early.

A major design constraint is zend-servicemanager compatibility. All changes applied to mxc-services are proposed to the zend-servicemanager project also via pull request. Changes master and develop branches of zend-servicemanager will get merged into mxc-services.

Our motivation to do this is our need for a fast servicemanager component and our commitment to open source.

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

Goal of this activities is to exploit PHP capabilities as far as possible for performance enhancements without giving up on backwards compatibility to
zend-servicemanager 3.3.2 (currently). We are working on optimizing the PHP implementation in order to find out what the particular requirements for
maximum speed actually are. Another thing we want to learn about is how to streamline service manager configuration in order to ease comprehension and
effectivity.

Based on what we learn we plan to provide a PHP core component or extension library implemented in C, which will combine the functionality and
compatibility of the PHP implementation with the performance of a C implementation. Work on that will not start before 07-2018. Please do not expect visible or stable early.

Please refer to the "State of Progress" section at the end of this file for details on our current achievements towards the goals.

## Version

Version 0.0.1 created by Frank Hein, maxence operations GmbH

## Installation

mxc-services is a fork of zend-servicemanager. As such we can not provide a distinct composer package for this repository.

For your convenience we provide a distinct repository [mxc-servicemanager](https://github.com/mxc-commons/mxc-servicemanager) which can by installed by composer. This other repository is fed from here and provides ServiceManager.php and AbstractPluginManager.php only. Both classes live in our
namespace MxcCommons\ServiceManager.

To install mxc-servicemanager:

1. Add a dependency to mxc-servicemanager to your composer.json

    "require": {
        ...
        "mxc-commons/mxc-servicemanager": "*"
    }

2. Configure PSR-4 compliant autoloading of the namespace MxcCommons. If you use the recommended way of composer based autoloading, add this configuration to your composer.json

    "autoload": {
        "psr-4": {
            "MxcCommons\\ServiceManager\\": "src/"
        }
    },

3. Run composer update

You can now use MxcCommons\ServiceManager in your project.

## Using in zendframework based projects

If you want to tranparently replace the servicemanager component your application uses with mxc-servicemanager, we do not currently provide a managed way to accomplish that.
The easiest way do that is to replace ServiceManager.php and AbstractPluginManager.php  in the zend-servicemanager/src directory with the class files provided here.
Change the the namespace of both files from MxcCommons\ServiceManager to Zend\Servicemanager, and your done.

## License

mxc-services is provided under the New BSD License. See `license.txt`.

## Discussion

Platform for discussion of all things related to this fork is the [issues section of this repository](https://github.com/mxc-commons/mxc-services/issues).

## Tests

This fork is unit tested with [Sebastian Bergmann's PHPUnit](https://github.com/sebastianbergmann/phpunit) unit testing framework.
In order to run the tests and benchmarks you need to clone this repo to your project. Please refer to the documentation on how
to use PHPUnit.

## Benchmarks

There are scripts provided for benchmarking zend-servicemanager using the
[PHPBench](https://github.com/phpbench/phpbench) framework; these can be found in mxc-services also
in the `benchmarks/` directory.

To execute the benchmarks you can run the following command:

```bash
$ vendor/bin/phpbench run --report=aggregate
```

On Windows you have to

```bash
$ vendor/bin/phpbench run benchmarks --report=aggregate
```
Please refer to the PHPBench documentation for more sophisticated usages of that suite,

## State Of Progress - Benchmark Comparisons

For your convenience you will find benchmark comparisons of zend-servicemanager:master and mxc-services:develop below. This section will be updated from time to time when new versions come up on either side.

Significant performance improvements currently are the creation of a new ServiceManager with several thousand
items via call to `configure()` (3x faster) and service creation via the setter APIs (setService, setAlias, ...) which is between minimum 1.3x and maximum 18.0x as fast as zend-servicemanager. Most other sections profit a bit from the refactored handling of invokable and aliases.


	$ vendor\bin\phpbench report --file=..\zend.FetchNewServiceManager.xml --file=..\mxc.FetchNewServiceManager.xml --report=compare
	benchmark: FetchNewServiceManagerBench
	+----------------------------------+-----------------+----------------+
	| subject                          | suite:zend:mean | suite:mxc:mean |
	+----------------------------------+-----------------+----------------+
	| benchFetchServiceManagerCreation | 878.050µs       | 287.376µs      |
	+----------------------------------+-----------------+----------------+

	$ vendor\bin\phpbench report --file=..\zend.all.xml --file=..\mxc.all.xml --report=compare
	benchmark: FetchCachedServicesBench
	+----------------------------------+-----------------+----------------+
	| subject                          | suite:zend:mean | suite:mxc:mean |
	+----------------------------------+-----------------+----------------+
	| benchFetchFactory1               | 0.452µs         | 0.435µs        |
	| benchFetchInvokable1             | 0.473µs         | 0.454µs        |
	| benchFetchService1               | 0.457µs         | 0.437µs        |
	| benchFetchAlias1                 | 0.458µs         | 0.440µs        |
	| benchFetchRecursiveAlias1        | 0.474µs         | 0.451µs        |
	| benchFetchRecursiveAlias2        | 0.468µs         | 0.450µs        |
	| benchFetchAbstractFactoryService | 2.450µs         | 2.471µs        |
	+----------------------------------+-----------------+----------------+

	benchmark: FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench
	+-------------------------------------+-----------------+----------------+
	| subject                             | suite:zend:mean | suite:mxc:mean |
	+-------------------------------------+-----------------+----------------+
	| benchFetchServiceWithNoDependencies | 5.042µs         | 4.482µs        |
	| benchBuildServiceWithNoDependencies | 4.613µs         | 4.239µs        |
	| benchFetchServiceDependingOnConfig  | 5.744µs         | 5.061µs        |
	| benchBuildServiceDependingOnConfig  | 5.306µs         | 4.813µs        |
	| benchFetchServiceWithDependency     | 5.681µs         | 5.046µs        |
	| benchBuildServiceWithDependency     | 5.210µs         | 4.798µs        |
	+-------------------------------------+-----------------+----------------+

	benchmark: FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench
	+-------------------------------------+-----------------+----------------+
	| subject                             | suite:zend:mean | suite:mxc:mean |
	+-------------------------------------+-----------------+----------------+
	| benchFetchServiceWithNoDependencies | 3.963µs         | 3.490µs        |
	| benchBuildServiceWithNoDependencies | 3.537µs         | 3.297µs        |
	| benchFetchServiceDependingOnConfig  | 7.089µs         | 6.745µs        |
	| benchBuildServiceDependingOnConfig  | 6.650µs         | 6.610µs        |
	| benchFetchServiceWithDependency     | 8.432µs         | 8.160µs        |
	| benchBuildServiceWithDependency     | 7.960µs         | 7.895µs        |
	+-------------------------------------+-----------------+----------------+

	benchmark: FetchNewServiceViaConfigAbstractFactoryBench
	+-------------------------------------+-----------------+----------------+
	| subject                             | suite:zend:mean | suite:mxc:mean |
	+-------------------------------------+-----------------+----------------+
	| benchFetchServiceWithNoDependencies | 5.489µs         | 5.112µs        |
	| benchBuildServiceWithNoDependencies | 4.922µs         | 4.743µs        |
	| benchFetchServiceDependingOnConfig  | 6.143µs         | 5.744µs        |
	| benchBuildServiceDependingOnConfig  | 5.601µs         | 5.412µs        |
	| benchFetchServiceWithDependency     | 6.122µs         | 5.742µs        |
	| benchBuildServiceWithDependency     | 5.564µs         | 5.363µs        |
	+-------------------------------------+-----------------+----------------+

	benchmark: FetchNewServiceViaReflectionAbstractFactoryBench
	+-------------------------------------+-----------------+----------------+
	| subject                             | suite:zend:mean | suite:mxc:mean |
	+-------------------------------------+-----------------+----------------+
	| benchFetchServiceWithNoDependencies | 3.434µs         | 3.273µs        |
	| benchBuildServiceWithNoDependencies | 2.919µs         | 2.991µs        |
	| benchFetchServiceDependingOnConfig  | 6.766µs         | 6.680µs        |
	| benchBuildServiceDependingOnConfig  | 6.221µs         | 6.402µs        |
	| benchFetchServiceWithDependency     | 8.095µs         | 7.994µs        |
	| benchBuildServiceWithDependency     | 7.555µs         | 7.694µs        |
	+-------------------------------------+-----------------+----------------+

	benchmark: FetchNewServicesBench
	+----------------------------------+-----------------+----------------+
	| subject                          | suite:zend:mean | suite:mxc:mean |
	+----------------------------------+-----------------+----------------+
	| benchFetchFactory1               | 2.820µs         | 2.667µs        |
	| benchBuildFactory1               | 2.395µs         | 2.200µs        |
	| benchFetchInvokable1             | 3.315µs         | 2.477µs        |
	| benchBuildInvokable1             | 2.620µs         | 2.060µs        |
	| benchFetchService1               | 0.455µs         | 0.444µs        |
	| benchFetchFactoryAlias1          | 2.454µs         | 2.223µs        |
	| benchBuildFactoryAlias1          | 2.461µs         | 2.249µs        |
	| benchFetchRecursiveFactoryAlias1 | 2.475µs         | 2.259µs        |
	| benchBuildRecursiveFactoryAlias1 | 2.490µs         | 2.252µs        |
	| benchFetchRecursiveFactoryAlias2 | 2.497µs         | 2.255µs        |
	| benchBuildRecursiveFactoryAlias2 | 2.473µs         | 2.247µs        |
	| benchFetchAbstractFactoryFoo     | 2.407µs         | 2.411µs        |
	| benchBuildAbstractFactoryFoo     | 1.947µs         | 1.985µs        |
	+----------------------------------+-----------------+----------------+

	benchmark: HasBench
	+-------------------------+-----------------+----------------+
	| subject                 | suite:zend:mean | suite:mxc:mean |
	+-------------------------+-----------------+----------------+
	| benchHasFactory1        | 0.526µs         | 0.535µs        |
	| benchHasInvokable1      | 0.603µs         | 0.578µs        |
	| benchHasService1        | 0.482µs         | 0.518µs        |
	| benchHasAlias1          | 0.584µs         | 0.556µs        |
	| benchHasRecursiveAlias1 | 0.605µs         | 0.569µs        |
	| benchHasRecursiveAlias2 | 0.603µs         | 0.565µs        |
	| benchHasAbstractFactory | 0.839µs         | 0.870µs        |
	| benchHasNot             | 0.851µs         | 0.877µs        |
	+-------------------------+-----------------+----------------+

	benchmark: SetNewServicesBench
	+------------------------------------+-----------------+----------------+
	| subject                            | suite:zend:mean | suite:mxc:mean |
	+------------------------------------+-----------------+----------------+
	| benchSetService                    | 2.027µs         | 0.654µs        |
	| benchSetFactory                    | 4.350µs         | 1.229µs        |
	| benchSetAlias                      | 11.946µs        | 1.917µs        |
	| benchOverrideAlias                 | 36.493µs        | 1.929µs        |
	| benchSetInvokableClass             | 5.359µs         | 0.612µs        |
	| benchAddDelegator                  | 2.090µs         | 0.728µs        |
	| benchAddInitializerByClassName     | 2.473µs         | 1.490µs        |
	| benchAddInitializerByInstance      | 1.764µs         | 0.910µs        |
	| benchAddAbstractFactoryByClassName | 3.488µs         | 2.436µs        |
	| benchAddAbstractFactoryByInstance  | 3.118µs         | 2.043µs        |
	+------------------------------------+-----------------+----------------+
