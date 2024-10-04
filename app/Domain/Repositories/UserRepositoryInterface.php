<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;

interface UserRepositoryInterface {
    public function getAllUsers(): array;
    public function addUser(User $user): void;
    public function findByEmail(string $email): ?User;
}
