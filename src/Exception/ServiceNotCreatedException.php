<?php
/**
 * @link      http://github.com/zendframework/zend-servicemanager for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\ServiceManager\Exception;

use Interop\Container\Exception\ContainerException;
use RuntimeException as SplRuntimeException;
use Zend\ServiceManager\Factory\DelegatorFactoryInterface;

/**
 * This exception is thrown when the service locator do not manage to create
 * the service (factory that has an error...)
 */
class ServiceNotCreatedException extends SplRuntimeException implements
    ContainerException,
    ExceptionInterface
{
    public static function fromException($name, $exception)
    {
        return new self(sprintf(
            'Service with name "%s" could not be created. Reason: %s',
            $name,
            $exception->getMessage()
        ), (int) $exception->getCode(), $exception);
    }

    public static function fromInvalidClass($name)
    {
        return new self(sprintf(
            'An invalid delegator factory was registered; resolved to class or function "%s" '
            . 'which does not exist; please provide a valid function name or class name resolving '
            . 'to an implementation of %s',
            $name,
            DelegatorFactoryInterface::class
        ));
    }

    public static function fromInvalidInstance($name)
    {
        return new self(sprintf(
            'A non-callable delegator, "%s", was provided; expected a callable or instance of "%s"',
            is_object($name) ? get_class($name) : gettype($name),
            DelegatorFactoryInterface::class
        ));
    }
}
