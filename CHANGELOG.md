# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## Version 0.5.0 - 2018-02-22: Final version without BC break

### Benchmark Comparison zend-master vs. mxc-master

We provide two benchmark comparison, one sorted by benchmark, one sorted descending by performance gain factor.
The benchmark comparisonsare based on a patched version of PHPBench 0.15-dev. The patch adds the `diff` column and sorts descendig by this
column. All tests were done with PHPBench 0.15-dev. The benchmark suite used was backported to zend:master.

#### By performance gain factor

    $ vendor\bin\phpbench report --file=..\all.050.xml --file=..\all.zend.xml --report="extends: compare, compare: tag, cols: ["benchmark", "subject"]
    +-------------------------------------------------------------+-------------------------------------+--------+--------------+---------------+
    | benchmark                                                   | subject                             | diff   | tag:mxc:mean | tag:zend:mean |
    +-------------------------------------------------------------+-------------------------------------+--------+--------------+---------------+
    | SetNewServicesBench                                         | benchOverrideAlias                  | 33.34x | 1.949μs      | 64.965μs      |
    | SetNewServicesBench                                         | benchSetAlias                       | 9.66x  | 1.949μs      | 18.828μs      |
    | SetNewServicesBench                                         | benchSetInvokableClass              | 4.34x  | 1.224μs      | 5.311μs       |
    | FetchNewServiceManagerBench                                 | benchFetchServiceManagerCreation    | 4.09x  | 228.723μs    | 935.954μs     |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByClassName  | 4.09x  | 0.808μs      | 3.304μs       |
    | SetNewServicesBench                                         | benchSetFactory                     | 3.79x  | 1.136μs      | 4.304μs       |
    | SetNewServicesBench                                         | benchSetService                     | 3.30x  | 0.596μs      | 1.968μs       |
    | SetNewServicesBench                                         | benchAddInitializerByInstance       | 2.01x  | 0.829μs      | 1.668μs       |
    | FetchNewServicesBench                                       | benchBuildMultiDelegatorCached      | 1.75x  | 3.449μs      | 6.053μs       |
    | FetchNewServicesBench                                       | benchFetchMultiDelegatorCached      | 1.70x  | 3.872μs      | 6.572μs       |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByInstance   | 1.65x  | 1.691μs      | 2.794μs       |
    | FetchNewServicesBench                                       | benchFetchInvokable1                | 1.65x  | 2.022μs      | 3.338μs       |
    | SetNewServicesBench                                         | benchAddInitializerByClassName      | 1.62x  | 1.438μs      | 2.327μs       |
    | FetchNewServicesBench                                       | benchBuildInvokable1                | 1.58x  | 1.669μs      | 2.641μs       |
    | SetNewServicesBench                                         | benchAddMultiDelegator              | 1.53x  | 2.252μs      | 3.447μs       |
    | FetchNewServicesBench                                       | benchBuildDelegatorCached           | 1.47x  | 2.627μs      | 3.868μs       |
    | SetNewServicesBench                                         | benchAddDelegator                   | 1.44x  | 2.398μs      | 3.444μs       |
    | FetchNewServicesBench                                       | benchFetchDelegatorCached           | 1.43x  | 3.075μs      | 4.410μs       |
    | FetchNewServicesBench                                       | benchFetchLazyServiceCached         | 1.39x  | 4.941μs      | 6.892μs       |
    | FetchNewServicesBench                                       | benchBuildLazyServiceCached         | 1.32x  | 4.317μs      | 5.709μs       |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithNoDependencies | 1.23x  | 4.340μs      | 5.343μs       |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithNoDependencies | 1.22x  | 3.936μs      | 4.800μs       |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithDependency     | 1.21x  | 4.502μs      | 5.435μs       |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithDependency     | 1.20x  | 4.964μs      | 5.958μs       |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceDependingOnConfig  | 1.20x  | 4.996μs      | 5.989μs       |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceDependingOnConfig  | 1.19x  | 4.562μs      | 5.442μs       |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias1    | 1.18x  | 2.053μs      | 2.432μs       |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithNoDependencies | 1.18x  | 3.261μs      | 3.851μs       |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias2    | 1.18x  | 2.060μs      | 2.430μs       |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias1    | 1.18x  | 2.058μs      | 2.421μs       |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias2    | 1.18x  | 2.070μs      | 2.434μs       |
    | FetchNewServicesBench                                       | benchFetchFactoryAlias1             | 1.17x  | 2.057μs      | 2.413μs       |
    | FetchNewServicesBench                                       | benchBuildFactoryAlias1             | 1.17x  | 2.056μs      | 2.407μs       |
    | FetchNewServicesBench                                       | benchBuildFactory1                  | 1.14x  | 2.103μs      | 2.391μs       |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithDependency     | 1.13x  | 5.107μs      | 5.766μs       |
    | FetchNewServicesBench                                       | benchFetchFactory1                  | 1.12x  | 2.513μs      | 2.806μs       |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceDependingOnConfig  | 1.10x  | 6.429μs      | 7.071μs       |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceDependingOnConfig  | 1.09x  | 5.123μs      | 5.602μs       |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithNoDependencies | 1.09x  | 3.101μs      | 3.382μs       |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithDependency     | 1.08x  | 7.753μs      | 8.406μs       |
    | HasBench                                                    | benchHasRecursiveAlias2             | 1.08x  | 0.493μs      | 0.534μs       |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithNoDependencies | 1.08x  | 4.546μs      | 4.923μs       |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithNoDependencies | 1.08x  | 3.048μs      | 3.299μs       |
    | HasBench                                                    | benchHasRecursiveAlias1             | 1.07x  | 0.499μs      | 0.534μs       |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceDependingOnConfig  | 1.06x  | 6.212μs      | 6.558μs       |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithDependency     | 1.05x  | 4.859μs      | 5.112μs       |
    | HasBench                                                    | benchHasAlias1                      | 1.05x  | 0.502μs      | 0.527μs       |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceDependingOnConfig  | 1.05x  | 4.900μs      | 5.133μs       |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithDependency     | 1.04x  | 7.638μs      | 7.955μs       |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithDependency     | 1.04x  | 7.506μs      | 7.816μs       |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceDependingOnConfig  | 1.04x  | 6.462μs      | 6.710μs       |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithNoDependencies | 1.03x  | 4.326μs      | 4.473μs       |
    | HasBench                                                    | benchHasInvokable1                  | 1.02x  | 0.526μs      | 0.537μs       |
    | FetchCachedServicesBench                                    | benchFetchDelegatorService          | 1.01x  | 0.415μs      | 0.420μs       |
    | FetchNewServicesBench                                       | benchBuildAbstractFactoryFoo        | 1.01x  | 1.842μs      | 1.862μs       |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceDependingOnConfig  | 1.00x  | 6.049μs      | 6.063μs       |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFooCached  | 1.00x  | 2.307μs      | 2.309μs       |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithDependency     | 1.00x  | 7.379μs      | 7.378μs       |
    | FetchNewServicesBench                                       | benchFetchLazyService               | 1.00x  | 204.750μs    | 204.562μs     |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFoo        | 0.99x  | 2.314μs      | 2.301μs       |
    | FetchNewServicesBench                                       | benchBuildLazyService               | 0.99x  | 203.850μs    | 202.212μs     |
    | FetchNewServicesBench                                       | benchFetchService1                  | 0.99x  | 0.401μs      | 0.397μs       |
    | FetchCachedServicesBench                                    | benchFetchInvokable1                | 0.99x  | 0.413μs      | 0.408μs       |
    | FetchCachedServicesBench                                    | benchFetchService1                  | 0.98x  | 0.412μs      | 0.405μs       |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias2           | 0.98x  | 0.407μs      | 0.399μs       |
    | FetchCachedServicesBench                                    | benchFetchAlias1                    | 0.98x  | 0.406μs      | 0.397μs       |
    | FetchNewServicesBench                                       | benchFetchMultiDelegator            | 0.97x  | 9.064μs      | 8.810μs       |
    | FetchCachedServicesBench                                    | benchFetchLazyService               | 0.97x  | 0.410μs      | 0.398μs       |
    | FetchCachedServicesBench                                    | benchFetchAbstractFactoryService    | 0.97x  | 0.412μs      | 0.399μs       |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias1           | 0.96x  | 0.415μs      | 0.400μs       |
    | FetchCachedServicesBench                                    | benchFetchMultiDelegatorService     | 0.96x  | 0.412μs      | 0.397μs       |
    | FetchNewServicesBench                                       | benchBuildMultiDelegator            | 0.96x  | 8.660μs      | 8.336μs       |
    | FetchCachedServicesBench                                    | benchFetchFactory1                  | 0.96x  | 0.416μs      | 0.398μs       |
    | HasBench                                                    | benchHasNot                         | 0.95x  | 0.856μs      | 0.814μs       |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithNoDependencies | 0.95x  | 2.885μs      | 2.741μs       |
    | HasBench                                                    | benchHasAbstractFactory             | 0.94x  | 0.815μs      | 0.766μs       |
    | HasBench                                                    | benchHasFactory1                    | 0.94x  | 0.510μs      | 0.479μs       |
    | FetchNewServicesBench                                       | benchFetchDelegator                 | 0.92x  | 6.167μs      | 5.702μs       |
    | FetchNewServicesBench                                       | benchBuildDelegator                 | 0.90x  | 5.733μs      | 5.163μs       |
    | HasBench                                                    | benchHasService1                    | 0.88x  | 0.482μs      | 0.423μs       |
    +-------------------------------------------------------------+-------------------------------------+--------+--------------+---------------+

#### By benchmark

    +-------------------------------------------------------------+-------------------------------------+--------+--------------+---------------+
    | benchmark                                                   | subject                             | diff   | tag:mxc:mean | tag:zend:mean |
    +-------------------------------------------------------------+-------------------------------------+--------+--------------+---------------+
    | FetchCachedServicesBench                                    | benchFetchFactory1                  | 0.96x  | 0.416μs      | 0.398μs       |
    | FetchCachedServicesBench                                    | benchFetchInvokable1                | 0.99x  | 0.413μs      | 0.408μs       |
    | FetchCachedServicesBench                                    | benchFetchService1                  | 0.98x  | 0.412μs      | 0.405μs       |
    | FetchCachedServicesBench                                    | benchFetchAlias1                    | 0.98x  | 0.406μs      | 0.397μs       |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias1           | 0.96x  | 0.415μs      | 0.400μs       |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias2           | 0.98x  | 0.407μs      | 0.399μs       |
    | FetchCachedServicesBench                                    | benchFetchAbstractFactoryService    | 0.97x  | 0.412μs      | 0.399μs       |
    | FetchCachedServicesBench                                    | benchFetchMultiDelegatorService     | 0.96x  | 0.412μs      | 0.397μs       |
    | FetchCachedServicesBench                                    | benchFetchDelegatorService          | 1.01x  | 0.415μs      | 0.420μs       |
    | FetchCachedServicesBench                                    | benchFetchLazyService               | 0.97x  | 0.410μs      | 0.398μs       |
    | FetchNewServiceManagerBench                                 | benchFetchServiceManagerCreation    | 4.09x  | 228.723μs    | 935.954μs     |
    | FetchNewServicesBench                                       | benchFetchFactory1                  | 1.12x  | 2.513μs      | 2.806μs       |
    | FetchNewServicesBench                                       | benchBuildFactory1                  | 1.14x  | 2.103μs      | 2.391μs       |
    | FetchNewServicesBench                                       | benchFetchInvokable1                | 1.65x  | 2.022μs      | 3.338μs       |
    | FetchNewServicesBench                                       | benchBuildInvokable1                | 1.58x  | 1.669μs      | 2.641μs       |
    | FetchNewServicesBench                                       | benchFetchService1                  | 0.99x  | 0.401μs      | 0.397μs       |
    | FetchNewServicesBench                                       | benchFetchFactoryAlias1             | 1.17x  | 2.057μs      | 2.413μs       |
    | FetchNewServicesBench                                       | benchBuildFactoryAlias1             | 1.17x  | 2.056μs      | 2.407μs       |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias1    | 1.18x  | 2.053μs      | 2.432μs       |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias1    | 1.18x  | 2.058μs      | 2.421μs       |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias2    | 1.18x  | 2.070μs      | 2.434μs       |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias2    | 1.18x  | 2.060μs      | 2.430μs       |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFoo        | 0.99x  | 2.314μs      | 2.301μs       |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFooCached  | 1.00x  | 2.307μs      | 2.309μs       |
    | FetchNewServicesBench                                       | benchBuildAbstractFactoryFoo        | 1.01x  | 1.842μs      | 1.862μs       |
    | FetchNewServicesBench                                       | benchFetchMultiDelegator            | 0.97x  | 9.064μs      | 8.810μs       |
    | FetchNewServicesBench                                       | benchBuildMultiDelegator            | 0.96x  | 8.660μs      | 8.336μs       |
    | FetchNewServicesBench                                       | benchFetchDelegator                 | 0.92x  | 6.167μs      | 5.702μs       |
    | FetchNewServicesBench                                       | benchBuildDelegator                 | 0.90x  | 5.733μs      | 5.163μs       |
    | FetchNewServicesBench                                       | benchFetchLazyService               | 1.00x  | 204.750μs    | 204.562μs     |
    | FetchNewServicesBench                                       | benchBuildLazyService               | 0.99x  | 203.850μs    | 202.212μs     |
    | FetchNewServicesBench                                       | benchFetchMultiDelegatorCached      | 1.70x  | 3.872μs      | 6.572μs       |
    | FetchNewServicesBench                                       | benchBuildMultiDelegatorCached      | 1.75x  | 3.449μs      | 6.053μs       |
    | FetchNewServicesBench                                       | benchFetchDelegatorCached           | 1.43x  | 3.075μs      | 4.410μs       |
    | FetchNewServicesBench                                       | benchBuildDelegatorCached           | 1.47x  | 2.627μs      | 3.868μs       |
    | FetchNewServicesBench                                       | benchFetchLazyServiceCached         | 1.39x  | 4.941μs      | 6.892μs       |
    | FetchNewServicesBench                                       | benchBuildLazyServiceCached         | 1.32x  | 4.317μs      | 5.709μs       |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithNoDependencies | 1.08x  | 4.546μs      | 4.923μs       |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithNoDependencies | 1.03x  | 4.326μs      | 4.473μs       |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceDependingOnConfig  | 1.09x  | 5.123μs      | 5.602μs       |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceDependingOnConfig  | 1.05x  | 4.900μs      | 5.133μs       |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithDependency     | 1.13x  | 5.107μs      | 5.766μs       |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithDependency     | 1.05x  | 4.859μs      | 5.112μs       |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithNoDependencies | 1.18x  | 3.261μs      | 3.851μs       |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithNoDependencies | 1.09x  | 3.101μs      | 3.382μs       |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceDependingOnConfig  | 1.10x  | 6.429μs      | 7.071μs       |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceDependingOnConfig  | 1.06x  | 6.212μs      | 6.558μs       |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithDependency     | 1.08x  | 7.753μs      | 8.406μs       |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithDependency     | 1.04x  | 7.506μs      | 7.816μs       |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithNoDependencies | 1.23x  | 4.340μs      | 5.343μs       |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithNoDependencies | 1.22x  | 3.936μs      | 4.800μs       |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceDependingOnConfig  | 1.20x  | 4.996μs      | 5.989μs       |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceDependingOnConfig  | 1.19x  | 4.562μs      | 5.442μs       |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithDependency     | 1.20x  | 4.964μs      | 5.958μs       |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithDependency     | 1.21x  | 4.502μs      | 5.435μs       |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithNoDependencies | 1.08x  | 3.048μs      | 3.299μs       |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithNoDependencies | 0.95x  | 2.885μs      | 2.741μs       |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceDependingOnConfig  | 1.04x  | 6.462μs      | 6.710μs       |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceDependingOnConfig  | 1.00x  | 6.049μs      | 6.063μs       |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithDependency     | 1.04x  | 7.638μs      | 7.955μs       |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithDependency     | 1.00x  | 7.379μs      | 7.378μs       |
    | HasBench                                                    | benchHasFactory1                    | 0.94x  | 0.510μs      | 0.479μs       |
    | HasBench                                                    | benchHasInvokable1                  | 1.02x  | 0.526μs      | 0.537μs       |
    | HasBench                                                    | benchHasService1                    | 0.88x  | 0.482μs      | 0.423μs       |
    | HasBench                                                    | benchHasAlias1                      | 1.05x  | 0.502μs      | 0.527μs       |
    | HasBench                                                    | benchHasRecursiveAlias1             | 1.07x  | 0.499μs      | 0.534μs       |
    | HasBench                                                    | benchHasRecursiveAlias2             | 1.08x  | 0.493μs      | 0.534μs       |
    | HasBench                                                    | benchHasAbstractFactory             | 0.94x  | 0.815μs      | 0.766μs       |
    | HasBench                                                    | benchHasNot                         | 0.95x  | 0.856μs      | 0.814μs       |
    | SetNewServicesBench                                         | benchSetService                     | 3.30x  | 0.596μs      | 1.968μs       |
    | SetNewServicesBench                                         | benchSetFactory                     | 3.79x  | 1.136μs      | 4.304μs       |
    | SetNewServicesBench                                         | benchSetAlias                       | 9.66x  | 1.949μs      | 18.828μs      |
    | SetNewServicesBench                                         | benchOverrideAlias                  | 33.34x | 1.949μs      | 64.965μs      |
    | SetNewServicesBench                                         | benchSetInvokableClass              | 4.34x  | 1.224μs      | 5.311μs       |
    | SetNewServicesBench                                         | benchAddDelegator                   | 1.44x  | 2.398μs      | 3.444μs       |
    | SetNewServicesBench                                         | benchAddMultiDelegator              | 1.53x  | 2.252μs      | 3.447μs       |
    | SetNewServicesBench                                         | benchAddInitializerByClassName      | 1.62x  | 1.438μs      | 2.327μs       |
    | SetNewServicesBench                                         | benchAddInitializerByInstance       | 2.01x  | 0.829μs      | 1.668μs       |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByClassName  | 4.09x  | 0.808μs      | 3.304μs       |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByInstance   | 1.65x  | 1.691μs      | 2.794μs       |
    +-------------------------------------------------------------+-------------------------------------+--------+--------------+---------------+

## Version 0.4.0 - 2018-02-20: ConfigAbstractFactory

### Added

- nothing

### Fixed

- nothing

### Changed

- Caching of configuration in ConfigAbstractFactory. Configuration can be assumed to be unchanged between calls,
  also this is not documented. If configuration would be allowed to be changed between calls, abstract factories could not grant,
  that they can produce services which they report to be able to produce via canCreate.

### Deprecated

- nothing

### Benchmark comparison

Here is a new full benchmark comparison. The diff column says, how much time zend-servicemanager needs compared to mxc-servicemanager. For example: The first line of the report below
says: zend-servicemanager needs 2,99x the time mxc-servicemanager needs to complete the benchFetchServiceManagerCreation test which can be found in FetchNewServiceManagerBench.php.

Tests, where mxc-servicemanager is slower than zend-servicemanager are marked with an asterisk (*) for your convenience.

    +-------------------------------------------------------------+-------------------------------------------+--------+--------+--------+-----------------+----------------+--------+
    | benchmark                                                   | subject                                   | groups | params | revs   | suite:zend:mean | suite:mxc:mean | diff   |
    +-------------------------------------------------------------+-------------------------------------------+--------+--------+--------+-----------------+----------------+--------+
    | FetchNewServiceManagerBench                                 | benchFetchServiceManagerCreation          |        | []     | 500    | 891.600µs       | 298.017µs      | 2.99x  |
    | AbstractFactoryCacheBench                                   | benchGetViaAbstractFactory                |        | []     | 100000 | 2.268µs         | 2.268µs        | 1.00x  |
    | AbstractFactoryCacheBench                                   | benchGetViaCachedAbstractFactory          |        | []     | 100000 | 2.290µs         | 1.774µs        | 1.29x  |
    | AbstractFactoryCacheBench                                   | benchIfHasThenGetViaAbstractFactory       |        | []     | 100000 | 2.860µs         | 2.858µs        | 1.00x  |
    | AbstractFactoryCacheBench                                   | benchIfHasThenGetViaCachedAbstractFactory |        | []     | 100000 | 2.837µs         | 2.036µs        | 1.39x  |
    | FetchCachedServicesBench                                    | benchFetchFactory1                        |        | []     | 100000 | 0.441µs         | 0.397µs        | 1.11x  |
    | FetchCachedServicesBench                                    | benchFetchInvokable1                      |        | []     | 100000 | 0.422µs         | 0.399µs        | 1.06x  |
    | FetchCachedServicesBench                                    | benchFetchService1                        |        | []     | 100000 | 0.403µs         | 0.394µs        | 1.02x  |
    | FetchCachedServicesBench                                    | benchFetchAlias1                          |        | []     | 100000 | 0.402µs         | 0.400µs        | 1.01x  |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias1                 |        | []     | 100000 | 0.398µs         | 0.395µs        | 1.01x  |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias2                 |        | []     | 100000 | 0.396µs         | 0.395µs        | 1.00x  |
    | FetchCachedServicesBench                                    | benchFetchAbstractFactoryService          |        | []     | 100000 | 2.448µs         | 2.523µs        | 0.97x  | *
    | FetchNewServicesBench                                       | benchFetchFactory1                        |        | []     | 100000 | 2.769µs         | 2.479µs        | 1.12x  |
    | FetchNewServicesBench                                       | benchBuildFactory1                        |        | []     | 100000 | 2.344µs         | 2.054µs        | 1.14x  |
    | FetchNewServicesBench                                       | benchFetchInvokable1                      |        | []     | 100000 | 3.292µs         | 2.045µs        | 1.61x  |
    | FetchNewServicesBench                                       | benchBuildInvokable1                      |        | []     | 100000 | 2.597µs         | 1.634µs        | 1.59x  |
    | FetchNewServicesBench                                       | benchFetchService1                        |        | []     | 100000 | 0.399µs         | 0.393µs        | 1.02x  |
    | FetchNewServicesBench                                       | benchFetchFactoryAlias1                   |        | []     | 100000 | 2.387µs         | 2.016µs        | 1.18x  |
    | FetchNewServicesBench                                       | benchBuildFactoryAlias1                   |        | []     | 100000 | 2.399µs         | 2.012µs        | 1.19x  |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias1          |        | []     | 100000 | 2.380µs         | 2.013µs        | 1.18x  |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias1          |        | []     | 100000 | 2.405µs         | 2.011µs        | 1.20x  |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias2          |        | []     | 100000 | 2.408µs         | 2.021µs        | 1.19x  |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias2          |        | []     | 100000 | 2.408µs         | 2.013µs        | 1.20x  |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFoo              |        | []     | 100000 | 2.315µs         | 2.483µs        | 0.93x  | *
    | FetchNewServicesBench                                       | benchBuildAbstractFactoryFoo              |        | []     | 100000 | 1.862µs         | 2.083µs        | 0.89x  | *
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithNoDependencies       |        | []     | 100000 | 4.976µs         | 4.556µs        | 1.09x  |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithNoDependencies       |        | []     | 100000 | 4.497µs         | 4.319µs        | 1.04x  |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceDependingOnConfig        |        | []     | 100000 | 5.605µs         | 5.119µs        | 1.09x  |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceDependingOnConfig        |        | []     | 100000 | 5.164µs         | 4.927µs        | 1.05x  |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithDependency           |        | []     | 100000 | 5.595µs         | 5.115µs        | 1.09x  |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithDependency           |        | []     | 100000 | 5.116µs         | 4.861µs        | 1.05x  |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithNoDependencies       |        | []     | 100000 | 3.889µs         | 3.234µs        | 1.20x  |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithNoDependencies       |        | []     | 100000 | 3.415µs         | 3.037µs        | 1.12x  |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceDependingOnConfig        |        | []     | 100000 | 7.176µs         | 6.426µs        | 1.12x  |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceDependingOnConfig        |        | []     | 100000 | 6.709µs         | 6.201µs        | 1.08x  |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithDependency           |        | []     | 100000 | 8.401µs         | 7.758µs        | 1.08x  |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithDependency           |        | []     | 100000 | 7.847µs         | 7.497µs        | 1.05x  |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithNoDependencies       |        | []     | 100000 | 5.454µs         | 4.502µs        | 1.21x  |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithNoDependencies       |        | []     | 100000 | 5.412µs         | 4.231µs        | 1.28x  |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceDependingOnConfig        |        | []     | 100000 | 6.759µs         | 5.119µs        | 1.32x  |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceDependingOnConfig        |        | []     | 100000 | 5.639µs         | 4.855µs        | 1.16x  |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithDependency           |        | []     | 100000 | 6.087µs         | 5.110µs        | 1.19x  |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithDependency           |        | []     | 100000 | 5.514µs         | 4.860µs        | 1.13x  |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithNoDependencies       |        | []     | 100000 | 3.346µs         | 3.205µs        | 1.04x  |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithNoDependencies       |        | []     | 100000 | 2.791µs         | 3.011µs        | 0.92x  | *
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceDependingOnConfig        |        | []     | 100000 | 6.784µs         | 6.604µs        | 1.03x  |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceDependingOnConfig        |        | []     | 100000 | 6.169µs         | 6.345µs        | 0.97x  | *
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithDependency           |        | []     | 100000 | 8.144µs         | 7.872µs        | 1.03x  |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithDependency           |        | []     | 100000 | 7.481µs         | 7.654µs        | 0.98x  | *
    | HasBench                                                    | benchHasFactory1                          |        | []     | 100000 | 0.482µs         | 0.501µs        | 0.96x  | *
    | HasBench                                                    | benchHasInvokable1                        |        | []     | 100000 | 0.544µs         | 0.520µs        | 1.04x  |
    | HasBench                                                    | benchHasService1                          |        | []     | 100000 | 0.426µs         | 0.476µs        | 0,89x  | *
    | HasBench                                                    | benchHasAlias1                            |        | []     | 100000 | 0.530µs         | 0.490µs        | 1,08x  |
    | HasBench                                                    | benchHasRecursiveAlias1                   |        | []     | 100000 | 0.535µs         | 0.494µs        | 1,08x  |
    | HasBench                                                    | benchHasRecursiveAlias2                   |        | []     | 100000 | 0.536µs         | 0.496µs        | 1,08x  |
    | HasBench                                                    | benchHasAbstractFactory                   |        | []     | 100000 | 0.769µs         | 0.809µs        | 0,95x  | *
    | HasBench                                                    | benchHasNot                               |        | []     | 100000 | 0.817µs         | 0.850µs        | 0,96x  | *
    | SetNewServicesBench                                         | benchSetService                           |        | []     | 100000 | 1.980µs         | 0.589µs        | 3,41x  |
    | SetNewServicesBench                                         | benchSetFactory                           |        | []     | 100000 | 4.364µs         | 1.142µs        | 3,82x  |
    | SetNewServicesBench                                         | benchSetAlias                             |        | []     | 100000 | 18.998µs        | 1.947µs        | 9,76x  |
    | SetNewServicesBench                                         | benchOverrideAlias                        |        | []     | 100000 | 66.780µs        | 1.947µs        | 34,30x |
    | SetNewServicesBench                                         | benchSetInvokableClass                    |        | []     | 100000 | 5.411µs         | 1.241µs        | 4.36x  |
    | SetNewServicesBench                                         | benchAddDelegator                         |        | []     | 100000 | 3.875µs         | 2.025µs        | 1.91x  |
    | SetNewServicesBench                                         | benchAddInitializerByClassName            |        | []     | 100000 | 2.629µs         | 1.422µs        | 1.85x  |
    | SetNewServicesBench                                         | benchAddInitializerByInstance             |        | []     | 100000 | 1.675µs         | 0.819µs        | 2.05x  |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByClassName        |        | []     | 100000 | 3.288µs         | 0.795µs        | 4.14x  |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByInstance         |        | []     | 100000 | 2.788µs         | 1.848µs        | 1.51x  |
    +-------------------------------------------------------------+-------------------------------------------+--------+--------+--------+-----------------+----------------+--------+

## Version 0.3.1 - 2018-02-19

### Added

- nothing

### Fixed

- Added test and fixed that service manager accepted factories not implementing FactoryInterface
- Added test and fixed that service manager accepted initializers not implementing InitializerInterface
- Added test and fixed that service manager accepted delegator factories not implementing DelegatorFactoryInterface

### Changed

- Standardized exception used for invalid service manager configuration to InvalidArgumentException.
- ServiceNotCreatedException now gets only thrown, if an external exception was caught.

### Deprecated

- nothing

### Benchmark comparison

See 0.2.0 below.


## Version 0.3.0

### Added

- Nothing.

### Changed

- Restructured Packagist offering mxc-servicemanager to provide full repo. This way the
  full benchmark suite and phpunit suite gets available.

- Former reduced offering mxc-servicemanager has been changed to mxc-servicemanager-s. Low
footprint, MxcCommons namespace, dependency to mxc-servicemanager.

- Documentation adjusted to reflect changes above.

### Deprecated

- mxc-services GitHub repo. It's now mxc-servicemanager.


### Benchmark Comparison zend-master vs. mxc-master

No impact. See 0.2.0 below.

## Version 0.2.0

### Added

- Nothing.

### Changed

- Abstract factories do not get pre-instantiated any longer. As other factories they
  get instantiated and cached on first use. This has impact on all benchmarks which deal
  with abstract factories, because the price of abstract factory instantiation gets measured
  now.

- Initializers do not get preinstanciated any longer. They get instanciated on first use.
  This has performance impact on the first call to get, because initializer instanciation
  get's mesured now.

- The callback function iteratively created for delegators gets cached now.

- Refactored the service resolution process for performance. Achievement around 10%.

### Deprecated

- Nothing.


### Benchmark Comparison zend-master vs. mxc-master

Because of dropping pre-instantiation of abstract factories some benchmarks dropped in performance.
Rationale is that mxc-master does instantiation of abstract factories in get/has so time is measured,
while benchmarks do not measure zend-master abstract factory instantiation overhead at all. Same for
initializers. The benchmarks impacted most by that are marked with an asterrisk.

As of 0.1.0 we had the error that the test suites applied to zend-master and mxc-master were not
completely in sync. This was corrected in this version. The corrected benchmark unreveals that
setAlias and setOverrideAlias are much slower in zend-master than suggested by the 0.1.0 benchmark
comparison.


        $ vendor\bin\phpbench report --file=..\all.master.xml --file=..\all.020.xml --report="compare"
        benchmark: AbstractFactoryCacheBench
        +----------------------------------+-------------------+----------------+
        | subject                          | suite:master:mean | suite:mxc:mean |
        +----------------------------------+-------------------+----------------+
        | benchFetchServiceManagerCreation | 875.480μs         | 297.637μs      |
        +----------------------------------+-------------------+----------------+

        benchmark: FetchNewServiceManagerBench
        +-------------------------------------------+-------------------+----------------+
        | subject                                   | suite:master:mean | suite:mxc:mean |
        +-------------------------------------------+-------------------+----------------+
        | benchGetViaAbstractFactory                | 2.335μs           | 2.977μs        | *
        | benchGetViaCachedAbstractFactory          | 2.352μs           | 1.894μs        |
        | benchIfHasThenGetViaAbstractFactory       | 2.947μs           | 3.217μs        | *
        | benchIfHasThenGetViaCachedAbstractFactory | 2.958μs           | 2.158μs        |
        +-------------------------------------------+-------------------+----------------+

        benchmark: FetchCachedServicesBench
        +----------------------------------+-------------------+----------------+
        | subject                          | suite:master:mean | suite:mxc:mean |
        +----------------------------------+-------------------+----------------+
        | benchFetchFactory1               | 0.452μs           | 0.439μs        |
        | benchFetchInvokable1             | 0.470μs           | 0.448μs        |
        | benchFetchService1               | 0.454μs           | 0.440μs        |
        | benchFetchAlias1                 | 0.450μs           | 0.435μs        |
        | benchFetchRecursiveAlias1        | 0.468μs           | 0.456μs        |
        | benchFetchRecursiveAlias2        | 0.467μs           | 0.456μs        |
        | benchFetchAbstractFactoryService | 2.466μs           | 3.258μs        | *
        +----------------------------------+-------------------+----------------+

        benchmark: FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench
        +-------------------------------------+-------------------+----------------+
        | subject                             | suite:master:mean | suite:mxc:mean |
        +-------------------------------------+-------------------+----------------+
        | benchFetchServiceWithNoDependencies | 5.020μs           | 4.507μs        |
        | benchBuildServiceWithNoDependencies | 4.617μs           | 4.187μs        |
        | benchFetchServiceDependingOnConfig  | 5.724μs           | 5.170μs        |
        | benchBuildServiceDependingOnConfig  | 5.160μs           | 4.840μs        |
        | benchFetchServiceWithDependency     | 5.662μs           | 4.990μs        |
        | benchBuildServiceWithDependency     | 5.275μs           | 4.663μs        |
        +-------------------------------------+-------------------+----------------+

        benchmark: FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench
        +-------------------------------------+-------------------+----------------+
        | subject                             | suite:master:mean | suite:mxc:mean |
        +-------------------------------------+-------------------+----------------+
        | benchFetchServiceWithNoDependencies | 3.967μs           | 3.518μs        |
        | benchBuildServiceWithNoDependencies | 3.556μs           | 3.343μs        |
        | benchFetchServiceDependingOnConfig  | 7.115μs           | 6.758μs        |
        | benchBuildServiceDependingOnConfig  | 6.594μs           | 6.467μs        |
        | benchFetchServiceWithDependency     | 8.422μs           | 8.001μs        |
        | benchBuildServiceWithDependency     | 7.896μs           | 7.694μs        |
        +-------------------------------------+-------------------+----------------+

        benchmark: FetchNewServiceViaConfigAbstractFactoryBench
        +-------------------------------------+-------------------+----------------+
        | subject                             | suite:master:mean | suite:mxc:mean |
        +-------------------------------------+-------------------+----------------+
        | benchFetchServiceWithNoDependencies | 5.314μs           | 5.870μs        | *
        | benchBuildServiceWithNoDependencies | 4.855μs           | 5.547μs        | *
        | benchFetchServiceDependingOnConfig  | 6.086μs           | 6.581μs        | *
        | benchBuildServiceDependingOnConfig  | 5.365μs           | 6.198μs        | *
        | benchFetchServiceWithDependency     | 6.002μs           | 5.962μs        | *
        | benchBuildServiceWithDependency     | 5.650μs           | 5.720μs        | *
        +-------------------------------------+-------------------+----------------+

        benchmark: FetchNewServiceViaReflectionAbstractFactoryBench
        +-------------------------------------+-------------------+----------------+
        | subject                             | suite:master:mean | suite:mxc:mean |
        +-------------------------------------+-------------------+----------------+
        | benchFetchServiceWithNoDependencies | 3.388μs           | 4.192μs        | *
        | benchBuildServiceWithNoDependencies | 2.869μs           | 4.005μs        | *
        | benchFetchServiceDependingOnConfig  | 6.677μs           | 7.660μs        | *
        | benchBuildServiceDependingOnConfig  | 6.129μs           | 7.488μs        | *
        | benchFetchServiceWithDependency     | 7.758μs           | 8.555μs        | *
        | benchBuildServiceWithDependency     | 7.496μs           | 8.135μs        | *
        +-------------------------------------+-------------------+----------------+

        benchmark: FetchNewServicesBench
        +----------------------------------+-------------------+----------------+
        | subject                          | suite:master:mean | suite:mxc:mean |
        +----------------------------------+-------------------+----------------+
        | benchFetchFactory1               | 2.836μs           | 2.664μs        |
        | benchBuildFactory1               | 2.414μs           | 2.209μs        |
        | benchFetchInvokable1             | 3.254μs           | 2.146μs        |
        | benchBuildInvokable1             | 2.648μs           | 1.693μs        |
        | benchFetchService1               | 0.470μs           | 0.439μs        |
        | benchFetchFactoryAlias1          | 2.427μs           | 2.233μs        |
        | benchBuildFactoryAlias1          | 2.450μs           | 2.224μs        |
        | benchFetchRecursiveFactoryAlias1 | 2.445μs           | 2.238μs        |
        | benchBuildRecursiveFactoryAlias1 | 2.475μs           | 2.234μs        |
        | benchFetchRecursiveFactoryAlias2 | 2.457μs           | 2.231μs        |
        | benchBuildRecursiveFactoryAlias2 | 2.461μs           | 2.229μs        |
        | benchFetchAbstractFactoryFoo     | 2.392μs           | 3.217μs        | *
        | benchBuildAbstractFactoryFoo     | 1.934μs           | 2.735μs        | *
        +----------------------------------+-------------------+----------------+

        benchmark: HasBench
        +-------------------------+-------------------+----------------+
        | subject                 | suite:master:mean | suite:mxc:mean |
        +-------------------------+-------------------+----------------+
        | benchHasFactory1        | 0.530μs           | 0.557μs        |
        | benchHasInvokable1      | 0.598μs           | 0.599μs        |
        | benchHasService1        | 0.477μs           | 0.535μs        |
        | benchHasAlias1          | 0.578μs           | 0.573μs        |
        | benchHasRecursiveAlias1 | 0.597μs           | 0.596μs        |
        | benchHasRecursiveAlias2 | 0.601μs           | 0.591μs        |
        | benchHasAbstractFactory | 0.834μs           | 1.619μs        | *
        | benchHasNot             | 0.841μs           | 1.545μs        | *
        +-------------------------+-------------------+----------------+

        benchmark: SetNewServicesBench
        +------------------------------------+-------------------+----------------+
        | subject                            | suite:master:mean | suite:mxc:mean |
        +------------------------------------+-------------------+----------------+
        | benchSetService                    | 2.020μs           | 0.647μs        |
        | benchSetFactory                    | 4.306μs           | 1.216μs        |
        | benchSetAlias                      | 19.030μs          | 1.952μs        |
        | benchOverrideAlias                 | 65.250μs          | 1.930μs        |
        | benchSetInvokableClass             | 5.301μs           | 1.229μs        |
        | benchAddDelegator                  | 3.482μs           | 2.065μs        |
        | benchAddInitializerByClassName     | 2.458μs           | 0.506μs        |
        | benchAddInitializerByInstance      | 1.772μs           | 0.548μs        |
        | benchAddAbstractFactoryByClassName | 3.524μs           | 0.738μs        |
        | benchAddAbstractFactoryByInstance  | 3.076μs           | 1.500μs        |
        +------------------------------------+-------------------+----------------+

## Version 0.1.0

### Added

- Nothing.

### Changed

- [#221](https://github.com/zendframework/zend-servicemanager/pull/221) provides
  enormous performance improvements for each of the various mutator methods
  (`setAlias()`, `setFactory()`, etc.), `has()` lookups, and initial
  container configuration.

### Deprecated

- Nothing.

### Removed

- [#197](https://github.com/zendframework/zend-servicemanager/pull/197) drops
  support for PHP versions prior to 7.1.

- [#193](https://github.com/zendframework/zend-servicemanager/pull/193) drops
  support for HHVM.

### Fixed

- [#230](https://github.com/zendframework/zend-servicemanager/pull/230) fixes a
  problem in detecting cyclic aliases, ensuring they are detected correctly.


### Benchmark Comparsion zend-master vs. mxc-master
Significant performance improvements currently are the creation of a new ServiceManager with several thousand items via call to configure() (3x faster) and service creation via the setter APIs (setService, setAlias, ...) which is between minimum 1.3x and maximum 18.0x as fast as zend-servicemanager. Most other sections profit a bit from the refactored handling of invokable and aliases.

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


## 3.3.2 - 2018-01-29

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#243](https://github.com/zendframework/zend-servicemanager/pull/243) provides
  a fix to the `ReflectionBasedAbstractFactory` to resolve type-hinted arguments
  with default values to their default values if no matching type is found in
  the container.

- [#233](https://github.com/zendframework/zend-servicemanager/pull/233) fixes a
  number of parameter annotations to reflect the actual types used.

## 3.3.1 - 2017-11-27

### Added

- [#201](https://github.com/zendframework/zend-servicemanager/pull/201) and
  [#202](https://github.com/zendframework/zend-servicemanager/pull/202) add
  support for PHP versions 7.1 and 7.2.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#206](https://github.com/zendframework/zend-servicemanager/pull/206) fixes an
  issue where by callables in `Class::method` notation were not being honored
  under PHP 5.6.

## 3.3.0 - 2017-03-01

### Added

- [#180](https://github.com/zendframework/zend-servicemanager/pull/180) adds
  explicit support for PSR-11 (ContainerInterface) by requiring
  container-interop at a minimum version of 1.2.0, and adding a requirement on
  psr/container 1.0. `Zend\ServiceManager\ServiceLocatorInterface` now
  explicitly extends the `ContainerInterface` from both projects.

  Factory interfaces still typehint against the container-interop variant, as
  changing the typehint would break backwards compatibility. Users can
  duck-type most of these interfaces, however, by creating callables or
  invokables that typehint against psr/container instead.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 3.2.1 - 2017-02-15

### Added

- [#176](https://github.com/zendframework/zend-servicemanager/pull/176) adds
  the options `-i` or `--ignore-unresolved` to the shipped
  `generate-deps-for-config-factory` command. This flag allows it to build
  configuration for classes resolved by the `ConfigAbstractFactory` that
  typehint on interfaces, which was previously unsupported.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#174](https://github.com/zendframework/zend-servicemanager/pull/174) updates
  the `ConfigAbstractFactory` to allow the `config` service to be either an
  `array` or an `ArrayObject`; previously, only `array` was supported.

## 3.2.0 - 2016-12-19

### Added

- [#146](https://github.com/zendframework/zend-servicemanager/pull/146) adds
  `Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory`, which enables a
  configuration-based approach to providing class dependencies when all
  dependencies are services known to the `ServiceManager`. Please see
  [the documentation](doc/book/config-abstract-factory.md) for details.
- [#154](https://github.com/zendframework/zend-servicemanager/pull/154) adds
  `Zend\ServiceManager\Tool\ConfigDumper`, which will introspect a given class
  to determine dependencies, and then create configuration for
  `Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory`, merging it with
  the provided configuration file. It also adds a vendor binary,
  `generate-deps-for-config-factory`, for generating these from the command
  line.
- [#154](https://github.com/zendframework/zend-servicemanager/pull/154) adds
  `Zend\ServiceManager\Tool\FactoryCreator`, which will introspect a given class
  and generate a factory for it. It also adds a vendor binary,
  `generate-factory-for-class`, for generating these from the command line.
- [#153](https://github.com/zendframework/zend-servicemanager/pull/153) adds
  `Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory`. This
  class may be used as either a mapped factory or an abstract factory, and will
  use reflection in order to determine which dependencies to use from the
  container when instantiating the requested service, with the following rules:
  - Scalar values are not allowed, unless they have default values associated.
  - Values named `$config` type-hinted against `array` will be injected with the
    `config` service, if present.
  - All other array values will be provided an empty array.
  - Class/interface typehints will be pulled from the container.
- [#150](https://github.com/zendframework/zend-servicemanager/pull/150) adds
  a "cookbook" section to the documentation, with an initial document detailing
  the pros and cons of abstract factory usage.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#106](https://github.com/zendframework/zend-servicemanager/pull/106) adds
  detection of multiple attempts to register the same instance or named abstract
  factory, using a previous instance when detected. You may still use multiple
  discrete instances, however.

## 3.1.2 - 2016-12-19

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#167](https://github.com/zendframework/zend-servicemanager/pull/167) fixes
  how exception codes are provided to ServiceNotCreatedException. Previously,
  the code was provided as-is. However, some PHP internal exception classes,
  notably PDOException, can sometimes return other values (such as strings),
  which can lead to fatal errors when instantiating the new exception. The
  patch provided casts exception codes to integers to prevent these errors.

## 3.1.1 - 2016-07-15

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#136](https://github.com/zendframework/zend-servicemanager/pull/136) removes
  several imports to classes in subnamespaces within the `ServiceManager`
  classfile, removing potential name resolution conflicts that occurred in edge
  cases when testing.

## 3.1.0 - 2016-06-01

### Added

- [#103](https://github.com/zendframework/zend-servicemanager/pull/103) Allowing
  installation of `ocramius/proxy-manager` `^2.0` together with
  `zendframework/zend-servicemanager`.
- [#103](https://github.com/zendframework/zend-servicemanager/pull/103) Disallowing
  test failures when running tests against PHP `7.0.*`.
- [#113](https://github.com/zendframework/zend-servicemanager/pull/113) Improved performance
  when dealing with registering aliases and factories via `ServiceManager#setFactory()` and
  `ServiceManager#setAlias()`
- [#120](https://github.com/zendframework/zend-servicemanager/pull/120) The
  `zendframework/zend-servicemanager` component now provides a
  `container-interop/container-interop-implementation` implementation

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#97](https://github.com/zendframework/zend-servicemanager/pull/97) Typo corrections
  in the delegator factories documentation.
- [#98](https://github.com/zendframework/zend-servicemanager/pull/98) Using coveralls ^1.0
  for tracking test code coverage changes.

## 3.0.4 - TBD

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 3.0.3 - 2016-02-02

### Added

- [#89](https://github.com/zendframework/zend-servicemanager/pull/89) adds
  cyclic alias detection to the `ServiceManager`; it now raises a
  `Zend\ServiceManager\Exception\CyclicAliasException` when one is detected,
  detailing the cycle detected.
- [#95](https://github.com/zendframework/zend-servicemanager/pull/95) adds
  GitHub Pages publication automation, and moves the documentation to
  https://zendframework.github.io/zend-servicemanager/
- [#93](https://github.com/zendframework/zend-servicemanager/pull/93) adds
  `Zend\ServiceManager\Test\CommonPluginManagerTrait`, which can be used to
  validate that a plugin manager instance is ready for version 3.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#90](https://github.com/zendframework/zend-servicemanager/pull/90) fixes
  several examples in the configuration chapter of the documentation, ensuring
  that the signatures are correct.
- [#92](https://github.com/zendframework/zend-servicemanager/pull/92) ensures
  that alias resolution is skipped during configuration if no aliases are
  present, and forward-ports the test from [#81](https://github.com/zendframework/zend-servicemanager/pull/81)
  to validate v2/v3 compatibility for plugin managers.

## 3.0.2 - 2016-01-24

### Added

- [#64](https://github.com/zendframework/zend-servicemanager/pull/64) performance optimizations
  when dealing with alias resolution during service manager instantiation

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#62](https://github.com/zendframework/zend-servicemanager/pull/62)
  [#64](https://github.com/zendframework/zend-servicemanager/pull/64) corrected benchmark assets signature
- [#72](https://github.com/zendframework/zend-servicemanager/pull/72) corrected link to the Proxy Pattern Wikipedia
  page in the documentation
- [#78](https://github.com/zendframework/zend-servicemanager/issues/78)
  [#79](https://github.com/zendframework/zend-servicemanager/pull/79) creation context was not being correctly passed
  to abstract factories when using plugin managers
- [#82](https://github.com/zendframework/zend-servicemanager/pull/82) corrected migration guide in the DocBlock of
  the `InitializerInterface`

## 3.0.1 - 2016-01-19

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- [#68](https://github.com/zendframework/zend-servicemanager/pull/68) removes
  the dependency on zend-stdlib by inlining the `ArrayUtils::merge()` routine
  as a private method of `Zend\ServiceManager\Config`.

### Fixed

- Nothing.

## 3.0.0 - 2016-01-11

First stable release of version 3 of zend-servicemanager.

Documentation is now available at http://zend-servicemanager.rtfd.org

### Added

- You can now map multiple key names to the same factory. It was previously
  possible in ZF2 but it was not enforced by the `FactoryInterface` interface.
  Now the interface receives the `$requestedName` as the *second* parameter
  (previously, it was the third).

  Example:

  ```php
  $sm = new \Zend\ServiceManager\ServiceManager([
      'factories'  => [
          MyClassA::class => MyFactory::class,
          MyClassB::class => MyFactory::class,
          'MyClassC'      => 'MyFactory' // This is equivalent as using ::class
      ],
  ]);

  $sm->get(MyClassA::class); // MyFactory will receive MyClassA::class as second parameter
  ```

- Writing a plugin manager has been simplified. If you have simple needs, you no
  longer need to implement the complete `validate` method.

  In versions 2.x, if your plugin manager only allows creating instances that
  implement `Zend\Validator\ValidatorInterface`, you needed to write the
  following code:

  ```php
  class MyPluginManager extends AbstractPluginManager
  {
    public function validate($instance)
    {
        if ($instance instanceof \Zend\Validator\ValidatorInterface) {
            return;
        }

        throw new InvalidServiceException(sprintf(
            'Plugin manager "%s" expected an instance of type "%s", but "%s" was received',
             __CLASS__,
             \Zend\Validator\ValidatorInterface::class,
             is_object($instance) ? get_class($instance) : gettype($instance)
        ));
    }
  }
  ```

  In version 3, this becomes:

  ```php
  use Zend\ServiceManager\AbstractPluginManager;
  use Zend\Validator\ValidatorInterface;

  class MyPluginManager extends AbstractPluginManager
  {
      protected $instanceOf = ValidatorInterface::class;
  }
  ```

  Of course, you can still override the `validate` method if your logic is more
  complex.

  To aid migration, `validate()` will check for a `validatePlugin()` method (which
  was required in v2), and proxy to it if found, after emitting an
  `E_USER_DEPRECATED` notice prompting you to rename the method.

- A new method, `configure()`, was added, allowing full configuration of the
  `ServiceManager` instance at once. Each of the various configuration methods —
  `setAlias()`, `setInvokableClass()`, etc. — now proxy to this method.

- A new method, `mapLazyService($name, $class = null)`, was added, to allow
  mapping a lazy service, and as an analog to the other various service
  definition methods.

### Deprecated

- Nothing

### Removed

- Peering has been removed. It was a complex and rarely used feature that was
  misunderstood most of the time.

- Integration with `Zend\Di` has been removed. It may be re-integrated later.

- `MutableCreationOptionsInterface` has been removed, as options can now be
  passed directly through factories.

- `ServiceLocatorAwareInterface` and its associated trait has been removed. It
  was an anti-pattern, and you are encouraged to inject your dependencies in
  factories instead of injecting the whole service locator.

### Changed/Fixed

v3 of the ServiceManager component is a completely rewritten, more efficient
implementation of the service locator pattern. It includes a number of breaking
changes, outlined in this section.

- You no longer need a `Zend\ServiceManager\Config` object to configure the
  service manager; you can pass the configuration array directly instead.

  In version 2.x:

  ```php
  $config = new \Zend\ServiceManager\Config([
      'factories'  => [...]
  ]);

  $sm = new \Zend\ServiceManager\ServiceManager($config);
  ```

  In ZF 3.x:

  ```php
  $sm = new \Zend\ServiceManager\ServiceManager([
      'factories'  => [...]
  ]);
  ```

  `Config` and `ConfigInterface` still exist, however, but primarily for the
  purposes of codifying and aggregating configuration to use.

- `ConfigInterface` has two important changes:
  - `configureServiceManager()` now **must** return the updated service manager
    instance.
  - A new method, `toArray()`, was added, to allow pulling the configuration in
    order to pass to a ServiceManager or plugin manager's constructor or
    `configure()` method.

- Interfaces for `FactoryInterface`, `DelegatorFactoryInterface` and
  `AbstractFactoryInterface` have changed. All are now directly invokable. This
  allows a number of performance optimization internally.

  Additionally, all signatures that accepted a "canonical name" argument now
  remove it.

  Most of the time, rewriting a factory to match the new interface implies
  replacing the method name by `__invoke`, and removing the canonical name
  argument if present.

  For instance, here is a simple version 2.x factory:

  ```php
  class MyFactory implements FactoryInterface
  {
      function createService(ServiceLocatorInterface $sl)
      {
          // ...
      }
  }
  ```

  The equivalent version 3 factory:

  ```php
  class MyFactory implements FactoryInterface
  {
      function __invoke(ServiceLocatorInterface $sl, $requestedName)
      {
          // ...
      }
  }
  ```

  Note another change in the above: factories also receive a second parameter,
  enforced through the interface, that allows you to easily map multiple service
  names to the same factory.

  To provide forwards compatibility, the original interfaces have been retained,
  but extend the new interfaces (which are under new namespaces). You can implement
  the new methods in your existing v2 factories in order to make them forwards
  compatible with v3.

- The for `AbstractFactoryInterface` interface renames the method `canCreateServiceWithName()`
  to `canCreate()`, and merges the `$name` and `$requestedName` arguments.

- Plugin managers will now receive the parent service locator instead of itself
  in factories. In version 2.x, you needed to call the method
  `getServiceLocator()` to retrieve the parent (application) service locator.
  This was confusing, and not IDE friendly as this method was not enforced
  through the interface.

  In version 2.x, if a factory was set to a service name defined in a plugin manager:

  ```php
  class MyFactory implements FactoryInterface
  {
      function createService(ServiceLocatorInterface $sl)
      {
          // $sl is actually a plugin manager

          $parentLocator = $sl->getServiceLocator();

          // ...
      }
  }
  ```

  In version 3:

  ```php
  class MyFactory implements FactoryInterface
  {
      function __invoke(ServiceLocatorInterface $sl, $requestedName)
      {
          // $sl is already the main, parent service locator. If you need to
          // retrieve the plugin manager again, you can retrieve it through the
          // servicelocator:
          $pluginManager = $sl->get(MyPluginManager::class);
          // ...
      }
  }
  ```

  In practice, this should reduce code, as dependencies often come from the main
  service locator, and not the plugin manager itself.

  To assist in migration, the method `getServiceLocator()` was added to `ServiceManager`
  to ensure that existing factories continue to work; the method emits an `E_USER_DEPRECATED`
  message to signal developers to update their factories.

- `PluginManager` now enforces the need for the main service locator in its
  constructor. In v2.x, people often forgot to set the parent locator, which led
  to bugs in factories trying to fetch dependencies from the parent locator.
  Additionally, plugin managers now pull dependencies from the parent locator by
  default; if you need to pull a peer plugin, your factories will now need to
  pull the corresponding plugin manager first.

  If you omit passing a service locator to the constructor, your plugin manager
  will continue to work, but will emit a deprecation notice indicatin you
  should update your initialization code.

- It's so fast now that your app will fly!

## 2.7.0 - 2016-01-11

### Added

- [#60](https://github.com/zendframework/zend-servicemanager/pull/60) adds
  forward compatibility features for `AbstractPluingManager` and introduces
  `InvokableFactory` to help forward migration to version 3.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#46](https://github.com/zendframework/zend-servicemanager/pull/46) updates
  the exception hierarchy to inherit from the container-interop exceptions.
  This ensures that all exceptions thrown by the component follow the
  recommendations of that project.
- [#52](https://github.com/zendframework/zend-servicemanager/pull/52) fixes
  the exception message thrown by `ServiceManager::setFactory()` to remove
  references to abstract factories.

## 2.6.0 - 2015-07-23

### Added

- [#4](https://github.com/zendframework/zend-servicemanager/pull/4) updates the
    `ServiceManager` to [implement the container-interop interface](https://github.com/container-interop/container-interop),
    allowing interoperability with applications that consume that interface.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#3](https://github.com/zendframework/zend-servicemanager/pull/3) properly updates the
  codebase to PHP 5.5, by taking advantage of the default closure binding
  (`$this` in a closure is the invoking object when created within a method). It
  also removes several `@requires PHP 5.4.0` annotations.
