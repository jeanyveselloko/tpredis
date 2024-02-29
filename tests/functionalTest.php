<?php
use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
require __DIR__ . '/../vendor/autoload.php';

class FunctionalTest extends TestCase {
    protected $webDriver;

    protected function setUp(): void {
        $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', ['platform' => 'WINDOWS', 'browserName' => 'chrome']);
    }

    protected function tearDown(): void {
        $this->webDriver->quit();
    }

    public function testAddUser() {
        $this->webDriver->get('http://your-app-url');

        $this->webDriver->findElement(WebDriverBy::name('nom'))->sendKeys('John');
        $this->webDriver->findElement(WebDriverBy::name('prenom'))->sendKeys('Doe');
        // ... other form fields

        $this->webDriver->findElement(WebDriverBy::name('password'))->sendKeys('password123');
        $this->webDriver->findElement(WebDriverBy::cssSelector('button[type=submit]'))->click();

        $this->assertTrue($this->webDriver->findElement(WebDriverBy::tagName('body'))->getText() === 'User added successfully');
    }
}

?>