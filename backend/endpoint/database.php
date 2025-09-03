<?php
$host = "10.188.35.19";
$port = "3024";
$dbname = "isabelli-kubo";
$username = "isabelli-kubo";
$password = "isabelli-kubo";

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
