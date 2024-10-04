<?php

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Persistence\UserRepository;
use App\Domain\Entities\User;

class UserRepositoryTest extends TestCase {
    private $repository;

    protected function setUp(): void {
        $this->repository = new UserRepository();
    }

    public function testCanAddAndRetrieveUser() {
        $user = new User("Alice Johnson", "alice.johnson@example.com", "Student");
        $this->repository->addUser($user);

        $retrievedUser = $this->repository->findByEmail("alice.johnson@example.com");
        $this->assertEquals($user->getName(), $retrievedUser->getName());
    }

    public function testCanRetrieveAllUsers() {
        $users = $this->repository->getAllUsers();
        $this->assertGreaterThan(0, count($users)); // Verifica se existem usuários no repositório
    }
}
