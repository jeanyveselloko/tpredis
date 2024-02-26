<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $metier = $_POST['metier'];
    $adresse = $_POST['adresse'];
    $password = $_POST['password'];

    // Call the API to get address details
    $apiUrl = "https://api-adresse.data.gouv.fr/search/?q=" . urlencode($adresse) . "&type=housenumber&autocomplete=1";
    $apiResponse = file_get_contents($apiUrl);
    $apiData = json_decode($apiResponse, true);

    // Extract relevant information from the API response
    if (isset($apiData['features'][0]['properties'])) {
        $properties = $apiData['features'][0]['properties'];
        $street = $properties['street'];
        $postcode = $properties['postcode'];
        $city = $properties['city'];
        $fullAddress = $properties['label'];

        // Continue with the rest of your code to store the user in Redis and MySQL
        global $redis, $mysqli;

        // Generate a unique ID for the user
        $userId = uniqid();

        $userKey = "users:$userId";
        $user = [
            'id' => $userId,
            'nom' => $nom,
            'prenom' => $prenom,
            'username' => $username,
            'metier' => $metier,
            'adresse' => $fullAddress,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];

        // Add the user to Redis list
        $redis->rPush('utilisateurs', json_encode($user));

        // Save 
        $redis->hMset($userKey, $user);

        // Add MySQL database
        $stmt = $mysqli->prepare("INSERT INTO users (nom, prenom, username, metier, adresse, password) VALUES (?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("ssssss", $nom, $prenom, $username, $metier, $fullAddress, password_hash($password, PASSWORD_DEFAULT));

            if ($stmt->execute()) {
                $stmt->close();

                header('Location: acceuil.php');
                exit;
            } else {
                die("MySQL Execute failed: " . $stmt->error);
            }
        } else {
            die("MySQL Prepare failed: " . $mysqli->error);
        }
    } else {
        echo "Unable to fetch address details from the API.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Utilisateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>

<div class="container mt-5">
    <h2>Ajouter un Utilisateur</h2>
    <form method="post">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom:</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>
        <div class="form-group">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="metier">Métier:</label>
            <input type="text" class="form-control" id="metier" name="metier" required>
        </div>
        <div class="form-group">
            <label for="adresse">Addresse:</label>
            <input type="text" class="form-control" id="metier" name="adresse" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="acceuil.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>


</body>
</html>
