<?php
/**
 * @link      http://github.com/zendframework/zend-servicemanager for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\ServiceManager;

use DateTime;
use Interop\Container\Exception\ContainerException;
use ReflectionProperty;
use stdClass;
use Zend\ServiceManager\Exception\ContainerModificationsNotAllowedException;
use Zend\ServiceManager\Exception\CyclicAliasException;
use Zend\ServiceManager\Exception\InvalidArgumentException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\ServiceManager\Initializer\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZendTest\ServiceManager\TestAsset\AbstractFactoryFoo;
use ZendTest\ServiceManager\TestAsset\CallTimesAbstractFactory;
use ZendTest\ServiceManager\TestAsset\FailingAbstractFactory;
use ZendTest\ServiceManager\TestAsset\FailingExceptionWithStringAsCodeFactory;
use ZendTest\ServiceManager\TestAsset\FailingFactory;
use ZendTest\ServiceManager\TestAsset\InvokableObject;
use ZendTest\ServiceManager\TestAsset\PassthroughDelegatorFactory;
use ZendTest\ServiceManager\TestAsset\SampleFactory;
use ZendTest\ServiceManager\TestAsset\SimpleAbstractFactory;

use function call_user_func_array;
use function restore_error_handler;
use function set_error_handler;

trait CommonServiceLocatorBehaviorsTrait
{
    /**
     * The creation context container; used in some mocks for comparisons; set during createContainer.
     */
    protected $creationContext;

    abstract public function createContainer(array $config = []);

    public function testIsSharedByDefault()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => InvokableFactory::class
            ]
        ]);

        $object1 = $serviceManager->get(stdClass::class);
        $object2 = $serviceManager->get(stdClass::class);

        self::assertSame($object1, $object2);
    }

    public function testCanDisableSharedByDefault()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => InvokableFactory::class
            ],
            'shared_by_default' => false
        ]);

        $object1 = $serviceManager->get(stdClass::class);
        $object2 = $serviceManager->get(stdClass::class);

        self::assertNotSame($object1, $object2);
    }

    public function testCanDisableSharedForSingleService()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => InvokableFactory::class
            ],
            'shared' => [
                stdClass::class => false
            ]
        ]);

        $object1 = $serviceManager->get(stdClass::class);
        $object2 = $serviceManager->get(stdClass::class);

        self::assertNotSame($object1, $object2);
    }

    public function testCanEnableSharedForSingleService()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => InvokableFactory::class
            ],
            'shared_by_default' => false,
            'shared'            => [
                stdClass::class => true
            ]
        ]);

        $object1 = $serviceManager->get(stdClass::class);
        $object2 = $serviceManager->get(stdClass::class);

        self::assertSame($object1, $object2);
    }

    public function testCanBuildObjectWithInvokableFactory()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                InvokableObject::class => InvokableFactory::class
            ]
        ]);

        $object = $serviceManager->build(InvokableObject::class, ['foo' => 'bar']);

        self::assertInstanceOf(InvokableObject::class, $object);
        self::assertEquals(['foo' => 'bar'], $object->options);
    }

    public function testCanCreateObjectWithClosureFactory()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => function (ServiceLocatorInterface $serviceLocator, $className) {
                    self::assertEquals(stdClass::class, $className);
                    return new stdClass();
                }
            ]
        ]);

        $object = $serviceManager->get(stdClass::class);
        self::assertInstanceOf(stdClass::class, $object);
    }

    public function testCanCreateServiceWithAbstractFactory()
    {
        $serviceManager = $this->createContainer([
            'abstract_factories' => [
                new SimpleAbstractFactory()
            ]
        ]);

        self::assertInstanceOf(DateTime::class, $serviceManager->get(DateTime::class));
    }

    public function testAllowsMultipleInstancesOfTheSameAbstractFactory()
    {
        CallTimesAbstractFactory::setCallTimes(0);

        $obj1 = new CallTimesAbstractFactory();
        $obj2 = new CallTimesAbstractFactory();

        $serviceManager = $this->createContainer([
            'abstract_factories' => [
                $obj1,
                $obj2,
            ]
        ]);
        $serviceManager->addAbstractFactory($obj1);
        $serviceManager->addAbstractFactory($obj2);
        $serviceManager->has(stdClass::class);

        self::assertEquals(2, CallTimesAbstractFactory::getCallTimes());
    }

    public function testWillReUseAnExistingNamedAbstractFactoryInstance()
    {
        CallTimesAbstractFactory::setCallTimes(0);

        $serviceManager = $this->createContainer([
            'abstract_factories' => [
                CallTimesAbstractFactory::class,
                CallTimesAbstractFactory::class,
            ]
        ]);
        $serviceManager->addAbstractFactory(CallTimesAbstractFactory::class);
        $serviceManager->has(stdClass::class);

        self::assertEquals(1, CallTimesAbstractFactory::getCallTimes());
    }

    public function testCanCreateServiceWithAlias()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                InvokableObject::class => InvokableFactory::class
            ],
            'aliases' => [
                'foo' => InvokableObject::class,
                'bar' => 'foo'
            ]
        ]);

        $object = $serviceManager->get('bar');

        self::assertInstanceOf(InvokableObject::class, $object);
        self::assertTrue($serviceManager->has('bar'));
        self::assertFalse($serviceManager->has('baz'));
    }

    public function testCheckingServiceExistenceWithChecksAgainstAbstractFactories()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => InvokableFactory::class
            ],
            'abstract_factories' => [
                new SimpleAbstractFactory() // This one always return true
            ]
        ]);

        self::assertTrue($serviceManager->has(stdClass::class));
        self::assertTrue($serviceManager->has(DateTime::class));
    }

    public function testBuildNeverSharesInstances()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => InvokableFactory::class
            ],
            'shared' => [
                stdClass::class => true
            ]
        ]);

        $object1 = $serviceManager->build(stdClass::class);
        $object2 = $serviceManager->build(stdClass::class, ['foo' => 'bar']);

        self::assertNotSame($object1, $object2);
    }

    public function testInitializersAreRunAfterCreation()
    {
        $initializer = $this->getMockBuilder(InitializerInterface::class)
            ->getMock();

        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => InvokableFactory::class
            ],
            'initializers' => [
                $initializer
            ]
        ]);

        $initializer->expects($this->once())
                    ->method('__invoke')
                    ->with($this->creationContext, $this->isInstanceOf(stdClass::class));

        // We call it twice to make sure that the initializer is only called once

        $serviceManager->get(stdClass::class);
        $serviceManager->get(stdClass::class);
    }

    public function testThrowExceptionIfServiceCannotBeCreated()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => FailingFactory::class
            ]
        ]);

        self::expectException(ServiceNotCreatedException::class);

        $serviceManager->get(stdClass::class);
    }

    public function testThrowExceptionWithStringAsCodeIfServiceCannotBeCreated()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => FailingExceptionWithStringAsCodeFactory::class
            ]
        ]);

        self::expectException(ServiceNotCreatedException::class);

        $serviceManager->get(stdClass::class);
    }

    public function testConfigureCanAddNewServices()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                DateTime::class => InvokableFactory::class
            ]
        ]);

        self::assertTrue($serviceManager->has(DateTime::class));
        self::assertFalse($serviceManager->has(stdClass::class));

        $newServiceManager = $serviceManager->configure([
            'factories' => [
                stdClass::class => InvokableFactory::class
            ]
        ]);

        self::assertSame($serviceManager, $newServiceManager);

        self::assertTrue($newServiceManager->has(DateTime::class));
        self::assertTrue($newServiceManager->has(stdClass::class));
    }

    public function testConfigureCanOverridePreviousSettings()
    {
        $firstFactory  = $this->getMockBuilder(FactoryInterface::class)
            ->getMock();
        $secondFactory = $this->getMockBuilder(FactoryInterface::class)
            ->getMock();

        $serviceManager = $this->createContainer([
            'factories' => [
                DateTime::class => $firstFactory
            ]
        ]);

        $newServiceManager = $serviceManager->configure([
            'factories' => [
                DateTime::class => $secondFactory
            ]
        ]);

        self::assertSame($serviceManager, $newServiceManager);

        $firstFactory->expects($this->never())->method('__invoke');
        $secondFactory->expects($this->once())->method('__invoke');

        $newServiceManager->get(DateTime::class);
    }

    /**
     * @group has
     */
    public function testHasReturnsFalseIfServiceNotConfigured()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => InvokableFactory::class,
            ],
        ]);
        self::assertFalse($serviceManager->has('Some\Made\Up\Entry'));
    }

    /**
     * @group has
     */
    public function testHasReturnsTrueIfServiceIsConfigured()
    {
        $serviceManager = $this->createContainer([
            'services' => [
                stdClass::class => new stdClass,
            ],
        ]);
        self::assertTrue($serviceManager->has(stdClass::class));
    }

    /**
     * @group has
     */
    public function testHasReturnsTrueIfFactoryIsConfigured()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => InvokableFactory::class,
            ],
        ]);
        self::assertTrue($serviceManager->has(stdClass::class));
    }

    public function abstractFactories()
    {
        return [
            'simple'  => [new SimpleAbstractFactory(), true],
            'failing' => [new FailingAbstractFactory(), false],
        ];
    }

    /**
     * @group has
     * @dataProvider abstractFactories
     */
    public function testHasChecksAgainstAbstractFactories($abstractFactory, $expected)
    {
        $serviceManager = $this->createContainer([
            'abstract_factories' => [
                $abstractFactory,
            ],
        ]);

        self::assertSame($expected, $serviceManager->has(DateTime::class));
    }

    /**
     * @covers \Zend\ServiceManager\ServiceManager::configure
     */
    public function testCanConfigureAllServiceTypes()
    {
        $serviceManager = $this->createContainer([
            'services' => [
                'config' => ['foo' => 'bar'],
            ],
            'factories' => [
                stdClass::class => InvokableFactory::class,
            ],
            'delegators' => [
                stdClass::class => [
                    function ($container, $name, $callback) {
                        $instance = $callback();
                        $instance->foo = 'bar';
                        return $instance;
                    },
                ],
            ],
            'shared' => [
                'config'        => true,
                stdClass::class => true,
            ],
            'aliases' => [
                'Aliased' => stdClass::class,
            ],
            'shared_by_default' => false,
            'abstract_factories' => [
                new SimpleAbstractFactory(),
            ],
            'initializers' => [
                function ($container, $instance) {
                    if (! $instance instanceof stdClass) {
                        return;
                    }
                    $instance->bar = 'baz';
                },
            ],
        ]);

        $dateTime = $serviceManager->get(DateTime::class);
        self::assertInstanceOf(DateTime::class, $dateTime, 'DateTime service did not resolve as expected');
        $notShared = $serviceManager->get(DateTime::class);
        self::assertInstanceOf(DateTime::class, $notShared, 'DateTime service did not re-resolve as expected');
        self::assertNotSame(
            $dateTime,
            $notShared,
            'Expected unshared instances for DateTime service but received shared instances'
        );

        $config = $serviceManager->get('config');
        self::assertInternalType('array', $config, 'Config service did not resolve as expected');
        self::assertSame(
            $config,
            $serviceManager->get('config'),
            'Config service resolved as unshared instead of shared'
        );

        $stdClass = $serviceManager->get(stdClass::class);
        self::assertInstanceOf(stdClass::class, $stdClass, 'stdClass service did not resolve as expected');
        self::assertSame(
            $stdClass,
            $serviceManager->get(stdClass::class),
            'stdClass service should be shared, but resolved as unshared'
        );
        self::assertTrue(
            isset($stdClass->foo),
            'Expected delegator to inject "foo" property in stdClass service, but it was not'
        );
        self::assertEquals('bar', $stdClass->foo, 'stdClass "foo" property was not injected correctly');
        self::assertTrue(
            isset($stdClass->bar),
            'Expected initializer to inject "bar" property in stdClass service, but it was not'
        );
        self::assertEquals('baz', $stdClass->bar, 'stdClass "bar" property was not injected correctly');
    }

    /**
     * @covers \Zend\ServiceManager\ServiceManager::configure
     */
    public function testCanSpecifyAbstractFactoryUsingStringViaConfiguration()
    {
        $serviceManager = $this->createContainer([
            'abstract_factories' => [
                SimpleAbstractFactory::class,
            ],
        ]);

        $dateTime = $serviceManager->get(DateTime::class);
        self::assertInstanceOf(DateTime::class, $dateTime);
    }

    public function invalidFactories()
    {
        return [
            'null'                 => [null],
            'true'                 => [true],
            'false'                => [false],
            'zero'                 => [0],
            'int'                  => [1],
            'zero-float'           => [0.0],
            'float'                => [1.1],
            'array'                => [['foo', 'bar']],
            'non-invokable-object' => [(object) ['foo' => 'bar']],
        ];
    }

    public function invalidAbstractFactories()
    {
        $factories = $this->invalidFactories();
        $factories['non-class-string'] = ['non-callable-string', 'valid class name'];
        return $factories;
    }

    /**
     * @dataProvider invalidAbstractFactories
     * @covers \Zend\ServiceManager\ServiceManager::configure
     */
    public function testPassingInvalidAbstractFactoryTypeViaConfigurationRaisesException(
        $factory,
        $contains = 'invalid abstract factory'
    ) {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($contains);
        $this->createContainer([
            'abstract_factories' => [
                $factory,
            ],
        ]);
    }

    public function testCanSpecifyInitializerUsingStringViaConfiguration()
    {
        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => InvokableFactory::class,
            ],
            'initializers' => [
                TestAsset\SimpleInitializer::class,
            ],
        ]);

        $instance = $serviceManager->get(stdClass::class);
        self::assertInstanceOf(stdClass::class, $instance);
        self::assertTrue(isset($instance->foo), '"foo" property was not injected by initializer');
        self::assertEquals('bar', $instance->foo, '"foo" property was not properly injected');
    }

    public function invalidInitializers()
    {
        $factories = $this->invalidFactories();
        $factories['non-class-string'] = ['non-callable-string', 'callable or an instance of'];
        return $factories;
    }

    /**
     * @dataProvider invalidInitializers
     * @covers \Zend\ServiceManager\ServiceManager::configure
     */
    public function testPassingInvalidInitializerTypeViaConfigurationRaisesException(
        $initializer,
        $contains = 'invalid initializer'
    ) {
        $this->expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($contains);
        $sm = $this->createContainer([
            'factories' => [
                'factory' => SampleFactory::class,
            ],
            'initializers' => [
                $initializer,
            ],
        ]);
    }

    public function testGetRaisesExceptionWhenNoFactoryIsResolved()
    {
        $serviceManager = $this->createContainer();
        self::expectException(ContainerException::class);
        self::expectExceptionMessage('Unable to resolve');
        $serviceManager->get('Some\Unknown\Service');
    }

    public function invalidDelegators()
    {
        $invalidDelegators = $this->invalidFactories();
        $invalidDelegators['invalid-classname']   = ['not-a-class-name', 'invalid delegator'];
        $invalidDelegators['non-invokable-class'] = [stdClass::class];
        return $invalidDelegators;
    }

    /**
     * @dataProvider invalidDelegators
     * @covers \Zend\ServiceManager\ServiceManager::createServiceFromDelegator
     */
    public function testInvalidDelegatorShouldRaiseExceptionDuringCreation(
        $delegator,
        $contains = 'non-callable delegator'
    ) {
        $serviceManager = $this->createContainer([
            'factories' => [
                stdClass::class => InvokableFactory::class,
            ],
            'delegators' => [
                stdClass::class => [
                    $delegator,
                ],
            ],
        ]);

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($contains);
        $serviceManager->get(stdClass::class);
    }

    /**
     * @group mutation
     * @covers \Zend\ServiceManager\ServiceManager::setAlias
     */
    public function testCanInjectAliases()
    {
        $container = $this->createContainer([
            'factories' => [
                'foo' => function () {
                    return new stdClass;
                }
            ],
        ]);

        $container->setAlias('bar', 'foo');

        $foo = $container->get('foo');
        $bar = $container->get('bar');
        self::assertInstanceOf(stdClass::class, $foo);
        self::assertInstanceOf(stdClass::class, $bar);
        self::assertSame($foo, $bar);
    }

    /**
     * @group mutation
     * @covers \Zend\ServiceManager\ServiceManager::setInvokableClass
     */
    public function testCanInjectInvokables()
    {
        $container = $this->createContainer();
        $container->setInvokableClass('foo', stdClass::class);
        self::assertTrue($container->has('foo'));
        $foo = $container->get('foo');
        self::assertInstanceOf(stdClass::class, $foo);
    }

    /**
     * @group mutation
     * @covers \Zend\ServiceManager\ServiceManager::setFactory
     */
    public function testCanInjectFactories()
    {
        $instance  = new stdClass;
        $container = $this->createContainer();

        $container->setFactory('foo', function () use ($instance) {
            return $instance;
        });
        self::assertTrue($container->has('foo'));
        $foo = $container->get('foo');
        self::assertSame($instance, $foo);
    }

    /**
     * @group mutation
     * @covers \Zend\ServiceManager\ServiceManager::mapLazyService
     */
    public function testCanMapLazyServices()
    {
        $container = $this->createContainer();
        $container->mapLazyService('foo', __CLASS__);
        $r = new ReflectionProperty($container, 'lazyServicesClassMap');
        $r->setAccessible(true);
        $lazyServicesClassMap = $r->getValue($container);
        self::assertArrayHasKey('foo', $lazyServicesClassMap);
        self::assertEquals(__CLASS__, $lazyServicesClassMap['foo']);
    }

    /**
     * @group mutation
     * @covers \Zend\ServiceManager\ServiceManager::addAbstractFactory
     */
    public function testCanInjectAbstractFactories()
    {
        $container = $this->createContainer();
        $container->addAbstractFactory(TestAsset\SimpleAbstractFactory::class);
        // @todo Remove "true" flag once #49 is merged
        self::assertTrue($container->has(stdClass::class, true));
        $instance = $container->get(stdClass::class);
        self::assertInstanceOf(stdClass::class, $instance);
    }

    /**
     * @group mutation
     * @covers \Zend\ServiceManager\ServiceManager::addDelegator
     */
    public function testCanInjectDelegators()
    {
        $container = $this->createContainer([
            'factories' => [
                'foo' => function () {
                    return new stdClass;
                }
            ],
        ]);
        $container->addDelegator('foo', function ($container, $name, $callback) {
            $instance = $callback();
            $instance->name = $name;
            return $instance;
        });

        $foo = $container->get('foo');
        self::assertInstanceOf(stdClass::class, $foo);
        self::assertAttributeEquals('foo', 'name', $foo);
    }

    /**
     * @group mutation
     * @covers \Zend\ServiceManager\ServiceManager::addInitializer
     */
    public function testCanInjectInitializers()
    {
        $container = $this->createContainer([
            'factories' => [
                'foo' => function () {
                    return new stdClass;
                }
            ],
        ]);
        $container->addInitializer(function ($container, $instance) {
            if (! $instance instanceof stdClass) {
                return;
            }
            $instance->name = stdClass::class;
            return $instance;
        });

        $foo = $container->get('foo');
        self::assertInstanceOf(stdClass::class, $foo);
        self::assertAttributeEquals(stdClass::class, 'name', $foo);
    }

    /**
     * @group mutation
     * @covers \Zend\ServiceManager\ServiceManager::setService
     */
    public function testCanInjectServices()
    {
        $container = $this->createContainer();
        $container->setService('foo', $this);
        self::assertSame($this, $container->get('foo'));
    }

    /**
     * @group mutation
     * @covers \Zend\ServiceManager\ServiceManager::setShared
     */
    public function testCanInjectSharingRules()
    {
        $container = $this->createContainer([
            'factories' => [
                'foo' => function () {
                    return new stdClass;
                }
            ],
        ]);
        $container->setShared('foo', false);
        $first  = $container->get('foo');
        $second = $container->get('foo');
        self::assertNotSame($first, $second);
    }

    public function methodsAffectedByOverrideSettings()
    {
        // @codingStandardsIgnoreStart
        //  name                        => [ 'method to invoke',  [arguments for invocation]]
        return [
            'setAlias'                  => ['setAlias',           ['foo', 'bar']],
            'setInvokableClass'         => ['setInvokableClass',  ['foo', __CLASS__]],
            'setFactory'                => ['setFactory',         ['foo', function () {}]],
            'setService'                => ['setService',         ['foo', $this]],
            'setShared'                 => ['setShared',          ['foo', false]],
            'mapLazyService'            => ['mapLazyService',     ['foo', __CLASS__]],
            'addDelegator'              => ['addDelegator',       ['foo', function () {}]],
            'configure-alias'           => ['configure',          [['aliases'       => ['foo' => 'bar']]]],
            'configure-invokable'       => ['configure',          [['invokables'    => ['foo' => 'foo']]]],
            'configure-invokable-alias' => ['configure',          [['invokables'    => ['foo' => 'bar']]]],
            'configure-factory'         => ['configure',          [['factories'     => ['foo' => function () {}]]]],
            'configure-service'         => ['configure',          [['services'      => ['foo' => $this]]]],
            'configure-shared'          => ['configure',          [['shared'        => ['foo' => false]]]],
            'configure-lazy-service'    => ['configure',          [['lazy_services' => ['class_map' => ['foo' => __CLASS__]]]]],
        ];
        // @codingStandardsIgnoreEnd
    }

    /**
     * @dataProvider methodsAffectedByOverrideSettings
     * @group mutation
     */
    public function testConfiguringInstanceRaisesExceptionIfAllowOverrideIsFalse($method, $args)
    {
        $container = $this->createContainer(['services' => ['foo' => $this]]);
        $container->setAllowOverride(false);
        self::expectException(ContainerModificationsNotAllowedException::class);
        call_user_func_array([$container, $method], $args);
    }

    /**
     * @group mutation
     */
    public function testAllowOverrideFlagIsFalseByDefault()
    {
        $container = $this->createContainer();
        self::assertFalse($container->getAllowOverride());
        return $container;
    }

    /**
     * @group mutation
     * @depends testAllowOverrideFlagIsFalseByDefault
     */
    public function testAllowOverrideFlagIsMutable($container)
    {
        $container->setAllowOverride(true);
        self::assertTrue($container->getAllowOverride());
    }

    /**
     * @group migration
     */
    public function testCanRetrieveParentContainerViaGetServiceLocatorWithDeprecationNotice()
    {
        $container = $this->createContainer();
        set_error_handler(function ($errno, $errstr) {
            self::assertEquals(E_USER_DEPRECATED, $errno);
        }, E_USER_DEPRECATED);
        self::assertSame($this->creationContext, $container->getServiceLocator());
        restore_error_handler();
    }

    /**
     * @group zendframework/zend-servicemanager#83
     */
    public function testCrashesOnCyclicAliases()
    {
        self::expectException(CyclicAliasException::class);

        $this->createContainer([
            'aliases' => [
                'a' => 'b',
                'b' => 'a',
            ],
        ]);
    }

    public function testMinimalCyclicAliasDefinitionShouldThrow()
    {
        $sm = $this->createContainer([]);

        self::expectException(CyclicAliasException::class);
        $sm->setAlias('alias', 'alias');
    }

    /**
     * @covers \Zend\ServiceManager\Exception\InvalidArgunmentException::fromInvalidFactory
     */
    public function testThrowOnFactoriesNotImplementingFactoryInterface()
    {
        $sm = $this->createContainer([
            'factories' => [
                'wrongFactory' => InvokableObject::class,
            ],
        ]);
        self::expectException(InvalidArgumentException::class);
        $sm->get('wrongFactory');
    }

    public function testThrowOnDelegatorsNotImplementingDelegatorFactoryInterface()
    {
        $sm = $this->createContainer([
            'factories' => [
                'delegator' => SampleFactory::class,
            ],
            'delegators' => [
                'delegator' => [
                    InvokableObject::class
                ],
            ],
        ]);
        self::expectException(InvalidArgumentException::class);
        $sm->get('delegator');
    }

    public function testThrowOnInitializersNotImplementingInitializerInterface()
    {
        self::expectException(InvalidArgumentException::class);
        $sm = $this->createContainer([
            'initializers' => [
                InvokableObject::class
            ]
        ]);
    }

    public function testCoverageDepthFirstTaggingOnRecursiveAliasDefinitions()
    {
        $sm = $this->createContainer([
            'factories' => [
                stdClass::class => InvokableFactory::class,
            ],
            'aliases' => [
                'alias1' => 'alias2',
                'alias2' => 'alias3',
                'alias3' => stdClass::class,
            ],
        ]);
        self::assertSame($sm->get('alias1'), $sm->get('alias2'));
        self::assertSame($sm->get(stdClass::class), $sm->get('alias1'));
    }

    /**
     * The ServiceManager can change internal state on calls to get,
     * build or has, latter not currently. Possible state changes
     * are caching a factory, registering a service produced by
     * a factory, ...
     *
     * This tests performs three consecutive calls to build/get for
     * each registered service to push the service manager through
     * all internal states, thereby verifying that build/get/has
     * remain stable through the internal states.
     *
     * @dataProvider provideConsistencyOverInternalStatesTests
     *
     * @param ContainerInterface $smTemplate
     * @param string $name
     * @param array[] string $test
     */
    public function testConsistencyOverInternalStates($smTemplate, $name, $test, $shared)
    {
        $sm = clone $smTemplate;
        $object['get'] = [];
        $object['build'] = [];

        // call get()/build() and store the retrieved
        // objects in $object['get'] or $object['build']
        // respectively
        foreach ($test as $method) {
            $obj = $sm->$method($name);
            $object[$shared ? $method : 'build'][] = $obj;
            self::assertNotNull($obj);
            self::assertTrue($sm->has($name));
        }

        // compares the first to the first also, but ok
        foreach ($object['get'] as $sharedObj) {
            self::assertSame($object['get'][0], $sharedObj);
        }
        // objects from object['build'] have to be different
        // from all other objects
        foreach ($object['build'] as $idx1 => $nonSharedObj1) {
            self::assertNotContains($nonSharedObj1, $object['get']);
            foreach ($object['build'] as $idx2 => $nonSharedObj2) {
                if ($idx1 !== $idx2) {
                    self::assertNotSame($nonSharedObj1, $nonSharedObj2);
                }
            }
        }
    }

    /**
     * Data provider
     *
     * @see testConsistencyOverInternalStates above
     *
     * @param ContainerInterface $smTemplate
     * @param string $name
     * @param string[] $test
     */
    public function provideConsistencyOverInternalStatesTests()
    {
        $config1 = [
            'factories' => [
                // to allow build('service')
                'service' => function ($container, $requestedName, array $options = null) {
                    return new stdClass();
                },
                'factory' => SampleFactory::class,
                'delegator' => SampleFactory::class,
            ],
            'delegators' => [
                'delegator' => [
                   PassthroughDelegatorFactory::class,
                ],
            ],
            'invokables' => [
                'invokable' => InvokableObject::class,
            ],
            'services' => [
                'service' => new stdClass(),
            ],
            'aliases' => [
                'serviceAlias'          => 'service',
                'invokableAlias'        => 'invokable',
                'factoryAlias'          => 'factory',
                'abstractFactoryAlias'  => 'foo',
                'delegatorAlias'        => 'delegator',
            ],
            'abstract_factories' => [
                AbstractFactoryFoo::class
            ]
        ];
        $config2 = $config1;
        $config2['shared_by_default'] = false;

        $configs = [ $config1, $config2 ];

        foreach ($configs as $config) {
            $smTemplates[] = $this->createContainer($config);
        }

        // produce all 3-tuples of 'build' and 'get', i.e.
        //
        // [['get', 'get', 'get'], ['get', 'get', 'build'], ...
        // ['build', 'build', 'build']]
        //
        $methods = ['get', 'build'];
        foreach ($methods as $method1) {
            foreach ($methods as $method2) {
                foreach ($methods as $method3) {
                    $callSequences[] = [$method1, $method2, $method3];
                }
            }
        }

        foreach ($configs as $config) {
            $smTemplate = $this->createContainer($config);

            // setup sharing, services are always shared
            $names = array_fill_keys(array_keys($config['services']), true);

            // initialize the other keys with shared_by_default
            // and merge them
            $names = array_merge(array_fill_keys(array_keys(array_merge(
                $config['factories'],
                $config['invokables'],
                $config['aliases'],
                $config['delegators']
            )), $config['shared_by_default'] ?? true), $names);

            // add the key resolved by the abstract factory
            $names['foo'] = $config['shared_by_default'] ?? true;

            // adjust shared setting for individual keys from
            // $shared array if present
            if (! empty($config['shared'])) {
                foreach ($config['shared'] as $name => $shared) {
                    $names[$name] = $shared;
                }
            }

            foreach ($names as $name => $shared) {
                foreach ($callSequences as $callSequence) {
                    $sm = clone $smTemplate;
                    $tests[] = [$smTemplate, $name, $callSequence, $shared];
                }
            }
        }
        return $tests;
    }
}
