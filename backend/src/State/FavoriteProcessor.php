<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\MovieRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class FavoriteProcessor implements ProcessorInterface
{

    public function __construct(
        private UserRepository $userRepository,
        private MovieRepository $movieRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $user = $this->userRepository->find($uriVariables['id']);
        $movie = $data->getFavoris()->first();
        $this->entityManager->refresh($user);

        if ($user->getFavoris()->contains($movie)) {
            $user->removeFavori($movie);
        } else {
            $user->addFavori($movie);
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user->getFavoris();
    }
}
