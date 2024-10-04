<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Loan;

interface LoanRepositoryInterface {
    public function getAllLoans(): array;
    public function addLoan(Loan $loan): void;
    public function findActiveLoan(string $isbn, string $email): ?Loan;
    public function updateLoan(Loan $loan): void;
}
