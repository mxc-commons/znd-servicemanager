# Benchmarking mxc-servicemanager

We provide a comprehensive suite of benchmark tests to measure mxc-servicemanager. Test implementations can be found in the files
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

The test for services and factories only is expected to run fastest with both zend-servicemanager and mxc-servicemanager.
Delegators are expected to run somewhat slower, because there are delegator and factory definitions involved. Aliases
are expected to run slowest on both implementations, because of alias resolution.

The table below shows a comparison between mxc-servicemanager and zend-servicemanager for this benchmark.

    +-----------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | benchmark                               | subject                                        | diff   | tag:zend:mean | tag:mxc:mean |
    +-----------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | CreateSingleFeaturedServiceManagerBench | benchCreateNewServiceManagerWithAliasesOnly    | 25.66x | 4,154.332µs   | 161.929µs    |
    | CreateSingleFeaturedServiceManagerBench | benchCreateNewServiceManagerWithDelegatorsOnly | 8.84x  | 13.201µs      | 1.494µs      |
    | CreateSingleFeaturedServiceManagerBench | benchCreateNewServiceManagerWithFactoriesOnly  | 4.03x  | 5.587µs       | 1.387µs      |
    | CreateSingleFeaturedServiceManagerBench | benchCreateNewServiceManagerWithInvokablesOnly | 83.72x | 117.213µs     | 1.400µs      |
    | CreateSingleFeaturedServiceManagerBench | benchCreateNewServiceManagerWithServicesOnly   | 4.13x  | 5.792µs       | 1.403µs      |
    +-----------------------------------------+------------------------------------------------+--------+---------------+--------------+

## Benchmark FetchCachedServicesBench

This benchmark measures the time it takes to retrieve an item from the service manager which is already in the shared
services cache. The tests should result in almost the same value for every item type. zend-servicemanager is 2% faster
than mxc-servicemanager. The reason for that is unclear, because the code running is same in both implementations.

The table below shows a comparison between mxc-servicemanager and zend-servicemanager for this benchmark.

    +--------------------------+----------------------------------+--------+---------------+--------------+
    | benchmark                | subject                          | diff   | tag:zend:mean | tag:mxc:mean |
    +--------------------------+----------------------------------+--------+---------------+--------------+
    | FetchCachedServicesBench | benchFetchAbstractFactoryService | 0.98x  | 0.400µs       | 0.410µs      |
    | FetchCachedServicesBench | benchFetchAlias1                 | 0.97x  | 0.400µs       | 0.413µs      |
    | FetchCachedServicesBench | benchFetchDelegatorService       | 0.98x  | 0.400µs       | 0.410µs      |
    | FetchCachedServicesBench | benchFetchFactory1               | 0.97x  | 0.400µs       | 0.414µs      |
    | FetchCachedServicesBench | benchFetchInvokable1             | 0.98x  | 0.404µs       | 0.413µs      |
    | FetchCachedServicesBench | benchFetchLazyService            | 0.98x  | 0.403µs       | 0.413µs      |
    | FetchCachedServicesBench | benchFetchMultiDelegatorService  | 0.98x  | 0.400µs       | 0.410µs      |
    | FetchCachedServicesBench | benchFetchRecursiveAlias1        | 0.97x  | 0.400µs       | 0.412µs      |
    | FetchCachedServicesBench | benchFetchRecursiveAlias2        | 0.97x  | 0.400µs       | 0.413µs      |
    | FetchCachedServicesBench | benchFetchService1               | 0.98x  | 0.403µs       | 0.410µs      |
    +--------------------------+----------------------------------+--------+---------------+--------------+

## Benchmark FetchNewServicesBench

This benchmark measures the time it takes to retrieve an item from the service manager which is NOT already in the shared
services cache, i.e. must get created (except benchFetchService1). You may notice that all requests for delegators
are significantly - about 8% - slower with mxc-servicemanager (buildDelegator, fetchDelegator, buildMultiDelegator, fetchMultiDelegator).

This performance decrease is the price of the newly added caching of delegator callbacks. The first request
for a particular delegator with zend-servicemanager is faster (~ 8%). Consecutive requests for the same delegator
are faster with mxc-servicemanager (~45-75%).

Lazy service are cached better in mxc-servicemanager, but without an additional price for cache setup. Consecutive
requests for the same lazy service are 30% - 40% faster with mxc-servicemanager (because of delegator caching).

Requests for aliased services are about 25% faster with mxc-servicemanager. Same for invokables (about 75%) and
factories (about 17%).

The table below shows a comparison between mxc-servicemanager and zend-servicemanager for this benchmark.

    +-----------------------+------------------------------------+--------+---------------+--------------+
    | benchmark             | subject                            | diff   | tag:zend:mean | tag:mxc:mean |
    +-----------------------+------------------------------------+--------+---------------+--------------+
    | FetchNewServicesBench | benchBuildAbstractFactoryFoo       | 1.02x  | 1.879µs       | 1.850µs      |
    | FetchNewServicesBench | benchBuildDelegator                | 0.90x  | 5.182µs       | 5.759µs      |
    | FetchNewServicesBench | benchBuildDelegatorCached          | 1.47x  | 3.906µs       | 2.653µs      |
    | FetchNewServicesBench | benchBuildFactory1                 | 1.13x  | 2.414µs       | 2.130µs      |
    | FetchNewServicesBench | benchBuildFactoryAlias1            | 1.17x  | 2.428µs       | 2.083µs      |
    | FetchNewServicesBench | benchBuildInvokable1               | 1.58x  | 2.648µs       | 1.678µs      |
    | FetchNewServicesBench | benchBuildLazyService              | 0.99x  | 216.973µs     | 218.773µs    |
    | FetchNewServicesBench | benchBuildLazyServiceCached        | 1.31x  | 5.744µs       | 4.389µs      |
    | FetchNewServicesBench | benchBuildMultiDelegator           | 0.95x  | 8.330µs       | 8.814µs      |
    | FetchNewServicesBench | benchBuildMultiDelegatorCached     | 1.73x  | 6.061µs       | 3.503µs      |
    | FetchNewServicesBench | benchBuildRecursiveFactoryAlias1   | 1.22x  | 2.526µs       | 2.073µs      |
    | FetchNewServicesBench | benchBuildRecursiveFactoryAlias2   | 1.23x  | 2.553µs       | 2.082µs      |
    | FetchNewServicesBench | benchFetchAbstractFactoryFoo       | 1.06x  | 2.325µs       | 2.199µs      |
    | FetchNewServicesBench | benchFetchAbstractFactoryFooCached | 1.06x  | 2.325µs       | 2.200µs      |
    | FetchNewServicesBench | benchFetchDelegator                | 0.93x  | 5.710µs       | 6.172µs      |
    | FetchNewServicesBench | benchFetchDelegatorCached          | 1.46x  | 4.426µs       | 3.024µs      |
    | FetchNewServicesBench | benchFetchFactory1                 | 1.17x  | 2.816µs       | 2.405µs      |
    | FetchNewServicesBench | benchFetchFactoryAlias1            | 1.17x  | 2.433µs       | 2.071µs      |
    | FetchNewServicesBench | benchFetchInvokable1               | 1.74x  | 3.357µs       | 1.924µs      |
    | FetchNewServicesBench | benchFetchLazyService              | 1.00x  | 217.692µs     | 218.253µs    |
    | FetchNewServicesBench | benchFetchLazyServiceCached        | 1.42x  | 6.892µs       | 4.852µs      |
    | FetchNewServicesBench | benchFetchMultiDelegator           | 0.97x  | 8.838µs       | 9.149µs      |
    | FetchNewServicesBench | benchFetchMultiDelegatorCached     | 1.74x  | 6.590µs       | 3.797µs      |
    | FetchNewServicesBench | benchFetchRecursiveFactoryAlias1   | 1.21x  | 2.519µs       | 2.081µs      |
    | FetchNewServicesBench | benchFetchRecursiveFactoryAlias2   | 1.21x  | 2.521µs       | 2.075µs      |
    | FetchNewServicesBench | benchFetchService1                 | 0.99x  | 0.400µs       | 0.404µs      |
    +-----------------------+------------------------------------+--------+---------------+--------------+

## Benchmark HasBench

This benchmark measures the performance if the `has()` member of service manager. Assuming that shared
services are most often requested, this was prioritized in mxc-servicemanager, resulting in a 13% performance
increase. Due to the completely refactored alias handling requests asking for aliases are sped up also by
around 6-8%.

For abstract factories, factories and to find out, that service manager does not have the requested service,
mxc-servicemanager is not as fast as zend-servicemanager. Rationale for that, is that mxc-serivcemanager
changed the treatment of invokables. They are stored in an array like services and factories. This additional
array has to be checked additionally to find out, that the requested name is not an invokable.

The table below shows a comparison between mxc-servicemanager and zend-servicemanager for this benchmark.

    +-----------+-------------------------+--------+---------------+--------------+
    | benchmark | subject                 | diff   | tag:zend:mean | tag:mxc:mean |
    +-----------+-------------------------+--------+---------------+--------------+
    | HasBench  | benchHasAbstractFactory | 0.94x  | 0.772µs       | 0.819µs      |
    | HasBench  | benchHasAlias1          | 1.06x  | 0.534µs       | 0.503µs      |
    | HasBench  | benchHasFactory1        | 0.91x  | 0.476µs       | 0.523µs      |
    | HasBench  | benchHasInvokable1      | 1.00x  | 0.546µs       | 0.545µs      |
    | HasBench  | benchHasNot             | 0.95x  | 0.821µs       | 0.868µs      |
    | HasBench  | benchHasRecursiveAlias1 | 1.08x  | 0.545µs       | 0.503µs      |
    | HasBench  | benchHasRecursiveAlias2 | 1.06x  | 0.535µs       | 0.503µs      |
    | HasBench  | benchHasService1        | 1.13x  | 0.428µs       | 0.380µs      |
    +-----------+-------------------------+--------+---------------+--------------+

## Benchmark SetNewServiceBench

This benchmark measures the time it takes to add an item to the service manager configuration using the
"setter APIs" (mutability APIs). mxc-servicemanager is far faster than zend-servicemanager for all item
types. Minimum performance gain (addInitializerByClassName) is 64%, maximum performance gain (overrideAlias) is
3.350,00%.

One important rationale for that is that zend-servicemanager routes each API over `configure()`, which
implies lot of redundant work to find out what item type to add and if that change is allowed. Information
already provided by the user. Optimization of invokable handling, alias handling, ... explains the rest.

The table below shows a comparison between mxc-servicemanager and zend-servicemanager for this benchmark.

    +---------------------+------------------------------------+--------+---------------+--------------+
    | benchmark           | subject                            | diff   | tag:zend:mean | tag:mxc:mean |
    +---------------------+------------------------------------+--------+---------------+--------------+
    | SetNewServicesBench | benchAddAbstractFactoryByClassName | 4.04x  | 3.302µs       | 0.817µs      |
    | SetNewServicesBench | benchAddAbstractFactoryByInstance  | 1.57x  | 2.791µs       | 1.779µs      |
    | SetNewServicesBench | benchAddDelegator                  | 2.23x  | 3.456µs       | 1.552µs      |
    | SetNewServicesBench | benchAddInitializerByClassName     | 1.61x  | 2.347µs       | 1.455µs      |
    | SetNewServicesBench | benchAddInitializerByInstance      | 2.01x  | 1.687µs       | 0.839µs      |
    | SetNewServicesBench | benchAddMultiDelegator             | 2.42x  | 3.463µs       | 1.433µs      |
    | SetNewServicesBench | benchOverrideAlias                 | 34.50x | 65.717µs      | 1.905µs      |
    | SetNewServicesBench | benchSetAlias                      | 9.74x  | 18.974µs      | 1.948µs      |
    | SetNewServicesBench | benchSetFactory                    | 3.80x  | 4.351µs       | 1.143µs      |
    | SetNewServicesBench | benchSetInvokableClass             | 4.57x  | 5.304µs       | 1.161µs      |
    | SetNewServicesBench | benchSetService                    | 3.22x  | 1.977µs       | 0.613µs      |
    +---------------------+------------------------------------+--------+---------------+--------------+

## Benchmarks UsageXXXX.php

There are six benchmarks measuring the same processes but for a different total number of items each.
Each test creates a service manager with XXX items of each services, factories, delegators,
invokables and aliases (Usage25Bench.php -> 25 items each, ..., Usage1000Bench.php -> 1000 items each).
Abstract factories and lazy services are left out here.

The fetchNewServiceManager test measures the time it takes to construct and initialize a service manager
for the respective number of items. The results show, that as a result of refactoring the configuration
process not only configurations with a very large number (e.g. 1000) of services each profit.

The relative performance gain provided by mxc-servicemanager is even higher if the number of total
services enters ranges more realistical to common use cases (50 or 100 services of each type).

The table below shows a comparison between mxc-servicemanager and zend-servicemanager for creating
a new service manager with a given number of services.

    +----------------+-----------------------------+--------+---------------+--------------+
    | benchmark      | subject                     | diff   | tag:zend:mean | tag:mxc:mean |
    +----------------+-----------------------------+--------+---------------+--------------+
    | Usage1000Bench | benchFetchNewServiceManager | 4.00x  | 942.214µs     | 235.774µs    |
    | Usage500Bench  | benchFetchNewServiceManager | 4.31x  | 502.565µs     | 116.727µs    |
	| Usage250Bench  | benchFetchNewServiceManager | 4.74x  | 284.656µs     | 60.004µs     |
    | Usage100Bench  | benchFetchNewServiceManager | 5.59x  | 156.489µs     | 28.001µs     |
    | Usage50Bench   | benchFetchNewServiceManager | 6.71x  | 110.726µs     | 16.507µs     |
    | Usage25Bench   | benchFetchNewServiceManager | 8.49x  | 90.485µs      | 10.653µs     |
    +----------------+-----------------------------+--------+---------------+--------------+

With each of the UsageXXX.php benchmarks there are three tests focussing the performance of the
service manager, when it comes to creating a service which is not cached already.

These tests are

* fetchEachServiceOnce
* fetchEachServiceTwice
* fetchEachServiceThreeTimes

Three tests are provided to make sure, that service manager does actually reach each possible state
of internal caching (factories, delegator callbacks, ...). Practically, fetchEachServiceThreeTimes
is currently obsolete, because service manager walks all internal caching states by retrievin each
service twice. In order to measure service manager performance all three tests use `build()` to create
a service.

The table below compares these tests for all numbers of total services. It shows, that the major
performance gain gets realized, if the same service gets requested twice. The performance gain
is around 40-55%.

If each service gets requested once only, the overall performance gain drops to 5-10%, bacause the
better algos get used once only.

    +----------------+---------------------------------+--------+---------------+--------------+
    | benchmark      | subject                         | diff   | tag:zend:mean | tag:mxc:mean |
    +----------------+---------------------------------+--------+---------------+--------------+
    | Usage1000Bench | benchFetchEachServiceOnce       | 1.09x  | 13.011ms      | 11.897ms     |
    | Usage1000Bench | benchFetchEachServiceTwice      | 1.34x  | 10.247ms      | 7.651ms      |
    | Usage1000Bench | benchFetchEachServiceThreeTimes | 1.35x  | 10.254ms      | 7.599ms      |
    | Usage500Bench  | benchFetchEachServiceOnce       | 1.07x  | 6.379ms       | 5.967ms      |
    | Usage500Bench  | benchFetchEachServiceTwice      | 1.37x  | 5.109ms       | 3.726ms      |
    | Usage500Bench  | benchFetchEachServiceThreeTimes | 1.35x  | 5.101ms       | 3.766ms      |
    | Usage250Bench  | benchFetchEachServiceOnce       | 1.07x  | 3.199ms       | 2.983ms      |
    | Usage250Bench  | benchFetchEachServiceTwice      | 1.39x  | 2.566ms       | 1.841ms      |
    | Usage250Bench  | benchFetchEachServiceThreeTimes | 1.38x  | 2.544ms       | 1.846ms      |
    | Usage100Bench  | benchFetchEachServiceOnce       | 1.06x  | 1.300ms       | 1.222ms      |
    | Usage100Bench  | benchFetchEachServiceTwice      | 1.40x  | 1.027ms       | 0.732ms      |
    | Usage100Bench  | benchFetchEachServiceThreeTimes | 1.40x  | 1.031ms       | 0.734ms      |
    | Usage50Bench   | benchFetchEachServiceOnce       | 1.00x  | 0.642ms       | 0.643ms      |
    | Usage50Bench   | benchFetchEachServiceTwice      | 1.40x  | 0.509ms       | 0.362ms      |
    | Usage50Bench   | benchFetchEachServiceThreeTimes | 1.42x  | 0.512ms       | 0.360ms      |
    | Usage25Bench   | benchFetchEachServiceOnce       | 1.05x  | 0.355ms       | 0.339ms      |
    | Usage25Bench   | benchFetchEachServiceTwice      | 1.56x  | 0.281ms       | 0.181ms      |
    | Usage25Bench   | benchFetchEachServiceThreeTimes | 1.48x  | 0.267ms       | 0.180ms      |
    +----------------+---------------------------------+--------+---------------+--------------+

The UsageXXXBenches feature two additional tests which sum up configuration time and the time it
takes to satisfy requests. benchFullCycleBuild does this using `build()`, benchFullCycleGet does
this using `get()`. The latter case reduces the influence of the refactoring results of service manager
to the possible minimum. Both benchmarks include the times needed for service manager configuration.

    +----------------+---------------------+--------+---------------+--------------+
    | benchmark      | subject             | diff   | tag:zend:mean | tag:mxc:mean |
    +----------------+---------------------+--------+---------------+--------------+
    | Usage1000Bench | benchFullCycleBuild | 1.24x  | 34.396ms      | 27.664ms     |
    | Usage1000Bench | benchFullCycleGet   | 1.05x  | 15.405ms      | 14.700ms     |
    | Usage500Bench  | benchFullCycleBuild | 1.26x  | 17.165ms      | 13.598ms     |
    | Usage500Bench  | benchFullCycleGet   | 1.04x  | 7.602ms       | 7.299ms      |
    | Usage250Bench  | benchFullCycleBuild | 1.27x  | 8.641ms       | 6.791ms      |
    | Usage250Bench  | benchFullCycleGet   | 1.06x  | 3.884ms       | 3.656ms      |
    | Usage100Bench  | benchFullCycleBuild | 1.28x  | 3.514ms       | 2.748ms      |
    | Usage100Bench  | benchFullCycleGet   | 1.06x  | 1.585ms       | 1.497ms      |
    | Usage50Bench   | benchFullCycleBuild | 1.26x  | 1.767ms       | 1.399ms      |
    | Usage50Bench   | benchFullCycleGet   | 1.05x  | 0.822ms       | 0.785ms      |
    | Usage25Bench   | benchFullCycleBuild | 1.28x  | 0.927ms       | 0.722ms      |
    | Usage25Bench   | benchFullCycleGet   | 1.08x  | 0.447ms       | 0.416ms      |
    +----------------+---------------------+--------+---------------+--------------+

## Benchmark FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench

This benchmark measures the time it takes to retrieve an item from a ConfigAbstractFactory, when the ConfigAbstractFactory is
registered as a factory to service manager. mxc-servicemanager is about 10% faster than zend-servicemanager. This is a side effect
of other changes applied to the service retrieval process, not in particular related to changes to ConfigAbstractFactory

The table below shows a comparison between mxc-servicemanager and zend-servicemanager for this benchmark.

    +---------------------------------------------------------+-------------------------------------+--------+---------------+--------------+
    | benchmark                                               | subject                             | diff   | tag:zend:mean | tag:mxc:mean |
    +---------------------------------------------------------+-------------------------------------+--------+---------------+--------------+
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench | benchBuildServiceDependingOnConfig  | 1.08x  | 5.148µs       | 4.762µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench | benchBuildServiceWithDependency     | 1.08x  | 5.116µs       | 4.734µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench | benchBuildServiceWithNoDependencies | 1.08x  | 4.507µs       | 4.161µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench | benchFetchServiceDependingOnConfig  | 1.11x  | 5.589µs       | 5.024µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench | benchFetchServiceWithDependency     | 1.12x  | 5.596µs       | 4.976µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench | benchFetchServiceWithNoDependencies | 1.12x  | 4.981µs       | 4.434µs      |
    +---------------------------------------------------------+-------------------------------------+--------+---------------+--------------+

## Benchmark FetchNewServiceViaConfigAbstractFactoryBench

This benchmark measures the time it takes to retrieve an item from a ConfigAbstractFactory, when the ConfigAbstractFactory is
registered as an abstract factory to service manager. mxc-servicemanager is about 25% faster than zend-servicemanager. This is a result
of adding some caching capability to ConfigAbstractFactory.

The table below shows a comparison between mxc-servicemanager and zend-servicemanager for this benchmark.

    +----------------------------------------------+-------------------------------------+--------+---------------+--------------+
    | benchmark                                    | subject                             | diff   | tag:zend:mean | tag:mxc:mean |
    +----------------------------------------------+-------------------------------------+--------+---------------+--------------+
    | FetchNewServiceViaConfigAbstractFactoryBench | benchBuildServiceDependingOnConfig  | 1.26x  | 5.544µs       | 4.407µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench | benchBuildServiceWithDependency     | 1.11x  | 5.443µs       | 4.918µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench | benchBuildServiceWithNoDependencies | 1.28x  | 4.856µs       | 3.802µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench | benchFetchServiceDependingOnConfig  | 1.26x  | 6.044µs       | 4.805µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench | benchFetchServiceWithDependency     | 1.26x  | 6.004µs       | 4.751µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench | benchFetchServiceWithNoDependencies | 1.30x  | 5.443µs       | 4.172µs      |
    +----------------------------------------------+-------------------------------------+--------+---------------+--------------+

## Benchmark FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench

This benchmark measures the time it takes to retrieve an item from a ReflectionBasedAbstractFactory, when the ReflectionBasedAbstractFactory is
registered as a factory to service manager. mxc-servicemanager is about 10-15% faster than zend-servicemanager. This is a side effect
of other changes applied to the service retrieval process. We did not do anything to improve ReflectionBasedAbstractFactory's performance.

The table below shows a comparison between mxc-servicemanager and zend-servicemanager for this benchmark.

    +-------------------------------------------------------------+-------------------------------------+--------+---------------+--------------+
    | benchmark                                                   | subject                             | diff   | tag:zend:mean | tag:mxc:mean |
    +-------------------------------------------------------------+-------------------------------------+--------+---------------+--------------+
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceDependingOnConfig  | 1.09x  | 6.604µs       | 6.040µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithDependency     | 1.09x  | 7.898µs       | 7.262µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithNoDependencies | 1.11x  | 3.406µs       | 3.073µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceDependingOnConfig  | 1.14x  | 7.165µs       | 6.279µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithDependency     | 1.12x  | 8.443µs       | 7.553µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithNoDependencies | 1.18x  | 3.896µs       | 3.297µs      |
    +-------------------------------------------------------------+-------------------------------------+--------+---------------+--------------+

## Benchmark FetchNewServiceViaReflectionAbstractFactoryBench

This benchmark measures the time it takes to retrieve an item from a ReflectionBasedAbstractFactory, when the ReflectionBasedAbstractFactory is
registered as an abstract factory to service manager. mxc-servicemanager is about as fast as zend-servicemanager. We did not do anything
about ReflectionBasedAbstractFactory.

The table below shows a comparison between mxc-servicemanager and zend-servicemanager for this benchmark.

    +--------------------------------------------------+-------------------------------------+--------+---------------+--------------+
    | benchmark                                        | subject                             | diff   | tag:zend:mean | tag:mxc:mean |
    +--------------------------------------------------+-------------------------------------+--------+---------------+--------------+
    | FetchNewServiceViaReflectionAbstractFactoryBench | benchBuildServiceDependingOnConfig  | 1.00x  | 6.103µs       | 6.111µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench | benchBuildServiceWithDependency     | 1.04x  | 7.436µs       | 7.173µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench | benchBuildServiceWithNoDependencies | 0.96x  | 2.741µs       | 2.851µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench | benchFetchServiceDependingOnConfig  | 1.06x  | 6.758µs       | 6.346µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench | benchFetchServiceWithDependency     | 1.06x  | 7.973µs       | 7.541µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench | benchFetchServiceWithNoDependencies | 1.04x  | 3.328µs       | 3.190µs      |
    +--------------------------------------------------+-------------------------------------+--------+---------------+--------------+




