<?php

use PHPUnit\Framework\TestCase;

require __DIR__ . '/../vendor/autoload.php';

class SecurityTest extends TestCase {
    public function testSqlInjection() {
        $mysqli = new mysqli('localhost', 'root', '', 'tpredis');

        // Utiliser des déclarations préparées pour empêcher les injections SQL
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $_GET['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        $this->assertNotNull($result);
    }

    public function testXssAttack() {

        $_GET['user_input'] = '<script>alert("XSS Attack!");</script>';
        $sanitizedInput = htmlspecialchars($_GET['user_input']);
        $this->assertEquals('&lt;script&gt;alert(&quot;XSS Attack!&quot;);&lt;/script&gt;', $sanitizedInput);
    }

    public function testLoginWithCorrectCredentials() {
        // Simulation
        $_GET['username'] = 'diraye';
        $_GET['password'] = '1234567';

        $loggedIn = $this->login($_GET['username'], $_GET['password']);

        $this->assertTrue($loggedIn);
    }

    public function login($username, $password) {
        return $username === 'diraye' && $password === '1234567';
    }
}


?>
