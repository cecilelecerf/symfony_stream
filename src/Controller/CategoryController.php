<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\MediaRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route(path: '/category/{id}', name: 'category')]
    public function category(Category $category): Response
    {

        return $this->render(
            "/media/category.html.twig",
            [
                "category" => $category,
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
            0);
        return $this->render(
            "/other/discover.html.twig",
            [
                "categories" => $categories,
                "medias"=> $medias
            ]
        );
    }
}
