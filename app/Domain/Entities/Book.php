<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\ISBN;

class Book {
    private string $title;
    private string $author;
    private ISBN $isbn;
    private bool $borrowed = false;

    public function __construct(string $title, string $author, string $isbn) {
        $this->title = $title;
        $this->author = $author;
        $this->isbn = new ISBN($isbn);
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function getIsbn(): string {
        return $this->isbn->getValue();
    }

    public function borrow(): void {
        if ($this->borrowed) {
            throw new \Exception("The book is already borrowed.");
        }
        $this->borrowed = true;
    }

    public function returnBook(): void {
        if (!$this->borrowed) {
            throw new \Exception("The book is not borrowed.");
        }
        $this->borrowed = false;
    }

    public function isBorrowed(): bool {
        return $this->borrowed;
    }
}
