<?php
require 'config.php';

function getUserDetailsFromRedis($userId) {
    global $redis;
    $userData = $redis->lIndex('utilisateurs', $userId);
    return json_decode($userData, true);
}


// Check if the user ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = (int)$_GET['id'];
    $userDetails = getUserDetailsFromRedis($userId);
} else {
    // Redirect to the user list if no user ID is provided
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Utilisateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Détails de l'Utilisateur</h2>
    <a href="acceuil.php" class="btn btn-primary mb-3">Retour à la Liste des Utilisateurs</a>
    <dl class="row">
        <dt class="col-sm-3">ID</dt>
        <dd class="col-sm-9"><?php echo isset($userDetails['id']) ? $userDetails['id'] : ''; ?></dd>

        <dt class="col-sm-3">Nom</dt>
        <dd class="col-sm-9"><?php echo isset($userDetails['nom']) ? $userDetails['nom'] : ''; ?></dd>

        <dt class="col-sm-3">Prénom</dt>
        <dd class="col-sm-9"><?php echo isset($userDetails['prenom']) ? $userDetails['prenom'] : ''; ?></dd>

        <dt class="col-sm-3">Nom d'utilisateur</dt>
        <dd class="col-sm-9"><?php echo isset($userDetails['username']) ? $userDetails['username'] : ''; ?></dd>

        <dt class="col-sm-3">Métier</dt>
        <dd class="col-sm-9"><?php echo isset($userDetails['metier']) ? $userDetails['metier'] : ''; ?></dd>

        <dt class="col-sm-3">Adresse</dt>
        <dd class="col-sm-9"><?php echo isset($userDetails['adresse']) ? $userDetails['adresse'] : ''; ?></dd>
    </dl>
</div>
</body>
</html>
