<?php
/**
 * @link      http://github.com/zendframework/zend-servicemanager for the canonical source repository
 * @copyright Copyright (c) 2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendBench\ServiceManager;

use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;
use PhpBench\Benchmark\Metadata\Annotations\Warmup;
use Zend\ServiceManager\ServiceManager;

/**
 * @Revs(100000)
 * @Iterations(20)
 * @Warmup(2)
 */
class HasBench
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
            ],
            'invokables' => [
                'invokable1' => BenchAsset\Foo::class,
            ],
            'services' => [
                'service1' => new \stdClass(),
            ],
            'aliases' => [
                'alias1'          => 'service1',
                'recursiveAlias1' => 'alias1',
                'recursiveAlias2' => 'recursiveAlias1',
            ],
            'abstract_factories' => [
                BenchAsset\AbstractFactoryFoo::class
            ],
        ]);
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchHasFactory1()
    {
        $sm = clone $this->sm;
        $sm->has('factory1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchHasInvokable1()
    {
        $sm = clone $this->sm;
        $sm->has('invokable1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchHasService1()
    {

        $sm = clone $this->sm;
        $sm->has('service1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchHasAlias1()
    {
        $sm = clone $this->sm;
        $sm->has('alias1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchHasRecursiveAlias1()
    {
        $sm = clone $this->sm;
        $sm->has('recursiveAlias1');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchHasRecursiveAlias2()
    {
        $sm = clone $this->sm;
        $sm->has('recursiveAlias2');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchHasAbstractFactory()
    {
        $sm = clone $this->sm;
        $sm->has('foo');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchHasNot()
    {
        $sm = clone $this->sm;
        $sm->has('42');
    }
}
