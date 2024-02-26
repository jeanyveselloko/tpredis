<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Interface Utilisateur Redis</title>
    <!-- Ajouter du style CSS pour rendre l'interface plus agréable -->
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php
// ... Votre code PHP existant ...
?>

<h2>Gestion des Utilisateurs</h2>

<form method="POST">
  <div class="mb-3 col-4">
    <label for="userId">ID Utilisateur:</label>
    <input type="text" name="userId" class="form-control" id="userId">
  </div>
  <div class="mb-3 col-4">
    <label for="userEmail">Email:</label>
    <input type="email" name="userEmail" class="form-control" id="userEmail" required>
  </div>
  <div class="mb-3 col-4">
    <label for="userName">Nom:</label>
    <input type="text" name="userName" class="form-control" id="userName" required>
  </div>
  <div class="mb-3 col-4">
    <label for="userPassword" class="form-label">Mot de passe</label>
    <input type="password" name="userPassword" class="form-control" id="userPassword" required>
  </div>
  <button type="submit" name="createUser" class="btn btn-primary">Créer</button>

  <!-- Ajoutez les autres boutons ici -->
</form>

<?php
// ... Gestion des formulaires ici ...


?>

<h2>Liste des Utilisateurs</h2>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    require 'index.php';

    $userList = readUser();

    foreach ($userList as $userData) {
        echo "<tr>";
        echo "<td>{$userData['id']}</td>";
        echo "<td>{$userData['name']}</td>";
        echo "<td>{$userData['email']}</td>";
        echo "<td><a href='utilisateur.php' onclick='updateUser({$userData['id']}, \"{$userData['name']}\", \"{$userData['email']}\")'>Modifier</a> | <a href='#' onclick='deleteUser({$userData['id']})'>Supprimer</a></td>";
        echo "</tr>";
    }
    
    
    
    ?>
    </tbody>
</table>

<script>

    function updateUserForm(userId, userName, userEmail) {
        console.log("Update User Form - User ID: " + userId + ", Name: " + userName + ", Email: " + userEmail);

        // Vérifiez si les champs sont correctement récupérés
        console.log("User ID field: ", document.getElementById('userId'));
        console.log("User Name field: ", document.getElementById('userName'));
        console.log("User Email field: ", document.getElementById('userEmail'));

        document.getElementById('userId').value = userId;
        document.getElementById('userName').value = userName;
        document.getElementById('userEmail').value = userEmail;
    }


    function deleteUser(userId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur?")) {
           .
            alert("Suppression de l'utilisateur " + userId);
        }
    }
</script>

<script src="js/bootstrap.min.js"></script>
</body>
</html>
