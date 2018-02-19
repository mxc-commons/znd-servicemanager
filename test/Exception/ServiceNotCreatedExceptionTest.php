<?php
/**
 * @link      https://github.com/zendframework/zend-servicemanager for the canonical source repository
 * @copyright Copyright (c) 2018 maxence operations gmbh, Germany
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\ServiceManager\Exception;

use stdClass;
use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Factory\DelegatorFactoryInterface;

/**
 * @covers \Zend\ServiceManager\Exception\ServiceNotCreatedException
 */
class ServiceNotCreatedExceptionTest extends TestCase
{
    public static function testFromException()
    {
        $subException = ServiceNotFoundException::fromUnknownService(stdClass::class);
        $exception = ServiceNotCreatedException::fromException(stdClass::class, $subException);

        self::assertInstanceOf(ServiceNotCreatedException::class, $exception);
        self::assertSame(
            sprintf('Service with name "stdClass" could not be created. Reason: %s', $subException->getMessage()),
            $exception->getMessage()
        );
    }
}
