<?php
// Inclure l'autoloader de Predis
require 'vendor/autoload.php';

// Configuration du serveur Redis
$redisConfig = [
    'scheme' => 'tcp',
    'host' => 'redis-16004.c326.us-east-1-3.ec2.cloud.redislabs.com:16004',
    'port' => 16004,
    'password' => 'txR0eUzFoSc3ze124MIm3vmCi0aAj8lk',
];

try {
    // Créer un nouveau client Predis
    $redis = new Predis\Client($redisConfig);



  // Créer un nouvel utilisateur
  function createUser($userId, $userName, $userEmail, $userPassword) {
    global $redis;
    $userKey = "user:$userId";

    // Hasher le mot de passe
    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

    $userData = [
        'id' => $userId,
        'name' => $userName,
        'email' => $userEmail,
        'password' => $hashedPassword, // Ajouter le mot de passe hashé
    ];

    // Ajouter les données de l'utilisateur à la fin de la liste 'utilisateurs'
    $redis->rPush('utilisateurs', json_encode($userData)); // Convertir le tableau en JSON avant de le stocker

    // Enregistrer les données de l'utilisateur
    $redis->hMset($userKey, $userData);
}

if (isset($_POST['createUser'])) {
    // Récupérer les valeurs du formulaire
    $userId = $_POST['userId'];
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];

    // Appeler la fonction pour créer un utilisateur
    createUser($userId, $userName, $userEmail, $userPassword);
}



    // Lire les données utilisateur
    function readUser() {
        global $redis;
    
        // Récupérer tous les éléments de la liste 'utilisateurs'
        $userList = $redis->lRange('utilisateurs', 0, -1);
    
        $users = [];
    
        // Convertir les utilisateurs en tableau
        foreach ($userList as $userData) {
            $user = json_decode($userData, true); // Convertir JSON en tableau
            $users[] = $user;
        }
    
        return $users;
    }
    
    
    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['createUser'])) {
            // Récupérer les valeurs du formulaire
            $userId = $_POST['userId'];
            $userName = $_POST['userName'];
            $userEmail = $_POST['userEmail'];
            $userPassword = $_POST['userPassword'];
    
            // Appeler la fonction pour créer un utilisateur
            createUser($userId, $userName, $userEmail, $userPassword);
        } elseif (isset($_POST['listUsers'])) {
            // Appeler la fonction pour lister les utilisateurs
            listUsers();
        }
    }
    

    
    // Mettre à jour les données utilisateur
    function updateUser($userId, $newName, $newEmail) {
        global $redis;

        $userKey = "user:$userId";

        $userData = [
            'name' => $newName,
            'email' => $newEmail,
        ];

        $redis->hMset($userKey, $userData);
    }

    // Supprimer un utilisateur
    function deleteUser($userId) {
        global $redis;

        $userKey = "user:$userId";

        $redis->del($userKey);
    }

    // // Exemple d'utilisation

    // // Créer un nouvel utilisateur
    // createUser(1, 'John Doe', 'john@example.com', '1234567');

    // // Lire les données utilisateur
    // $getUserData = readUser(1);
    // echo "Données de l'utilisateur : " . print_r($getUserData, true) . "\n";

    // // Mettre à jour les données utilisateur
    // updateUser(1, 'John Doe Jr.', 'john.jr@example.com', '1234567');

    // // Lire les données utilisateur mises à jour
    // $updatedUserData = readUser(1);
    // echo "Données utilisateur mises à jour : " . print_r($updatedUserData, true) . "\n";

    // // Supprimer l'utilisateur
    // deleteUser(1);

    // // Tenter de lire les données d'un utilisateur supprimé
    // $deletedUserData = readUser(1);
    // echo "Données utilisateur supprimées : " . print_r($deletedUserData, true) . "\n";

    // Fermer la connexion Redis
    $redis->disconnect();
} catch (Predis\Response\ServerException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
?>