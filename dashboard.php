<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// You can now display the user's dashboard content
$userId = $_SESSION['user_id'];
// Fetch additional user data or perform other actions based on the user ID

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Welcome to the Dashboard</h2>
    <p>User ID: <?php echo $userId; ?></p>
    <a href="logout.php" class="btn btn-primary">Logout</a>
</div>

</body>
</html>
