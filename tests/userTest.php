<?php
use PHPUnit\Framework\TestCase;
require __DIR__ . '/../vendor/autoload.php';

class UserTest extends TestCase {
    public function testGetFullName() {
        $user = new User('John', 'Doe');
        $this->assertEquals('John Doe', $user->getFullName());
    }

    public function testAuthentificate() {
        $user = new User('John', 'Doe', 'johndoe', 'password123');
        $this->assertTrue($user->authentificate('password123'));
        $this->assertFalse($user->authentificate('wrongpassword'));
    }
}

?>