<?php
/**
 * @link      https://github.com/zendframework/zend-servicemanager for the canonical source repository
 * @copyright Copyright (c) 2018, maxence operations gmbh, Germany
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

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
