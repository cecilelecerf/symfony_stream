<?php

namespace App\Controller;

use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use App\Services\UserHistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OtherController extends AbstractController
{
    private $user_movie_watchHistorys;
    private $user_serie_watchHistorys;


    public function __construct(UserHistoryService $userHistoryService)
    {
        $userHistoryService = $userHistoryService;
        $this->user_movie_watchHistorys = $userHistoryService->getUserMovieWatchHistory();
        $this->user_serie_watchHistorys = $userHistoryService->getUserSerieWatchHistory();
    }
    #[Route(path: '/abonnements', name: 'abonnements')]
    public function abonnements(UserRepository $userRepository, SubscriptionRepository $subscriptionRepository): Response
    {
        $user = $this->getUser();
        $subscriptions = $subscriptionRepository->findAll();
        return $this->render("/other/abonnements.html.twig", [
            "user" => $user,
            "subscriptions" => $subscriptions,
            "user_movie_watchHistorys" => $this->user_movie_watchHistorys,
            "user_serie_watchHistorys" => $this->user_serie_watchHistorys
        ]);
    }

    #[Route(path: '/default', name: 'default')]
    public function default(): Response
    {
        return $this->render("/other/default.html.twig", [
            "user_movie_watchHistorys" => $this->user_movie_watchHistorys,
            "user_serie_watchHistorys" => $this->user_serie_watchHistorys
        ]);
    }
}
