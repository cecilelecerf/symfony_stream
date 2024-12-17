<?php

namespace App\Controller;

use App\Entity\Media;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlaylistRepository;
use App\Repository\PlaylistSubscriptionRepository;
use Symfony\Component\HttpFoundation\Request;

class MediaController extends AbstractController
{
    #[Route(path: '/detail/{id}', name: 'detail')]
    public function detail(Media $media): Response
    {
        return $this->render(
            "/media/detail.html.twig",
            [
                "media" => $media,
            ]
        );
    }
    #[Route(path: '/lists', name: 'lists')]
    public function lists(PlaylistSubscriptionRepository $playlistSubscriptionRepository, PlaylistRepository $playlistRepository, Request $request): Response

    {
        $user = $this->getUser();
        $playlistSubscriptions = $playlistSubscriptionRepository->findBy(["user" => $user]);
        $playlists = array_map(fn($sub) => $sub->getPlaylist(), $playlistSubscriptions);

        $playlistId = $request->query->get("playlist");
        $playlist = $playlistId ? $playlistRepository->find($playlistId) : null;

        return $this->render(
            "/media/lists.html.twig",
            [
                "playlists" => $playlists,
                "playlist" => $playlist
            ]
        );
    }
}
