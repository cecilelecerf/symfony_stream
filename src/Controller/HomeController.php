<?php

namespace App\Controller;

use App\Repository\PlaylistSubscriptionRepository;
use App\Repository\MediaRepository;
use App\Services\UserHistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $user_movie_watchHistorys;
    private $user_serie_watchHistorys;


    public function __construct(UserHistoryService $userHistoryService)
    {
        $userHistoryService = $userHistoryService;
        $this->user_movie_watchHistorys = $userHistoryService->getUserMovieWatchHistory();
        $this->user_serie_watchHistorys = $userHistoryService->getUserSerieWatchHistory();
    }
    #[Route(path: '/', name: 'index')]
    public function index(PlaylistSubscriptionRepository $playlistSubscriptionRepository, MediaRepository $mediaRepository): Response
    {
        $user = $this->getUser();

        $playlistSubscription = $playlistSubscriptionRepository->findAll();
        $medias = $mediaRepository->findBy(
            array(),
            array('id' => 'DESC'),
            9,
            0
        );


        return $this->render("index.html.twig", ["user" => $playlistSubscription, "medias" => $medias, "user_movie_watchHistorys" => $this->user_movie_watchHistorys, "user_serie_watchHistorys" => $this->user_serie_watchHistorys]);
    }
}
