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
use stdClass;
use Zend\ServiceManager\ServiceManager;
use ZendBench\ServiceManager\BenchAsset\DelegatorFactory;

/**
 * @Revs(50000)
 * @Iterations(20)
 * @OutputTimeUnit("microseconds", precision=3)
 * @Warmup(2)
 */
class CreateSingleFeaturedServiceManagerBench
{
    const NUM_SERVICES = 250;

    /**
     * @var array
     */
    private $configServices;
    private $configAliases;
    private $configDelegators;
    private $configFactories;
    private $configInvokables;

    public function __construct()
    {
        $service = new stdClass();
        $this->configAliases['factories']["factory"] = BenchAsset\FactoryFoo::class;

        for ($i = 0; $i < self::NUM_SERVICES; $i++) {
            $this->configServices['services']["service_$i"] = $service;
            $this->configFactories['factories']["factory_$i"] = BenchAsset\FactoryFoo::class;
            $j = $i - 1;
            $this->configAliases['aliases']["alias_$i"] = $i === 0 ? "factory" : "alias_$j";
            $this->configInvokables['invokables']["invokable_$i"] = BenchAsset\Foo::class;
            $this->configDelegators['factories']["factory_$i"]    = BenchAsset\FactoryFoo::class;
            $this->configDelegators['delegators']["factory_$i"]   = [ DelegatorFactory::class, DelegatorFactory::class];
        }
    }

    public function benchCreateNewServiceManagerWithServicesOnly()
    {
        new ServiceManager($this->configServices);
    }

    /**
     * @Revs(250)
     */
    public function benchCreateNewServiceManagerWithAliasesOnly()
    {
        new ServiceManager($this->configAliases);
    }

    /**
     * @Revs(25000)
     */
    public function benchCreateNewServiceManagerWithDelegatorsOnly()
    {
        new ServiceManager($this->configDelegators);
    }

    public function benchCreateNewServiceManagerWithFactoriesOnly()
    {
        new ServiceManager($this->configFactories);
    }

    /**
     * @Revs(10000)
     */
    public function benchCreateNewServiceManagerWithInvokablesOnly()
    {
        new ServiceManager($this->configInvokables);
    }
}
