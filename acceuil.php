<?php
require 'config.php';

function readUsersFromRedis() {
    global $redis;
    $userList = $redis->lRange('utilisateurs', 0, -1);

    $users = [];
    foreach ($userList as $userData) {
        $user = json_decode($userData, true);
        $users[] = $user;
    }

    return $users;
}

// function readUsersFromMySQL() {
//     global $mysqli;
//     $users = [];

//     $result = $mysqli->query("SELECT * FROM users");
    
//     while ($row = $result->fetch_assoc()) {
//         $users[] = $row;
//     }

//     return $users;
// }

// Read users from both Redis and MySQL
$usersFromRedis = readUsersFromRedis();
// $usersFromMySQL = readUsersFromMySQL();

// Merge users from both sources
// $users = array_merge($usersFromRedis, $usersFromMySQL);
$users = array_merge($usersFromRedis);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5 col-11">
    <h2>Liste des Utilisateurs</h2>
    <a href="add.php" class="btn btn-primary mb-3">Ajouter un Utilisateur</a>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Nom d'utilisateur</th>
            <th>Métier</th>
            <th>Addresse</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo isset($user['id']) ? $user['id'] : ''; ?></td>
                <td><?php echo isset($user['nom']) ? $user['nom'] : ''; ?></td>
                <td><?php echo isset($user['prenom']) ? $user['prenom'] : ''; ?></td>
                <td><?php echo isset($user['username']) ? $user['username'] : ''; ?></td>
                <td><?php echo isset($user['metier']) ? $user['metier'] : ''; ?></td>
                <td><?php echo isset($user['adresse']) ? $user['adresse'] : ''; ?></td>
                <td>
                    <a href='view.php?id=<?php echo isset($user['id']) ? $user['id'] : ''; ?>' class='btn btn-info btn-sm'>Voir Détails</a>
                    <a href='edit.php?id=<?php echo isset($user['id']) ? $user['id'] : ''; ?>' class='btn btn-warning btn-sm'>Modifier</a>
                    <a href='delete.php?id=<?php echo isset($user['id']) ? $user['id'] : ''; ?>' class='btn btn-danger btn-sm'>Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
