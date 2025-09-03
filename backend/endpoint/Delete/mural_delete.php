<?php
require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"), true);

// Atualizando a consulta SQL de acordo com a tabela 'Murais'
$sql = $conn->prepare("DELETE FROM murais WHERE idMurais = :id");
$sql->bindValue(':id', $json['idMurais'], PDO::PARAM_INT);

// Executando a consulta SQL
$sql->execute();

// Verificando se a exclusão foi bem-sucedida
if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "erro"]);
}
?>