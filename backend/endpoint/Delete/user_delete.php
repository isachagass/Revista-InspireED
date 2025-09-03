<?php
require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"), true);
var_dump($json);

$id_user = $json['idUsuarios'];

$sql = $conn->prepare("DELETE FROM usuarios WHERE idUsuarios = :id");
$sql->bindValue(':id', $id_user, PDO::PARAM_INT);

$sql->execute();

if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "erro"]);
}

