<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\OpenApi\Model\Operation as ModelOperation;
use App\Enum\MovieType;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    description: "Gestion des films de Netflux",
    operations: [
        new GetCollection(
            openapi: new ModelOperation(
                summary: "Liste des films",
                description: "Api qui permet de lister tout les films",
            ),
            normalizationContext: ['groups' => ['movie:list']],
            // Pagination
            paginationEnabled: true,
            paginationItemsPerPage: 10,
            paginationClientItemsPerPage: true,
            paginationMaximumItemsPerPage: 50,

        ),
        new Get(
            openapi: new ModelOperation(
                summary: "Fiche détaillé de chaque film",
                description: "Api qui permet d'afficher la fiche détaillée de chaque film"
            )
        ),
        new Post(
            openapi: new ModelOperation(
                summary: "Création d'un film",
                description: "Api qui permet d'ajouter un film"
            )
        ),
        new Put(
            openapi: new ModelOperation(
                summary: "Mettre à jour tout les champs du film",
                description: "Api qui permet de mettre à jours un film"
            )
        ),
        new Patch(
            openapi: new ModelOperation(
                summary: "Mettre à jour que certains champs du film",
                description: "Api qui permet de mettre à jours un film"
            )
        ),

        new Delete(
            openapi: new ModelOperation(
                summary: "Supprimer un film",
                description: " Api qui permet de supprimer un film"
            )
        ),
    ],
    normalizationContext: ['groups' => ['movie:read']],
    denormalizationContext: ['groups' => ['movie:write']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'title' => 'partial', //mot-clé sur le titre
    'type' => 'exact', //types(string) de contenu (film/serie)
    'belong.id' => 'exact', //genre (action,comédie)..par id
])]

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['movie:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movie:read', 'movie:write', 'movie:list'])]
    #[Assert\NotBlank(message: 'Le titre est obligatoire.')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'le titre du film doit être minimum de {{ limit }} characters',
        maxMessage: 'le titre du film doit être maximum de {{ limit }} characters',
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['movie:read', 'movie:write'])]
    #[Assert\NotBlank(message: 'Le synopsis est obligatoire.')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'le synopsis doit être minimum de {{ limit }} characters',
        maxMessage: 'le synopsis doit être maximum de {{ limit }} characters',
    )]
    private ?string $synopsis = null;

    #[ORM\Column]
    #[Groups(['movie:read', 'movie:write'])]
    #[Assert\NotBlank(message: 'La date de réalisation est obligatoire.')]
    // #[Assert\Date()]
    private ?\DateTime $releaseDate = null;

    #[ORM\Column(type: 'integer')]
    #[Groups(['movie:read', 'movie:write'])]
    #[Assert\NotBlank(message: 'La durée du film est obligatoire.')]
    #[Assert\Positive()]
    private ?int $duration = null;

    #[ORM\Column]
    #[Groups(['movie:read', 'movie:write'])]
    #[Assert\Range(min: 0, max: 5)]
    private ?float $rating = null;

    #[ORM\Column(enumType: MovieType::class, nullable: true)]
    #[Groups(['movie:read', 'movie:write', 'movie:list'])]
    private ?MovieType $type = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movie:read', 'movie:write', 'movie:list'])]
    #[Assert\NotBlank(message: 'L\'image du film est obligatoire.')]
    // #[Assert\Url(message: 'L\'URL de l\'image n\'est pas valide.')]
    private ?string $imageUrl = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movie:read', 'movie:write'])]
    #[Assert\NotBlank(message: 'La video du film est obligatoire.')]
    // #[Assert\Video()]
    private ?string $videoUrl = null;

    #[ORM\Column]
    #[Groups(['movie:read'])]
    private ?\DateTime $created_at = null;

    #[ORM\Column]
    #[Groups(['movie:read'])]
    private ?\DateTime $updated_at = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favoris')]
    private Collection $users;

    /**
     * @var Collection<int, Genre>
     */
    #[Groups(['movie:read', 'movie:list'])]
    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'movies')]
    private Collection $belong;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->belong = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getReleaseDate(): ?\DateTime
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTime $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getType(): ?MovieType
    {
        return $this->type;
    }

    public function setType(MovieType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    public function setVideoUrl(string $videoUrl): static
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTime $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addFavori($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavori($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getBelong(): Collection
    {
        return $this->belong;
    }

    public function addBelong(Genre $belong): static
    {
        if (!$this->belong->contains($belong)) {
            $this->belong->add($belong);
        }

        return $this;
    }

    public function removeBelong(Genre $belong): static
    {
        $this->belong->removeElement($belong);

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updated_at = new \DateTime();
    }
}
