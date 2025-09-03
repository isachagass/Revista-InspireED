<?php
header("Content-Type: application/json");
require '../database.php';


$id_user = $_GET['id_user'] ?? null;

if ($id_user === null) {
    echo json_encode(["error" => "Parâmetro 'id_user' não fornecido."]);
    exit;
}


$stmt = $conn->prepare('SELECT 
  Usuario_nome, 
  Matéria_tipo, 
  Conteudo_titulo, 
  Conteudo_img, 
  Conteudo_link,
  idConteudos, 
  Conteudo_status
FROM conteudos
INNER JOIN usuarios 
  ON Conteudos.Usuarios_idUsuarios = Usuarios.idUsuarios
JOIN matéria 
  ON Matéria.idMatéria = Conteudos.Matéria_idMatéria
WHERE Conteudo_tipo = 1 
  AND Conteudos.Usuarios_idUsuarios = :id_user;');
  
$stmt->bindValue(':id_user', $id_user);

$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
// pega os conteudos certos para expor sobre as noticias como o titulo, conteudo, imagem,
// a qual matéria pertence, e o nome do usuria que a registrou