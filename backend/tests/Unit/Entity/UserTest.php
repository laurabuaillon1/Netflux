<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Movie;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetEmail(): void
    {
        $user = new User();
        $user->setEmail('');
        $this->assertEquals('lolo@gmail.com',$user->getEmail());
    }

    public function testGetRole(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $this->assertEquals(['ROLE_USER'],$user->getRoles());
    }

    public function testGetPseudo(): void
    {
        $user = new User();
        $user->setPseudo('Laura');
        $this->assertEquals('Laura',$user->getPseudo());
    }

    public function testGetPassword(): void
    {
        $user = new User();
        $user->setPassword('motdepassehache');
        $this->assertNotnull($user->getPassword());
        
    }

    public function testAddFavorite(): void
    {
        $user = new User();
        $movie = new Movie();

        $user->addFavori($movie);

        $this->assertCount(1, $user->getFavoris());
        $this->assertContains($movie,$user->getFavoris());
        
    }

    public function testRemoveFavorite(): void
    {
        $user = new User();
        $movie = new Movie();

        $user->addFavori($movie);
        $user->removeFavori($movie);

        $this->assertCount(0, $user->getFavoris());
        
        
    }

}
