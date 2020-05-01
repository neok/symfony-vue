<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Entity\Showtime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $imgSrc = [
            'https://cdn.pixabay.com/photo/2018/03/01/06/35/cat-3189845_1280.jpg',
            'https://cdn.pixabay.com/photo/2014/07/14/06/51/audrey-hepburn-392920_1280.jpg',
            'https://cdn.pixabay.com/photo/2017/01/31/14/50/comic-characters-2024745_1280.png',
            'https://cdn.pixabay.com/photo/2014/07/16/08/18/clint-eastwood-394536_1280.jpg',
        ];
        $faker = \Faker\Factory::create();
        for($i = 0; $i <10; $i++) {
            $movie = new Movie();
            $movie->setTitle($faker->text(50));
            $movie->setGenre($faker->text(10));
            $movie->setImageSrc($imgSrc[random_int(0, 3)]);
            for($j = 0; $j < 2; $j++) {
                $showTime = new Showtime();
                $showTime->setShowtime(new \DateTime('- ' . random_int(1,3) . ' months'));
                $movie->addShowtime($showTime);
                $manager->persist($movie);
            }
        }

        $manager->flush();
    }
}
