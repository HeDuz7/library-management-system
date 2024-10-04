<?php

namespace App\Application;

use App\Domain\Entities\User;
use App\Infrastructure\Persistence\UserRepository;

class UserService {
    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function addUser(User $user): void {
        $this->userRepository->addUser($user);
    }

    public function listUsers(): array {
        return $this->userRepository->getAllUsers();
    }

    public function findUserByEmail(string $email): ?User {
        return $this->userRepository->findByEmail($email);
    }
}
