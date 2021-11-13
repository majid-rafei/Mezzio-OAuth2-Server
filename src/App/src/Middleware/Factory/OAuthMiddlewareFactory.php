<?php


namespace App\Middleware\Factory;


use App\Middleware\OAuthMiddleware;
use Laminas\Stdlib\RequestInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class OAuthMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        // TODO: Implement __invoke() method.
        return new OAuthMiddleware();
    }

}