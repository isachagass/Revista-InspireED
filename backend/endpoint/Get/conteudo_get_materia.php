<?php
header("Content-Type: application/json");
require '../database.php';

$sql = "SELECT * FROM conteudos WHERE Conteudo_tipo='2';";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
// pega somente os conteudos das matérias