<?php
// データベースに接続
$dsn = 'mysql:dbname=sns;host=172.24.188.149;charset=utf8mb4';
$user = 'root';
$password = 'Okazaki8888_';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    die('データベースに接続できませんでした。' . $e->getMessage());
}

?>