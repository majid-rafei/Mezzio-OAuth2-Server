<?php

declare(strict_types=1);

namespace Auth;

//use App\Middleware\Factory\OAuthMiddlewareFactory;
//use App\Middleware\OAuthMiddleware;
//use Auth\AuthenticationServiceFactory;
//use Auth\MyAuthAdapter;
//use Auth\MyAuthAdapterFactory;
//use Zend\Authentication\AuthenticationService;
use App\Handler\HomePageHandler;
use App\Handler\PingHandler;
use Auth\Middleware\AuthMiddleware;
use Auth\Middleware\AuthMiddlewareFactory;
use Auth\Middleware\LoginMiddleware;
use Auth\Middleware\LoginMiddlewareFactory;

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
        ];
    }

    public function getRoutes(): array
    {
        return [
            [
                'path' => '/login',
                'name' => 'login',
                'middleware' => [LoginMiddleware::class],
                'allowed_methods' => ['GET', 'POST'],
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
                AuthMiddleware::class => AuthMiddlewareFactory::class,
                LoginMiddleware::class => LoginMiddlewareFactory::class,
//                AuthenticationService::class => AuthenticationServiceFactory::class,
                AuthAdapter::class => AuthAdapterFactory::class,
            ],
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
