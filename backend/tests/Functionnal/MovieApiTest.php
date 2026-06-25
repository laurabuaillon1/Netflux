<?php

namespace App\Tests\Functionnal;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Enum\Type;
use App\DataFixtures\AppFixtures;
use Doctrine\ORM\EntityManagerInterface;


class MovieApiTest extends WebTestCase
{

    // ============================================================
    // ÉTAPE 1 — PROPRIÉTÉS PARTAGÉES ENTRE TOUS LES TESTS
    // Un seul client HTTP, un seul token, réutilisés partout
    // ============================================================
    /**
     * Force le démarrage du kernel pour chaque test
     */
    protected static ?bool $alwaysBootKernel = true;

    /**
     * Token JWT d'authentification
     */
    protected string $token;

    /**
     * Client HTTP pour les requêtes API
     */
    protected $client;

    /**
     * Gestionnaire d'entités Doctrine
     */
    protected EntityManagerInterface $entityManager;


    // ============================================================
    // ÉTAPE 2 — SETUP : s'exécute AVANT chaque test automatiquement
    // ============================================================
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->authenticate();
    }

    /**
     * Authentifie l'utilisateur et récupère le token JWT
     * 
     * Utilise les identifiants de l'utilisateur admin pour obtenir
     * un token d'authentification valide pour les tests.
     */
    private function authenticate(): void
    {
        $this->client->request(
            'POST',
            '/api/login',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json'
            ],
            json_encode([
                'email' => 'admin@netflux.fr',
                'password' => 'admin123',
            ])
        );

        $this->assertResponseIsSuccessful();
        $this->token = json_decode(
            $this->client->getResponse()->getContent(),
            true
        )['token'];
    }

    /**
     * Retourne les en-têtes d'authentification
     * 
     * @return array En-têtes HTTP contenant le token Bearer
     */
    private function getAuthHeaders(string $method, string $url, array $body = [], string $contentType = 'application/ld+json'): void
    {
        $this->client->request($method, $url, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token,
            'CONTENT_TYPE' => $contentType
        ], empty($body) ? null : json_encode($body));
    }



    public function testMovieList(): void
    {
        $this->client->request('GET', '/api/movies');

        //Vérifier la réponse
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);

        //Vérifie le contenue
        $data = json_decode($this->client->getResponse()->getContent(), true);
        // dump($data); //affiche tout les films
        $this->assertArrayHasKey('member', $data);
        $this->assertNotEmpty($data['member']);
        $this->assertArrayHasKey('title', $data['member'][0]);
        // dump($data['member'][0]); //affiche le premier film
    }




    public function testCreateMovie(): void
    {
        $this->getAuthHeaders('POST', '/api/movies', [
        "title" => "Harry Potter",
        "synopsis" => "Film",
        "releaseDate" => "2024-06-25T10:31:34.796Z",
        "duration" => 160,
        "rating" => 5,
        "type" => "Film",
        "imageUrl" => "harrypotter.jpg",
        "videoUrl" => "harrypotter.jpg"
    ]);

        //Vérifier la réponse
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);

        //Vérifie le contenue
        $data = json_decode($this->client->getResponse()->getContent(), true);
        // dump($data); //affiche tout les films
        $this->assertArrayHasKey('title', $data);
        // $this->assertNotEmpty($data['member']);
        // $this->assertArrayHasKey('title', $data['member'][0]);
        // dump($data['member'][0]); //affiche le premier film
        $this->assertEquals('Harry Potter', $data['title']);
    }



    public function testUpdateMovie(): void
    {
        // Récupère d'abord l'id d'un film existant (créé par les fixtures)
        $this->client->request('GET', '/api/movies');
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $id = $data['member'][0]['id'];

        // PATCH = modification partielle (pas PUT qui écrase tout)
        // Content-Type spécial obligatoire pour PATCH avec API Platform
        $this->getAuthHeaders('PATCH', '/api/movies/' . $id, [
        "title" => "Harry Potter modifié",
        "synopsis" => "Film",
        "releaseDate" => "2024-06-25T10:31:34.796Z",
        "duration" => 160,
        "rating" => 5,
        "type" => "Film",
        "imageUrl" => "harrypotter.jpg",
        "videoUrl" => "harrypotter.jpg"
    ],'application/merge-patch+json');

        // Vérifie la réponse
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        
        //Vérifie le contenu
        $data = json_decode($this->client->getResponse()->getContent(), true);
        dump($data);
        $this->assertEquals('Harry Potter modifié', $data['title']);
    }



    public function testDeleteMovie(): void
    {
        // Récupère d'abord l'id d'un film existant (créé par les fixtures)
        $this->client->request('GET', '/api/movies');
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $id = $data['member'][0]['id'];

        $this->getAuthHeaders('DELETE', '/api/movies' . $id);

    // Vérifie la réponse
        $this->assertResponseStatusCodeSame(204);
        
        
        
    }
}
