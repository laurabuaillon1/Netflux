<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserProcessor implements ProcessorInterface
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasherInterface, private EntityManagerInterface $em) {}
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $data->setRoles(['ROLE_USER']);
        $hash = $this->userPasswordHasherInterface->hashPassword($data, $data->getPassword());

        $data->setPassword($hash);
        $this->em->persist($data);
        $this->em->flush();

        return $data;
    }
}
