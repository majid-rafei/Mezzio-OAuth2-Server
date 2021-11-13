<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;
use Mezzio\Authentication\OAuth2;
use Mezzio\Session\SessionMiddleware;

/**
 * laminas-router route configuration
 *
 * @see https://docs.laminas.dev/laminas-router/
 *
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Mezzio\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    /**
     * Step 1: Authorization: {
     *   route: '/oauth' -> Base on grant_type, send username, password, and authorization grant type
     *                      to this route with a GET or POST method to do an authentication
     *                      and go to the next step,
     * }
     */
    $app->post('/oauth2/token', OAuth2\TokenEndpointHandler::class);
};
