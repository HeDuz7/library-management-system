<?php

namespace App\Domain\ValueObjects;

class ISBN {
    private string $value;

    public function __construct(string $isbn) {
        if (!$this->isValidIsbn($isbn)) {
            throw new \Exception("Invalid ISBN format.");
        }
        $this->value = $isbn;
    }

    private function isValidIsbn(string $isbn): bool {
        // Validação básica de ISBN
        return preg_match('/^\d{3}-\d{10}$/', $isbn) === 1;
    }

    public function getValue(): string {
        return $this->value;
    }
}
