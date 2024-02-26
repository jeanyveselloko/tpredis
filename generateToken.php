<?php
require 'config.php';

// Function to generate a secure token
function generateToken() {
    return bin2hex(random_bytes(16)); // Adjust the length based on your security needs
}

// Function to set a user token in Redis
function setUserToken($userId, $token, $expiration) {
    global $redis;

    $redis->set("token:$token", $userId);
    
    // Set the token expiration (for example, expire after 1 hour)
    $redis->set("token:$token:expiration", $expiration);
}

// Function to get user ID from the token (replace with your logic)
function getUserIdFromToken($token) {
    global $redis;

    // Retrieve the user ID associated with the token
    $userId = $redis->get("token:$token");

    // Check if the token has expired
    $expiration = $redis->get("token:$token:expiration");
    if ($expiration && time() > $expiration) {
        // Token has expired
        return null;
    }

    return $userId;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_GET['token'];

    // Validate the token
    $userId = getUserIdFromToken($token);

    if ($userId !== null) {
        // Perform the action for the authenticated user
        // ...

        // Optionally, refresh the token expiration if needed
        $newExpiration = time() + 3600; // Set to expire 1 hour from now
        setUserToken($userId, $token, $newExpiration);
    } else {
        // Invalid or expired token
        die("Invalid or expired token");
    }
}

// When generating a token for a user (for example, in your HTML link)
$userToBeAuthenticatedId = "123"; // Replace with the actual user ID
$newToken = generateToken();
$tokenExpiration = time() + 3600; // Set to expire 1 hour from now
setUserToken($userToBeAuthenticatedId, $newToken, $tokenExpiration);

?>