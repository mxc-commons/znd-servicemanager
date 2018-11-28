# Benchmarking znd-servicemanager

We provide a comprehensive suite of benchmark tests to measure znd-servicemanager. Test implementations can be found in the files
listed below. This document delivers short descriptions of the tests. The whole suite was backported to zend-servicemanager:master
to be able to compare the results.

* CreateSingleFeaturedServiceManagerBench.php
* FetchCachedServicesBench.php
* FetchNewServicesBench.php
* HasBench.php
* Usage10Bench.php
* Usage25Bench.php
* Usage50Bench.php
* Usage100Bench.php
* Usage250Bench.php
* Usage500Bench.php
* Usage1000Bench.php
* FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench.php
* FetchNewServiceViaConfigAbstractFactoryBench.php
* FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench.php
* FetchNewServiceViaReflectionAbstractFactoryBench.php

## Benchmark CreateSingleFeaturedServiceManagerBench

The purpose of this benchmark is to unreveal the costs of configuration of the several items supported by service manager.
To accomplish that there are several tests provided, which create a service manager from a configuration which contains
only 250 of a single type of item (factories, aliases, ...). The tests measure the time it takes to construct a service
manager from this config.

Because several item types (aliases, invokables (zend)) require additional operations on setup, the overhead of these
additional setup gets unrevealed.

The test for services and factories only is expected to run fastest with both zend-servicemanager and znd-servicemanager.
Delegators are expected to run somewhat slower, because there are delegator and factory definitions involved. Aliases
are expected to run slowest on both implementations, because of alias resolution.

The biggest performance increase provided by znd-servicemanager is for aliases because of the much better resolution
algorithm, followed by invokables.

## Benchmark FetchCachedServicesBench

This benchmark measures the time it takes to retrieve an item from the service manager which is already in the shared
services cache. The tests should result in almost the same value for every item type and should be almost the same
in both implementations.

## Benchmark FetchNewServicesBench

This benchmark measures the time it takes to retrieve an item from the service manager which is NOT already in the shared
services cache, i.e. must get created (except benchFetchService1). Allthough we introduced some overhead to cache
the $creationCallback of delegators, this overhead is almost compensated by other changes.

The new cache improves performance of consecutive requests for the same delegator by 45-75% and of consecutive
requests for the same lazy service by 56%.

Requests for aliased services are about 30% faster with znd-servicemanager. Same for invokables (about 87%) and
factories (about 34%).

## Benchmark HasBench

This benchmark measures the performance if the `has()` member of service manager. While `has(alias)` is slightly
slower than zend-servicemanager now, `has` for all other items znd-servicemanager is significantly faster than
zend-servicemanager.

## Benchmark SetNewServiceBench

This benchmark measures the time it takes to add an item to the service manager configuration using the
"setter APIs" (mutability APIs). znd-servicemanager is far faster than zend-servicemanager for all item
types. Minimum performance gain (addInitializerByClassName) is 81%, maximum performance gain (overrideAlias) is
3.658,00%.

One important rationale for that is that zend-servicemanager routes each API over `configure()`, which
implies lot of redundant work to find out what item type to add and if that change is allowed. Information
already provided by the user. Optimization of invokable handling, alias handling, ... explains the rest.

## Benchmarks UsageXXXX.php

There are six benchmarks measuring the same processes but for a different total number of items each.
Each test creates a service manager with XXX items of each services, factories, delegators,
invokables and aliases (Usage25Bench.php -> 25 items each, ..., Usage1000Bench.php -> 1000 items each).
Abstract factories and lazy services are left out here.

The fetchNewServiceManager test measures the time it takes to construct and initialize a service manager
for the respective number of items. The results show, that as a result of refactoring the configuration
process not only configurations with a very large number (e.g. 1000) of services each profit.

The relative performance gain provided by znd-servicemanager is even higher if the number of total
services enters ranges more realistical to common use cases (50 or 100 services of each type).

With each of the UsageXXX.php benchmarks there are three tests focussing the performance of the
service manager, when it comes to creating a service which is not cached already.

These tests are

* fetchEachServiceOnce
* fetchEachServiceTwice
* fetchEachServiceThreeTimes

Three tests are provided to make sure, that service manager does actually reach each possible state
of internal caching (factories, delegator callbacks, ...). Practically, fetchEachServiceThreeTimes
is currently obsolete, because service manager walks all internal caching states by retrieving each
service twice. In order to measure service manager performance all three tests use `build()` to create
a service.

The table below compares these tests for all numbers of total services. It shows, that the major
performance gain gets realized, if the same service gets requested twice. The performance gain
is around 47-71%.

If each service gets requested once only, the overall performance gain drops to 14-18%, bacause the
better algos get used once only.

The UsageXXXBenches feature two additional tests which sum up configuration time and the time it
takes to satisfy requests. benchFullCycleBuild does this using `build()`, benchFullCycleGet does
this using `get()`. The latter case reduces the influence of the refactoring results of service manager
to the possible minimum. Both benchmarks include the times needed for service manager configuration.

## Benchmark FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench

This benchmark measures the time it takes to retrieve an item from a ConfigAbstractFactory, when the ConfigAbstractFactory is
registered as a factory to service manager. znd-servicemanager is about 20-26% faster than zend-servicemanager. This is a side effect
of other changes applied to the service retrieval process, not in particular related to changes to ConfigAbstractFactory

## Benchmark FetchNewServiceViaConfigAbstractFactoryBench

This benchmark measures the time it takes to retrieve an item from a ConfigAbstractFactory, when the ConfigAbstractFactory is
registered as an abstract factory to service manager. znd-servicemanager is about 37-45% faster than zend-servicemanager. This is a result
of adding some caching capability to ConfigAbstractFactory.


## Benchmark FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench

This benchmark measures the time it takes to retrieve an item from a ReflectionBasedAbstractFactory, when the ReflectionBasedAbstractFactory is
registered as a factory to service manager. znd-servicemanager is about 19-28% faster than zend-servicemanager. This is a side effect
of other changes applied to the service retrieval process. We did not do anything to improve ReflectionBasedAbstractFactory's performance.

## Benchmark FetchNewServiceViaReflectionAbstractFactoryBench

This benchmark measures the time it takes to retrieve an item from a ReflectionBasedAbstractFactory, when the ReflectionBasedAbstractFactory is
registered as an abstract factory to service manager. znd-servicemanager is about 8-19% faster than zend-servicemanager. We did not do anything
about ReflectionBasedAbstractFactory.
