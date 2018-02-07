# mxc-servicemanager

Master:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager.svg?branch=master)](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-servicemanager/badge.svg?branch=master)](https://coveralls.io/github/mxc-commons/mxc-servicemanager?branch=master)
Develop:
[![Build Status](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager.svg?branch=develop)](https://secure.travis-ci.org/mxc-commons/mxc-servicemanager)
[![Coverage Status](https://coveralls.io/repos/github/mxc-commons/mxc-servicemanager/badge.svg?branch=develop)](https://coveralls.io/github/mxc-commons/mxc-servicemanager?branch=develop)


- File issues at https://github.com/mxc-commons/mxc-servicemanager/issues
- [Online documentation of zend-servicemanager](https://docs.zendframework.com/zend-servicemanager)

## Important Note

Currently initial setup of this project is still going on. Please do not download or use as long as this notice is still part of this file.

## Introduction

mxc-servicemanager is a fork of [zend-servicemanager  3.3](https://github.com/zendframework/zend-servicemanager "zend-servicemanager"). We changed the repo name to indicate that this fork
features well maintained master and develop branches which can differ from master and develop branches of zend-servicemanager.

For mxc-servicemanager we refactored several parts of zend-servicemanager for better performance. This includes configuration and setup, factory caching and service resolution. This package was introduced to deliver enhancements early.

A major design constraint is zend-servicemanager compatibility. All changes applied to mxc-servicemanager are proposed to the zend-servicemanager project also via pull request. Changed master and develop branches of zend-servicemanager will get merged into mxc-servicemanager asap after release.

Our motivation to do this comes out of our project portfolio management on one hand (we need a fast service manager for other projects), our commitment to Open Source on the other hand, and from economical constraints.

We are not strong or big enough to work on many projects at the same time, so we have to be focussed (this on the third hand ;). We need a way to bring our ideas for servicemanager enhancements in having a limited time frame.
This fork is the playground where we can complete and deploy our work early.

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

Please refer to the "Benchmark Results" section at the end of this file for details on current achievements towards the goals.	

Based on what we learn we plan to provide a PHP core component or extension library implemented in C, which will combine the functionality and
compatibility of the PHP implementation with the performance of a C implementation. Work on that will not start before 07-2018. Please do not expect visible or stable results in 2018. Preliminary project name is mxc-servicemanager-x2.

## Version

Version 0.0.1 created by Frank Hein, maxence operations GmbH

## Installation

mxc-servicemanager is a fork of zend-servicemanager. As such we can not provide a composer package. You can not use zend-servicemanager and mxc-servicemanager in the same project, because both live in the Zend\ServiceManager namespace.

Installation is more or less:

1. Clone the repository to your project directory.

2. Remove zend-servicemanager from your projects dependencies in composer.json

3. If your project is composer based, redirect servicemanager autoloading to the mxc-servicemanager directory.

     "autoload": {
         "psr-4": {
             "Zend\\ServiceManager\\": "src/"
         }
     },

4. Run composer dumpautoload

Note: Things can be more complex if your project is made up of components, which again have dependencies to zend-servicemanager. We do not use this fork that way and do not recommend to do so for other purposes than testing.

## License

mxc-servicemanager is provided under the New BSD License. See `license.txt`.

## Discussion

Platform for discussion of all things related to this fork is the [issues section of this repository](https://github.com/mxc-commons/mxc-servicemanager/issues)

## Copyright Acknowledgement

If you want to contribute to this fork, you may add your copyright notice to copyrights.md specifying the particular things you hold the copyright for in `copyrights.md`.
The only restriction for copyright claims is that you have license the things you supply under the New BSD License, the same license under which both zend-servicemanager and this fork are provided.

## Benchmarks

There are scripts provided for benchmarking zend-servicemanager using the
[PHPBench](https://github.com/phpbench/phpbench) framework; these can be found in mxc-servicemanager also
in the `benchmarks/` directory.

To execute the benchmarks you can run the following command:

```bash
$ vendor/bin/phpbench run --report=aggregate
```

On Windows you have to

```bash
$ vendor/bin/phpbench run benchmarks --report=aggregate
```

## Benchmark results

For your convenience you will find benchmark comparisons of zend-servicemanager:master and mxc-servicemanager:develop. This section will be updated as new versions come up on either side.

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
