<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(): Response
    {
        return $this->render(view: "/auth/login.html.twig");
    }
    #[Route(path: '/forgot', name: 'forgot')]
    public function forgot(): Response
    {
        return $this->render(view: "/auth/forgot.html.twig");
    }
    #[Route(path: '/register', name: 'register')]
    public function register(): Response
    {
        return $this->render(view: "/auth/register.html.twig");
    }
    #[Route(path: '/reset', name: 'reset')]
    public function reset(): Response
    {
        return $this->render(view: "/auth/reset.html.twig");
    }
    #[Route(path: '/confirm', name: 'confirm')]
    public function confirm(): Response
    {
        return $this->render(view: "/auth/confirm.html.twig");
    }
}
