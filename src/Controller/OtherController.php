<?php

namespace App\Controller;

use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OtherController extends AbstractController
{
    #[Route(path: '/abonnements', name: 'abonnements')]
    public function abonnements(UserRepository $userRepository, SubscriptionRepository $subscriptionRepository): Response
    {
        $user = $userRepository->find(78);

        $subscriptions = $subscriptionRepository->findAll(); 
        return $this->render("/other/abonnements.html.twig", ["user" => $user, "subscriptions" => $subscriptions]);
    }

    #[Route(path: '/default', name: 'default')]
    public function default(): Response
    {
        return $this->render(view: "/other/default.html.twig");
    }
}
