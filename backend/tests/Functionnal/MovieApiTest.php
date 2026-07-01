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

    /** Force le démarrage du kernel pour chaque test */
    protected static ?bool $alwaysBootKernel = true;

    /** Token JWT récupéré lors de l'authentification */
    protected string $token;

    /** Client HTTP qui simule les requêtes vers l'API */
    protected $client;

    /** Gestionnaire d'entités Doctrine (accès base de données) */
    protected EntityManagerInterface $entityManager;


    // ============================================================
    // ÉTAPE 2 — SETUP : s'exécute AVANT chaque test automatiquement
    // ============================================================
    protected function setUp(): void
    {
        parent::setUp();
        // Crée un client HTTP de test (simule un navigateur/Postman)
        $this->client = static::createClient();
        // Récupère le service Doctrine depuis le conteneur Symfony
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        // Authentifie l'admin et stocke le token JWT dans $this->token
        $this->authenticate();
    }


    // ============================================================
    // ÉTAPE 3 — MÉTHODES UTILITAIRES (privées, non exécutées comme tests)
    // ============================================================
    /** Authentifie l'utilisateur et récupère le token JWT
     * Utilise les identifiants de l'utilisateur admin pour obtenir
     * un token d'authentification valide pour les tests.
     */
    private function authenticate(): void
    {
        $this->client->request(
            'POST',
            '/api/login',
            [], // paramètres GET (vide)
            [], // fichiers (vide)
            [
                'CONTENT_TYPE' => 'application/json'
            ],
            json_encode([
                'email' => 'admin@netflux.fr',
                'password' => 'admin123',
            ])
        );

        // Vérifie que la connexion a réussi (code 2xx)
        $this->assertResponseIsSuccessful();

        // Extrait et stocke le token JWT depuis la réponse JSON
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
    // Centralise l'ajout du header Authorization pour éviter
    // la répétition dans chaque test.
    private function getAuthHeaders(string $method, string $url, array $body = [], string $contentType = 'application/ld+json'): void
    {
        $this->client->request($method, $url, [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token,
            'CONTENT_TYPE' => $contentType
        ], empty($body) ? null : json_encode($body));
    }


    // ============================================================
    // ÉTAPE 4 — TESTS (méthodes publiques préfixées par "test")
    // PHPUnit les détecte et les exécute automatiquement
    // ============================================================

    /** Vérifie que la liste des films est accessible sans authentification et que la réponse contient bien des films avec un titre.*/

    public function testMovieList(): void
    {
        // --- Requête ---
        // GET /api/movies — pas besoin de token, route publique
        $this->client->request('GET', '/api/movies');

        //--- Assertions sur le statut HTTP ---Vérifier la réponse
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);

        //---Assertions sur le contenu JSON---Vérifie le contenue
        $data = json_decode($this->client->getResponse()->getContent(), true);
        // dump($data); //affiche tout les films

        // API Platform retourne les collections sous la clé 'member'
        $this->assertArrayHasKey('member', $data);
        $this->assertNotEmpty($data['member']);

        // Vérifie que le premier film possède bien un champ 'title'
        $this->assertArrayHasKey('title', $data['member'][0]);
        // dump($data['member'][0]); //affiche le premier film
    }



    // Vérifie qu'un admin peut créer un nouveau film (POST).
    // Attend un code 201 Created et vérifie le titre retourné.

    public function testCreateMovie(): void
    {
        // --- Requête authentifiée ---
        // POST /api/movies avec les données du film à créer
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

    public function testCreateMovieWithoutAuth(): void
    {
        $this->client->request('POST', '/api/movies', [], [], [
            'CONTENT_TYPE' => 'application/ld+json'
        ], json_encode([
            'title' => 'film sans auth',
        ]));

        $this->assertResponseStatusCodeSame(401);
    }



    // Vérifie qu'un admin peut créer un nouveau film (POST).
    // Attend un code 201 Created et vérifie le titre retourné.

    public function testUpdateMovie(): void
    {
        // --- Étape 1 : récupérer l'id d'un film existant ---
        $this->client->request('GET', '/api/movies');
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $id = $data['member'][0]['id'];


        // --- Étape 2 : envoyer la modification ---
        // PATCH = modification partielle (pas PUT qui écrase tout)
        // Content-Type obligatoire : 'application/merge-patch+json' pour PATCH avec API Platform
        $this->getAuthHeaders('PATCH', '/api/movies/' . $id, [
            "title" => "Harry Potter modifié",
            "synopsis" => "Film",
            "releaseDate" => "2024-06-25T10:31:34.796Z",
            "duration" => 160,
            "rating" => 5,
            "type" => "Film",
            "imageUrl" => "harrypotter.jpg",
            "videoUrl" => "harrypotter.jpg"
        ], 'application/merge-patch+json');

        // Vérifie la réponse
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);

        //Vérifie le contenu
        $data = json_decode($this->client->getResponse()->getContent(), true);
        // dump($data);
        $this->assertEquals('Harry Potter modifié', $data['title']);
    }

    public function testUpdateMovieWithInvalidData(): void
    {
        $this->client->request('GET', '/api/movies');
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $id = $data['member'][0]['id'];

        $this->getAuthHeaders('PATCH', '/api/movies/' . $id, [
            "rating" => 10,
        ], 'application/merge-patch+json');

        $this->assertResponseStatusCodeSame(422);
    }





    public function testDeleteMovie(): void
    {
        // Récupère d'abord l'id d'un film existant 
        $this->client->request('GET', '/api/movies');
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $id = $data['member'][0]['id'];

        $this->getAuthHeaders('DELETE', '/api/movies/' . $id);

        // Vérifie la réponse
        $this->assertResponseStatusCodeSame(204);
    }
    public function testGetMovieNotFound(): void
    {
        $this->getAuthHeaders('GET', '/api/movies/9999');
        $this->assertResponseStatusCodeSame(404);
    }
}
