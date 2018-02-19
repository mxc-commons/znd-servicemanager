<?php
/**
 * @link      https://github.com/zendframework/zend-servicemanager for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\ServiceManager\Exception;

use PHPUnit\Framework\TestCase;
use stdClass;
use Zend\ServiceManager\Initializer\InitializerInterface;
use Zend\ServiceManager\Exception\InvalidArgumentException;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\Factory\DelegatorFactoryInterface;

/**
 * @covers \Zend\ServiceManager\Exception\InvalidArgumentException
 */
class InvalidArgumentExceptionTest extends TestCase
{
    public function testFromInvalidInitializer()
    {
        $exception = InvalidArgumentException::fromInvalidInitializer(new stdClass());
        $this->assertInstanceOf(InvalidArgumentException::class, $exception);
        $this->assertSame(
            'An invalid initializer was registered. Expected a valid function name, '
            . 'class name, a callable or an instance of "'. InitializerInterface::class
            . '", but "stdClass" was received.',
            $exception->getMessage()
        );
    }

    public function testFromInvalidAbstractFactory()
    {
        $exception = InvalidArgumentException::fromInvalidAbstractFactory(new stdClass());
        $this->assertInstanceOf(InvalidArgumentException::class, $exception);
        $this->assertSame('An invalid abstract factory was registered. Expected an instance of or a valid'
            . ' class name resolving to an implementation of "'. AbstractFactoryInterface::class
            . '", but "stdClass" was received.', $exception->getMessage());
    }

    public function testFromInvalidDelegatorFactoryClass()
    {
        $exception = InvalidArgumentException::fromInvalidDelegatorFactoryClass(stdClass::class);
        self::assertInstanceOf(InvalidArgumentException::class, $exception);
        self::assertSame(
            sprintf(
                'An invalid delegator factory was registered; resolved to class or function "%s" '
                . 'which does not exist; please provide a valid function name or class name resolving '
                . 'to an implementation of %s',
                stdClass::class,
                DelegatorFactoryInterface::class
            ),
            $exception->getMessage()
        );
    }

    public function testFromInvalidDelegatorFactoryInstance()
    {
        $exception = InvalidArgumentException::fromInvalidDelegatorFactoryInstance(stdClass::class);
        self::assertInstanceOf(InvalidArgumentException::class, $exception);
        self::assertSame(
            sprintf(
                'A non-callable delegator, "%s", was provided; expected a callable or instance of "%s"',
                'string',
                DelegatorFactoryInterface::class
            ),
            $exception->getMessage()
        );
    }
}
