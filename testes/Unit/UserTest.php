<?php

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\User;

class UserTest extends TestCase {
    public function testUserCanBeCreated() {
        $user = new User("Alice Johnson", "alice.johnson@example.com", "Student");
        $this->assertEquals("Alice Johnson", $user->getName());
        $this->assertEquals("alice.johnson@example.com", $user->getEmail());
        $this->assertEquals("Student", $user->getRole());
    }
}
