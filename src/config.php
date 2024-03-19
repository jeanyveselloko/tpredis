<?php
require __DIR__ . '/../vendor/autoload.php';


$redisConfig = [
    'scheme' => 'tcp',
    'host' => 'redis-19484.c326.us-east-1-3.ec2.cloud.redislabs.com:19484',
    'port' => 19484,
    'password' => 'UzLOwXSXclqRSHm2ADMxIjcOzGsZT8Qp',
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
