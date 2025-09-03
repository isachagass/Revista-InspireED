
<?php
require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"), true);

$sql = $conn->prepare("UPDATE matéria SET Matéria_tipo = :tipo WHERE idMatéria = :id");
$sql->bindValue(':tipo', $json['Matéria_tipo']);
$sql->bindValue(':id', $json['idMatéria'], PDO::PARAM_INT);

$sql->execute();

if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "erro"]);
}