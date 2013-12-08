<?php

namespace UVd\UserBundle\Handler;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    /**
     * @var \FOS\RestBundle\View\ViewHandler
     */
    protected $viewHandler;

    /**
     * @param $viewHandler
     */
    public function __construct(ViewHandler $viewHandler)
    {
        $this->viewHandler = $viewHandler;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $view = View::create($token->getUser());
        $view->setStatusCode(200);
        return $this->viewHandler->handle($view);
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $view = View::create([]);
        $view->setStatusCode(403);
        return $this->viewHandler->handle($view);
    }

}