<?php
// src/Service/UserHistoryService.php
namespace App\Services;

use App\Repository\MovieRepository;
use App\Repository\SerieRepository;
use App\Repository\WatchHistoryRepository;
use Symfony\Component\Security\Core\Security;

class UserHistoryService
{
    private $watchHistoryRepository;
    private $movieRepository;
    private $serieRepository;
    private $security;

    public function __construct(WatchHistoryRepository $watchHistoryRepository, Security $security, MovieRepository $movieRepository, SerieRepository $serieRepository)
    {
        $this->watchHistoryRepository = $watchHistoryRepository;
        $this->movieRepository = $movieRepository;
        $this->serieRepository = $serieRepository;
        $this->security = $security;
    }

    public function getUserMovieWatchHistory()
    {
        $user = $this->security->getUser();
        if ($user) {
            return $this->watchHistoryRepository->findBy(
                [
                    'user' => $user,
                    'media' => $this->movieRepository->findAll()
                ],
                ['lastWatched' => 'DESC'], // Sort by last watched date in descending order
                3, // Limit to 3 results
                0  // No offset
            );
        }
    }
    public function getUserSerieWatchHistory()
    {
        $user = $this->security->getUser();
        if ($user) {
            return $this->watchHistoryRepository->findBy(
                [
                    'user' => $user,
                    'media' => $this->serieRepository->findAll()
                ], // Filter by user
                ['lastWatched' => 'DESC'], // Sort by last watched date in descending order
                3, // Limit to 3 results
                0  // No offset
            );
        }
    }
}
