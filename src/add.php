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


<?php require 'header.html';?>

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
    <label for="adresse">Adresse :</label>
    <input type="text" class="form-control" id="adresse" name="adresse" required>
    <div id="autocomplete-results"></div>
</div>
        <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="acceuil.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<script>
$(document).ready(function() {
    // Détecter les changements dans le champ d'adresse
    $('#adresse').on('input', function() {
        // Récupérer la valeur du champ d'adresse
        var adresseValue = $(this).val();

        // Vérifier si la valeur est vide
        if (adresseValue.trim() === '') {
            $('#autocomplete-results').html(''); // Effacer les résultats si le champ est vide
            return;
        }

        // Appeler l'API pour obtenir les détails de l'adresse
        var apiUrl = "https://api-adresse.data.gouv.fr/search/?q=" + encodeURIComponent(adresseValue) + "&type=housenumber&autocomplete=1";

        // Effectuer une requête AJAX
        $.ajax({
            url: apiUrl,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // Afficher les résultats dans la div autocomplete-results
                var resultsHtml = '';
                if (data.features && data.features.length > 0) {
                    data.features.forEach(function(feature) {
                        resultsHtml += '<div class="result-item" data-label="' + feature.properties.label + '">' + feature.properties.label + '</div>';
                    });
                } else {
                    resultsHtml = '<div>Aucun résultat trouvé.</div>';
                }
                $('#autocomplete-results').html(resultsHtml);
            },
            error: function() {
                $('#autocomplete-results').html('<div>Erreur lors de la récupération des résultats.</div>');
            }
        });
    });

    // Gérer le clic sur un résultat
    $('#autocomplete-results').on('click', '.result-item', function() {
        var selectedAddress = $(this).data('label');
        $('#adresse').val(selectedAddress);
        $('#autocomplete-results').html(''); // Effacer les résultats après le choix de l'utilisateur
    });
});
</script>
<?php require 'footer.html';?>
