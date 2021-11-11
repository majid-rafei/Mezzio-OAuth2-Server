<?php


namespace Auth\Middleware;

use Auth\AuthAdapter;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Expressive\Template\TemplateRendererInterface;

class LoginMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LoginAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(AuthenticationService::class),
            $container->get(AuthAdapter::class)
        );
    }
}
