<?php

namespace App\Controller;

use App\Entity\Media;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlaylistRepository;
use App\Repository\PlaylistSubscriptionRepository;
use App\Repository\WatchHistoryRepository;
use App\Services\UserHistoryService;
use Symfony\Component\HttpFoundation\Request;


class MediaController extends AbstractController
{
    private $user_movie_watchHistorys;
    private $user_serie_watchHistorys;


    public function __construct(UserHistoryService $userHistoryService)
    {
        $userHistoryService = $userHistoryService;
        $this->user_movie_watchHistorys = $userHistoryService->getUserMovieWatchHistory();
        $this->user_serie_watchHistorys = $userHistoryService->getUserSerieWatchHistory();
    }
    #[Route(path: '/detail/{id}', name: 'detail')]
    public function detail(Media $media): Response
    {
        return $this->render(
            "/media/detail.html.twig",
            [
                "media" => $media,
                "user_movie_watchHistorys" => $this->user_movie_watchHistorys,
                "user_serie_watchHistorys" => $this->user_serie_watchHistorys
            ]
        );
    }
    #[Route(path: '/lists', name: 'lists')]
    public function lists(PlaylistSubscriptionRepository $playlistSubscriptionRepository, PlaylistRepository $playlistRepository, Request $request): Response

    {
        $user = $this->getUser();
        $playlistSubscriptions = $playlistSubscriptionRepository->findBy(["user" => $user]);
        $playlists = array_map(fn($sub) => $sub->getPlaylist(), $playlistSubscriptions);
        $playlistsAuthor = $playlistRepository->findBy(["author" => $user]);
        $playlists = [...$playlists, ...$playlistsAuthor];
        $playlistId = $request->query->get("playlist");
        $playlist = $playlistId ? $playlistRepository->find($playlistId) : null;

        return $this->render(
            "/media/lists.html.twig",
            [
                "playlists" => $playlists,
                "playlist" => $playlist,
                "user_movie_watchHistorys" => $this->user_movie_watchHistorys,
                "user_serie_watchHistorys" => $this->user_serie_watchHistorys
            ]
        );
    }

    #[Route(path: '/watch-history', name: 'watchHistory')]
    public function watchHistory(Request $request, WatchHistoryRepository $watchHistoryRepository): Response

    {
        $user = $this->getUser();
        $watchHistory = $watchHistoryRepository->findBy(["user" => $user]);
        return $this->render(
            "/media/watchHistories.html.twig",
            [
                "watchHistories" => $watchHistory,
                "user_movie_watchHistorys" => $this->user_movie_watchHistorys,
                "user_serie_watchHistorys" => $this->user_serie_watchHistorys
            ]
        );
    }
}
