<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Book;
use App\Domain\Repositories\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface {
    private string $filePath = __DIR__ . '/../Database/books.json';

    public function getAllBooks(): array {
        $booksData = json_decode(file_get_contents($this->filePath), true) ?? [];
        return array_map(function ($bookData) {
            return new Book($bookData['title'], $bookData['author'], $bookData['isbn']);
        }, $booksData);
    }

    public function addBook(Book $book): void {
        $books = $this->getAllBooks();
        $books[] = [
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'isbn' => $book->getIsbn()
        ];
        file_put_contents($this->filePath, json_encode($books));
    }

    public function findByIsbn(string $isbn): ?Book {
        $books = $this->getAllBooks();
        foreach ($books as $book) {
            if ($book->getIsbn() === $isbn) {
                return $book;
            }
        }
        return null;
    }

    public function updateBook(Book $book): void {
        $books = $this->getAllBooks();
        foreach ($books as &$storedBook) {
            if ($storedBook['isbn'] === $book->getIsbn()) {
                $storedBook['borrowed'] = $book->isBorrowed();
            }
        }
        file_put_contents($this->filePath, json_encode($books));
    }
}
