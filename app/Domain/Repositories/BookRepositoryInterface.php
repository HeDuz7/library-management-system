<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Book;

interface BookRepositoryInterface {
    public function getAllBooks(): array;
    public function addBook(Book $book): void;
    public function findByIsbn(string $isbn): ?Book;
    public function updateBook(Book $book): void;
}
