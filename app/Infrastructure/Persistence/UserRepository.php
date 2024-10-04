<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {
    private string $filePath = __DIR__ . '/../Database/users.json';

    public function getAllUsers(): array {
        $usersData = json_decode(file_get_contents($this->filePath), true) ?? [];
        return array_map(function ($userData) {
            return new User($userData['name'], $userData['email'], $userData['role']);
        }, $usersData);
    }

    public function addUser(User $user): void {
        $users = $this->getAllUsers();
        $users[] = [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'role' => $user->getRole()
        ];
        file_put_contents($this->filePath, json_encode($users));
    }

    public function findByEmail(string $email): ?User {
        $users = $this->getAllUsers();
        foreach ($users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        return null;
    }
}
