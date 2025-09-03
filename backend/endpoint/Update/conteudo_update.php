<?php
require_once '../database.php';

header('Content-Type: application/json');

// TRATAMENTO DE DADOS via FormData ($_POST)
$titulo     = $_POST["Conteudo_titulo"] ?? null;
$link       = $_POST["Conteudo_link"] ?? null;
$autor      = $_POST["Conteudo_autor"] ?? null;
$id_user    = $_POST["Usuarios_idUsuarios"] ?? null;
$id_conteudo   = $_POST["idConteudos"] ?? null;
$id_materia   = $_POST["Matéria_idMatéria"] ?? null;
$tipo   = $_POST["Conteudo_tipo"] ?? null;
$status   = $_POST["Conteudo_status"] ?? null;

$conteudo    = $_POST["Conteudo_cont"] ?? null;
$dica = $_POST["Conteudo_dica"] ?? null;


$imagem_final = $_POST["Conteudo_img"] ?? null;

if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] === 0) {
    $nomeArquivo = basename($_FILES["imagem"]["name"]);
    $caminhoDestino = "../../uploads/" . $nomeArquivo;

    if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoDestino)) {
        $imagem_final = $nomeArquivo;
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao salvar imagem"]);
        exit;
    }
} else if (isset($_POST["imagem_antiga"])) {
    $imagem_final = $_POST["imagem_antiga"];
} else {
    echo json_encode(["status" => "error", "message" => "Nenhuma imagem fornecida"]);
    exit;
}

// VALIDAÇÃO SIMPLES
if (!$titulo || !$id_conteudo || !$id_user || !$id_materia || !$imagem_final || !$tipo || !$status) {
    echo json_encode(["status" => "erro", "message" => "Dados incompletos"]);
    exit;
}

$sql = $conn->prepare("UPDATE conteudos SET 
    Conteudo_titulo = :titulo, 
    Conteudo_img = :img, 
    Conteudo_cont = :conteudo, 
    Conteudo_dica = :dica, 
    Conteudo_status = :status, 
    Conteudo_autor = :autor, 
    Conteudo_link = :link, 
    Usuarios_idUsuarios = :id_user, 
    Conteudo_tipo = :tipo, 
    Matéria_idMatéria = :fkmateria 
WHERE idConteudos = :id");

$sql->bindValue(':titulo', $titulo);
$sql->bindValue(':conteudo', $conteudo);
$sql->bindValue(':img', $imagem_final);
$sql->bindValue(':link', $link);
$sql->bindValue(':autor', $autor);
$sql->bindValue(':dica', $dica);
$sql->bindValue(':tipo', $tipo);
$sql->bindValue(':status', $status);
$sql->bindValue(':id_user', $id_user);
$sql->bindValue(':fkmateria', $id_materia);
$sql->bindValue(':id', $id_conteudo, PDO::PARAM_INT);


$sql->execute();

if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "erro"]);
}
