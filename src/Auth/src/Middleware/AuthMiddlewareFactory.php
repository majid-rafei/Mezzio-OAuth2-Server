<?php


namespace Auth\Middleware;

use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Exception;

class AuthMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuthMiddleware($container->get(AuthenticationService::class));
    }
}