<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OtherController extends AbstractController
{
    #[Route(path: '/abonnements', name: 'abonnements')]
    public function abonnements(): Response
    {
        return $this->render(view: "/other/abonnements.html.twig");
    }

    #[Route(path: '/default', name: 'default')]
    public function default(): Response
    {
        return $this->render(view: "/other/default.html.twig");
    }
}
