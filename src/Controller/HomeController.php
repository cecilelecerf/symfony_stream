<?php

namespace App\Controller;

use App\Repository\PlaylistSubscriptionRepository;
use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'index')]
    public function index(PlaylistSubscriptionRepository $playlistSubscriptionRepository, MediaRepository $mediaRepository): Response
    {
        $user = $playlistSubscriptionRepository->findAll();
        $medias = $mediaRepository->findBy(
            array(),
            array('id' => 'DESC'),
            9,
            0
        );

        return $this->render("index.html.twig", ["user" => $user, "medias" => $medias]);
    }
}
