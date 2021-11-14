<?php

declare(strict_types=1);

namespace OAuth2;

use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\OAuth2\OAuth2Adapter;
use Mezzio\Authentication\OAuth2\TokenEndpointHandler;

/**
 * The configuration provider for the OAuth2 module
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
            /**
             * Step 1: Give access token: {
             *      route:  '/oauth2/token',
             *      Desc:   Base on grant_type, send username, password, and authorization grant type
             *              to this route with a GET or POST method to do an authentication
             *              and go to the next step,
             * }
             */
            [
                'name'            => 'oauth2.token',
                'path'            => '/oauth2/token',
                'middleware'      => TokenEndpointHandler::class,
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
            ],
            'factories'  => [
            ],
            'aliases' => [
                AuthenticationInterface::class => OAuth2Adapter::class,
            ],
        ];
    }
}
