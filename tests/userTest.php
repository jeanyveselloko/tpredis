<?php

use PHPUnit\Framework\TestCase;



class UserRegistrationTest extends TestCase {
    
    public function testUserRegistration() {
        // Créer un nouvel utilisateur
        $user = new User('John', 'Doe', 'johndoe',  'macon', '1 ter ru du houx 35700','password123');
        
        // Vérifier que l'utilisateur est créé avec succès
        $this->assertInstanceOf(User::class, $user);
        
        // Vérifier que les informations de l'utilisateur sont correctes
        $this->assertEquals('John', $user->getFirstNom());
        $this->assertEquals('Doe', $user->getLastPrenom());
        $this->assertEquals('johndoe', $user->getUsername());
        $this->assertEquals('macon', $user->getMetier());
        $this->assertEquals('1 ter ru du houx 35700', $user->getAdresse());
        $this->assertTrue(password_verify('password123', $user->getPassword())); // Vérifie si le mot de passe est correctement haché
        
        // Vous pouvez ajouter plus de vérifications ici selon vos besoins
    }

    // public function testUserRegistrationWithInvalidData() {
    //     // Test d'enregistrement avec des données incorrectes
    //     // Par exemple, en utilisant un nom d'utilisateur vide
    //     $this->expectException(InvalidArgumentException::class);
    //     new User('John', 'Doe', '', 'password123');
    // }

    // Vous pouvez ajouter plus de tests ici pour tester d'autres scénarios d'enregistrement d'utilisateurs
}
?>
