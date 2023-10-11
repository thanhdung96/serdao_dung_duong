<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) { }

    public function findAllUsers(): array {
        return $this->userRepository->findAll();
    }

    public function findUserById(string $id): ?User{
        return $this->userRepository->find($id);
    }

    public function newUser(User $user): void{
        $this->userRepository->add($user);
    }

    public function removeUser(User $user): void{
        $this->userRepository->remove($user);
    }

    public function validateUser(User $user): array{
        return [];
    }
}