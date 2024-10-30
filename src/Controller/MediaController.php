<?php

namespace App\Controller;

use App\Entity\Media;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController
{

    #[Route(path: '/detailSerie', name: 'detail_serie')]
    public function detail_serie(): Response
    {
        return $this->render(view: "/media/detail_serie.html.twig");
    }
    #[Route(path: '/detail/{id}', name: 'detail')]
    public function detail(Media $media): Response
    {
        return $this->render("/media/detail.html.twig",     [
            "media" => $media,
        ]);
    }
    #[Route(path: '/lists', name: 'lists')]
    public function lists(): Response
    {
        return $this->render(view: "/media/lists.html.twig");
    }
}
