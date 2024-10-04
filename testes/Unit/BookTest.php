<?php

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Book;
use App\Domain\ValueObjects\ISBN;

class BookTest extends TestCase {
    public function testBookCanBeCreated() {
        $book = new Book("Clean Code", "Robert C. Martin", "978-0132350884");
        $this->assertEquals("Clean Code", $book->getTitle());
        $this->assertEquals("Robert C. Martin", $book->getAuthor());
        $this->assertEquals("978-0132350884", $book->getIsbn());
    }

    public function testBookCanBeBorrowed() {
        $book = new Book("Clean Code", "Robert C. Martin", "978-0132350884");
        $book->borrow();
        $this->assertTrue($book->isBorrowed());
    }

    public function testBookCannotBeBorrowedTwice() {
        $this->expectException(Exception::class);
        $book = new Book("Clean Code", "Robert C. Martin", "978-0132350884");
        $book->borrow();
        $book->borrow(); // Should throw an exception
    }

    public function testBookCanBeReturned() {
        $book = new Book("Clean Code", "Robert C. Martin", "978-0132350884");
        $book->borrow();
        $book->returnBook();
        $this->assertFalse($book->isBorrowed());
    }
}
