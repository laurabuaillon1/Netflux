<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\User;
use App\Enum\MovieType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create();

        // ==========================================
        // CRÉATION DES GENRES 
        // ==========================================
        $genreNames = ['Action', 'Comédie','Drame', 'Science-fiction', 'Horreur','Thriller', 'Animation'];
        $genresdb=[];

        foreach($genreNames as $name){
            $genre = new Genre();
            $genre->setName($name);
            $manager->persist($genre);
            $genresdb[]=$genre;
        }

        // ==========================================
        // CRÉATION DES UTILISATEURS 
        // ==========================================
        for($i=0;$i <5;$i++){
            $user = new User();
            $user->setPseudo($faker->userName());
            $user->setEmail($faker->unique()->email());
            $user->setPassword($this->passwordHasher->hashPassword($user, 'user123'));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }


        // ==========================================
        // CRÉATION DES FILMS ET SÉRIES (Une vingtaine)
        // ==========================================
        $movieTypes= MovieType::cases();

        for ($i = 0; $i < 20; $i++) {
            $movie = new Movie();
            $movie->setTitle($faker->name());
            $movie->setSynopsis($faker->paragraph());
            $movie->setReleaseDate($faker->dateTimeBetween('-20 years', 'now'));
            $movie->setDuration($faker->numberBetween(80, 180));
            $movie->setRating($faker->randomFloat(1, 1, 5));
            $movie->setImageUrl($faker->imageUrl(640, 480, 'cinema'));
            $movie->setVideoUrl('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
            $movie->setCreatedAt($faker->dateTime());
            $movie->setUpdatedAt($faker->dateTime());
            $manager->persist($movie);

            if(!empty($movieTypes)){
                $movie->setType($faker->randomElement($movieTypes));
                $movie->addBelong($faker->randomElement($genresdb));
            }
        }
        $manager->flush();
    }
}
