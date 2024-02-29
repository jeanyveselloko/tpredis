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
$currentUser = []; 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $userList = $redis->lRange('utilisateurs', 0, -1);

    foreach ($userList as $userData) {
        $user = json_decode($userData, true);
        if ($user['id'] === $id) {
            $currentUser = $user;
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $metier = $_POST['metier'];
    $password = $_POST['password'];

    $userList = $redis->lRange('utilisateurs', 0, -1);

    foreach ($userList as $key => $userData) {
        $user = json_decode($userData, true);
        if ($user['id'] === $id) {
            // Update user data in Redis
            $updatedUser = [
                'id' => $id,
                'nom' => $nom,
                'prenom' => $prenom,
                'username' => $username,
                'metier' => $metier,
                'password' => isset($password) ? password_hash($password, PASSWORD_DEFAULT) : $user['password'],
            ];
            $redis->lSet('utilisateurs', $key, json_encode($updatedUser));
            break;
        }
    }

    // Update user data in MySQL
    $stmt = $mysqli->prepare("UPDATE users SET nom=?, prenom=?, username=?, metier=?, password=? WHERE id=?");
    
    // Check if the prepare statement was successful
    if ($stmt) {
        $hashedPassword = isset($password) ? password_hash($password, PASSWORD_DEFAULT) : $currentUser['password'];
        $stmt->bind_param("ssssss", $nom, $prenom, $username, $metier, $hashedPassword, $id);

        // Check if the execute statement was successful
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
}
?>

<?php require 'header.html';?>

<div class="container mt-5">
    <h2>Modifier un Utilisateur</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo isset($currentUser['id']) ? $currentUser['id'] : ''; ?>">
        
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo isset($currentUser['nom']) ? $currentUser['nom'] : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom:</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo isset($currentUser['prenom']) ? $currentUser['prenom'] : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($currentUser['username']) ? $currentUser['username'] : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="metier">Métier:</label>
            <input type="text" class="form-control" id="metier" name="metier" value="<?php echo isset($currentUser['metier']) ? $currentUser['metier'] : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Nouveau mot de passe:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="acceuil.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
<?php require 'footer.html';?>
