<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin')]
class AdminController extends AbstractController
{
    #[Route(path: '/', name: 'home_admin')]
    public function admin(): Response
    {
        $links = [["href" => "app_user_index", "label" => "Utilisateurs"]];
        return $this->render("/admin/home.html.twig", ["links" => $links]);
    }
    #[Route(path: '/addMovie', name: 'add_movie')]
    public function addMovie(): Response
    {
        return $this->render(view: "/admin/admin_add_movie.html.twig");
    }
    #[Route(path: '/movies', name: 'movies')]
    public function movies(): Response
    {
        return $this->render(view: "/admin/admin_movies.html.twig");
    }

    #[Route(path: '/upload', name: 'upload')]
    public function upload(): Response
    {
        return $this->render(view: "/admin/upload.html.twig");
    }
}
