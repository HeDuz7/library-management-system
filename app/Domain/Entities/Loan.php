<?php

namespace App\Domain\Entities;

use DateTime;

class Loan {
    private User $user;
    private Book $book;
    private DateTime $borrowDate;
    private ?DateTime $returnDate = null;

    public function __construct(User $user, Book $book) {
        $this->user = $user;
        $this->book = $book;
        $this->borrowDate = new DateTime();
    }

    public function getUser(): User {
        return $this->user;
    }

    public function getBook(): Book {
        return $this->book;
    }

    public function getBorrowDate(): DateTime {
        return $this->borrowDate;
    }

    public function getReturnDate(): ?DateTime {
        return $this->returnDate;
    }

    public function returnBook(): void {
        $this->returnDate = new DateTime();
    }

    public function isReturned(): bool {
        return $this->returnDate !== null;
    }
}
