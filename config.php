<?php
require 'vendor/autoload.php';

$redisConfig = [
    'scheme' => 'tcp',
    'host' => 'redis-15823.c326.us-east-1-3.ec2.cloud.redislabs.com:15823',
    'port' => 15823,
    'password' => 'nl7bxM5J1JmVEUnU8APxMObMIrW80Jyd',
];

$redis = new Predis\Client($redisConfig);

$mysqlConfig = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'tpredis',
];

$mysqli = new mysqli($mysqlConfig['host'], $mysqlConfig['username'], $mysqlConfig['password'], $mysqlConfig['database']);

if ($mysqli->connect_error) {
    die("MySQL Connection failed: " . $mysqli->connect_error);
}
?>
