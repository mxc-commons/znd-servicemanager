<?php
/**
 * @link      https://github.com/mxc-commons/znd-servicemanager for the canonical source repository
 * @copyright Copyright (c) 2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright Copyright (c) 2018 maxence operations gmbh, Germany
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendBench\ServiceManager;

use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;
use PhpBench\Benchmark\Metadata\Annotations\Warmup;
use Zend\ServiceManager\Proxy\LazyServiceFactory;
use Zend\ServiceManager\ServiceManager;
use ZendBench\ServiceManager\BenchAsset\DelegatorFactory;

/**
 * @Revs(100000)
 * @Iterations(20)
 * @Warmup(2)
 */
class FetchNewServicesBench
{
    /**
     * @var ServiceManager
     */
    private $sm;
    private $smCached;

    public function __construct()
    {
        $this->sm = new ServiceManager([
            'factories' => [
                'factory1' => BenchAsset\FactoryFoo::class,
                'multi_delegator' => BenchAsset\FactoryFoo::class,
                'delegator' => BenchAsset\FactoryFoo::class,
                BenchAsset\Foo::class => BenchAsset\FactoryFoo::class,
            ],
            'invokables' => [
                'invokable1' => BenchAsset\Foo::class,
            ],
            'delegators' => [
                'multi_delegator' => [
                    DelegatorFactory::class,
                    DelegatorFactory::class,
                    DelegatorFactory::class,
                 ],
                'delegator' => [
                    DelegatorFactory::class,
                ],
                'lazy_service' => [
                    LazyServiceFactory::class,
                ]
            ],
            'lazy_services' => [
                'class_map' => [
                    'lazy_service' => BenchAsset\Foo::class
                ],
            ],
            'services' => [
                'service1' => new \stdClass(),
                'config' => [],
            ],
            'aliases' => [
                'factoryAlias1'          => 'factory1',
                'recursiveFactoryAlias1' => 'factoryAlias1',
                'recursiveFactoryAlias2' => 'recursiveFactoryAlias1',
            ],
            'abstract_factories' => [
                BenchAsset\AbstractFactoryFoo::class,
            ],
        ]);
        $this->smCached = clone $this->sm;
        $this->smCached->build('foo');
        $this->smCached->build('multi_delegator');
        $this->smCached->build('delegator');
        $this->smCached->build('lazy_service');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchFactory1()
    {
        $sm = clone $this->sm;
        $sm->get('factory1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchBuildFactory1()
    {
        $sm = clone $this->sm;
        $sm->build('factory1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchInvokable1()
    {
        $sm = clone $this->sm;
        $sm->get('invokable1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchBuildInvokable1()
    {
        $sm = clone $this->sm;
        $sm->build('invokable1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchService1()
    {
        $sm = clone $this->sm;
        $sm->get('service1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchFactoryAlias1()
    {
        $sm = clone $this->sm;
        $sm->build('factoryAlias1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchBuildFactoryAlias1()
    {
        $sm = clone $this->sm;
        $sm->build('factoryAlias1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchRecursiveFactoryAlias1()
    {
        $sm = clone $this->sm;
        $sm->build('recursiveFactoryAlias1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchBuildRecursiveFactoryAlias1()
    {
        $sm = clone $this->sm;
        $sm->build('recursiveFactoryAlias1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchRecursiveFactoryAlias2()
    {
        $sm = clone $this->sm;
        $sm->build('recursiveFactoryAlias2');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchBuildRecursiveFactoryAlias2()
    {
        $sm = clone $this->sm;
        $sm->build('recursiveFactoryAlias2');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchAbstractFactoryFoo()
    {
        $sm = clone $this->sm;
        $sm->get('foo');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchAbstractFactoryFooCached()
    {
        $sm = clone $this->smCached;
        $sm->get('foo');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchBuildAbstractFactoryFoo()
    {
        $sm = clone $this->sm;
        $sm->build('foo');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchMultiDelegator()
    {
        $sm = clone $this->sm;
        $sm->get('multi_delegator');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchBuildMultiDelegator()
    {
        $sm = clone $this->sm;
        $sm->build('multi_delegator');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchDelegator()
    {
        $sm = clone $this->sm;
        $sm->get('delegator');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchBuildDelegator()
    {
        $sm = clone $this->sm;
        $sm->build('delegator');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     * @Revs(1000)
     */
    public function benchFetchLazyService()
    {
        $sm = clone $this->sm;
        $sm->get('lazy_service');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     * @Revs(1000)
     */
    public function benchBuildLazyService()
    {
        $sm = clone $this->sm;
        $sm->build('lazy_service');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchMultiDelegatorCached()
    {
        $sm = clone $this->smCached;
        $sm->get('multi_delegator');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchBuildMultiDelegatorCached()
    {
        $sm = clone $this->smCached;
        $sm->build('multi_delegator');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchDelegatorCached()
    {
        $sm = clone $this->smCached;
        $sm->get('delegator');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchBuildDelegatorCached()
    {
        $sm = clone $this->smCached;
        $sm->build('delegator');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchLazyServiceCached()
    {
        $sm = clone $this->smCached;
        $sm->get('lazy_service');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchBuildLazyServiceCached()
    {
        $sm = clone $this->smCached;
        $sm->build('lazy_service');
    }
}
