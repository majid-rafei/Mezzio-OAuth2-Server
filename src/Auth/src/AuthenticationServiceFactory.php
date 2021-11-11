<?php
//
//
//namespace Auth;
//
//use Interop\Container\ContainerInterface;
//use Mezzio\Authentication\AuthenticationMiddleware;
//
////use Laminas\Authentication\AuthenticationService;
//
//class AuthenticationServiceFactory
//{
//    public function __invoke(ContainerInterface $container)
//    {
//        return new AuthenticationMiddleware(
//            null,
//            $container->get(MyAuthAdapter::class)
//        );
//    }
//}