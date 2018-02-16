
## Benchmark Comparisons

This file holds comparison benchmarks of zend-servicemanager to mxc-servicemanager.

### Version 0.2.0, 2018-02-16

Some benchmarks dealing with abstract factories show immense performance decreases now. Rationale behind that is, that we dropped the behaviour
to instantiate all abstract factories on startup. Abstract factories and initializers are instantiated when needed now. The overhead of instantiating
abstract factories and initializers now gets measured. We marked the benchmarks involved with a (*) below.


        $ vendor\bin\phpbench report --file=..\master.all.xml --file=..\all.020.xml --report="compare"
        benchmark: AbstractFactoryCacheBench
        +-------------------------------------------+-------------------+------------------+
        | subject                                   | suite:master:mean | suite:0.2.0:mean |
        +-------------------------------------------+-------------------+------------------+
    (*) | benchGetViaAbstractFactory                | 2.361µs           | 4.470µs          |
        | benchGetViaCachedAbstractFactory          | 2.405µs           | 1.920µs          |
    (*) | benchIfHasThenGetViaAbstractFactory       | 2.982µs           | 4.861µs          |
        | benchIfHasThenGetViaCachedAbstractFactory | 2.978µs           | 2.178µs          |
        +-------------------------------------------+-------------------+------------------+

        benchmark: FetchCachedServicesBench
        +----------------------------------+-------------------+------------------+
        | subject                          | suite:master:mean | suite:0.2.0:mean |
        +----------------------------------+-------------------+------------------+
        | benchFetchFactory1               | 0.452µs           | 0.449µs          |
        | benchFetchInvokable1             | 0.473µs           | 0.459µs          |
        | benchFetchService1               | 0.457µs           | 0.450µs          |
        | benchFetchAlias1                 | 0.458µs           | 0.452µs          |
        | benchFetchRecursiveAlias1        | 0.474µs           | 0.463µs          |
        | benchFetchRecursiveAlias2        | 0.468µs           | 0.466µs          |
    (*) | benchFetchAbstractFactoryService | 2.450µs           | 4.782µs          |
        +----------------------------------+-------------------+------------------+

        benchmark: FetchNewServiceUsingConfigAbstractFactoryAsFactoryBench
        +-------------------------------------+-------------------+------------------+
        | subject                             | suite:master:mean | suite:0.2.0:mean |
        +-------------------------------------+-------------------+------------------+
        | benchFetchServiceWithNoDependencies | 5.042µs           | 4.582µs          |
        | benchBuildServiceWithNoDependencies | 4.613µs           | 4.293µs          |
        | benchFetchServiceDependingOnConfig  | 5.744µs           | 5.186µs          |
        | benchBuildServiceDependingOnConfig  | 5.306µs           | 4.936µs          |
        | benchFetchServiceWithDependency     | 5.681µs           | 5.140µs          |
        | benchBuildServiceWithDependency     | 5.210µs           | 4.833µs          |
        +-------------------------------------+-------------------+------------------+

        benchmark: FetchNewServiceUsingReflectionAbstractFactoryAsFactoryBench
        +-------------------------------------+-------------------+------------------+
        | subject                             | suite:master:mean | suite:0.2.0:mean |
        +-------------------------------------+-------------------+------------------+
        | benchFetchServiceWithNoDependencies | 3.963µs           | 3.566µs          |
        | benchBuildServiceWithNoDependencies | 3.537µs           | 3.380µs          |
        | benchFetchServiceDependingOnConfig  | 7.089µs           | 6.745µs          |
        | benchBuildServiceDependingOnConfig  | 6.650µs           | 6.544µs          |
        | benchFetchServiceWithDependency     | 8.432µs           | 8.049µs          |
        | benchBuildServiceWithDependency     | 7.960µs           | 8.120µs          |  <- interesting! should be less
        +-------------------------------------+-------------------+------------------+

        benchmark: FetchNewServiceViaConfigAbstractFactoryBench
        +--------------------------------------+-------------------+------------------+
        | subject                              | suite:master:mean | suite:0.2.0:mean |
        +--------------------------------------+-------------------+------------------+
        | benchFetchsServiceWithNoDependencies | 5.489µs           | 7.669µs          |
        | benchBuildServiceWithNoDependencies  | 4.922µs           | 7.472µs          |
        | benchFetchServiceDependingOnConfig   | 6.143µs           | 8.488µs          |
        | benchBuildServiceDependingOnConfig   | 5.601µs           | 8.037µs          |
        | benchFetchServiceWithDependency      | 6.122µs           | 5.811µs          |
        | benchBuildServiceWithDependency      | 5.564µs           | 5.411µs          |
        +--------------------------------------+-------------------+------------------+

        benchmark: FetchNewServiceViaReflectionAbstractFactoryBench
        +-------------------------------------+-------------------+------------------+
        | subject                             | suite:master:mean | suite:0.2.0:mean |
        +-------------------------------------+-------------------+------------------+
    (*) | benchFetchServiceWithNoDependencies | 3.434µs           | 5.774µs          |
    (*) | benchBuildServiceWithNoDependencies | 2.919µs           | 5.560µs          |
    (*) | benchFetchServiceDependingOnConfig  | 6.766µs           | 9.458µs          |
    (*) | benchBuildServiceDependingOnConfig  | 6.221µs           | 9.215µs          |
    (*) | benchFetchServiceWithDependency     | 8.095µs           | 7.995µs          | <- interesting! Should not be less.
    (*) | benchBuildServiceWithDependency     | 7.555µs           | 8.370µs          |
        +-------------------------------------+-------------------+------------------+

        benchmark: FetchNewServicesBench
        +----------------------------------+-------------------+------------------+
        | subject                          | suite:master:mean | suite:0.2.0:mean |
        +----------------------------------+-------------------+------------------+
        | benchFetchFactory1               | 2.820µs           | 2.751µs          |
        | benchBuildFactory1               | 2.395µs           | 2.325µs          |
        | benchFetchInvokable1             | 3.315µs           | 2.205µs          |
        | benchBuildInvokable1             | 2.620µs           | 1.726µs          |
        | benchFetchService1               | 0.455µs           | 0.460µs          |
        | benchFetchFactoryAlias1          | 2.454µs           | 2.243µs          |
        | benchBuildFactoryAlias1          | 2.461µs           | 2.245µs          |
        | benchFetchRecursiveFactoryAlias1 | 2.475µs           | 2.253µs          |
        | benchBuildRecursiveFactoryAlias1 | 2.490µs           | 2.249µs          |
        | benchFetchRecursiveFactoryAlias2 | 2.497µs           | 2.239µs          |
        | benchBuildRecursiveFactoryAlias2 | 2.473µs           | 2.282µs          |
    (*) | benchFetchAbstractFactoryFoo     | 2.407µs           | 4.702µs          |
    (*) | benchBuildAbstractFactoryFoo     | 1.947µs           | 4.268µs          |
        +----------------------------------+-------------------+------------------+

        benchmark: HasBench
        +-------------------------+-------------------+------------------+
        | subject                 | suite:master:mean | suite:0.2.0:mean |
        +-------------------------+-------------------+------------------+
        | benchHasFactory1        | 0.526µs           | 0.593µs          |
        | benchHasInvokable1      | 0.603µs           | 0.619µs          |
        | benchHasService1        | 0.482µs           | 0.550µs          |
        | benchHasAlias1          | 0.584µs           | 0.592µs          |
        | benchHasRecursiveAlias1 | 0.605µs           | 0.606µs          |
        | benchHasRecursiveAlias2 | 0.603µs           | 0.606µs          |
        | benchHasAbstractFactory | 0.839µs           | 3.034µs          |
    (*) | benchHasNot             | 0.851µs           | 2.837µs          |
        +-------------------------+-------------------+------------------+
