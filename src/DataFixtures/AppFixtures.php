<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $movie = new Movie();
        $movie->setTitle(title: "Avatar");
        $movie->setShortDescription(short_description: "lalaland");
        $movie->setLongDescription(long_description: "lala");
        $movie->setCoverImage(cover_image: "avatar.png");
        $movie->setReleaseDate(release_date: new \DateTime());
        $movie->setCast([]);
        $movie->setStaff([]);
        $manager->persist($movie);

        $manager->flush();
    }
}
