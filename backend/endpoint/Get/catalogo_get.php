<?php
header("Content-Type: application/json");
require '../database.php';

$sql = "SELECT Usuario_nome, Catalogo_titulo, Catalogo_img, Catalogo_sinopse FROM catalogos INNER JOIN usuarios ON Catalogos.Usuarios_idUsuarios = Usuarios.idUsuarios";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);