<?php
header("Content-Type: application/json");
require '../database.php';

$sql = "SELECT Usuario_nome, Matéria_tipo, Atividade_titulo, Atividade_img, Atividade_cont FROM atividades INNER JOIN usuarios ON atividades.Usuarios_idUsuarios = Usuarios.idUsuarios JOIN matéria ON Matéria.idMatéria = Atividades.Matéria_idMatéria";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);