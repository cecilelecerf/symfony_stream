<?php

namespace App\Controller;

use App\Repository\PlaylistSubscription;
use App\Repository\PlaylistSubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'index')]
    public function index(PlaylistSubscriptionRepository $playlistSubscriptionRepository): Response
    {

        $user = $playlistSubscriptionRepository->findBy(["user" => 52]);
        dump($user);

        return $this->render("index.html.twig", ["user" => $user]);
    }
}
