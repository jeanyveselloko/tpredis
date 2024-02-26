<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $redis = new Predis\Client($redisConfig);

    $userList = $redis->lRange('utilisateurs', 0, -1);

    foreach ($userList as $key => $userData) {
        $user = json_decode($userData, true);
        if ($user['id'] === $id) {
            // Remove the entire element from the Redis list
            $result = $redis->lRem('utilisateurs', $userData);

            if ($result === false) {
                die("Error removing user from Redis: " . $redis->getLastError());
            }

            break;
        }
    }

    header('Location: acceuil.php');
    exit;
}
?>
