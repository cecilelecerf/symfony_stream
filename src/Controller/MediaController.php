<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController
{
    #[Route(path: '/category', name: 'category')]
    public function category(): Response
    {
        return $this->render(view: "/media/category.html.twig");
    }
    #[Route(path: '/detailSerie', name: 'detail_serie')]
    public function detail_serie(): Response
    {
        return $this->render(view: "/media/detail_serie.html.twig");
    }
    #[Route(path: '/detail', name: 'detail')]
    public function detail(): Response
    {
        return $this->render(view: "/media/detail.html.twig");
    }
    #[Route(path: '/lists', name: 'lists')]
    public function lists(): Response
    {
        return $this->render(view: "/media/lists.html.twig");
    }
}
