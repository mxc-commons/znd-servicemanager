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
 * @Revs(100)
 * @Iterations(20)
 * @OutputTimeUnit("milliseconds", precision=3)
 * @Warmup(2)
 */
class Usage500Bench
{
    const NUM_SERVICES = 500;

    /**
     * @var array
     */
    private $sm;
    private $config;

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
            $config['aliases']["alias_$i"]        = "factory_$i";
            $config['factories']["factory_$i"]    = BenchAsset\FactoryFoo::class;
            $config['invokables']["invokable_$i"] = BenchAsset\Foo::class;
        }
        for ($i = self::NUM_SERVICES; $i < self::NUM_SERVICES + 1000; $i++) {
             $config['factories']["factory_$i"]    = BenchAsset\FactoryFoo::class;
             $config['delegators']["factory_$i"]   = [ DelegatorFactory::class, DelegatorFactory::class];
        }

        $this->sm = new ServiceManager($config);
        $this->config = $config;

        $this->sm2 = clone $this->sm;
        for ($i = 0; $i < self::NUM_SERVICES; $i++) {
            $this->sm2->get("service_$i");
            $this->sm2->build("alias_$i");
            $this->sm2->build("factory_$i");
            $this->sm2->build("invokable_$i");
        }
        for ($i = self::NUM_SERVICES; $i < self::NUM_SERVICES + self::NUM_SERVICES; $i++) {
            $this->sm2->build("factory_$i");
        }
        $this->sm3 = clone $this->sm2;
        for ($k = 1; $k < 3; $k++) {
            for ($i = 0; $i < self::NUM_SERVICES; $i++) {
                $this->sm3->get("service_$i");
                $this->sm3->build("alias_$i");
                $this->sm3->build("factory_$i");
                $this->sm3->build("invokable_$i");
            }
            for ($i = self::NUM_SERVICES; $i < self::NUM_SERVICES + self::NUM_SERVICES; $i++) {
                $this->sm3->build("factory_$i");
            }
        }
    }

    /**
     * @OutputTimeUnit("microseconds", precision=3)
     * @Revs(500)
     */
    public function benchFetchNewServiceManager()
    {
        $sm = new ServiceManager($this->config);
    }

    public function benchFetchEachServiceOnce()
    {
        $sm = clone $this->sm;

        for ($i = 0; $i < self::NUM_SERVICES; $i++) {
            $sm->get("service_$i");
            $sm->build("alias_$i");
            $sm->build("factory_$i");
            $sm->build("invokable_$i");
        }
        for ($i = self::NUM_SERVICES; $i < self::NUM_SERVICES * 2; $i++) {
            $sm->build("factory_$i");
        }
    }

    public function benchFetchEachServiceTwice()
    {
        $sm = clone $this->sm2;

        for ($i = 0; $i < self::NUM_SERVICES; $i++) {
            $sm->get("service_$i");
            $sm->build("alias_$i");
            $sm->build("factory_$i");
            $sm->build("invokable_$i");
        }
        for ($i = self::NUM_SERVICES; $i < self::NUM_SERVICES * 2; $i++) {
            $sm->build("factory_$i");
        }
    }

    public function benchFetchEachServiceThreeTimes()
    {
        $sm = clone $this->sm3;

        for ($i = 0; $i < self::NUM_SERVICES; $i++) {
            $sm->get("service_$i");
            $sm->build("alias_$i");
            $sm->build("factory_$i");
            $sm->build("invokable_$i");
        }
        for ($i = self::NUM_SERVICES; $i < self::NUM_SERVICES * 2; $i++) {
            $sm->build("factory_$i");
        }
    }

    public function benchFullCycleBuild()
    {
        $sm = new ServiceManager($this->config);

        for ($cycle = 0; $cycle < 3; $cycle++) {
            for ($i = 0; $i < self::NUM_SERVICES; $i++) {
                $sm->get("service_$i");
                $sm->build("alias_$i");
                $sm->build("factory_$i");
                $sm->build("invokable_$i");
            }
            for ($i = self::NUM_SERVICES; $i < self::NUM_SERVICES * 2; $i++) {
                $sm->build("factory_$i");
            }
        }
    }

    public function benchFullCycleGet()
    {
        $sm = new ServiceManager($this->config);

        for ($cycle = 0; $cycle < 3; $cycle++) {
            for ($i = 0; $i < self::NUM_SERVICES; $i++) {
                $sm->get("service_$i");
                $sm->get("alias_$i");
                $sm->get("factory_$i");
                $sm->get("invokable_$i");
            }
            for ($i = self::NUM_SERVICES; $i < self::NUM_SERVICES * 2; $i++) {
                $sm->get("factory_$i");
            }
        }
    }
}
