<?php

namespace App\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use App\Entity\Movie;
use App\Enum\MovieType;

class MovieAssertTest extends TestCase
{
    public function testValidTitle(): void
    {
        
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setTitle('Un titre valide');

        $errors = $validator->validateProperty($movie, 'title');

        $this->assertCount(0, $errors);

    }

    public function testNotValidTitle(): void
    {
        
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setTitle('U');

        $errors = $validator->validateProperty($movie, 'title');

        $this->assertCount(1, $errors);

    }

    public function testValidSynopsis(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setSynopsis('Un synopsis valide');
        $errors = $validator->validateProperty($movie, 'synopsis');

        $this->assertCount(0, $errors);

    }

    public function testNotValidSynopsis(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setSynopsis('U');
        $errors = $validator->validateProperty($movie, 'synopsis');

        $this->assertCount(1, $errors);

    }

    public function testValidReleaseDate(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setReleaseDate(new \DateTime('2020-01-01'));
        $errors = $validator->validateProperty($movie, 'releaseDate');

        $this->assertCount(0, $errors);

    }

    public function testNotValidReleaseDate(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        // $movie->setReleaseDate(new \DateTime('2'));
        $errors = $validator->validateProperty($movie, 'releaseDate');

        $this->assertCount(1, $errors);

    }

    public function testValidDuration(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setDuration(160);
        $errors = $validator->validateProperty($movie, 'duration');

        $this->assertCount(0, $errors);

    }

    public function testNotValidDuration(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setDuration(-2);
        $errors = $validator->validateProperty($movie, 'duration');

        $this->assertCount(1, $errors);

    }

    public function testValidRating(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setRating(4.5);
        $errors = $validator->validateProperty($movie, 'rating');

        $this->assertCount(0, $errors);

    }

    public function testNotValidRating(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setRating(-2);
        $errors = $validator->validateProperty($movie, 'rating');

        $this->assertCount(1, $errors);

    }

    public function testValidType(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setType(MovieType::Film);
        $errors = $validator->validateProperty($movie, 'type');

        $this->assertCount(0, $errors);

    }

    public function testValidImageUrl(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setImageUrl('image.jpeg');
        $errors = $validator->validateProperty($movie, 'imageUrl');

        $this->assertCount(0, $errors);

    }

    public function testNotValidImageUrl(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setImageUrl('');
        $errors = $validator->validateProperty($movie, 'imageUrl');

        $this->assertCount(1, $errors);

    }

    public function testValidVideoUrl(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setVideoUrl('image.jpeg');
        $errors = $validator->validateProperty($movie, 'videoUrl');

        $this->assertCount(0, $errors);

    }

    public function testNotValidVideoUrl(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setVideoUrl('');
        $errors = $validator->validateProperty($movie, 'videoUrl');

        $this->assertCount(1, $errors);

    }

    public function testValidCreatedAt(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setCreatedAt(new \DateTime('2020-01-01'));
        $errors = $validator->validateProperty($movie, 'createdAt');

        $this->assertCount(0, $errors);

    }

    public function testValidUpdatedAt(): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $movie = new Movie();
        $movie->setUpdatedAt(new \DateTime('2020-01-01'));
        $errors = $validator->validateProperty($movie, 'updatedAt');

        $this->assertCount(0, $errors);

    }

    
}
