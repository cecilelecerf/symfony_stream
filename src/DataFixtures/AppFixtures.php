<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Faker\ImageProvider;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Movie;
use App\Entity\Serie;
use App\Entity\User;
use App\Entity\Playlist;
use App\Entity\PlaylistMedia;
use App\Entity\PlaylistSubscription;
use App\Entity\Subscription;
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
        $subscriptions = $this->generateSubscription($manager);
        $users = $this->generateUsers($manager, $subscriptions);
        $medias = $this->generateMedias($manager);
        $categories = $this->generateCategories($manager, $medias);
        $languages = $this->generateLanguages($manager, $medias);
        $playlists = $this->generatePlaylists($manager, $users, $medias);

        $manager->flush();
    }

    private function generateUsers(ObjectManager $manager, array $subscriptions): array
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
            $user->setCurrentSubscrition($subscriptions[array_rand($subscriptions)]);
            $user->setRoles(["ROLE_USER"]);
            $users[] = $user;
            $manager->persist($user);
        }

        return $users;
    }


    protected function generateLanguages(ObjectManager $manager, array $medias): array
    {
        $tabs = [['fr', 'Français'], ['en', 'Anglais'], ['es', 'Espagnol'], ['de', 'Allemand'], ['it', 'Italien'], ['pt', 'Portugais'], ['ru', 'Russe'], ['zh', 'Chinois'], ['ja', 'Japonais'], ['ar', 'Arabe'], ['hi', 'Hindi'], ['bn', 'Bengali'], ['pt', 'Portugais'], ['ru', 'Russe'], ['ko', 'Coréen'], ['tr', 'Turc'], ['nl', 'Néerlandais'], ['pl', 'Polonais'], ['vi', 'Vietnamien'], ['sv', 'Suédois'], ['cs', 'Tchèque'], ['fi', 'Finnois'], ['el', 'Grec'], ['da', 'Danois'], ['no', 'Norvégien'], ['he', 'Hébreu'], ['id', 'Indonésien'], ['ms', 'Malais'], ['th', 'Thaï'], ['hu', 'Hongrois'], ['sk', 'Slovaque'], ['ro', 'Roumain'], ['bg', 'Bulgare'], ['uk', 'Ukrainien'], ['hr', 'Croate'], ['ca', 'Catalan'], ['sr', 'Serbe'], ['lt', 'Lituanien'], ['sl', 'Slovène'], ['et', 'Estonien'], ['lv', 'Letton'], ['mk', 'Macédonien'], ['sq', 'Albanais'], ['hy', 'Arménien'], ['ka', 'Géorgien'], ['uz', 'Ouzbek'], ['kk', 'Kazakh'], ['az', 'Azéri'], ['tg', 'Tadjik'], ['tk', 'Turkmène'], ['mn', 'Mongol'], ['ky', 'Kirghiz'], ['si', 'Sinhala'], ['am', 'Amharique'], ['km', 'Khmer'], ['lo', 'Lao'], ['my', 'Birman'],];
        $languages = [];

        foreach ($tabs as $tab) {
            $entity = new Language();
            $entity->setCode($tab[0]);
            $entity->setName($tab[1]);
            $manager->persist($entity);
            $languages[] = $entity;

            for ($k = 0; $k < random_int(0, 20); $k++) {
                $media = $medias[array_rand($medias)];
                $media->addLanguage($entity);
            }
        }

        return $languages;
    }

    protected function generateCategories(ObjectManager $manager, array $medias): array
    {
        $categories = [];
        $tabs = ['Action', 'Aventure', 'Comédie', 'Drame', 'Fantastique', 'Horreur', 'Policier', 'Science-fiction', 'Thriller'];
        foreach ($tabs as $tab) {
            $category = new Category();
            $category->setLabel($tab);
            $category->setName(strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $tab)));
            $manager->persist($category);
            $categories[] = $category;

            for ($k = 0; $k < random_int(0, 20); $k++) {
                $media = $medias[array_rand($medias)];
                $media->addCategory($category);
            }
        }

        return $categories;
    }

    protected function generateMedias(ObjectManager $manager): array
    {
        $faker = Factory::create();
        $faker->addProvider(new ImageProvider($faker));


        /** @var array<Movie|Serie> $medias */
        $medias = [];
        for ($j = 0; $j < random_int(10, 20); $j++) {
            $movie = new Movie();
            $movie->setTitle($faker->sentence(3));
            $movie->setShortDescription($faker->sentence(10));
            $movie->setLongDescription($faker->paragraph());
            $movie->setCoverImage($faker->imageUrl(400, 300));
            $movie->setReleaseDate($faker->dateTimeBetween('-10 years', 'now'));
            $movie->setCasting([$faker->lastname(), $faker->lastname(), $faker->lastname()]);
            $movie->setStaff([$faker->lastname(), $faker->lastname(), $faker->lastname()]);
            $medias[] = $movie;
            $manager->persist($movie);
        }

        for ($j = 0; $j < random_int(10, 20); $j++) {
            $serie = new Serie();
            $serie->setTitle($faker->sentence(3));
            $serie->setShortDescription($faker->sentence(10));
            $serie->setLongDescription($faker->paragraph());
            $serie->setCoverImage($faker->imageUrl(400, 300, "movies", true, $faker->sentence(1)));
            $serie->setReleaseDate($faker->dateTimeBetween('-10 years', 'now'));
            $serie->setCasting([$faker->lastname(), $faker->lastname(), $faker->lastname()]);
            $serie->setStaff([$faker->lastname(), $faker->lastname(), $faker->lastname()]);
            $medias[] = $serie;
            $manager->persist($serie);
        }
        return $medias;
    }

    protected function generatePlaylists(ObjectManager $manager, array $users, array $medias): array
    {
        $playlists = [];
        $names = ["playlist1", "playlist2", "playlist3", "playlist4"];
        $now = new \DateTimeImmutable();

        foreach ($names as $name) {
            $playlist = new Playlist();
            $playlist->setName($name);
            $playlist->setAuthor($users[0]);
            $playlist->setCreatedAt($now);
            $playlist->setUpdatedAt($now);
            for ($k = 0; $k < random_int(0, count($medias)); $k++) {
                $playlistMedia = new PlaylistMedia();
                $media = $medias[array_rand($medias)];
                $playlistMedia->setMedia($media);
                $playlistMedia->setPlaylist($playlist);
                $playlistMedia->setAddedAt($now);
                $manager->persist($playlistMedia);
                $playlist->addPlaylistMedia($playlistMedia);
            }
            for ($k = 0; $k < random_int(0, count($users)); $k++) {
                $playlistSubscription = new PlaylistSubscription();
                $playlistSubscription->setUser($users[$k]);
                $playlistSubscription->setPlaylist($playlist);
                $playlistSubscription->setSubscribedAt($now);
                $manager->persist($playlistSubscription);
                $playlist->addPlaylistSubscription($playlistSubscription);
            }
            $manager->persist($playlist);
            $playlists[] = $playlist;
        }
        return $playlists;
    }

    protected function generateSubscription(ObjectManager $manager): array
    {
        $subscriptions = [];
        $tabs = [
            ['name' => 'HD', 'price' => 3, 'durationInMonths' => 1],
            ['name' => '4K HDR', 'price' => 6, 'durationInMonths' => 1],
            ['name' => 'HD', 'price' => 30, 'durationInMonths' => 12],
            ['name' => '4K HDR 3D', 'price' => 30, 'durationInMonths' => 12],
        ];
        foreach ($tabs as $tab) {
            $subscription = new Subscription();
            $subscription->setName($tab["name"]);
            $subscription->setPrice($tab["price"]);
            $subscription->setDurationInMonth($tab["durationInMonths"]);
            $manager->persist($subscription);
            $subscriptions[] = $subscription;
        };
        return $subscriptions;
    }
}
