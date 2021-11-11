<?php

namespace Auth\Middleware;

use Auth\AuthAdapter;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Mezzio\Authentication\AuthenticationService;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Psr\Http\Server\MiddlewareInterface;

class LoginMiddleware implements MiddlewareInterface
{
    private $auth;
    private $authAdapter;
    private $template;

    public function __construct(
        \Mezzio\Template\TemplateRendererInterface $template,
        AuthenticationService $auth,
        AuthAdapter $authAdapter
    ) {
        $this->template    = $template;
        $this->auth        = $auth;
        $this->authAdapter = $authAdapter;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if ($request->getMethod() === 'POST') {
            return $this->authenticate($request);
        }

        return new HtmlResponse($this->template->render('auth::login'));
    }

    public function authenticate(ServerRequestInterface $request)
    {
        $params = $request->getParsedBody();

        if (empty($params['username'])) {
            return new HtmlResponse($this->template->render('auth::login', [
                'error' => 'The username cannot be empty',
            ]));
        }

        if (empty($params['password'])) {
            return new HtmlResponse($this->template->render('auth::login', [
                'username' => $params['username'],
                'error'    => 'The password cannot be empty',
            ]));
        }

        $this->authAdapter->setUsername($params['username']);
        $this->authAdapter->setPassword($params['password']);

        $result = $this->auth->authenticate();
        if (!$result->isValid()) {
            return new HtmlResponse($this->template->render('auth::login', [
                'username' => $params['username'],
                'error'    => 'The credentials provided are not valid',
            ]));
        }

        return new RedirectResponse('/admin');
    }
}