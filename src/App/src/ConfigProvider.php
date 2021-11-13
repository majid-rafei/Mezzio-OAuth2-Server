<?php

declare(strict_types=1);

namespace App;

use App\Handler\HomePageHandler;
use App\Handler\PingHandler;
use App\Middleware\Factory\OAuthMiddlewareFactory;
use App\Middleware\OAuthMiddleware;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\AuthenticationMiddleware;
use Mezzio\Authentication\OAuth2\OAuth2Adapter;

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
            'templates'    => $this->getTemplates(),
            'routes' => $this->getRoutes(),
        ];
    }

    public function getRoutes(): array
    {
        return [
            [
                'path'            => '/',
                'name'            => 'home',
                'middleware'      => [HomePageHandler::class],
                'allowed_methods' => ['GET'],
            ],
            [
                'path'            => '/api/ping',
                'name'            => 'api.ping',
                'middleware'      => [
                    AuthenticationMiddleware::class,
                    PingHandler::class,
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
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
            ],
            'aliases' => [
                AuthenticationInterface::class => OAuth2Adapter::class,
            ],
//            'delegators' => [
//                \Mezzio\Application::class => [
//                    \Mezzio\Container\ApplicationConfigInjectionDelegator::class,
//                ]
//            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
