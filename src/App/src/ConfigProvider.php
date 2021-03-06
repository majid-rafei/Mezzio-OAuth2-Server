<?php

declare(strict_types=1);

namespace App;

use Mezzio\Authentication\AuthenticationMiddleware;
use Mezzio\Authentication\OAuth2\AuthorizationMiddleware;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
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
                'path'            => '/logout',
                'name'            => 'logout',
                'middleware'      => [
                    AuthenticationMiddleware::class,
                    AuthorizationMiddleware::class,
                ],
                'allowed_methods' => ['GET'],
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
            ],
            'factories'  => [
            ],
            'aliases' => [
            ],
        ];
    }
}
