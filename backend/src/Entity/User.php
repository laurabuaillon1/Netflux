<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation as ModelOperation;
use App\Repository\UserRepository;
use App\State\FavoriteListProvider;
use App\State\FavoriteProcessor;
use App\State\UserProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints\PasswordStrength;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/users/me',
            name: 'user_profil',
            openapi: new ModelOperation(
                summary: "Profil de l'utilisateur connecté",
                description: "Api qui permet de voir le profil de l'utilisateur connecté"
            ),
            security: "is_granted('ROLE_USER')",
            provider: UserProvider::class,
        ),
        new GetCollection(
            uriTemplate: '/users/{id}/favorites',
            name: 'user_favorite_list',
            openapi: new ModelOperation(
                summary: 'Liste des favoris',
                description: "Api qui permet de lister les films mis en favoris par l'utilisateur"
            ),
            normalizationContext: ['groups' => ['movie:list']],
            security: "is_granted('ROLE_USER')",
            provider: FavoriteListProvider::class,
        ),
        new Post(
            uriTemplate: '/users/{id}/favorites',
            name: 'user_favorite_list_update',
            openapi: new ModelOperation(
                summary: "Ajout/retrait d'un film en favoris",
                description: "Api qui permet d'ajouter/d'enlever un film mis en favoris"
            ),
            security: "is_granted('ROLE_USER')",
            processor: FavoriteProcessor::class,
            denormalizationContext: ['groups' => ['favorite:write']],
        ),
        // new Post(
        //     uriTemplate: '/users',
        //     name: 'user_new',
        //     openapi: new ModelOperation(
        //         summary: "Ajout d'un utilisateur",
        //         description: "Api qui permet d'ajouter un utilisateur"
        //     ),
        // ),
        new Patch(
            uriTemplate: '/users/{id}',
            name: 'user_updated',
            openapi: new ModelOperation(
                summary: "Modifier certains champs d'un utilisateur",
                description: "Api qui permet de modifier certains champs d'un utilisateur"
            ),
            security: "is_granted('ROLE_USER') and object == user or is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            uriTemplate: '/users/{id}',
            name: 'user_delete',
            openapi: new ModelOperation(
                summary: "Supprimer un utilisateur",
                description: "Api qui permet de supprimer un utilisateur"
            ),
            security: "is_granted('ROLE_USER') and object == user or is_granted('ROLE_ADMIN')"
        ),
        
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']]
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['user:read', 'user:write'])]
    #[Assert\NotBlank(message: "L\'email' est obligatoire.")]
    #[Assert\Email(
        message: 'l\email: "{{ value }} " n\'est pas valide'
    )]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['user:read'])]
    #[Assert\Choice(
        choices: ['ROLE_USER', 'ROLE_ADMIN'],
        multiple: true,
        message: 'Rôle invalide.'
    )]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['user:write'])]
    #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
    #[Assert\Length(
        min: 8,
        minMessage: "Le mot de passe doit contenir au moins {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: '/^(?=.*[A-Za-z])(?=.*\d).+$/',
        message: "Le mot de passe doit contenir au moins une lettre et un chiffre."
    )]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Votre pseudo doit être minimum de {{ limit }} characters',
        maxMessage: 'Votre pseudo doit être maximum de {{ limit }} characters',
    )]
    #[Groups(['user:read', 'user:write'])]
    private ?string $pseudo = null;

    /**
     * @var Collection<int, Movie>
     */
    #[ORM\ManyToMany(targetEntity: Movie::class, inversedBy: 'users')]
    #[Groups(['user:read', 'user:write','favorite:write'])]
    private Collection $favoris;

    public function __construct()
    {
        $this->favoris = new ArrayCollection();
    }

    /**
     * @var Collection<int, Movie>
     */




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Movie $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
        }

        return $this;
    }

    public function removeFavori(Movie $favori): static
    {
        $this->favoris->removeElement($favori);

        return $this;
    }
}
