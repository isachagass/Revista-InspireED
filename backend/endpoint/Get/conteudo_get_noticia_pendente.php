<?php
header("Content-Type: application/json");
require '../database.php';

$status = $_GET['status'] ?? null;

if ($status === null) {
    echo json_encode(["error" => "Parâmetro 'status' não fornecido."]);
    exit;
}

$sql = $conn->prepare(
    "SELECT 
        c.idConteudos, 
        c.Conteudo_titulo, 
        c.Conteudo_cont, 
        c.Conteudo_img, 
        c.Conteudo_dica, 
        c.Conteudo_autor, 
        c.Conteudo_link, 
        c.Usuarios_idUsuarios,
        c.Matéria_idMatéria,
        m.Matéria_tipo AS nome_materia 
     FROM conteudos c 
     INNER JOIN matéria m ON c.Matéria_idMatéria = m.idMatéria 
     WHERE c.Conteudo_tipo = '1' 
       AND c.Conteudo_status = :status"
);

$sql->bindValue(':status', $status);
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
