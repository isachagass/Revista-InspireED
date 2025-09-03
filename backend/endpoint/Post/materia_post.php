<?php
require_once '../database.php';

header('Content-Type: application/json');
$json = json_decode(file_get_contents("php://input"),true);


$sql = $conn->prepare(query: "INSERT INTO matéria VALUE(NULL, :tipo)");
$sql->bindValue(':tipo', $json['Matéria_tipo']);

$sql->execute();

if ($sql->rowCount() > 0) {
    header('Content-Type: application/json');
    $mesagem = [
        "status" => "success",
    ];
    echo json_encode($mesagem);

} else {
    header("Content-Type: application/json");
    $mesagem = [
        "status" => "erro",
    ];
    echo json_encode($mesagem);
}


