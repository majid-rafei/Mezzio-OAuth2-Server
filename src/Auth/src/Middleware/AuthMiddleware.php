<?php


namespace Auth\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Mezzio\Authentication\AuthenticationInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Diactoros\Response\RedirectResponse;

class AuthMiddleware implements MiddlewareInterface
{
    private $auth;

    public function __construct(AuthenticationInterface $auth)
    {
        $this->auth = $auth;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        if (! $this->auth->hasIdentity()) {
            return new RedirectResponse('/login');
        }

        $identity = $this->auth->getIdentity();
        return $handler->process($request->withAttribute(self::class, $identity));
    }
}
