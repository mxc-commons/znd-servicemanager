# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## Version 0.9.0 - 2018-03-13: Reworked has() to prefer non-alias resolution

### Changed
- Reworked has() to prefer non-alias resolution over alias resolution

### Benchmark Comparison zend-master vs. mxc-master

#### Comparison by benchmark and subject

    $ vendor\bin\phpbench  report  --file=..\all.zend.xml --file=..\all.080.xml --report="extends: compare, compare: tag, cols: ["benchmark", "subject"]"

    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | benchmark                                                   | subject                                        | diff   | tag:zend:mean | tag:mxc:mean |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithAliasesOnly    | 32.64x | 4,154.332µs   | 127.287µs    |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithDelegatorsOnly | 7.55x  | 13.201µs      | 1.748µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithFactoriesOnly  | 3.36x  | 5.587µs       | 1.664µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithInvokablesOnly | 68.94x | 117.213µs     | 1.700µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithServicesOnly   | 3.48x  | 5.792µs       | 1.664µs      |
    | FetchCachedServicesBench                                    | benchFetchAbstractFactoryService               | 1.00x  | 0.400µs       | 0.401µs      |
    | FetchCachedServicesBench                                    | benchFetchAlias1                               | 0.99x  | 0.400µs       | 0.403µs      |
    | FetchCachedServicesBench                                    | benchFetchDelegatorService                     | 0.99x  | 0.400µs       | 0.404µs      |
    | FetchCachedServicesBench                                    | benchFetchFactory1                             | 0.99x  | 0.400µs       | 0.403µs      |
    | FetchCachedServicesBench                                    | benchFetchInvokable1                           | 0.99x  | 0.404µs       | 0.409µs      |
    | FetchCachedServicesBench                                    | benchFetchLazyService                          | 1.00x  | 0.403µs       | 0.403µs      |
    | FetchCachedServicesBench                                    | benchFetchMultiDelegatorService                | 1.00x  | 0.400µs       | 0.401µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias1                      | 0.99x  | 0.400µs       | 0.402µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias2                      | 1.00x  | 0.400µs       | 0.402µs      |
    | FetchCachedServicesBench                                    | benchFetchService1                             | 1.00x  | 0.403µs       | 0.402µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceDependingOnConfig             | 1.22x  | 5.148µs       | 4.230µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithDependency                | 1.21x  | 5.116µs       | 4.224µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithNoDependencies            | 1.20x  | 4.507µs       | 3.766µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceDependingOnConfig             | 1.26x  | 5.589µs       | 4.429µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithDependency                | 1.26x  | 5.596µs       | 4.426µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithNoDependencies            | 1.26x  | 4.981µs       | 3.956µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceDependingOnConfig             | 1.21x  | 6.604µs       | 5.471µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithDependency                | 1.19x  | 7.898µs       | 6.629µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithNoDependencies            | 1.23x  | 3.406µs       | 2.763µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceDependingOnConfig             | 1.26x  | 7.165µs       | 5.700µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithDependency                | 1.24x  | 8.443µs       | 6.819µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithNoDependencies            | 1.28x  | 3.896µs       | 3.045µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceDependingOnConfig             | 1.38x  | 5.544µs       | 4.030µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithDependency                | 1.37x  | 5.443µs       | 3.969µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithNoDependencies            | 1.37x  | 4.856µs       | 3.535µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceDependingOnConfig             | 1.41x  | 6.044µs       | 4.295µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithDependency                | 1.40x  | 6.004µs       | 4.289µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithNoDependencies            | 1.44x  | 5.443µs       | 3.793µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceDependingOnConfig             | 1.12x  | 6.103µs       | 5.463µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithDependency                | 1.14x  | 7.436µs       | 6.540µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithNoDependencies            | 1.08x  | 2.741µs       | 2.545µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceDependingOnConfig             | 1.19x  | 6.758µs       | 5.688µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithDependency                | 1.14x  | 7.973µs       | 6.978µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithNoDependencies            | 1.16x  | 3.328µs       | 2.865µs      |
    | FetchNewServicesBench                                       | benchBuildAbstractFactoryFoo                   | 1.08x  | 1.879µs       | 1.744µs      |
    | FetchNewServicesBench                                       | benchBuildDelegator                            | 0.98x  | 5.182µs       | 5.293µs      |
    | FetchNewServicesBench                                       | benchBuildDelegatorCached                      | 1.59x  | 3.906µs       | 2.464µs      |
    | FetchNewServicesBench                                       | benchBuildFactory1                             | 1.29x  | 2.414µs       | 1.874µs      |
    | FetchNewServicesBench                                       | benchBuildFactoryAlias1                        | 1.32x  | 2.428µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchBuildInvokable1                           | 1.76x  | 2.648µs       | 1.507µs      |
    | FetchNewServicesBench                                       | benchBuildLazyService                          | 0.98x  | 216.973µs     | 222.233µs    |
    | FetchNewServicesBench                                       | benchBuildLazyServiceCached                    | 1.41x  | 5.744µs       | 4.071µs      |
    | FetchNewServicesBench                                       | benchBuildMultiDelegator                       | 1.01x  | 8.330µs       | 8.271µs      |
    | FetchNewServicesBench                                       | benchBuildMultiDelegatorCached                 | 1.83x  | 6.061µs       | 3.314µs      |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias1               | 1.37x  | 2.526µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias2               | 1.38x  | 2.553µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFoo                   | 1.16x  | 2.325µs       | 2.002µs      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFooCached             | 1.15x  | 2.325µs       | 2.019µs      |
    | FetchNewServicesBench                                       | benchFetchDelegator                            | 1.01x  | 5.710µs       | 5.670µs      |
    | FetchNewServicesBench                                       | benchFetchDelegatorCached                      | 1.61x  | 4.426µs       | 2.751µs      |
    | FetchNewServicesBench                                       | benchFetchFactory1                             | 1.34x  | 2.816µs       | 2.108µs      |
    | FetchNewServicesBench                                       | benchFetchFactoryAlias1                        | 1.31x  | 2.433µs       | 1.855µs      |
    | FetchNewServicesBench                                       | benchFetchInvokable1                           | 1.87x  | 3.357µs       | 1.797µs      |
    | FetchNewServicesBench                                       | benchFetchLazyService                          | 0.98x  | 217.692µs     | 223.253µs    |
    | FetchNewServicesBench                                       | benchFetchLazyServiceCached                    | 1.56x  | 6.892µs       | 4.428µs      |
    | FetchNewServicesBench                                       | benchFetchMultiDelegator                       | 1.03x  | 8.838µs       | 8.606µs      |
    | FetchNewServicesBench                                       | benchFetchMultiDelegatorCached                 | 1.83x  | 6.590µs       | 3.600µs      |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias1               | 1.36x  | 2.519µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias2               | 1.37x  | 2.521µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchFetchService1                             | 1.00x  | 0.400µs       | 0.399µs      |
    | HasBench                                                    | benchHasAbstractFactory                        | 1.03x  | 0.772µs       | 0.746µs      |
    | HasBench                                                    | benchHasAlias1                                 | 0.96x  | 0.534µs       | 0.555µs      |
    | HasBench                                                    | benchHasFactory1                               | 1.19x  | 0.476µs       | 0.398µs      |
    | HasBench                                                    | benchHasInvokable1                             | 1.31x  | 0.546µs       | 0.418µs      |
    | HasBench                                                    | benchHasNot                                    | 1.05x  | 0.821µs       | 0.784µs      |
    | HasBench                                                    | benchHasRecursiveAlias1                        | 0.98x  | 0.545µs       | 0.555µs      |
    | HasBench                                                    | benchHasRecursiveAlias2                        | 0.96x  | 0.535µs       | 0.558µs      |
    | HasBench                                                    | benchHasService1                               | 1.20x  | 0.428µs       | 0.358µs      |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByClassName             | 4.43x  | 3.302µs       | 0.745µs      |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByInstance              | 1.68x  | 2.791µs       | 1.661µs      |
    | SetNewServicesBench                                         | benchAddDelegator                              | 2.42x  | 3.456µs       | 1.426µs      |
    | SetNewServicesBench                                         | benchAddInitializerByClassName                 | 1.81x  | 2.347µs       | 1.297µs      |
    | SetNewServicesBench                                         | benchAddInitializerByInstance                  | 2.27x  | 1.687µs       | 0.745µs      |
    | SetNewServicesBench                                         | benchAddMultiDelegator                         | 2.67x  | 3.463µs       | 1.299µs      |
    | SetNewServicesBench                                         | benchOverrideAlias                             | 36.58x | 65.717µs      | 1.797µs      |
    | SetNewServicesBench                                         | benchSetAlias                                  | 10.79x | 18.974µs      | 1.759µs      |
    | SetNewServicesBench                                         | benchSetFactory                                | 4.08x  | 4.351µs       | 1.066µs      |
    | SetNewServicesBench                                         | benchSetInvokableClass                         | 4.93x  | 5.304µs       | 1.075µs      |
    | SetNewServicesBench                                         | benchSetService                                | 3.70x  | 1.977µs       | 0.534µs      |
    | Usage1000Bench                                              | benchFetchEachServiceOnce                      | 1.18x  | 13.011ms      | 11.024ms     |
    | Usage1000Bench                                              | benchFetchEachServiceThreeTimes                | 1.47x  | 10.254ms      | 6.989ms      |
    | Usage1000Bench                                              | benchFetchEachServiceTwice                     | 1.47x  | 10.247ms      | 6.961ms      |
    | Usage1000Bench                                              | benchFetchNewServiceManager                    | 4.50x  | 942.214µs     | 209.572µs    |
    | Usage1000Bench                                              | benchFullCycleBuild                            | 1.34x  | 34.396ms      | 25.634ms     |
    | Usage1000Bench                                              | benchFullCycleGet                              | 1.12x  | 15.405ms      | 13.809ms     |
    | Usage100Bench                                               | benchFetchEachServiceOnce                      | 1.17x  | 1.300ms       | 1.113ms      |
    | Usage100Bench                                               | benchFetchEachServiceThreeTimes                | 1.54x  | 1.031ms       | 0.668ms      |
    | Usage100Bench                                               | benchFetchEachServiceTwice                     | 1.53x  | 1.027ms       | 0.669ms      |
    | Usage100Bench                                               | benchFetchNewServiceManager                    | 6.29x  | 156.489µs     | 24.881µs     |
    | Usage100Bench                                               | benchFullCycleBuild                            | 1.39x  | 3.514ms       | 2.527ms      |
    | Usage100Bench                                               | benchFullCycleGet                              | 1.13x  | 1.585ms       | 1.399ms      |
    | Usage250Bench                                               | benchFetchEachServiceOnce                      | 1.17x  | 3.199ms       | 2.734ms      |
    | Usage250Bench                                               | benchFetchEachServiceThreeTimes                | 1.52x  | 2.544ms       | 1.676ms      |
    | Usage250Bench                                               | benchFetchEachServiceTwice                     | 1.52x  | 2.566ms       | 1.689ms      |
    | Usage250Bench                                               | benchFetchNewServiceManager                    | 5.24x  | 284.656µs     | 54.363µs     |
    | Usage250Bench                                               | benchFullCycleBuild                            | 1.38x  | 8.641ms       | 6.271ms      |
    | Usage250Bench                                               | benchFullCycleGet                              | 1.13x  | 3.884ms       | 3.445ms      |
    | Usage25Bench                                                | benchFetchEachServiceOnce                      | 1.14x  | 0.355ms       | 0.312ms      |
    | Usage25Bench                                                | benchFetchEachServiceThreeTimes                | 1.61x  | 0.267ms       | 0.165ms      |
    | Usage25Bench                                                | benchFetchEachServiceTwice                     | 1.71x  | 0.281ms       | 0.165ms      |
    | Usage25Bench                                                | benchFetchNewServiceManager                    | 9.03x  | 90.485µs      | 10.021µs     |
    | Usage25Bench                                                | benchFullCycleBuild                            | 1.39x  | 0.927ms       | 0.667ms      |
    | Usage25Bench                                                | benchFullCycleGet                              | 1.14x  | 0.447ms       | 0.392ms      |
    | Usage500Bench                                               | benchFetchEachServiceOnce                      | 1.17x  | 6.379ms       | 5.456ms      |
    | Usage500Bench                                               | benchFetchEachServiceThreeTimes                | 1.50x  | 5.101ms       | 3.393ms      |
    | Usage500Bench                                               | benchFetchEachServiceTwice                     | 1.50x  | 5.109ms       | 3.402ms      |
    | Usage500Bench                                               | benchFetchNewServiceManager                    | 4.82x  | 502.565µs     | 104.326µs    |
    | Usage500Bench                                               | benchFullCycleBuild                            | 1.37x  | 17.165ms      | 12.564ms     |
    | Usage500Bench                                               | benchFullCycleGet                              | 1.11x  | 7.602ms       | 6.867ms      |
    | Usage50Bench                                                | benchFetchEachServiceOnce                      | 1.09x  | 0.642ms       | 0.588ms      |
    | Usage50Bench                                                | benchFetchEachServiceThreeTimes                | 1.55x  | 0.512ms       | 0.332ms      |
    | Usage50Bench                                                | benchFetchEachServiceTwice                     | 1.53x  | 0.509ms       | 0.332ms      |
    | Usage50Bench                                                | benchFetchNewServiceManager                    | 7.39x  | 110.726µs     | 14.977µs     |
    | Usage50Bench                                                | benchFullCycleBuild                            | 1.37x  | 1.767ms       | 1.294ms      |
    | Usage50Bench                                                | benchFullCycleGet                              | 1.11x  | 0.822ms       | 0.742ms      |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+

#### Comparison by diff

    $ vendor\bin\phpbench  report  --file=..\all.zend.xml --file=..\all.080.xml --report="extends: compare, compare: tag, cols: ["benchmark", "subject"]"

    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | benchmark                                                   | subject                                        | diff   | tag:zend:mean | tag:mxc:mean |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithInvokablesOnly | 68.94x | 117.213µs     | 1.700µs      |
    | SetNewServicesBench                                         | benchOverrideAlias                             | 36.58x | 65.717µs      | 1.797µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithAliasesOnly    | 32.64x | 4,154.332µs   | 127.287µs    |
    | SetNewServicesBench                                         | benchSetAlias                                  | 10.79x | 18.974µs      | 1.759µs      |
    | Usage25Bench                                                | benchFetchNewServiceManager                    | 9.03x  | 90.485µs      | 10.021µs     |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithDelegatorsOnly | 7.55x  | 13.201µs      | 1.748µs      |
    | Usage50Bench                                                | benchFetchNewServiceManager                    | 7.39x  | 110.726µs     | 14.977µs     |
    | Usage100Bench                                               | benchFetchNewServiceManager                    | 6.29x  | 156.489µs     | 24.881µs     |
    | Usage250Bench                                               | benchFetchNewServiceManager                    | 5.24x  | 284.656µs     | 54.363µs     |
    | SetNewServicesBench                                         | benchSetInvokableClass                         | 4.93x  | 5.304µs       | 1.075µs      |
    | Usage500Bench                                               | benchFetchNewServiceManager                    | 4.82x  | 502.565µs     | 104.326µs    |
    | Usage1000Bench                                              | benchFetchNewServiceManager                    | 4.50x  | 942.214µs     | 209.572µs    |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByClassName             | 4.43x  | 3.302µs       | 0.745µs      |
    | SetNewServicesBench                                         | benchSetFactory                                | 4.08x  | 4.351µs       | 1.066µs      |
    | SetNewServicesBench                                         | benchSetService                                | 3.70x  | 1.977µs       | 0.534µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithServicesOnly   | 3.48x  | 5.792µs       | 1.664µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithFactoriesOnly  | 3.36x  | 5.587µs       | 1.664µs      |
    | SetNewServicesBench                                         | benchAddMultiDelegator                         | 2.67x  | 3.463µs       | 1.299µs      |
    | SetNewServicesBench                                         | benchAddDelegator                              | 2.42x  | 3.456µs       | 1.426µs      |
    | SetNewServicesBench                                         | benchAddInitializerByInstance                  | 2.27x  | 1.687µs       | 0.745µs      |
    | FetchNewServicesBench                                       | benchFetchInvokable1                           | 1.87x  | 3.357µs       | 1.797µs      |
    | FetchNewServicesBench                                       | benchFetchMultiDelegatorCached                 | 1.83x  | 6.590µs       | 3.600µs      |
    | FetchNewServicesBench                                       | benchBuildMultiDelegatorCached                 | 1.83x  | 6.061µs       | 3.314µs      |
    | SetNewServicesBench                                         | benchAddInitializerByClassName                 | 1.81x  | 2.347µs       | 1.297µs      |
    | FetchNewServicesBench                                       | benchBuildInvokable1                           | 1.76x  | 2.648µs       | 1.507µs      |
    | Usage25Bench                                                | benchFetchEachServiceTwice                     | 1.71x  | 0.281ms       | 0.165ms      |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByInstance              | 1.68x  | 2.791µs       | 1.661µs      |
    | Usage25Bench                                                | benchFetchEachServiceThreeTimes                | 1.61x  | 0.267ms       | 0.165ms      |
    | FetchNewServicesBench                                       | benchFetchDelegatorCached                      | 1.61x  | 4.426µs       | 2.751µs      |
    | FetchNewServicesBench                                       | benchBuildDelegatorCached                      | 1.59x  | 3.906µs       | 2.464µs      |
    | FetchNewServicesBench                                       | benchFetchLazyServiceCached                    | 1.56x  | 6.892µs       | 4.428µs      |
    | Usage50Bench                                                | benchFetchEachServiceThreeTimes                | 1.55x  | 0.512ms       | 0.332ms      |
    | Usage100Bench                                               | benchFetchEachServiceThreeTimes                | 1.54x  | 1.031ms       | 0.668ms      |
    | Usage100Bench                                               | benchFetchEachServiceTwice                     | 1.53x  | 1.027ms       | 0.669ms      |
    | Usage50Bench                                                | benchFetchEachServiceTwice                     | 1.53x  | 0.509ms       | 0.332ms      |
    | Usage250Bench                                               | benchFetchEachServiceTwice                     | 1.52x  | 2.566ms       | 1.689ms      |
    | Usage250Bench                                               | benchFetchEachServiceThreeTimes                | 1.52x  | 2.544ms       | 1.676ms      |
    | Usage500Bench                                               | benchFetchEachServiceThreeTimes                | 1.50x  | 5.101ms       | 3.393ms      |
    | Usage500Bench                                               | benchFetchEachServiceTwice                     | 1.50x  | 5.109ms       | 3.402ms      |
    | Usage1000Bench                                              | benchFetchEachServiceTwice                     | 1.47x  | 10.247ms      | 6.961ms      |
    | Usage1000Bench                                              | benchFetchEachServiceThreeTimes                | 1.47x  | 10.254ms      | 6.989ms      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithNoDependencies            | 1.44x  | 5.443µs       | 3.793µs      |
    | FetchNewServicesBench                                       | benchBuildLazyServiceCached                    | 1.41x  | 5.744µs       | 4.071µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceDependingOnConfig             | 1.41x  | 6.044µs       | 4.295µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithDependency                | 1.40x  | 6.004µs       | 4.289µs      |
    | Usage100Bench                                               | benchFullCycleBuild                            | 1.39x  | 3.514ms       | 2.527ms      |
    | Usage25Bench                                                | benchFullCycleBuild                            | 1.39x  | 0.927ms       | 0.667ms      |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias2               | 1.38x  | 2.553µs       | 1.846µs      |
    | Usage250Bench                                               | benchFullCycleBuild                            | 1.38x  | 8.641ms       | 6.271ms      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceDependingOnConfig             | 1.38x  | 5.544µs       | 4.030µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithNoDependencies            | 1.37x  | 4.856µs       | 3.535µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithDependency                | 1.37x  | 5.443µs       | 3.969µs      |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias1               | 1.37x  | 2.526µs       | 1.846µs      |
    | Usage500Bench                                               | benchFullCycleBuild                            | 1.37x  | 17.165ms      | 12.564ms     |
    | Usage50Bench                                                | benchFullCycleBuild                            | 1.37x  | 1.767ms       | 1.294ms      |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias2               | 1.37x  | 2.521µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias1               | 1.36x  | 2.519µs       | 1.846µs      |
    | Usage1000Bench                                              | benchFullCycleBuild                            | 1.34x  | 34.396ms      | 25.634ms     |
    | FetchNewServicesBench                                       | benchFetchFactory1                             | 1.34x  | 2.816µs       | 2.108µs      |
    | FetchNewServicesBench                                       | benchBuildFactoryAlias1                        | 1.32x  | 2.428µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchFetchFactoryAlias1                        | 1.31x  | 2.433µs       | 1.855µs      |
    | HasBench                                                    | benchHasInvokable1                             | 1.31x  | 0.546µs       | 0.418µs      |
    | FetchNewServicesBench                                       | benchBuildFactory1                             | 1.29x  | 2.414µs       | 1.874µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithNoDependencies            | 1.28x  | 3.896µs       | 3.045µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithDependency                | 1.26x  | 5.596µs       | 4.426µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceDependingOnConfig             | 1.26x  | 5.589µs       | 4.429µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithNoDependencies            | 1.26x  | 4.981µs       | 3.956µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceDependingOnConfig             | 1.26x  | 7.165µs       | 5.700µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithDependency                | 1.24x  | 8.443µs       | 6.819µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithNoDependencies            | 1.23x  | 3.406µs       | 2.763µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceDependingOnConfig             | 1.22x  | 5.148µs       | 4.230µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithDependency                | 1.21x  | 5.116µs       | 4.224µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceDependingOnConfig             | 1.21x  | 6.604µs       | 5.471µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithNoDependencies            | 1.20x  | 4.507µs       | 3.766µs      |
    | HasBench                                                    | benchHasService1                               | 1.20x  | 0.428µs       | 0.358µs      |
    | HasBench                                                    | benchHasFactory1                               | 1.19x  | 0.476µs       | 0.398µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithDependency                | 1.19x  | 7.898µs       | 6.629µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceDependingOnConfig             | 1.19x  | 6.758µs       | 5.688µs      |
    | Usage1000Bench                                              | benchFetchEachServiceOnce                      | 1.18x  | 13.011ms      | 11.024ms     |
    | Usage250Bench                                               | benchFetchEachServiceOnce                      | 1.17x  | 3.199ms       | 2.734ms      |
    | Usage500Bench                                               | benchFetchEachServiceOnce                      | 1.17x  | 6.379ms       | 5.456ms      |
    | Usage100Bench                                               | benchFetchEachServiceOnce                      | 1.17x  | 1.300ms       | 1.113ms      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithNoDependencies            | 1.16x  | 3.328µs       | 2.865µs      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFoo                   | 1.16x  | 2.325µs       | 2.002µs      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFooCached             | 1.15x  | 2.325µs       | 2.019µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithDependency                | 1.14x  | 7.973µs       | 6.978µs      |
    | Usage25Bench                                                | benchFullCycleGet                              | 1.14x  | 0.447ms       | 0.392ms      |
    | Usage25Bench                                                | benchFetchEachServiceOnce                      | 1.14x  | 0.355ms       | 0.312ms      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithDependency                | 1.14x  | 7.436µs       | 6.540µs      |
    | Usage100Bench                                               | benchFullCycleGet                              | 1.13x  | 1.585ms       | 1.399ms      |
    | Usage250Bench                                               | benchFullCycleGet                              | 1.13x  | 3.884ms       | 3.445ms      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceDependingOnConfig             | 1.12x  | 6.103µs       | 5.463µs      |
    | Usage1000Bench                                              | benchFullCycleGet                              | 1.12x  | 15.405ms      | 13.809ms     |
    | Usage50Bench                                                | benchFullCycleGet                              | 1.11x  | 0.822ms       | 0.742ms      |
    | Usage500Bench                                               | benchFullCycleGet                              | 1.11x  | 7.602ms       | 6.867ms      |
    | Usage50Bench                                                | benchFetchEachServiceOnce                      | 1.09x  | 0.642ms       | 0.588ms      |
    | FetchNewServicesBench                                       | benchBuildAbstractFactoryFoo                   | 1.08x  | 1.879µs       | 1.744µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithNoDependencies            | 1.08x  | 2.741µs       | 2.545µs      |
    | HasBench                                                    | benchHasNot                                    | 1.05x  | 0.821µs       | 0.784µs      |
    | HasBench                                                    | benchHasAbstractFactory                        | 1.03x  | 0.772µs       | 0.746µs      |
    | FetchNewServicesBench                                       | benchFetchMultiDelegator                       | 1.03x  | 8.838µs       | 8.606µs      |
    | FetchNewServicesBench                                       | benchBuildMultiDelegator                       | 1.01x  | 8.330µs       | 8.271µs      |
    | FetchNewServicesBench                                       | benchFetchDelegator                            | 1.01x  | 5.710µs       | 5.670µs      |
    | FetchNewServicesBench                                       | benchFetchService1                             | 1.00x  | 0.400µs       | 0.399µs      |
    | FetchCachedServicesBench                                    | benchFetchService1                             | 1.00x  | 0.403µs       | 0.402µs      |
    | FetchCachedServicesBench                                    | benchFetchLazyService                          | 1.00x  | 0.403µs       | 0.403µs      |
    | FetchCachedServicesBench                                    | benchFetchMultiDelegatorService                | 1.00x  | 0.400µs       | 0.401µs      |
    | FetchCachedServicesBench                                    | benchFetchAbstractFactoryService               | 1.00x  | 0.400µs       | 0.401µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias2                      | 1.00x  | 0.400µs       | 0.402µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias1                      | 0.99x  | 0.400µs       | 0.402µs      |
    | FetchCachedServicesBench                                    | benchFetchAlias1                               | 0.99x  | 0.400µs       | 0.403µs      |
    | FetchCachedServicesBench                                    | benchFetchFactory1                             | 0.99x  | 0.400µs       | 0.403µs      |
    | FetchCachedServicesBench                                    | benchFetchDelegatorService                     | 0.99x  | 0.400µs       | 0.404µs      |
    | FetchCachedServicesBench                                    | benchFetchInvokable1                           | 0.99x  | 0.404µs       | 0.409µs      |
    | HasBench                                                    | benchHasRecursiveAlias1                        | 0.98x  | 0.545µs       | 0.555µs      |
    | FetchNewServicesBench                                       | benchBuildDelegator                            | 0.98x  | 5.182µs       | 5.293µs      |
    | FetchNewServicesBench                                       | benchBuildLazyService                          | 0.98x  | 216.973µs     | 222.233µs    |
    | FetchNewServicesBench                                       | benchFetchLazyService                          | 0.98x  | 217.692µs     | 223.253µs    |
    | HasBench                                                    | benchHasAlias1                                 | 0.96x  | 0.534µs       | 0.555µs      |
    | HasBench                                                    | benchHasRecursiveAlias2                        | 0.96x  | 0.535µs       | 0.558µs      |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+

## Version 0.8.0 - 2018-03-13: Fine tuning

### Added
- New benchmark comparison.

### Deleted
- Removed particular results from BENCHMARKS.md

### Benchmark Comparison zend-master vs. mxc-master

#### Comparison by benchmark and subject

    $ vendor\bin\phpbench  report  --file=..\all.zend.xml --file=..\all.080.xml --report="extends: compare, compare: tag, cols: ["benchmark", "subject"]"

    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | benchmark                                                   | subject                                        | diff   | tag:zend:mean | tag:mxc:mean |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithAliasesOnly    | 32.64x | 4,154.332µs   | 127.287µs    |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithDelegatorsOnly | 7.55x  | 13.201µs      | 1.748µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithFactoriesOnly  | 3.36x  | 5.587µs       | 1.664µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithInvokablesOnly | 68.94x | 117.213µs     | 1.700µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithServicesOnly   | 3.48x  | 5.792µs       | 1.664µs      |
    | FetchCachedServicesBench                                    | benchFetchAbstractFactoryService               | 1.00x  | 0.400µs       | 0.401µs      |
    | FetchCachedServicesBench                                    | benchFetchAlias1                               | 0.99x  | 0.400µs       | 0.403µs      |
    | FetchCachedServicesBench                                    | benchFetchDelegatorService                     | 0.99x  | 0.400µs       | 0.404µs      |
    | FetchCachedServicesBench                                    | benchFetchFactory1                             | 0.99x  | 0.400µs       | 0.403µs      |
    | FetchCachedServicesBench                                    | benchFetchInvokable1                           | 0.99x  | 0.404µs       | 0.409µs      |
    | FetchCachedServicesBench                                    | benchFetchLazyService                          | 1.00x  | 0.403µs       | 0.403µs      |
    | FetchCachedServicesBench                                    | benchFetchMultiDelegatorService                | 1.00x  | 0.400µs       | 0.401µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias1                      | 0.99x  | 0.400µs       | 0.402µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias2                      | 1.00x  | 0.400µs       | 0.402µs      |
    | FetchCachedServicesBench                                    | benchFetchService1                             | 1.00x  | 0.403µs       | 0.402µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceDependingOnConfig             | 1.22x  | 5.148µs       | 4.230µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithDependency                | 1.21x  | 5.116µs       | 4.224µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithNoDependencies            | 1.20x  | 4.507µs       | 3.766µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceDependingOnConfig             | 1.26x  | 5.589µs       | 4.429µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithDependency                | 1.26x  | 5.596µs       | 4.426µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithNoDependencies            | 1.26x  | 4.981µs       | 3.956µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceDependingOnConfig             | 1.21x  | 6.604µs       | 5.471µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithDependency                | 1.19x  | 7.898µs       | 6.629µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithNoDependencies            | 1.23x  | 3.406µs       | 2.763µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceDependingOnConfig             | 1.26x  | 7.165µs       | 5.700µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithDependency                | 1.24x  | 8.443µs       | 6.819µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithNoDependencies            | 1.28x  | 3.896µs       | 3.045µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceDependingOnConfig             | 1.38x  | 5.544µs       | 4.030µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithDependency                | 1.37x  | 5.443µs       | 3.969µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithNoDependencies            | 1.37x  | 4.856µs       | 3.535µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceDependingOnConfig             | 1.41x  | 6.044µs       | 4.295µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithDependency                | 1.40x  | 6.004µs       | 4.289µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithNoDependencies            | 1.44x  | 5.443µs       | 3.793µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceDependingOnConfig             | 1.12x  | 6.103µs       | 5.463µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithDependency                | 1.14x  | 7.436µs       | 6.540µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithNoDependencies            | 1.08x  | 2.741µs       | 2.545µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceDependingOnConfig             | 1.19x  | 6.758µs       | 5.688µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithDependency                | 1.14x  | 7.973µs       | 6.978µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithNoDependencies            | 1.16x  | 3.328µs       | 2.865µs      |
    | FetchNewServicesBench                                       | benchBuildAbstractFactoryFoo                   | 1.08x  | 1.879µs       | 1.744µs      |
    | FetchNewServicesBench                                       | benchBuildDelegator                            | 0.98x  | 5.182µs       | 5.293µs      |
    | FetchNewServicesBench                                       | benchBuildDelegatorCached                      | 1.59x  | 3.906µs       | 2.464µs      |
    | FetchNewServicesBench                                       | benchBuildFactory1                             | 1.29x  | 2.414µs       | 1.874µs      |
    | FetchNewServicesBench                                       | benchBuildFactoryAlias1                        | 1.32x  | 2.428µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchBuildInvokable1                           | 1.76x  | 2.648µs       | 1.507µs      |
    | FetchNewServicesBench                                       | benchBuildLazyService                          | 0.98x  | 216.973µs     | 222.233µs    |
    | FetchNewServicesBench                                       | benchBuildLazyServiceCached                    | 1.41x  | 5.744µs       | 4.071µs      |
    | FetchNewServicesBench                                       | benchBuildMultiDelegator                       | 1.01x  | 8.330µs       | 8.271µs      |
    | FetchNewServicesBench                                       | benchBuildMultiDelegatorCached                 | 1.83x  | 6.061µs       | 3.314µs      |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias1               | 1.37x  | 2.526µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias2               | 1.38x  | 2.553µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFoo                   | 1.16x  | 2.325µs       | 2.002µs      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFooCached             | 1.15x  | 2.325µs       | 2.019µs      |
    | FetchNewServicesBench                                       | benchFetchDelegator                            | 1.01x  | 5.710µs       | 5.670µs      |
    | FetchNewServicesBench                                       | benchFetchDelegatorCached                      | 1.61x  | 4.426µs       | 2.751µs      |
    | FetchNewServicesBench                                       | benchFetchFactory1                             | 1.34x  | 2.816µs       | 2.108µs      |
    | FetchNewServicesBench                                       | benchFetchFactoryAlias1                        | 1.31x  | 2.433µs       | 1.855µs      |
    | FetchNewServicesBench                                       | benchFetchInvokable1                           | 1.87x  | 3.357µs       | 1.797µs      |
    | FetchNewServicesBench                                       | benchFetchLazyService                          | 0.98x  | 217.692µs     | 223.253µs    |
    | FetchNewServicesBench                                       | benchFetchLazyServiceCached                    | 1.56x  | 6.892µs       | 4.428µs      |
    | FetchNewServicesBench                                       | benchFetchMultiDelegator                       | 1.03x  | 8.838µs       | 8.606µs      |
    | FetchNewServicesBench                                       | benchFetchMultiDelegatorCached                 | 1.83x  | 6.590µs       | 3.600µs      |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias1               | 1.36x  | 2.519µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias2               | 1.37x  | 2.521µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchFetchService1                             | 1.00x  | 0.400µs       | 0.399µs      |
    | HasBench                                                    | benchHasAbstractFactory                        | 1.01x  | 0.772µs       | 0.764µs      |
    | HasBench                                                    | benchHasAlias1                                 | 1.06x  | 0.534µs       | 0.504µs      |
    | HasBench                                                    | benchHasFactory1                               | 0.93x  | 0.476µs       | 0.512µs      |
    | HasBench                                                    | benchHasInvokable1                             | 1.01x  | 0.546µs       | 0.539µs      |
    | HasBench                                                    | benchHasNot                                    | 1.01x  | 0.821µs       | 0.814µs      |
    | HasBench                                                    | benchHasRecursiveAlias1                        | 1.08x  | 0.545µs       | 0.506µs      |
    | HasBench                                                    | benchHasRecursiveAlias2                        | 1.06x  | 0.535µs       | 0.506µs      |
    | HasBench                                                    | benchHasService1                               | 1.14x  | 0.428µs       | 0.375µs      |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByClassName             | 4.43x  | 3.302µs       | 0.745µs      |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByInstance              | 1.68x  | 2.791µs       | 1.661µs      |
    | SetNewServicesBench                                         | benchAddDelegator                              | 2.42x  | 3.456µs       | 1.426µs      |
    | SetNewServicesBench                                         | benchAddInitializerByClassName                 | 1.81x  | 2.347µs       | 1.297µs      |
    | SetNewServicesBench                                         | benchAddInitializerByInstance                  | 2.27x  | 1.687µs       | 0.745µs      |
    | SetNewServicesBench                                         | benchAddMultiDelegator                         | 2.67x  | 3.463µs       | 1.299µs      |
    | SetNewServicesBench                                         | benchOverrideAlias                             | 36.58x | 65.717µs      | 1.797µs      |
    | SetNewServicesBench                                         | benchSetAlias                                  | 10.79x | 18.974µs      | 1.759µs      |
    | SetNewServicesBench                                         | benchSetFactory                                | 4.08x  | 4.351µs       | 1.066µs      |
    | SetNewServicesBench                                         | benchSetInvokableClass                         | 4.93x  | 5.304µs       | 1.075µs      |
    | SetNewServicesBench                                         | benchSetService                                | 3.70x  | 1.977µs       | 0.534µs      |
    | Usage1000Bench                                              | benchFetchEachServiceOnce                      | 1.18x  | 13.011ms      | 11.024ms     |
    | Usage1000Bench                                              | benchFetchEachServiceThreeTimes                | 1.47x  | 10.254ms      | 6.989ms      |
    | Usage1000Bench                                              | benchFetchEachServiceTwice                     | 1.47x  | 10.247ms      | 6.961ms      |
    | Usage1000Bench                                              | benchFetchNewServiceManager                    | 4.50x  | 942.214µs     | 209.572µs    |
    | Usage1000Bench                                              | benchFullCycleBuild                            | 1.34x  | 34.396ms      | 25.634ms     |
    | Usage1000Bench                                              | benchFullCycleGet                              | 1.12x  | 15.405ms      | 13.809ms     |
    | Usage100Bench                                               | benchFetchEachServiceOnce                      | 1.17x  | 1.300ms       | 1.113ms      |
    | Usage100Bench                                               | benchFetchEachServiceThreeTimes                | 1.54x  | 1.031ms       | 0.668ms      |
    | Usage100Bench                                               | benchFetchEachServiceTwice                     | 1.53x  | 1.027ms       | 0.669ms      |
    | Usage100Bench                                               | benchFetchNewServiceManager                    | 6.29x  | 156.489µs     | 24.881µs     |
    | Usage100Bench                                               | benchFullCycleBuild                            | 1.39x  | 3.514ms       | 2.527ms      |
    | Usage100Bench                                               | benchFullCycleGet                              | 1.13x  | 1.585ms       | 1.399ms      |
    | Usage250Bench                                               | benchFetchEachServiceOnce                      | 1.17x  | 3.199ms       | 2.734ms      |
    | Usage250Bench                                               | benchFetchEachServiceThreeTimes                | 1.52x  | 2.544ms       | 1.676ms      |
    | Usage250Bench                                               | benchFetchEachServiceTwice                     | 1.52x  | 2.566ms       | 1.689ms      |
    | Usage250Bench                                               | benchFetchNewServiceManager                    | 5.24x  | 284.656µs     | 54.363µs     |
    | Usage250Bench                                               | benchFullCycleBuild                            | 1.38x  | 8.641ms       | 6.271ms      |
    | Usage250Bench                                               | benchFullCycleGet                              | 1.13x  | 3.884ms       | 3.445ms      |
    | Usage25Bench                                                | benchFetchEachServiceOnce                      | 1.14x  | 0.355ms       | 0.312ms      |
    | Usage25Bench                                                | benchFetchEachServiceThreeTimes                | 1.61x  | 0.267ms       | 0.165ms      |
    | Usage25Bench                                                | benchFetchEachServiceTwice                     | 1.71x  | 0.281ms       | 0.165ms      |
    | Usage25Bench                                                | benchFetchNewServiceManager                    | 9.03x  | 90.485µs      | 10.021µs     |
    | Usage25Bench                                                | benchFullCycleBuild                            | 1.39x  | 0.927ms       | 0.667ms      |
    | Usage25Bench                                                | benchFullCycleGet                              | 1.14x  | 0.447ms       | 0.392ms      |
    | Usage500Bench                                               | benchFetchEachServiceOnce                      | 1.17x  | 6.379ms       | 5.456ms      |
    | Usage500Bench                                               | benchFetchEachServiceThreeTimes                | 1.50x  | 5.101ms       | 3.393ms      |
    | Usage500Bench                                               | benchFetchEachServiceTwice                     | 1.50x  | 5.109ms       | 3.402ms      |
    | Usage500Bench                                               | benchFetchNewServiceManager                    | 4.82x  | 502.565µs     | 104.326µs    |
    | Usage500Bench                                               | benchFullCycleBuild                            | 1.37x  | 17.165ms      | 12.564ms     |
    | Usage500Bench                                               | benchFullCycleGet                              | 1.11x  | 7.602ms       | 6.867ms      |
    | Usage50Bench                                                | benchFetchEachServiceOnce                      | 1.09x  | 0.642ms       | 0.588ms      |
    | Usage50Bench                                                | benchFetchEachServiceThreeTimes                | 1.55x  | 0.512ms       | 0.332ms      |
    | Usage50Bench                                                | benchFetchEachServiceTwice                     | 1.53x  | 0.509ms       | 0.332ms      |
    | Usage50Bench                                                | benchFetchNewServiceManager                    | 7.39x  | 110.726µs     | 14.977µs     |
    | Usage50Bench                                                | benchFullCycleBuild                            | 1.37x  | 1.767ms       | 1.294ms      |
    | Usage50Bench                                                | benchFullCycleGet                              | 1.11x  | 0.822ms       | 0.742ms      |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+

#### Comparison by diff

    $ vendor\bin\phpbench  report  --file=..\all.zend.xml --file=..\all.080.xml --report="extends: compare, compare: tag, cols: ["benchmark", "subject"]"

    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | benchmark                                                   | subject                                        | diff   | tag:zend:mean | tag:mxc:mean |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithInvokablesOnly | 68.94x | 117.213µs     | 1.700µs      |
    | SetNewServicesBench                                         | benchOverrideAlias                             | 36.58x | 65.717µs      | 1.797µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithAliasesOnly    | 32.64x | 4,154.332µs   | 127.287µs    |
    | SetNewServicesBench                                         | benchSetAlias                                  | 10.79x | 18.974µs      | 1.759µs      |
    | Usage25Bench                                                | benchFetchNewServiceManager                    | 9.03x  | 90.485µs      | 10.021µs     |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithDelegatorsOnly | 7.55x  | 13.201µs      | 1.748µs      |
    | Usage50Bench                                                | benchFetchNewServiceManager                    | 7.39x  | 110.726µs     | 14.977µs     |
    | Usage100Bench                                               | benchFetchNewServiceManager                    | 6.29x  | 156.489µs     | 24.881µs     |
    | Usage250Bench                                               | benchFetchNewServiceManager                    | 5.24x  | 284.656µs     | 54.363µs     |
    | SetNewServicesBench                                         | benchSetInvokableClass                         | 4.93x  | 5.304µs       | 1.075µs      |
    | Usage500Bench                                               | benchFetchNewServiceManager                    | 4.82x  | 502.565µs     | 104.326µs    |
    | Usage1000Bench                                              | benchFetchNewServiceManager                    | 4.50x  | 942.214µs     | 209.572µs    |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByClassName             | 4.43x  | 3.302µs       | 0.745µs      |
    | SetNewServicesBench                                         | benchSetFactory                                | 4.08x  | 4.351µs       | 1.066µs      |
    | SetNewServicesBench                                         | benchSetService                                | 3.70x  | 1.977µs       | 0.534µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithServicesOnly   | 3.48x  | 5.792µs       | 1.664µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithFactoriesOnly  | 3.36x  | 5.587µs       | 1.664µs      |
    | SetNewServicesBench                                         | benchAddMultiDelegator                         | 2.67x  | 3.463µs       | 1.299µs      |
    | SetNewServicesBench                                         | benchAddDelegator                              | 2.42x  | 3.456µs       | 1.426µs      |
    | SetNewServicesBench                                         | benchAddInitializerByInstance                  | 2.27x  | 1.687µs       | 0.745µs      |
    | FetchNewServicesBench                                       | benchFetchInvokable1                           | 1.87x  | 3.357µs       | 1.797µs      |
    | FetchNewServicesBench                                       | benchFetchMultiDelegatorCached                 | 1.83x  | 6.590µs       | 3.600µs      |
    | FetchNewServicesBench                                       | benchBuildMultiDelegatorCached                 | 1.83x  | 6.061µs       | 3.314µs      |
    | SetNewServicesBench                                         | benchAddInitializerByClassName                 | 1.81x  | 2.347µs       | 1.297µs      |
    | FetchNewServicesBench                                       | benchBuildInvokable1                           | 1.76x  | 2.648µs       | 1.507µs      |
    | Usage25Bench                                                | benchFetchEachServiceTwice                     | 1.71x  | 0.281ms       | 0.165ms      |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByInstance              | 1.68x  | 2.791µs       | 1.661µs      |
    | Usage25Bench                                                | benchFetchEachServiceThreeTimes                | 1.61x  | 0.267ms       | 0.165ms      |
    | FetchNewServicesBench                                       | benchFetchDelegatorCached                      | 1.61x  | 4.426µs       | 2.751µs      |
    | FetchNewServicesBench                                       | benchBuildDelegatorCached                      | 1.59x  | 3.906µs       | 2.464µs      |
    | FetchNewServicesBench                                       | benchFetchLazyServiceCached                    | 1.56x  | 6.892µs       | 4.428µs      |
    | Usage50Bench                                                | benchFetchEachServiceThreeTimes                | 1.55x  | 0.512ms       | 0.332ms      |
    | Usage100Bench                                               | benchFetchEachServiceThreeTimes                | 1.54x  | 1.031ms       | 0.668ms      |
    | Usage100Bench                                               | benchFetchEachServiceTwice                     | 1.53x  | 1.027ms       | 0.669ms      |
    | Usage50Bench                                                | benchFetchEachServiceTwice                     | 1.53x  | 0.509ms       | 0.332ms      |
    | Usage250Bench                                               | benchFetchEachServiceTwice                     | 1.52x  | 2.566ms       | 1.689ms      |
    | Usage250Bench                                               | benchFetchEachServiceThreeTimes                | 1.52x  | 2.544ms       | 1.676ms      |
    | Usage500Bench                                               | benchFetchEachServiceThreeTimes                | 1.50x  | 5.101ms       | 3.393ms      |
    | Usage500Bench                                               | benchFetchEachServiceTwice                     | 1.50x  | 5.109ms       | 3.402ms      |
    | Usage1000Bench                                              | benchFetchEachServiceTwice                     | 1.47x  | 10.247ms      | 6.961ms      |
    | Usage1000Bench                                              | benchFetchEachServiceThreeTimes                | 1.47x  | 10.254ms      | 6.989ms      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithNoDependencies            | 1.44x  | 5.443µs       | 3.793µs      |
    | FetchNewServicesBench                                       | benchBuildLazyServiceCached                    | 1.41x  | 5.744µs       | 4.071µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceDependingOnConfig             | 1.41x  | 6.044µs       | 4.295µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithDependency                | 1.40x  | 6.004µs       | 4.289µs      |
    | Usage100Bench                                               | benchFullCycleBuild                            | 1.39x  | 3.514ms       | 2.527ms      |
    | Usage25Bench                                                | benchFullCycleBuild                            | 1.39x  | 0.927ms       | 0.667ms      |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias2               | 1.38x  | 2.553µs       | 1.846µs      |
    | Usage250Bench                                               | benchFullCycleBuild                            | 1.38x  | 8.641ms       | 6.271ms      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceDependingOnConfig             | 1.38x  | 5.544µs       | 4.030µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithNoDependencies            | 1.37x  | 4.856µs       | 3.535µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithDependency                | 1.37x  | 5.443µs       | 3.969µs      |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias1               | 1.37x  | 2.526µs       | 1.846µs      |
    | Usage500Bench                                               | benchFullCycleBuild                            | 1.37x  | 17.165ms      | 12.564ms     |
    | Usage50Bench                                                | benchFullCycleBuild                            | 1.37x  | 1.767ms       | 1.294ms      |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias2               | 1.37x  | 2.521µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias1               | 1.36x  | 2.519µs       | 1.846µs      |
    | Usage1000Bench                                              | benchFullCycleBuild                            | 1.34x  | 34.396ms      | 25.634ms     |
    | FetchNewServicesBench                                       | benchFetchFactory1                             | 1.34x  | 2.816µs       | 2.108µs      |
    | FetchNewServicesBench                                       | benchBuildFactoryAlias1                        | 1.32x  | 2.428µs       | 1.846µs      |
    | FetchNewServicesBench                                       | benchFetchFactoryAlias1                        | 1.31x  | 2.433µs       | 1.855µs      |
    | FetchNewServicesBench                                       | benchBuildFactory1                             | 1.29x  | 2.414µs       | 1.874µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithNoDependencies            | 1.28x  | 3.896µs       | 3.045µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithDependency                | 1.26x  | 5.596µs       | 4.426µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceDependingOnConfig             | 1.26x  | 5.589µs       | 4.429µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithNoDependencies            | 1.26x  | 4.981µs       | 3.956µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceDependingOnConfig             | 1.26x  | 7.165µs       | 5.700µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithDependency                | 1.24x  | 8.443µs       | 6.819µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithNoDependencies            | 1.23x  | 3.406µs       | 2.763µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceDependingOnConfig             | 1.22x  | 5.148µs       | 4.230µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithDependency                | 1.21x  | 5.116µs       | 4.224µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceDependingOnConfig             | 1.21x  | 6.604µs       | 5.471µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithNoDependencies            | 1.20x  | 4.507µs       | 3.766µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithDependency                | 1.19x  | 7.898µs       | 6.629µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceDependingOnConfig             | 1.19x  | 6.758µs       | 5.688µs      |
    | Usage1000Bench                                              | benchFetchEachServiceOnce                      | 1.18x  | 13.011ms      | 11.024ms     |
    | Usage250Bench                                               | benchFetchEachServiceOnce                      | 1.17x  | 3.199ms       | 2.734ms      |
    | Usage500Bench                                               | benchFetchEachServiceOnce                      | 1.17x  | 6.379ms       | 5.456ms      |
    | Usage100Bench                                               | benchFetchEachServiceOnce                      | 1.17x  | 1.300ms       | 1.113ms      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithNoDependencies            | 1.16x  | 3.328µs       | 2.865µs      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFoo                   | 1.16x  | 2.325µs       | 2.002µs      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFooCached             | 1.15x  | 2.325µs       | 2.019µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithDependency                | 1.14x  | 7.973µs       | 6.978µs      |
    | Usage25Bench                                                | benchFullCycleGet                              | 1.14x  | 0.447ms       | 0.392ms      |
    | HasBench                                                    | benchHasService1                               | 1.14x  | 0.428µs       | 0.375µs      |
    | Usage25Bench                                                | benchFetchEachServiceOnce                      | 1.14x  | 0.355ms       | 0.312ms      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithDependency                | 1.14x  | 7.436µs       | 6.540µs      |
    | Usage100Bench                                               | benchFullCycleGet                              | 1.13x  | 1.585ms       | 1.399ms      |
    | Usage250Bench                                               | benchFullCycleGet                              | 1.13x  | 3.884ms       | 3.445ms      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceDependingOnConfig             | 1.12x  | 6.103µs       | 5.463µs      |
    | Usage1000Bench                                              | benchFullCycleGet                              | 1.12x  | 15.405ms      | 13.809ms     |
    | Usage50Bench                                                | benchFullCycleGet                              | 1.11x  | 0.822ms       | 0.742ms      |
    | Usage500Bench                                               | benchFullCycleGet                              | 1.11x  | 7.602ms       | 6.867ms      |
    | Usage50Bench                                                | benchFetchEachServiceOnce                      | 1.09x  | 0.642ms       | 0.588ms      |
    | FetchNewServicesBench                                       | benchBuildAbstractFactoryFoo                   | 1.08x  | 1.879µs       | 1.744µs      |
    | HasBench                                                    | benchHasRecursiveAlias1                        | 1.08x  | 0.545µs       | 0.506µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithNoDependencies            | 1.08x  | 2.741µs       | 2.545µs      |
    | HasBench                                                    | benchHasAlias1                                 | 1.06x  | 0.534µs       | 0.504µs      |
    | HasBench                                                    | benchHasRecursiveAlias2                        | 1.06x  | 0.535µs       | 0.506µs      |
    | FetchNewServicesBench                                       | benchFetchMultiDelegator                       | 1.03x  | 8.838µs       | 8.606µs      |
    | HasBench                                                    | benchHasInvokable1                             | 1.01x  | 0.546µs       | 0.539µs      |
    | HasBench                                                    | benchHasAbstractFactory                        | 1.01x  | 0.772µs       | 0.764µs      |
    | HasBench                                                    | benchHasNot                                    | 1.01x  | 0.821µs       | 0.814µs      |
    | FetchNewServicesBench                                       | benchBuildMultiDelegator                       | 1.01x  | 8.330µs       | 8.271µs      |
    | FetchNewServicesBench                                       | benchFetchDelegator                            | 1.01x  | 5.710µs       | 5.670µs      |
    | FetchNewServicesBench                                       | benchFetchService1                             | 1.00x  | 0.400µs       | 0.399µs      |
    | FetchCachedServicesBench                                    | benchFetchService1                             | 1.00x  | 0.403µs       | 0.402µs      |
    | FetchCachedServicesBench                                    | benchFetchLazyService                          | 1.00x  | 0.403µs       | 0.403µs      |
    | FetchCachedServicesBench                                    | benchFetchMultiDelegatorService                | 1.00x  | 0.400µs       | 0.401µs      |
    | FetchCachedServicesBench                                    | benchFetchAbstractFactoryService               | 1.00x  | 0.400µs       | 0.401µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias2                      | 1.00x  | 0.400µs       | 0.402µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias1                      | 0.99x  | 0.400µs       | 0.402µs      |
    | FetchCachedServicesBench                                    | benchFetchAlias1                               | 0.99x  | 0.400µs       | 0.403µs      |
    | FetchCachedServicesBench                                    | benchFetchFactory1                             | 0.99x  | 0.400µs       | 0.403µs      |
    | FetchCachedServicesBench                                    | benchFetchDelegatorService                     | 0.99x  | 0.400µs       | 0.404µs      |
    | FetchCachedServicesBench                                    | benchFetchInvokable1                           | 0.99x  | 0.404µs       | 0.409µs      |
    | FetchNewServicesBench                                       | benchBuildDelegator                            | 0.98x  | 5.182µs       | 5.293µs      |
    | FetchNewServicesBench                                       | benchBuildLazyService                          | 0.98x  | 216.973µs     | 222.233µs    |
    | FetchNewServicesBench                                       | benchFetchLazyService                          | 0.98x  | 217.692µs     | 223.253µs    |
    | HasBench                                                    | benchHasFactory1                               | 0.93x  | 0.476µs       | 0.512µs      |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+

## Version 0.7.0 - 2018-03-05: Documentation finalized

### Added
- Added brief description of benchmark tests [`BENCHMARKS.md`](BENCHMARKS.md).

### Changed

- Removed obsolote parts of README.
- Credits added.

## Version 0.6.0 - 2018-03-02: Benchmark suite finalized, final code review and cleanup

### Added

- Finalized benchmark suite

### Removed

- nothing

### Changed

- code review and cleanup

### Benchmark Comparison zend-master vs. mxc-master
There are two comparisons provided. One sorted by benchmark and subject. The other sorted by difference between
zend-servicemanager and znd-servicemanager. Diff > 1 means znd-servicemanager is faster.

The benchmark comparison is based on a patched version of PHPBench 0.15-dev.
The patch adds and computes the `diff` column and sorts descendig by this column. All tests were
done with PHPBench 0.15-dev. The benchmark suite used is of mxc-sevicemanager 0.5.0.
We backported the test suite to zend-sevicemanager:master.

Be aware that differences up to approx. 3% may be related to factors other than implementation, such
as overall processor load of benchmarking system, the wheather, room temperature, heart beat rate of
developer and such. :) This area is marked in the table below for your convenience.

All benchmarks were run with 50 iterations and a retry_threshold of 2 to ensure good stability.

#### Comparison by benchmark and subject

    $ vendor\bin\phpbench report --file=..\all.zend.xml --file=..\all.060.xml --report="extends: compare, compare: tag, cols: ["benchmark", "subject"]"
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | benchmark                                                   | subject                                        | diff   | tag:zend:mean | tag:mxc:mean |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithAliasesOnly    | 25.66x | 4,154.332µs   | 161.929µs    |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithDelegatorsOnly | 8.84x  | 13.201µs      | 1.494µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithFactoriesOnly  | 4.03x  | 5.587µs       | 1.387µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithInvokablesOnly | 83.72x | 117.213µs     | 1.400µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithServicesOnly   | 4.13x  | 5.792µs       | 1.403µs      |
    | FetchCachedServicesBench                                    | benchFetchAbstractFactoryService               | 0.98x  | 0.400µs       | 0.410µs      |
    | FetchCachedServicesBench                                    | benchFetchAlias1                               | 0.97x  | 0.400µs       | 0.413µs      |
    | FetchCachedServicesBench                                    | benchFetchDelegatorService                     | 0.98x  | 0.400µs       | 0.410µs      |
    | FetchCachedServicesBench                                    | benchFetchFactory1                             | 0.97x  | 0.400µs       | 0.414µs      |
    | FetchCachedServicesBench                                    | benchFetchInvokable1                           | 0.98x  | 0.404µs       | 0.413µs      |
    | FetchCachedServicesBench                                    | benchFetchLazyService                          | 0.98x  | 0.403µs       | 0.413µs      |
    | FetchCachedServicesBench                                    | benchFetchMultiDelegatorService                | 0.98x  | 0.400µs       | 0.410µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias1                      | 0.97x  | 0.400µs       | 0.412µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias2                      | 0.97x  | 0.400µs       | 0.413µs      |
    | FetchCachedServicesBench                                    | benchFetchService1                             | 0.98x  | 0.403µs       | 0.410µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceDependingOnConfig             | 1.08x  | 5.148µs       | 4.762µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithDependency                | 1.08x  | 5.116µs       | 4.734µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithNoDependencies            | 1.08x  | 4.507µs       | 4.161µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceDependingOnConfig             | 1.11x  | 5.589µs       | 5.024µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithDependency                | 1.12x  | 5.596µs       | 4.976µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithNoDependencies            | 1.12x  | 4.981µs       | 4.434µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceDependingOnConfig             | 1.09x  | 6.604µs       | 6.040µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithDependency                | 1.09x  | 7.898µs       | 7.262µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithNoDependencies            | 1.11x  | 3.406µs       | 3.073µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceDependingOnConfig             | 1.14x  | 7.165µs       | 6.279µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithDependency                | 1.12x  | 8.443µs       | 7.553µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithNoDependencies            | 1.18x  | 3.896µs       | 3.297µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceDependingOnConfig             | 1.26x  | 5.544µs       | 4.407µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithDependency                | 1.11x  | 5.443µs       | 4.918µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithNoDependencies            | 1.28x  | 4.856µs       | 3.802µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceDependingOnConfig             | 1.26x  | 6.044µs       | 4.805µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithDependency                | 1.26x  | 6.004µs       | 4.751µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithNoDependencies            | 1.30x  | 5.443µs       | 4.172µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceDependingOnConfig             | 1.00x  | 6.103µs       | 6.111µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithDependency                | 1.04x  | 7.436µs       | 7.173µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithNoDependencies            | 0.96x  | 2.741µs       | 2.851µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceDependingOnConfig             | 1.06x  | 6.758µs       | 6.346µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithDependency                | 1.06x  | 7.973µs       | 7.541µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithNoDependencies            | 1.04x  | 3.328µs       | 3.190µs      |
    | FetchNewServicesBench                                       | benchBuildAbstractFactoryFoo                   | 1.02x  | 1.879µs       | 1.850µs      |
    | FetchNewServicesBench                                       | benchBuildDelegator                            | 0.90x  | 5.182µs       | 5.759µs      |
    | FetchNewServicesBench                                       | benchBuildDelegatorCached                      | 1.47x  | 3.906µs       | 2.653µs      |
    | FetchNewServicesBench                                       | benchBuildFactory1                             | 1.13x  | 2.414µs       | 2.130µs      |
    | FetchNewServicesBench                                       | benchBuildFactoryAlias1                        | 1.17x  | 2.428µs       | 2.083µs      |
    | FetchNewServicesBench                                       | benchBuildInvokable1                           | 1.58x  | 2.648µs       | 1.678µs      |
    | FetchNewServicesBench                                       | benchBuildLazyService                          | 0.99x  | 216.973µs     | 218.773µs    |
    | FetchNewServicesBench                                       | benchBuildLazyServiceCached                    | 1.31x  | 5.744µs       | 4.389µs      |
    | FetchNewServicesBench                                       | benchBuildMultiDelegator                       | 0.95x  | 8.330µs       | 8.814µs      |
    | FetchNewServicesBench                                       | benchBuildMultiDelegatorCached                 | 1.73x  | 6.061µs       | 3.503µs      |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias1               | 1.22x  | 2.526µs       | 2.073µs      |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias2               | 1.23x  | 2.553µs       | 2.082µs      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFoo                   | 1.06x  | 2.325µs       | 2.199µs      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFooCached             | 1.06x  | 2.325µs       | 2.200µs      |
    | FetchNewServicesBench                                       | benchFetchDelegator                            | 0.93x  | 5.710µs       | 6.172µs      |
    | FetchNewServicesBench                                       | benchFetchDelegatorCached                      | 1.46x  | 4.426µs       | 3.024µs      |
    | FetchNewServicesBench                                       | benchFetchFactory1                             | 1.17x  | 2.816µs       | 2.405µs      |
    | FetchNewServicesBench                                       | benchFetchFactoryAlias1                        | 1.17x  | 2.433µs       | 2.071µs      |
    | FetchNewServicesBench                                       | benchFetchInvokable1                           | 1.74x  | 3.357µs       | 1.924µs      |
    | FetchNewServicesBench                                       | benchFetchLazyService                          | 1.00x  | 217.692µs     | 218.253µs    |
    | FetchNewServicesBench                                       | benchFetchLazyServiceCached                    | 1.42x  | 6.892µs       | 4.852µs      |
    | FetchNewServicesBench                                       | benchFetchMultiDelegator                       | 0.97x  | 8.838µs       | 9.149µs      |
    | FetchNewServicesBench                                       | benchFetchMultiDelegatorCached                 | 1.74x  | 6.590µs       | 3.797µs      |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias1               | 1.21x  | 2.519µs       | 2.081µs      |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias2               | 1.21x  | 2.521µs       | 2.075µs      |
    | FetchNewServicesBench                                       | benchFetchService1                             | 0.99x  | 0.400µs       | 0.404µs      |
    | HasBench                                                    | benchHasAbstractFactory                        | 0.94x  | 0.772µs       | 0.819µs      |
    | HasBench                                                    | benchHasAlias1                                 | 1.06x  | 0.534µs       | 0.503µs      |
    | HasBench                                                    | benchHasFactory1                               | 0.91x  | 0.476µs       | 0.523µs      |
    | HasBench                                                    | benchHasInvokable1                             | 1.00x  | 0.546µs       | 0.545µs      |
    | HasBench                                                    | benchHasNot                                    | 0.95x  | 0.821µs       | 0.868µs      |
    | HasBench                                                    | benchHasRecursiveAlias1                        | 1.08x  | 0.545µs       | 0.503µs      |
    | HasBench                                                    | benchHasRecursiveAlias2                        | 1.06x  | 0.535µs       | 0.503µs      |
    | HasBench                                                    | benchHasService1                               | 1.13x  | 0.428µs       | 0.380µs      |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByClassName             | 4.04x  | 3.302µs       | 0.817µs      |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByInstance              | 1.57x  | 2.791µs       | 1.779µs      |
    | SetNewServicesBench                                         | benchAddDelegator                              | 2.23x  | 3.456µs       | 1.552µs      |
    | SetNewServicesBench                                         | benchAddInitializerByClassName                 | 1.61x  | 2.347µs       | 1.455µs      |
    | SetNewServicesBench                                         | benchAddInitializerByInstance                  | 2.01x  | 1.687µs       | 0.839µs      |
    | SetNewServicesBench                                         | benchAddMultiDelegator                         | 2.42x  | 3.463µs       | 1.433µs      |
    | SetNewServicesBench                                         | benchOverrideAlias                             | 34.50x | 65.717µs      | 1.905µs      |
    | SetNewServicesBench                                         | benchSetAlias                                  | 9.74x  | 18.974µs      | 1.948µs      |
    | SetNewServicesBench                                         | benchSetFactory                                | 3.80x  | 4.351µs       | 1.143µs      |
    | SetNewServicesBench                                         | benchSetInvokableClass                         | 4.57x  | 5.304µs       | 1.161µs      |
    | SetNewServicesBench                                         | benchSetService                                | 3.22x  | 1.977µs       | 0.613µs      |
    | Usage1000Bench                                              | benchFetchEachServiceOnce                      | 1.09x  | 13.011ms      | 11.897ms     |
    | Usage1000Bench                                              | benchFetchEachServiceThreeTimes                | 1.35x  | 10.254ms      | 7.599ms      |
    | Usage1000Bench                                              | benchFetchEachServiceTwice                     | 1.34x  | 10.247ms      | 7.651ms      |
    | Usage1000Bench                                              | benchFetchNewServiceManager                    | 4.00x  | 942.214µs     | 235.774µs    |
    | Usage1000Bench                                              | benchFullCycleBuild                            | 1.24x  | 34.396ms      | 27.664ms     |
    | Usage1000Bench                                              | benchFullCycleGet                              | 1.05x  | 15.405ms      | 14.700ms     |
    | Usage100Bench                                               | benchFetchEachServiceOnce                      | 1.06x  | 1.300ms       | 1.222ms      |
    | Usage100Bench                                               | benchFetchEachServiceThreeTimes                | 1.40x  | 1.031ms       | 0.734ms      |
    | Usage100Bench                                               | benchFetchEachServiceTwice                     | 1.40x  | 1.027ms       | 0.732ms      |
    | Usage100Bench                                               | benchFetchNewServiceManager                    | 5.59x  | 156.489µs     | 28.001µs     |
    | Usage100Bench                                               | benchFullCycleBuild                            | 1.28x  | 3.514ms       | 2.748ms      |
    | Usage100Bench                                               | benchFullCycleGet                              | 1.06x  | 1.585ms       | 1.497ms      |
    | Usage250Bench                                               | benchFetchEachServiceOnce                      | 1.07x  | 3.199ms       | 2.983ms      |
    | Usage250Bench                                               | benchFetchEachServiceThreeTimes                | 1.38x  | 2.544ms       | 1.846ms      |
    | Usage250Bench                                               | benchFetchEachServiceTwice                     | 1.39x  | 2.566ms       | 1.841ms      |
    | Usage250Bench                                               | benchFetchNewServiceManager                    | 4.74x  | 284.656µs     | 60.004µs     |
    | Usage250Bench                                               | benchFullCycleBuild                            | 1.27x  | 8.641ms       | 6.791ms      |
    | Usage250Bench                                               | benchFullCycleGet                              | 1.06x  | 3.884ms       | 3.656ms      |
    | Usage25Bench                                                | benchFetchEachServiceOnce                      | 1.05x  | 0.355ms       | 0.339ms      |
    | Usage25Bench                                                | benchFetchEachServiceThreeTimes                | 1.48x  | 0.267ms       | 0.180ms      |
    | Usage25Bench                                                | benchFetchEachServiceTwice                     | 1.56x  | 0.281ms       | 0.181ms      |
    | Usage25Bench                                                | benchFetchNewServiceManager                    | 8.49x  | 90.485µs      | 10.653µs     |
    | Usage25Bench                                                | benchFullCycleBuild                            | 1.28x  | 0.927ms       | 0.722ms      |
    | Usage25Bench                                                | benchFullCycleGet                              | 1.08x  | 0.447ms       | 0.416ms      |
    | Usage500Bench                                               | benchFetchEachServiceOnce                      | 1.07x  | 6.379ms       | 5.967ms      |
    | Usage500Bench                                               | benchFetchEachServiceThreeTimes                | 1.35x  | 5.101ms       | 3.766ms      |
    | Usage500Bench                                               | benchFetchEachServiceTwice                     | 1.37x  | 5.109ms       | 3.726ms      |
    | Usage500Bench                                               | benchFetchNewServiceManager                    | 4.31x  | 502.565µs     | 116.727µs    |
    | Usage500Bench                                               | benchFullCycleBuild                            | 1.26x  | 17.165ms      | 13.598ms     |
    | Usage500Bench                                               | benchFullCycleGet                              | 1.04x  | 7.602ms       | 7.299ms      |
    | Usage50Bench                                                | benchFetchEachServiceOnce                      | 1.00x  | 0.642ms       | 0.643ms      |
    | Usage50Bench                                                | benchFetchEachServiceThreeTimes                | 1.42x  | 0.512ms       | 0.360ms      |
    | Usage50Bench                                                | benchFetchEachServiceTwice                     | 1.40x  | 0.509ms       | 0.362ms      |
    | Usage50Bench                                                | benchFetchNewServiceManager                    | 6.71x  | 110.726µs     | 16.507µs     |
    | Usage50Bench                                                | benchFullCycleBuild                            | 1.26x  | 1.767ms       | 1.399ms      |
    | Usage50Bench                                                | benchFullCycleGet                              | 1.05x  | 0.822ms       | 0.785ms      |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+

#### Comparison by diff

    $ vendor\bin\phpbench report --file=..\all.master.060.xml --file=..\all.060.xml --report="extends: compare, compare: tag, cols: ["benchmark", "subject"]"
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | benchmark                                                   | subject                                        | diff   | tag:zend:mean | tag:mxc:mean |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithInvokablesOnly | 83.72x | 117.213µs     | 1.400µs      |
    | SetNewServicesBench                                         | benchOverrideAlias                             | 34.50x | 65.717µs      | 1.905µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithAliasesOnly    | 25.66x | 4,154.332µs   | 161.929µs    |
    | SetNewServicesBench                                         | benchSetAlias                                  | 9.74x  | 18.974µs      | 1.948µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithDelegatorsOnly | 8.84x  | 13.201µs      | 1.494µs      |
    | Usage25Bench                                                | benchFetchNewServiceManager                    | 8.49x  | 90.485µs      | 10.653µs     |
    | Usage50Bench                                                | benchFetchNewServiceManager                    | 6.71x  | 110.726µs     | 16.507µs     |
    | Usage100Bench                                               | benchFetchNewServiceManager                    | 5.59x  | 156.489µs     | 28.001µs     |
    | Usage250Bench                                               | benchFetchNewServiceManager                    | 4.74x  | 284.656µs     | 60.004µs     |
    | SetNewServicesBench                                         | benchSetInvokableClass                         | 4.57x  | 5.304µs       | 1.161µs      |
    | Usage500Bench                                               | benchFetchNewServiceManager                    | 4.31x  | 502.565µs     | 116.727µs    |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithServicesOnly   | 4.13x  | 5.792µs       | 1.403µs      |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByClassName             | 4.04x  | 3.302µs       | 0.817µs      |
    | CreateSingleFeaturedServiceManagerBench                     | benchCreateNewServiceManagerWithFactoriesOnly  | 4.03x  | 5.587µs       | 1.387µs      |
    | Usage1000Bench                                              | benchFetchNewServiceManager                    | 4.00x  | 942.214µs     | 235.774µs    |
    | SetNewServicesBench                                         | benchSetFactory                                | 3.80x  | 4.351µs       | 1.143µs      |
    | SetNewServicesBench                                         | benchSetService                                | 3.22x  | 1.977µs       | 0.613µs      |
    | SetNewServicesBench                                         | benchAddMultiDelegator                         | 2.42x  | 3.463µs       | 1.433µs      |
    | SetNewServicesBench                                         | benchAddDelegator                              | 2.23x  | 3.456µs       | 1.552µs      |
    | SetNewServicesBench                                         | benchAddInitializerByInstance                  | 2.01x  | 1.687µs       | 0.839µs      |
    | FetchNewServicesBench                                       | benchFetchInvokable1                           | 1.74x  | 3.357µs       | 1.924µs      |
    | FetchNewServicesBench                                       | benchFetchMultiDelegatorCached                 | 1.74x  | 6.590µs       | 3.797µs      |
    | FetchNewServicesBench                                       | benchBuildMultiDelegatorCached                 | 1.73x  | 6.061µs       | 3.503µs      |
    | SetNewServicesBench                                         | benchAddInitializerByClassName                 | 1.61x  | 2.347µs       | 1.455µs      |
    | FetchNewServicesBench                                       | benchBuildInvokable1                           | 1.58x  | 2.648µs       | 1.678µs      |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByInstance              | 1.57x  | 2.791µs       | 1.779µs      |
    | Usage25Bench                                                | benchFetchEachServiceTwice                     | 1.56x  | 0.281ms       | 0.181ms      |
    | Usage25Bench                                                | benchFetchEachServiceThreeTimes                | 1.48x  | 0.267ms       | 0.180ms      |
    | FetchNewServicesBench                                       | benchBuildDelegatorCached                      | 1.47x  | 3.906µs       | 2.653µs      |
    | FetchNewServicesBench                                       | benchFetchDelegatorCached                      | 1.46x  | 4.426µs       | 3.024µs      |
    | Usage50Bench                                                | benchFetchEachServiceThreeTimes                | 1.42x  | 0.512ms       | 0.360ms      |
    | FetchNewServicesBench                                       | benchFetchLazyServiceCached                    | 1.42x  | 6.892µs       | 4.852µs      |
    | Usage100Bench                                               | benchFetchEachServiceThreeTimes                | 1.40x  | 1.031ms       | 0.734ms      |
    | Usage50Bench                                                | benchFetchEachServiceTwice                     | 1.40x  | 0.509ms       | 0.362ms      |
    | Usage100Bench                                               | benchFetchEachServiceTwice                     | 1.40x  | 1.027ms       | 0.732ms      |
    | Usage250Bench                                               | benchFetchEachServiceTwice                     | 1.39x  | 2.566ms       | 1.841ms      |
    | Usage250Bench                                               | benchFetchEachServiceThreeTimes                | 1.38x  | 2.544ms       | 1.846ms      |
    | Usage500Bench                                               | benchFetchEachServiceTwice                     | 1.37x  | 5.109ms       | 3.726ms      |
    | Usage500Bench                                               | benchFetchEachServiceThreeTimes                | 1.35x  | 5.101ms       | 3.766ms      |
    | Usage1000Bench                                              | benchFetchEachServiceThreeTimes                | 1.35x  | 10.254ms      | 7.599ms      |
    | Usage1000Bench                                              | benchFetchEachServiceTwice                     | 1.34x  | 10.247ms      | 7.651ms      |
    | FetchNewServicesBench                                       | benchBuildLazyServiceCached                    | 1.31x  | 5.744µs       | 4.389µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithNoDependencies            | 1.30x  | 5.443µs       | 4.172µs      |
    | Usage25Bench                                                | benchFullCycleBuild                            | 1.28x  | 0.927ms       | 0.722ms      |
    | Usage100Bench                                               | benchFullCycleBuild                            | 1.28x  | 3.514ms       | 2.748ms      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithNoDependencies            | 1.28x  | 4.856µs       | 3.802µs      |
    | Usage250Bench                                               | benchFullCycleBuild                            | 1.27x  | 8.641ms       | 6.791ms      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithDependency                | 1.26x  | 6.004µs       | 4.751µs      |
    | Usage50Bench                                                | benchFullCycleBuild                            | 1.26x  | 1.767ms       | 1.399ms      |
    | Usage500Bench                                               | benchFullCycleBuild                            | 1.26x  | 17.165ms      | 13.598ms     |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceDependingOnConfig             | 1.26x  | 5.544µs       | 4.407µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceDependingOnConfig             | 1.26x  | 6.044µs       | 4.805µs      |
    | Usage1000Bench                                              | benchFullCycleBuild                            | 1.24x  | 34.396ms      | 27.664ms     |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias2               | 1.23x  | 2.553µs       | 2.082µs      |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias1               | 1.22x  | 2.526µs       | 2.073µs      |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias2               | 1.21x  | 2.521µs       | 2.075µs      |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias1               | 1.21x  | 2.519µs       | 2.081µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithNoDependencies            | 1.18x  | 3.896µs       | 3.297µs      |
    | FetchNewServicesBench                                       | benchFetchFactoryAlias1                        | 1.17x  | 2.433µs       | 2.071µs      |
    | FetchNewServicesBench                                       | benchFetchFactory1                             | 1.17x  | 2.816µs       | 2.405µs      |
    | FetchNewServicesBench                                       | benchBuildFactoryAlias1                        | 1.17x  | 2.428µs       | 2.083µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceDependingOnConfig             | 1.14x  | 7.165µs       | 6.279µs      |
    | FetchNewServicesBench                                       | benchBuildFactory1                             | 1.13x  | 2.414µs       | 2.130µs      |
    | HasBench                                                    | benchHasService1                               | 1.13x  | 0.428µs       | 0.380µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithDependency                | 1.12x  | 5.596µs       | 4.976µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithNoDependencies            | 1.12x  | 4.981µs       | 4.434µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithDependency                | 1.12x  | 8.443µs       | 7.553µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceDependingOnConfig             | 1.11x  | 5.589µs       | 5.024µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithNoDependencies            | 1.11x  | 3.406µs       | 3.073µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithDependency                | 1.11x  | 5.443µs       | 4.918µs      |
    | Usage1000Bench                                              | benchFetchEachServiceOnce                      | 1.09x  | 13.011ms      | 11.897ms     |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceDependingOnConfig             | 1.09x  | 6.604µs       | 6.040µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithDependency                | 1.09x  | 7.898µs       | 7.262µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithNoDependencies            | 1.08x  | 4.507µs       | 4.161µs      |
    | HasBench                                                    | benchHasRecursiveAlias1                        | 1.08x  | 0.545µs       | 0.503µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceDependingOnConfig             | 1.08x  | 5.148µs       | 4.762µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithDependency                | 1.08x  | 5.116µs       | 4.734µs      |
    | Usage25Bench                                                | benchFullCycleGet                              | 1.08x  | 0.447ms       | 0.416ms      |
    | Usage250Bench                                               | benchFetchEachServiceOnce                      | 1.07x  | 3.199ms       | 2.983ms      |
    | Usage500Bench                                               | benchFetchEachServiceOnce                      | 1.07x  | 6.379ms       | 5.967ms      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceDependingOnConfig             | 1.06x  | 6.758µs       | 6.346µs      |
    | HasBench                                                    | benchHasRecursiveAlias2                        | 1.06x  | 0.535µs       | 0.503µs      |
    | Usage100Bench                                               | benchFetchEachServiceOnce                      | 1.06x  | 1.300ms       | 1.222ms      |
    | Usage250Bench                                               | benchFullCycleGet                              | 1.06x  | 3.884ms       | 3.656ms      |
    | HasBench                                                    | benchHasAlias1                                 | 1.06x  | 0.534µs       | 0.503µs      |
    | Usage100Bench                                               | benchFullCycleGet                              | 1.06x  | 1.585ms       | 1.497ms      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFoo                   | 1.06x  | 2.325µs       | 2.199µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithDependency                | 1.06x  | 7.973µs       | 7.541µs      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFooCached             | 1.06x  | 2.325µs       | 2.200µs      |
    | Usage1000Bench                                              | benchFullCycleGet                              | 1.05x  | 15.405ms      | 14.700ms     |
    | Usage25Bench                                                | benchFetchEachServiceOnce                      | 1.05x  | 0.355ms       | 0.339ms      |
    | Usage50Bench                                                | benchFullCycleGet                              | 1.05x  | 0.822ms       | 0.785ms      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithNoDependencies            | 1.04x  | 3.328µs       | 3.190µs      |
    | Usage500Bench                                               | benchFullCycleGet                              | 1.04x  | 7.602ms       | 7.299ms      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithDependency                | 1.04x  | 7.436µs       | 7.173µs      |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | Begin of range where differences in measures may be at some probability independent of implementation differences                                    |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | FetchNewServicesBench                                       | benchBuildAbstractFactoryFoo                   | 1.02x  | 1.879µs       | 1.850µs      |
    | HasBench                                                    | benchHasInvokable1                             | 1.00x  | 0.546µs       | 0.545µs      |
    | Usage50Bench                                                | benchFetchEachServiceOnce                      | 1.00x  | 0.642ms       | 0.643ms      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceDependingOnConfig             | 1.00x  | 6.103µs       | 6.111µs      |
    | FetchNewServicesBench                                       | benchFetchLazyService                          | 1.00x  | 217.692µs     | 218.253µs    |
    | FetchNewServicesBench                                       | benchBuildLazyService                          | 0.99x  | 216.973µs     | 218.773µs    |
    | FetchNewServicesBench                                       | benchFetchService1                             | 0.99x  | 0.400µs       | 0.404µs      |
    | FetchCachedServicesBench                                    | benchFetchService1                             | 0.98x  | 0.403µs       | 0.410µs      |
    | FetchCachedServicesBench                                    | benchFetchInvokable1                           | 0.98x  | 0.404µs       | 0.413µs      |
    | FetchCachedServicesBench                                    | benchFetchLazyService                          | 0.98x  | 0.403µs       | 0.413µs      |
    | FetchCachedServicesBench                                    | benchFetchMultiDelegatorService                | 0.98x  | 0.400µs       | 0.410µs      |
    | FetchCachedServicesBench                                    | benchFetchAbstractFactoryService               | 0.98x  | 0.400µs       | 0.410µs      |
    | FetchCachedServicesBench                                    | benchFetchDelegatorService                     | 0.98x  | 0.400µs       | 0.410µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias1                      | 0.97x  | 0.400µs       | 0.412µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias2                      | 0.97x  | 0.400µs       | 0.413µs      |
    | FetchCachedServicesBench                                    | benchFetchAlias1                               | 0.97x  | 0.400µs       | 0.413µs      |
    | FetchCachedServicesBench                                    | benchFetchFactory1                             | 0.97x  | 0.400µs       | 0.414µs      |
    | FetchNewServicesBench                                       | benchFetchMultiDelegator                       | 0.97x  | 8.838µs       | 9.149µs      |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | End of range where differences in measures may be at some probability independent of implementation differences                                      |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+
    | FetchNewServicesBench                                       | benchFetchMultiDelegator                       | 0.97x  | 8.838µs       | 9.149µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithNoDependencies            | 0.96x  | 2.741µs       | 2.851µs      |
    | HasBench                                                    | benchHasNot                                    | 0.95x  | 0.821µs       | 0.868µs      |
    | FetchNewServicesBench                                       | benchBuildMultiDelegator                       | 0.95x  | 8.330µs       | 8.814µs      |
    | HasBench                                                    | benchHasAbstractFactory                        | 0.94x  | 0.772µs       | 0.819µs      |
    | FetchNewServicesBench                                       | benchFetchDelegator                            | 0.93x  | 5.710µs       | 6.172µs      |
    | HasBench                                                    | benchHasFactory1                               | 0.91x  | 0.476µs       | 0.523µs      |
    | FetchNewServicesBench                                       | benchBuildDelegator                            | 0.90x  | 5.182µs       | 5.759µs      |
    +-------------------------------------------------------------+------------------------------------------------+--------+---------------+--------------+

## Version 0.5.0 - 2018-02-27: Enhanced benchmark suite, optimized ConfigAbstractFactory

### Added

- Added tests of lazy_services and delegators to almost all benchmarks.
- Added benchmarks to measure service manager with different sizes of configuration: 25, 50, 100, 250, 500 and 1000 services, aliases, delegators, factories and invokables each. All feature a single abstract factory.

### Removed
- Removed abstract factory caching because zend-servicemanager concept proofed to be superior. Optimized zend-servicemanager abstract factory initialization process.
- Removed FetchNewServiceManagerBench.php. This single test was replaced by UsageXXX.php benchmarks for several configuration sizes.
- Removed AbstractFactoryCacheBench.php which got obsolete.

### Changed

- changed ConfigAbstractFactory to cache configuration
- changed addDelegator, so that it accepts an array of delegator factories as second parameter also
- fixed FetchCachedServicesBench.php, which did not cache abstract factory based services
- flattened the internal representation of lazy_services config.

### Benchmark Comparison zend-master vs. mxc-master

Benchmark sorting was changed. Benchmarks are now displayed desendant sorted by difference between implementations.
Diff > 1 means, znd-servicemanager is faster. Diff < 1 means zend-servicemanager implementation is faster.

The benchmark comparison is based on a patched version of PHPBench 0.15-dev.
The patch adds and computes the `diff` column and sorts descendig by this column. All tests were
done with PHPBench 0.15-dev. The benchmark suite used is of mxc-sevicemanager 0.5.0.
We backported the test suite to zend-sevicemanager:master.

Be aware that differences up to approx. 3% may be related to factors other than implementation, such
as overall processor load of benchmarking system, the wheather, room temperature, heart beat rate of
developer and such. :) This area is marked in the table below for your convenience.

All benchmarks were run with 50 iterations and a retry_threshold of 2 to ensure good stability.

    $ vendor\bin\phpbench report --file=..\all.master.060.xml --file=..\all.060.xml --report="extends: compare, compare: tag, cols: ["benchmark", "subject", "revs"]"
    +-------------------------------------------------------------+-------------------------------------+--------+--------+---------------+--------------+
    | benchmark                                                   | subject                             | revs   | diff   | tag:zend:mean | tag:mxc:mean |
    +-------------------------------------------------------------+-------------------------------------+--------+--------+---------------+--------------+
    | SetNewServicesBench                                         | benchOverrideAlias                  | 100000 | 34.69x | 68.220µs      | 1.966µs      |
    | SetNewServicesBench                                         | benchSetAlias                       | 100000 | 10.29x | 19.992µs      | 1.944µs      |
    | Usage25Bench                                                | benchFetchNewServiceManager         | 500    | 7.70x  | 92.445µs      | 12.001µs     |
    | Usage50Bench                                                | benchFetchNewServiceManager         | 500    | 6.91x  | 110.486µs     | 16.001µs     |
    | Usage100Bench                                               | benchFetchNewServiceManager         | 500    | 5.70x  | 159.529µs     | 28.002µs     |
    | Usage250Bench                                               | benchFetchNewServiceManager         | 500    | 4.93x  | 295.577µs     | 60.004µs     |
    | SetNewServicesBench                                         | benchSetInvokableClass              | 100000 | 4.64x  | 5.515µs       | 1.188µs      |
    | Usage500Bench                                               | benchFetchNewServiceManager         | 500    | 4.33x  | 515.230µs     | 119.087µs    |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByClassName  | 100000 | 4.11x  | 3.408µs       | 0.829µs      |
    | Usage1000Bench                                              | benchFetchNewServiceManager         | 500    | 4.07x  | 969.415µs     | 238.454µs    |
    | SetNewServicesBench                                         | benchSetFactory                     | 100000 | 3.88x  | 4.533µs       | 1.168µs      |
    | SetNewServicesBench                                         | benchSetService                     | 100000 | 3.33x  | 2.066µs       | 0.620µs      |
    | SetNewServicesBench                                         | benchAddMultiDelegator              | 100000 | 2.46x  | 3.584µs       | 1.456µs      |
    | SetNewServicesBench                                         | benchAddDelegator                   | 100000 | 2.28x  | 3.630µs       | 1.591µs      |
    | SetNewServicesBench                                         | benchAddInitializerByInstance       | 100000 | 2.06x  | 1.750µs       | 0.850µs      |
    | FetchNewServicesBench                                       | benchBuildMultiDelegatorCached      | 100000 | 1.77x  | 6.329µs       | 3.567µs      |
    | FetchNewServicesBench                                       | benchFetchMultiDelegatorCached      | 100000 | 1.69x  | 6.841µs       | 4.046µs      |
    | SetNewServicesBench                                         | benchAddInitializerByClassName      | 100000 | 1.66x  | 2.436µs       | 1.465µs      |
    | SetNewServicesBench                                         | benchAddAbstractFactoryByInstance   | 100000 | 1.61x  | 2.914µs       | 1.808µs      |
    | FetchNewServicesBench                                       | benchFetchInvokable1                | 100000 | 1.58x  | 3.428µs       | 2.171µs      |
    | FetchNewServicesBench                                       | benchBuildInvokable1                | 100000 | 1.56x  | 2.741µs       | 1.756µs      |
    | FetchNewServicesBench                                       | benchBuildDelegatorCached           | 100000 | 1.50x  | 4.101µs       | 2.731µs      |
    | Usage25Bench                                                | benchFetchEachServiceTwice          | 1000   | 1.47x  | 0.275ms       | 0.187ms      |
    | FetchNewServicesBench                                       | benchFetchDelegatorCached           | 100000 | 1.45x  | 4.678µs       | 3.227µs      |
    | Usage100Bench                                               | benchFetchEachServiceThreeTimes     | 1000   | 1.44x  | 1.068ms       | 0.743ms      |
    | Usage25Bench                                                | benchFetchEachServiceThreeTimes     | 1000   | 1.44x  | 0.272ms       | 0.189ms      |
    | Usage100Bench                                               | benchFetchEachServiceTwice          | 1000   | 1.43x  | 1.058ms       | 0.739ms      |
    | Usage250Bench                                               | benchFetchEachServiceTwice          | 100    | 1.42x  | 2.686ms       | 1.888ms      |
    | FetchNewServicesBench                                       | benchFetchLazyServiceCached         | 100000 | 1.41x  | 7.301µs       | 5.178µs      |
    | Usage250Bench                                               | benchFetchEachServiceThreeTimes     | 100    | 1.39x  | 2.669ms       | 1.926ms      |
    | Usage50Bench                                                | benchFetchEachServiceThreeTimes     | 1000   | 1.38x  | 0.516ms       | 0.373ms      |
    | Usage50Bench                                                | benchFetchEachServiceTwice          | 1000   | 1.38x  | 0.516ms       | 0.373ms      |
    | Usage1000Bench                                              | benchFetchEachServiceThreeTimes     | 200    | 1.38x  | 10.698ms      | 7.763ms      |
    | Usage1000Bench                                              | benchFetchEachServiceTwice          | 200    | 1.37x  | 10.615ms      | 7.757ms      |
    | Usage500Bench                                               | benchFetchEachServiceThreeTimes     | 100    | 1.34x  | 5.132ms       | 3.838ms      |
    | FetchNewServicesBench                                       | benchBuildLazyServiceCached         | 100000 | 1.31x  | 5.939µs       | 4.538µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithNoDependencies | 100000 | 1.30x  | 5.531µs       | 4.241µs      |
    | Usage500Bench                                               | benchFetchEachServiceTwice          | 100    | 1.30x  | 5.057ms       | 3.888ms      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceDependingOnConfig  | 100000 | 1.30x  | 6.324µs       | 4.864µs      |
    | Usage25Bench                                                | benchFullCycle                      | 1000   | 1.30x  | 0.955ms       | 0.736ms      |
    | Usage100Bench                                               | benchFullCycle                      | 1000   | 1.30x  | 3.611ms       | 2.785ms      |
    | Usage250Bench                                               | benchFullCycle                      | 100    | 1.29x  | 8.982ms       | 6.938ms      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchFetchServiceWithDependency     | 100000 | 1.29x  | 6.230µs       | 4.844µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithNoDependencies | 100000 | 1.28x  | 5.036µs       | 3.946µs      |
    | Usage1000Bench                                              | benchFullCycle                      | 200    | 1.27x  | 35.723ms      | 28.143ms     |
    | Usage50Bench                                                | benchFullCycle                      | 1000   | 1.26x  | 1.766ms       | 1.404ms      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceWithDependency     | 100000 | 1.25x  | 5.636µs       | 4.526µs      |
    | FetchNewServiceViaConfigAbstractFactoryBench                | benchBuildServiceDependingOnConfig  | 100000 | 1.24x  | 5.641µs       | 4.537µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithNoDependencies | 100000 | 1.24x  | 4.076µs       | 3.290µs      |
    | Usage500Bench                                               | benchFullCycle                      | 100    | 1.23x  | 17.194ms      | 13.933ms     |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias1    | 100000 | 1.18x  | 2.544µs       | 2.148µs      |
    | FetchNewServicesBench                                       | benchFetchRecursiveFactoryAlias2    | 100000 | 1.18x  | 2.536µs       | 2.153µs      |
    | FetchNewServicesBench                                       | benchBuildFactoryAlias1             | 100000 | 1.18x  | 2.517µs       | 2.142µs      |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias2    | 100000 | 1.17x  | 2.524µs       | 2.164µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceDependingOnConfig  | 100000 | 1.17x  | 7.455µs       | 6.398µs      |
    | FetchNewServicesBench                                       | benchBuildRecursiveFactoryAlias1    | 100000 | 1.16x  | 2.494µs       | 2.141µs      |
    | FetchNewServicesBench                                       | benchFetchFactoryAlias1             | 100000 | 1.16x  | 2.496µs       | 2.151µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchFetchServiceWithDependency     | 100000 | 1.15x  | 8.760µs       | 7.610µs      |
    | HasBench                                                    | benchHasInvokable1                  | 100000 | 1.15x  | 0.568µs       | 0.493µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithNoDependencies | 100000 | 1.15x  | 5.164µs       | 4.501µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceWithDependency     | 100000 | 1.14x  | 5.829µs       | 5.096µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchFetchServiceDependingOnConfig  | 100000 | 1.14x  | 5.812µs       | 5.111µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceDependingOnConfig  | 100000 | 1.12x  | 6.967µs       | 6.200µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithNoDependencies | 100000 | 1.12x  | 3.557µs       | 3.170µs      |
    | FetchNewServicesBench                                       | benchBuildFactory1                  | 100000 | 1.12x  | 2.464µs       | 2.202µs      |
    | HasBench                                                    | benchHasService1                    | 100000 | 1.12x  | 0.440µs       | 0.394µs      |
    | FetchNewServicesBench                                       | benchFetchFactory1                  | 100000 | 1.11x  | 2.923µs       | 2.631µs      |
    | Usage1000Bench                                              | benchFetchEachServiceOnce           | 200    | 1.11x  | 13.491ms      | 12.155ms     |
    | Usage250Bench                                               | benchFetchEachServiceOnce           | 100    | 1.11x  | 3.351ms       | 3.024ms      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithDependency     | 100000 | 1.10x  | 5.341µs       | 4.843µs      |
    | FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench | benchBuildServiceWithDependency     | 100000 | 1.10x  | 8.156µs       | 7.448µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithNoDependencies | 100000 | 1.09x  | 3.444µs       | 3.147µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceWithDependency     | 100000 | 1.09x  | 8.238µs       | 7.551µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchFetchServiceDependingOnConfig  | 100000 | 1.09x  | 7.013µs       | 6.429µs      |
    | Usage100Bench                                               | benchFetchEachServiceOnce           | 1000   | 1.09x  | 1.342ms       | 1.231ms      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceWithNoDependencies | 100000 | 1.09x  | 4.687µs       | 4.305µs      |
    | FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench     | benchBuildServiceDependingOnConfig  | 100000 | 1.07x  | 5.349µs       | 5.000µs      |
    | HasBench                                                    | benchHasFactory1                    | 100000 | 1.06x  | 0.504µs       | 0.474µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithDependency     | 100000 | 1.04x  | 7.703µs       | 7.405µs      |
    | HasBench                                                    | benchHasRecursiveAlias2             | 100000 | 1.04x  | 0.565µs       | 0.543µs      |
    +-------------------------------------------------------------+-------------------------------------+--------+--------+---------------+--------------+
    | Begin of range where differences in measures may be at some probability independent of implementation differences                                  |
    +-------------------------------------------------------------+-------------------------------------+--------+--------+---------------+--------------+
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceDependingOnConfig  | 100000 | 1.03x  | 6.331µs       | 6.127µs      |
    | HasBench                                                    | benchHasAbstractFactory             | 100000 | 1.03x  | 0.799µs       | 0.776µs      |
    | Usage25Bench                                                | benchFetchEachServiceOnce           | 1000   | 1.03x  | 0.349ms       | 0.340ms      |
    | FetchNewServicesBench                                       | benchBuildAbstractFactoryFoo        | 100000 | 1.03x  | 1.960µs       | 1.907µs      |
    | Usage500Bench                                               | benchFetchEachServiceOnce           | 100    | 1.02x  | 6.382ms       | 6.229ms      |
    | HasBench                                                    | benchHasNot                         | 100000 | 1.02x  | 0.845µs       | 0.827µs      |
    | Usage50Bench                                                | benchFetchEachServiceOnce           | 1000   | 1.02x  | 0.647ms       | 0.633ms      |
    | HasBench                                                    | benchHasAlias1                      | 100000 | 1.02x  | 0.553µs       | 0.543µs      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFoo        | 100000 | 1.01x  | 2.412µs       | 2.397µs      |
    | FetchNewServicesBench                                       | benchFetchLazyService               | 1000   | 1.00x  | 228.953µs     | 228.133µs    |
    | FetchCachedServicesBench                                    | benchFetchLazyService               | 100000 | 1.00x  | 0.416µs       | 0.415µs      |
    | FetchNewServicesBench                                       | benchBuildLazyService               | 1000   | 1.00x  | 226.833µs     | 226.073µs    |
    | FetchNewServicesBench                                       | benchFetchService1                  | 100000 | 1.00x  | 0.414µs       | 0.413µs      |
    | HasBench                                                    | benchHasRecursiveAlias1             | 100000 | 1.00x  | 0.543µs       | 0.544µs      |
    | FetchNewServicesBench                                       | benchFetchAbstractFactoryFooCached  | 100000 | 1.00x  | 2.397µs       | 2.403µs      |
    | FetchCachedServicesBench                                    | benchFetchAlias1                    | 100000 | 1.00x  | 0.414µs       | 0.416µs      |
    | FetchCachedServicesBench                                    | benchFetchInvokable1                | 100000 | 0.99x  | 0.420µs       | 0.423µs      |
    | FetchNewServiceViaReflectionAbstractFactoryBench            | benchBuildServiceWithNoDependencies | 100000 | 0.99x  | 2.848µs       | 2.871µs      |
    | FetchCachedServicesBench                                    | benchFetchMultiDelegatorService     | 100000 | 0.99x  | 0.410µs       | 0.414µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias1           | 100000 | 0.99x  | 0.410µs       | 0.416µs      |
    | FetchCachedServicesBench                                    | benchFetchDelegatorService          | 100000 | 0.99x  | 0.410µs       | 0.416µs      |
    | FetchCachedServicesBench                                    | benchFetchAbstractFactoryService    | 100000 | 0.98x  | 0.410µs       | 0.417µs      |
    | FetchCachedServicesBench                                    | benchFetchFactory1                  | 100000 | 0.98x  | 0.414µs       | 0.423µs      |
    | FetchCachedServicesBench                                    | benchFetchRecursiveAlias2           | 100000 | 0.98x  | 0.404µs       | 0.415µs      |
    | FetchCachedServicesBench                                    | benchFetchService1                  | 100000 | 0.97x  | 0.413µs       | 0.423µs      |
    +-------------------------------------------------------------+-------------------------------------+--------+--------+---------------+--------------+
    | End of range where differences in measures may be at some probability independent of implementation differences                                    |
    +-------------------------------------------------------------+-------------------------------------+--------+--------+---------------+--------------+
    | FetchNewServicesBench                                       | benchBuildMultiDelegator            | 100000 | 0.97x  | 8.733µs       | 9.020µs      | *
    | FetchNewServicesBench                                       | benchFetchMultiDelegator            | 100000 | 0.96x  | 9.256µs       | 9.624µs      | *
    | FetchNewServicesBench                                       | benchBuildDelegator                 | 100000 | 0.91x  | 5.428µs       | 5.935µs      | *
    | FetchNewServicesBench                                       | benchFetchDelegator                 | 100000 | 0.90x  | 5.973µs       | 6.633µs      | *
    +-------------------------------------------------------------+-------------------------------------+--------+--------+---------------+--------------+

#### Rationale why `get()` and `build()`of a delegator is initially slower than zend-servicemanager (benchmarks above marked with *)

znd-servicemanager features a cache for the callback that get's produced when a delegator gets created. It is the cost of maintaining
this cache which makes getting or building a delegator slower on the first call.

You achieve benefit from this cache, when you build or get the same delegator again. Search for entries benchFetchDelegatorCached (45%),
benchBuildDelegatorCached (50%), benchFetchMultiDelegatorCached (69%), benchBuildMultiDelegatorCached (77%) in the benchmark table.

If there are use cases where delegators are most likely created once only, we could consider to introduce an option to turn that cache off.

#### Configuration speedup

Before 0.5.0 there was no benchmark available to measure the performance of creating a new service manager via `configure()` for different
sizes of configuration.

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

Here is a new full benchmark comparison. The diff column says, how much time zend-servicemanager needs compared to znd-servicemanager. For example: The first line of the report below
says: zend-servicemanager needs 2,99x the time znd-servicemanager needs to complete the benchFetchServiceManagerCreation test which can be found in FetchNewServiceManagerBench.php.

Tests, where znd-servicemanager is slower than zend-servicemanager are marked with an asterisk (*) for your convenience.

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

- Restructured Packagist offering znd-servicemanager to provide full repo. This way the
  full benchmark suite and phpunit suite gets available.

- Former reduced offering znd-servicemanager has been changed to znd-servicemanager-s. Low
footprint, MxcCommons namespace, dependency to znd-servicemanager.

- Documentation adjusted to reflect changes above.

### Deprecated

- mxc-services GitHub repo. It's now znd-servicemanager.


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
