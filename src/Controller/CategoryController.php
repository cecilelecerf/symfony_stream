<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
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
    public function discover(CategoryRepository $categoryRepository): Response
    {
        $categories =  $categoryRepository->findAll();
        return $this->render(
            "/other/discover.html.twig",
            [
                "categories" => $categories,
            ]
        );
    }
}
