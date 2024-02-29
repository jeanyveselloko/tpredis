<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

function getUserDetailsFromRedis($userId) {
    global $redis;

    // Utilisez lRange pour obtenir tous les éléments de la liste
    $userList = $redis->lRange('utilisateurs', 0, -1);

    // Vérifier si les données ont été récupérées avec succès
    if (empty($userList)) {
        return null;
    }

    // Parcourir les éléments pour trouver celui correspondant à l'ID recherché
    foreach ($userList as $userData) {
        $userDetails = json_decode($userData, true);

        // Vérifiez si l'ID correspond à l'utilisateur recherché
        if ($userDetails['id'] == $userId) {
            return $userDetails;
        }
    }

    // Si l'utilisateur n'est pas trouvé
    return null;
}


if (isset($_GET['id'])) {
    $userId = (int)$_GET['id'];
    $userDetails = getUserDetailsFromRedis($userId);

    // Vérifier si les données utilisateur sont valides
    if ($userDetails === null) {
        header('Location: acceuil.php');
        exit();
    }
} else {
    // Si pas d'ID utilisateur passé en paramètre
    header('Location: acceuil.php');
    exit();
}

?>

<?php require 'header.html';?>
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
<?php require 'footer.html';?>
