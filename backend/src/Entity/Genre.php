<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\OpenApi\Model\Operation as ModelOperation;
use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    description: "Gestion des genres des films de Netflux",
    operations: [
        new GetCollection(
            openapi: new ModelOperation(
                summary: "Liste des genres",
                description: "Api qui permet d'afficher le liste des genres",
            ),
            
            
        ),
        new Post(
            openapi: new ModelOperation(
                summary: "Ajouter un genre",
                description: "Api qui permet d'ajouter un genre",
            ),
            security:"is_granted('ROLE_ADMIN')"
        ),
        new Patch(
            openapi: new ModelOperation(
                summary: "Modifier un genre",
                description: "Api qui permet de modifier un genre",
            ),
            security:"is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            openapi: new ModelOperation(
                summary: "Supprimer  un genre",
                description: "Api qui permet de supprimer un genre",
            ),
            security:"is_granted('ROLE_ADMIN')"
        ),
        // new Put(),
    ],
    normalizationContext: ['groups' => 'genre:read'],
)]
#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['genre:read', 'movie:list','movie:read'])]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'le nom du genre doit être minimum de {{ limit }} characters',
        maxMessage: 'le nom du genre doit être maximum de {{ limit }} characters',
    )]
    #[ORM\Column(length: 100)]
    private ?string $name = null;

    /**
     * @var Collection<int, Movie>
     */


    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'belong')]
    private Collection $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): static
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
            $movie->addBelong($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): static
    {
        if ($this->movies->removeElement($movie)) {
            $movie->removeBelong($this);
        }

        return $this;
    }
}
