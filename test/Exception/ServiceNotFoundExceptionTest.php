<?php

namespace ZendTest\ServiceManager\Exception;

use stdClass;
use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

/**
 * @covers \Zend\ServiceManager\Exception\ServiceNotFoundException
 */
class ServiceNotFoundExceptionTest extends TestCase
{
    public function testFromUnknownService()
    {
        $exception = ServiceNotFoundException::fromUnknownService(stdClass::class);
        self::assertInstanceOf(ServiceNotFoundException::class, $exception);
        self::assertSame(
            'Unable to resolve service "stdClass" to a factory; are you certain you provided it during configuration?',
            $exception->getMessage()
        );
    }
}
