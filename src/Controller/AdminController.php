<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route(path: '/admin', name: 'home_admin')]
    public function admin(): Response
    {
        return $this->render(view: "/admin/home.html.twig");
    }
    #[Route(path: '/admin/addMovie', name: 'add_movie')]
    public function addMovie(): Response
    {
        return $this->render(view: "/admin/admin_add_movie.html.twig");
    }
    #[Route(path: '/admin/movies', name: 'movies')]
    public function movies(): Response
    {
        return $this->render(view: "/admin/admin_movies.html.twig");
    }
    #[Route(path: '/admin/users', name: 'users')]
    public function users(): Response
    {
        return $this->render(view: "/admin/users.html.twig");
    }
    #[Route(path: '/admin/upload', name: 'upload')]
    public function upload(): Response
    {
        return $this->render(view: "/admin/upload.html.twig");
    }
}
