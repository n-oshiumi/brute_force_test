<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbName = $_ENV['DB_NAME'];
$dbHost = $_ENV['DB_HOST'];
$dbUserName = $_ENV['DB_USERNAME'];
$dbPassword = $_ENV['DB_PASSWORD'];

try {
    //DBに接続
    $dsn = "mysql:dbname=$dbName; host=$dbHost";
    $username = $dbUserName;
    $password = $dbPassword;
    $pdo = new PDO($dsn, $username, $password);
} catch (Exception $e) {
    echo $e->getMessage();
}

?>
