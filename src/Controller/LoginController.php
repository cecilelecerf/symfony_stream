<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\RegistrationFormType;
use App\Enum\UserAccountStatusEnum;

class LoginController extends AbstractController
{
    #[Route(path: '/forgot', name: 'forgot')]
    public function forgot(): Response
    {
        return $this->render(view: "/auth/forgot.html.twig");
    }
    #[Route(path: '/register', name: 'app_register')]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        // Crée un nouvel utilisateur
        $user = new User();

        // Crée le formulaire et gère la requête
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        // Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Hash le mot de passe
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get("password")->getData()
            );
            $user->setPassword($hashedPassword);
            $user->setRoles(["ROLE_USER"]);
            $user->setAccountStatus(UserAccountStatusEnum::ACTIVE);
            // Sauvegarde l'utilisateur en base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirige après l'enregistrement
            return $this->redirectToRoute('index');
        }

        return $this->render("/auth/register.html.twig",  [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route(path: '/reset', name: 'reset')]
    public function reset(): Response
    {
        return $this->render(view: "/auth/reset.html.twig");
    }
    #[Route(path: '/confirm', name: 'confirm')]
    public function confirm(): Response
    {
        return $this->render(view: "/auth/confirm.html.twig");
    }
}
