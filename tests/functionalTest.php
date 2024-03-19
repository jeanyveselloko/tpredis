<?php
use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
require __DIR__ . '/../vendor/autoload.php';

class FunctionalTest extends TestCase {
    protected $webDriver;

    protected function setUp(): void {
        $this->webDriver = RemoteWebDriver::create('http://localhost/tpredis/src/add.php', ['platform' => 'WINDOWS', 'browserName' => 'chrome']);
    }

    protected function tearDown(): void {
        $this->webDriver->quit();
    }

    public function testAddUser() {
        $this->webDriver->get('http://localhost/tpredis/src/add.php');
    
        // Remplir tous les champs du formulaire
        $this->webDriver->findElement(WebDriverBy::name('nom'))->sendKeys('John');
        $this->webDriver->findElement(WebDriverBy::name('prenom'))->sendKeys('Doe');
        $this->webDriver->findElement(WebDriverBy::name('username'))->sendKeys('johndoe');
        $this->webDriver->findElement(WebDriverBy::name('metier'))->sendKeys('macon');
        $this->webDriver->findElement(WebDriverBy::name('adresse'))->sendKeys('1 ter ru du houx 35700');
        $this->webDriver->findElement(WebDriverBy::name('password'))->sendKeys('password123');
    
        // Cliquer sur le bouton de soumission du formulaire
        $this->webDriver->findElement(WebDriverBy::cssSelector('button[type=submit]'))->click();
    
        // Vérifier si le texte "User added successfully" est présent sur la page
        $this->assertTrue($this->webDriver->findElement(WebDriverBy::tagName('body'))->getText() === 'User added successfully');
    }
    
}

?>