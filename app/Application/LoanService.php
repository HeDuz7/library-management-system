<?php

namespace App\Application;

use App\Domain\Entities\Loan;
use App\Infrastructure\Persistence\LoanRepository;
use App\Infrastructure\Persistence\BookRepository;
use App\Infrastructure\Persistence\UserRepository;

class LoanService {
    private LoanRepository $loanRepository;
    private BookRepository $bookRepository;
    private UserRepository $userRepository;

    public function __construct() {
        $this->loanRepository = new LoanRepository();
        $this->bookRepository = new BookRepository();
        $this->userRepository = new UserRepository();
    }

    public function borrowBook(string $isbn, string $email): void {
        $book = $this->bookRepository->findByIsbn($isbn);
        $user = $this->userRepository->findByEmail($email);

        if ($book && !$book->isBorrowed()) {
            $loan = new Loan($user, $book);
            $book->borrow();
            $this->loanRepository->addLoan($loan);
            $this->bookRepository->updateBook($book);
        } else {
            throw new \Exception("Book is already borrowed or not found.");
        }
    }

    public function returnBook(string $isbn, string $email): void {
        $loan = $this->loanRepository->findActiveLoan($isbn, $email);
        if ($loan) {
            $loan->returnBook();
            $this->loanRepository->updateLoan($loan);
            $book = $loan->getBook();
            $book->returnBook();
            $this->bookRepository->updateBook($book);
        } else {
            throw new \Exception("No active loan found for this book and user.");
        }
    }

    public function listLoans(): array {
        return $this->loanRepository->getAllLoans();
    }
}
