<?php

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Persistence\LoanRepository;
use App\Domain\Entities\Loan;
use App\Domain\Entities\User;
use App\Domain\Entities\Book;

class LoanRepositoryTest extends TestCase {
    private $repository;

    protected function setUp(): void {
        $this->repository = new LoanRepository();
    }

    public function testCanAddAndRetrieveLoan() {
        $user = new User("Charlie Brown", "charlie.brown@example.com", "Student");
        $book = new Book("Design Patterns", "Erich Gamma", "978-0201633610");
        $loan = new Loan($user, $book);

        $this->repository->addLoan($loan);

        $retrievedLoan = $this->repository->findActiveLoan($book->getIsbn(), $user->getEmail());
        $this->assertEquals($loan->getUser()->getEmail(), $retrievedLoan->getUser()->getEmail());
    }

    public function testCanRetrieveAllLoans() {
        $loans = $this->repository->getAllLoans();
        $this->assertGreaterThan(0, count($loans)); // Verifica se existem empréstimos no repositório
    }
}
