<?php

require 'vendor/autoload.php';

use App\Domain\Entities\Book;
use App\Domain\Entities\User;
use App\Domain\Entities\Loan;
use App\Infrastructure\Persistence\BookRepository;
use App\Infrastructure\Persistence\UserRepository;
use App\Infrastructure\Persistence\LoanRepository;

// Criação de repositórios (normalmente isso seria feito via injeção de dependências)
$bookRepository = new BookRepository();
$userRepository = new UserRepository();
$loanRepository = new LoanRepository();

// Adiciona livros ao repositório
$book1 = new Book("The Pragmatic Programmer", "Andrew Hunt", "978-0201616224");
$book2 = new Book("Clean Code", "Robert C. Martin", "978-0132350884");

$bookRepository->addBook($book1);
$bookRepository->addBook($book2);

// Adiciona usuários ao repositório
$user1 = new User("Alice Johnson", "alice.johnson@example.com", "Student");
$user2 = new User("Bob Smith", "bob.smith@example.com", "Professor");

$userRepository->addUser($user1);
$userRepository->addUser($user2);

// Exibe todos os livros disponíveis
echo "Available books:\n";
foreach ($bookRepository->getAllBooks() as $book) {
    echo "- " . $book->getTitle() . " by " . $book->getAuthor() . " (ISBN: " . $book->getIsbn() . ")\n";
}

// Empresta um livro
echo "\nLoaning 'Clean Code' to Alice Johnson...\n";
$loan = new Loan($user1, $book2);
$loanRepository->addLoan($loan);
$book2->borrow();

// Verifica se o livro foi emprestado
echo "Is 'Clean Code' borrowed? " . ($book2->isBorrowed() ? "Yes" : "No") . "\n";

// Retorna o livro
echo "\nReturning 'Clean Code'...\n";
$loan->returnBook();
$book2->returnBook();

// Verifica novamente
echo "Is 'Clean Code' borrowed? " . ($book2->isBorrowed() ? "Yes" : "No") . "\n";
