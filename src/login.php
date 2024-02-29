<?php
session_start();

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($userId, $hashedPassword);
        
        if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
            // Login successful
            $_SESSION['user_id'] = $userId;
            header('Location: acceuil.php');
            exit;
        } else {
            $loginError = "Invalid username or password";
        }
        
        $stmt->close();
    } else {
        die("MySQL Prepare failed: " . $mysqli->error);
    }
}
?>

<?php require 'header.html';?>

<div class="container mt-5">
    <h2>Login</h2>
    <form method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <?php if (isset($loginError)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $loginError; ?>
            </div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
<?php require 'footer.html'; ?>

