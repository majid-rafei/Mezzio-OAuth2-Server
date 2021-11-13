<?php


namespace App\Middleware\Factory;


use App\Middleware\OAuthAuthorizationMiddleware;

class OAuthAuthorizationMiddlewareFactory
{
    public function __invoke()
    {
        // TODO: Implement __invoke() method.
        return new OAuthAuthorizationMiddleware();
    }

}