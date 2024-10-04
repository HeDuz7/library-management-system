<?php

namespace App\Application;

use App\Domain\Entities\Book;
use App\Infrastructure\Persistence\BookRepository;

class BookService {
    private BookRepository $bookRepository;

    public function __construct() {
        $this->bookRepository = new BookRepository();
    }

    public function addBook(Book $book): void {
        $this->bookRepository->addBook($book);
    }

    public function listBooks(): array {
        return $this->bookRepository->getAllBooks();
    }

    public function borrowBook(string $isbn): void {
        $book = $this->bookRepository->findByIsbn($isbn);
        if ($book) {
            $book->borrow();
            $this->bookRepository->updateBook($book);
        } else {
            throw new \Exception("Book not found.");
        }
    }

    public function returnBook(string $isbn): void {
        $book = $this->bookRepository->findByIsbn($isbn);
        if ($book) {
            $book->returnBook();
            $this->bookRepository->updateBook($book);
        } else {
            throw new \Exception("Book not found.");
        }
    }
}
