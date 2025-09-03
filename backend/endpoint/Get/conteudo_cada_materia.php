<?php
header("Content-Type: application/json");
require '../database.php';

$id_materia = isset($_GET['materia'])? intval($_GET['materia']) :0;

if($id_materia <= 0){
    echo "ID da matéria inválido!";
    exit;
}

$sql = "SELECT c.idConteudos, c.Conteudo_titulo, c.Conteudo_cont, c.Conteudo_img, Conteudo_dica, m.Matéria_tipo AS nome_materia 
        FROM conteudos c 
        INNER JOIN matéria m ON c.Matéria_idMatéria = m.idMatéria 
        WHERE Conteudo_tipo = '2'
        AND c.Matéria_idMatéria = :materia_id;";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':materia_id', $id_materia, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);
// pega somente os conteudos das matérias