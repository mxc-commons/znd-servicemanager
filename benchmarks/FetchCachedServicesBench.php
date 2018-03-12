<?php
/**
 * @link      https://github.com/mxc-commons/mxc-servicemanager for the canonical source repository
 * @copyright Copyright (c) 2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright Copyright (c) 2018 maxence operations gmbh, Germany
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendBench\ServiceManager;

use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;
use PhpBench\Benchmark\Metadata\Annotations\Warmup;
use stdClass;
use Zend\ServiceManager\Proxy\LazyServiceFactory;
use Zend\ServiceManager\ServiceManager;
use ZendBench\ServiceManager\BenchAsset\DelegatorFactory;

/**
 * @Revs(1000000)
 * @Iterations(20)
 * @Warmup(2)
 */
class FetchCachedServicesBench
{
    /**
     * @var ServiceManager
     */
    private $sm;

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
                'service1' => new stdClass(),
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

        // force caching of all services
        $this->sm->get('factory1');
        $this->sm->get('invokable1');
        $this->sm->get('service1');
        $this->sm->get('factoryAlias1');
        $this->sm->get('recursiveFactoryAlias1');
        $this->sm->get('recursiveFactoryAlias2');
        $this->sm->get('foo');
        $this->sm->get('delegator');
        $this->sm->get('multi_delegator');
        $this->sm->get('lazy_service');
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
    public function benchFetchInvokable1()
    {
        $sm = clone $this->sm;
        $sm->get('invokable1');
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
    public function benchFetchAlias1()
    {
        $sm = clone $this->sm;
        $sm->get('factoryAlias1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchRecursiveAlias1()
    {
        $sm = clone $this->sm;
        $sm->get('recursiveFactoryAlias1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchRecursiveAlias2()
    {
        $sm = clone $this->sm;
        $sm->get('recursiveFactoryAlias2');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchAbstractFactoryService()
    {
        $sm = clone $this->sm;
        $sm->get('foo');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchMultiDelegatorService()
    {
        $sm = clone $this->sm;
        $sm->get('multi_delegator');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchDelegatorService()
    {
        $sm = clone $this->sm;
        $sm->get('delegator');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchFetchLazyService()
    {
        $sm = clone $this->sm;
        $sm->get('delegator');
    }
}
