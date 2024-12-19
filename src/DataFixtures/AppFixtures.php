<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Faker\ImageProvider;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Language;
use App\Entity\Movie;
use App\Entity\WatchHistory;
use App\Entity\Serie;
use App\Entity\User;
use App\Entity\Playlist;
use App\Entity\PlaylistMedia;
use App\Entity\PlaylistSubscription;
use App\Entity\Subscription;
use App\Enum\CommentStatusEnum;
use App\Enum\UserAccountStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = $this->generateUsers($manager);

        // for user test
        $user = $this->generateUser($manager);
        $manager->flush();
    }

    private function generateUsers(ObjectManager $manager): array
    {
        $faker = Factory::create();

        $users = [];

        for ($i = 0; $i < random_int(10, 20); $i++) {
            $user = new User();
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $faker->password()
            );
            $user->setUsername($faker->firstname());
            $user->setEmail($faker->email());
            $user->setPassword($hashedPassword);
            $user->setAccountStatus(UserAccountStatusEnum::ACTIVE);
            $user->setRoles(["ROLE_USER"]);
            $users[] = $user;
            $manager->persist($user);
        }

        return $users;
    }


    // -----------------------------------------------------------------------
    // -----------------------------------------------------------------------
    // --------------------------------USER-----------------------------------
    // -----------------------------------------------------------------------
    // -----------------------------------------------------------------------
    // -----------------------------------------------------------------------
    // -----------------------------------------------------------------------

    private function generateUser(ObjectManager $manager): User
    {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            "user"
        );
        $user->setUsername("user");
        $user->setEmail("user@gmail.com");
        $user->setPassword($hashedPassword);
        $user->setAccountStatus(UserAccountStatusEnum::ACTIVE);;
        $user->setRoles(["ROLE_USER"]);

        $manager->persist($user);

        return $user;
    }
}
