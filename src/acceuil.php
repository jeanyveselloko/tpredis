<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// You can now display the user's dashboard content
$userId = $_SESSION['user_id'];
// Fetch additional user data or perform other actions based on the user ID
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

<?php require 'header.html';?>
<div class="container">
    <h2>Bienvenue a vous </h2>
    <p>User ID: <?php echo $userId; ?></p>
</div>
<div class="container col-11">
    <h2>Liste des Utilisateurs</h2>
    <a href="add.php" class="btn btn-primary mb-3">Ajouter un Utilisateur</a>
    <a href="logout.php" class="btn btn-primary pull-right">Logout</a>
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
<?php require 'footer.html'; ?>
