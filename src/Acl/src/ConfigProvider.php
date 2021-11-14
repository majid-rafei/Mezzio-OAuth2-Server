<?php

declare(strict_types=1);

namespace Acl;

use Acl\Handler\AclHandler;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\OAuth2\OAuth2Adapter;

/**
 * The configuration provider for the ACL module
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'routes' => $this->getRoutes(),
        ];
    }

    public function getRoutes(): array
    {
        return [
            [
                'path'            => '/acl',
                'name'            => 'acl',
                'middleware'      => [
                    AclHandler::class
                ],
                'allowed_methods' => ['POST'],
            ],
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\AclHandler::class => Handler\AclHandler::class,
            ],
            'factories'  => [
//                Handler\AclHandler::class => Handler\AclHandlerFactory::class,
            ],
            'aliases' => [
                AuthenticationInterface::class => OAuth2Adapter::class,
            ],
        ];
    }
}
