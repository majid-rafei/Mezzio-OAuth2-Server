<?php


namespace Auth;


use Interop\Container\ContainerInterface;
//use Zend\Authentication\AuthenticationService;

class AuthAdapterFactory
{
    public function __invoke(ContainerInterface $container) : AuthAdapter
    {
        // Retrieve any dependencies from the container when creating the instance
        return new AuthAdapter(/* any dependencies */);
    }
}