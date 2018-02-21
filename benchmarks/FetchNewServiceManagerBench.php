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
use Zend\ServiceManager\ServiceManager;
use ZendBench\ServiceManager\BenchAsset\DelegatorFactory;

/**
 * @Revs(500)
 * @Iterations(20)
 * @Warmup(2)
 */
class FetchNewServiceManagerBench
{
    const NUM_SERVICES = 1000;

    /**
     * @var array
     */
    private $config = [];

    public function __construct()
    {
        $config = [
            'factories'          => [],
            'invokables'         => [],
            'delegators'         => [],
            'services'           => [],
            'aliases'            => [],
            'abstract_factories' => [
                BenchAsset\AbstractFactoryFoo::class,
            ],
        ];

        $service = new \stdClass();

        for ($i = 0; $i < self::NUM_SERVICES; $i++) {
            $config['services']["service_$i"]     = $service;
            $config['aliases']["alias_$i"]        = "service_$i";
            $config['factories']["factory_$i"]    = BenchAsset\FactoryFoo::class;
            $config['invokables']["invokable_$i"] = BenchAsset\Foo::class;
        }
        for ($i = self::NUM_SERVICES; $i < self::NUM_SERVICES * 2; $i++) {
             $config['factories']["factory_$i"]    = BenchAsset\FactoryFoo::class;
             $config['delegators']["factory_$i"]   = [ DelegatorFactory::class, DelegatorFactory::class];
        }
        $this->config = $config;
    }

    public function benchFetchServiceManagerCreation()
    {
        new ServiceManager($this->config);
    }
}
