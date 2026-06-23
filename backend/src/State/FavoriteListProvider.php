<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;

class FavoriteListProvider implements ProviderInterface
{
    public function __construct(
        private UserRepository $userRepository
        )
    { }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $user = $this->userRepository->find($uriVariables['id']);
        return $user->getFavoris()->toArray();    }
}
