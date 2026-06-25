<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Movie;
use App\Enum\MovieType;
use PHPUnit\Framework\TestCase;

class MovieTest extends TestCase
{

    public function testGetTitle(): void
    {
        $movie = new Movie();
        $movie->setTitle('Batman');
        $this->assertEquals('Batman', $movie->getTitle());
    }

    public function testGetSynopsis(): void
    {
        $movie = new Movie();
        $movie->setSynopsis('film avec des méchants');
        $this->assertEquals('film avec des méchants', $movie->getSynopsis());
    }

    public function testGetReleaseDate(): void
    {
        $movie = new Movie();
        $movie->setReleaseDate(new \DateTime('2020-01-01'));
        $this->assertEquals(new \DateTime('2020-01-01'), $movie->getReleaseDate());
    }

    public function testGetDuration(): void
    {
        $movie = new Movie();
        $movie->setDuration(148);
        $this->assertEquals(148, $movie->getDuration());
    }

    public function testGetRating(): void
    {
        $movie = new Movie();
        $movie->setRating(4);
        $this->assertEquals(4, $movie->getRating());
    }

    public function testGetType(): void
    {
        $movie = new Movie();
        $movie->setType(MovieType::Film);
        $this->assertEquals(MovieType::Film, $movie->getType());
    }

    public function testGetImageUrl(): void
    {
        $movie = new Movie();
        $movie->setImageUrl('image.jpeg');
        $this->assertEquals('image.jpeg', $movie->getImageUrl());
    }

    public function testGetVideoUrl(): void
    {
        $movie = new Movie();
        $movie->setVideoUrl('video.mp4');
        $this->assertEquals('video.mp4', $movie->getVideoUrl());
    }

    public function testGetCreatedAt(): void
    {
        $movie = new Movie();
        $movie->setCreatedAt(new \DateTime('2020-01-01'));
        $this->assertEquals(new \DateTime('2020-01-01'), $movie->getCreatedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $movie = new Movie();
        $movie->setUpdatedAt(new \DateTime('2020-01-01'));
        $this->assertEquals(new \DateTime('2020-01-01'), $movie->getUpdatedAt());
    }
}
