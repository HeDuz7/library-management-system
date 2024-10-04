<?php

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Loan;
use App\Domain\Entities\User;
use App\Domain\Entities\Book;

class LoanTest extends TestCase {
    public function testLoanCanBeCreated() {
        $user = new User("Alice Johnson", "alice.johnson@example.com", "Student");
        $book = new Book("Clean Code", "Robert C. Martin", "978-0132350884");
        $loan = new Loan($user, $book);

        $this->assertEquals($user, $loan->getUser());
        $this->assertEquals($book, $loan->getBook());
        $this->assertInstanceOf(DateTime::class, $loan->getBorrowDate());
        $this->assertNull($loan->getReturnDate());
    }

    public function testLoanCanBeReturned() {
        $user = new User("Alice Johnson", "alice.johnson@example.com", "Student");
        $book = new Book("Clean Code", "Robert C. Martin", "978-0132350884");
        $loan = new Loan($user, $book);

        $loan->returnBook();
        $this->assertInstanceOf(DateTime::class, $loan->getReturnDate());
        $this->assertTrue($loan->isReturned());
    }
}
