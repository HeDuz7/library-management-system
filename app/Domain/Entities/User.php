<?php

namespace App\Domain\Entities;

class User {
    private string $name;
    private string $email;
    private string $role; // Pode ser "Student" ou "Professor"

    public function __construct(string $name, string $email, string $role) {
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getRole(): string {
        return $this->role;
    }
}
