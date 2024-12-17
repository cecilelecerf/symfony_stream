<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\MediaRepository;
use App\Services\UserHistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $user_movie_watchHistorys;
    private $user_serie_watchHistorys;


    public function __construct(UserHistoryService $userHistoryService)
    {
        $userHistoryService = $userHistoryService;
        $this->user_movie_watchHistorys = $userHistoryService->getUserMovieWatchHistory();
        $this->user_serie_watchHistorys = $userHistoryService->getUserSerieWatchHistory();
    }
    #[Route(path: '/category/{id}', name: 'category')]
    public function category(Category $category): Response
    {

        return $this->render(
            "/media/category.html.twig",
            [
                "category" => $category,
                "user_movie_watchHistorys" => $this->user_movie_watchHistorys,
                "user_serie_watchHistorys" => $this->user_serie_watchHistorys
            ]
        );
    }

    #[Route(path: '/discover', name: 'discover')]
    public function discover(CategoryRepository $categoryRepository, MediaRepository $mediaRepository): Response
    {
        $categories =  $categoryRepository->findAll();
        $medias = $mediaRepository->findBy(
            array(),
            array('id' => 'DESC'),
            9,
            0
        );
        return $this->render(
            "/other/discover.html.twig",
            [
                "categories" => $categories,
                "medias" => $medias,

                "user_movie_watchHistorys" => $this->user_movie_watchHistorys,
                "user_serie_watchHistorys" => $this->user_serie_watchHistorys
            ]
        );
    }
}
