<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Loan;
use App\Domain\Repositories\LoanRepositoryInterface;

class LoanRepository implements LoanRepositoryInterface {
    private string $filePath = __DIR__ . '/../Database/loans.json';

    public function getAllLoans(): array {
        $loansData = json_decode(file_get_contents($this->filePath), true) ?? [];
        return array_map(function ($loanData) {
            // Recrie o empréstimo com base nos dados do JSON
            $bookRepo = new BookRepository();
            $userRepo = new UserRepository();
            $book = $bookRepo->findByIsbn($loanData['isbn']);
            $user = $userRepo->findByEmail($loanData['email']);
            $loan = new Loan($user, $book);
            if (isset($loanData['returnDate'])) {
                $loan->returnBook();
            }
            return $loan;
        }, $loansData);
    }

    public function addLoan(Loan $loan): void {
        $loans = $this->getAllLoans();
        $loans[] = [
            'isbn' => $loan->getBook()->getIsbn(),
            'email' => $loan->getUser()->getEmail(),
            'borrowDate' => $loan->getBorrowDate()->format('Y-m-d'),
            'returnDate' => $loan->getReturnDate() ? $loan->getReturnDate()->format('Y-m-d') : null
        ];
        file_put_contents($this->filePath, json_encode($loans));
    }

    public function findActiveLoan(string $isbn, string $email): ?Loan {
        $loans = $this->getAllLoans();
        foreach ($loans as $loan) {
            if ($loan->getBook()->getIsbn() === $isbn && $loan->getUser()->getEmail() === $email && !$loan->isReturned()) {
                return $loan;
            }
        }
        return null;
    }

    public function updateLoan(Loan $loan): void {
        $loans = $this->getAllLoans();
        foreach ($loans as &$storedLoan) {
            if ($storedLoan['isbn'] === $loan->getBook()->getIsbn() && $storedLoan['email'] === $loan->getUser()->getEmail()) {
                $storedLoan['returnDate'] = $loan->getReturnDate() ? $loan->getReturnDate()->format('Y-m-d') : null;
            }
        }
        file_put_contents($this->filePath, json_encode($loans));
    }
}
