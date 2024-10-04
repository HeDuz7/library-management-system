<?php

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Persistence\BookRepository;
use App\Domain\Entities\Book;

class BookRepositoryTest extends TestCase {
    private $repository;

    protected function setUp(): void {
        $this->repository = new BookRepository();
    }

    public function testCanAddAndRetrieveBook() {
        $book = new Book("The Pragmatic Programmer", "Andrew Hunt", "978-0201616224");
        $this->repository->addBook($book);

        $retrievedBook = $this->repository->findByIsbn("978-0201616224");
        $this->assertEquals($book->getTitle(), $retrievedBook->getTitle());
        $this->assertEquals($book->getAuthor(), $retrievedBook->getAuthor());
    }

    public function testCanRetrieveAllBooks() {
        $books = $this->repository->getAllBooks();
        $this->assertGreaterThan(0, count($books)); // Verifica se existem livros no repositório
    }
}
