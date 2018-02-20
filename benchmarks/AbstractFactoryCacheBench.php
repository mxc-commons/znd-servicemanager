<?php
/**
 * @link      https://github.com/zendframework/zend-servicemanager for the canonical source repository
 * @copyright Copyright (c) 2018 maxence operations gmbh, Germany
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
class AbstractFactoryCacheBench
{
    /**
     * @var ServiceManager
     */
    private $sm;
    private $smCached;

    public function __construct()
    {
        $this->sm = new ServiceManager([
            'abstract_factories' => [
                BenchAsset\AbstractFactoryFoo::class
            ]
        ]);
        $this->smCached = clone $this->sm;
        //initialize cache
        $this->smCached->build('foo');
    }

    /**
    * @todo @link https://github.com/phpbench/phpbench/issues/304
    */
    public function benchGetViaAbstractFactory()
    {
        $sm = clone $this->sm;

        $sm->get('foo');
    }

    /**
    * @todo @link https://github.com/phpbench/phpbench/issues/304
    */
    public function benchGetViaCachedAbstractFactory()
    {
        $sm = clone $this->smCached;

        $sm->get('foo');
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchIfHasThenGetViaAbstractFactory()
    {
        $sm = clone $this->sm;

        if ($sm->has('foo')) {
            $sm->get('foo');
        }
    }

    /**
     * @todo @link https://github.com/phpbench/phpbench/issues/304
     */
    public function benchIfHasThenGetViaCachedAbstractFactory()
    {
        $sm = clone $this->smCached;

        if ($sm->has('foo')) {
            $sm->get('foo');
        }
    }
}
