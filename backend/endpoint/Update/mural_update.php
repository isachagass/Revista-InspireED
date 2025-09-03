<?php
require_once '../database.php';

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$id_mural = $_POST["idMurais"] ?? null;
$titulo         = $_POST["Mural_titulo"] ?? null;
$conteudo       = $_POST["Mural_cont"] ?? null;
$id_user     = $_POST["Usuarios_idUsuarios"] ?? null;

$imagem_final = null;

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

if (!$titulo) {
    echo json_encode(["status" => "erro", "message" => "Dados incompletos"]);
    exit;
}


// Atualizando a consulta SQL de acordo com a tabela 'Murais'
$sql = $conn->prepare("UPDATE murais 
                       SET Mural_titulo = :titulo, Mural_cont = :conteudo, Mural_img = :img, usuarios_idUsuarios = :fkUsuario 
                       WHERE idMurais = :id");

$sql->bindValue(':titulo', $titulo);
$sql->bindValue(':conteudo', $conteudo);
$sql->bindValue(':img', $imagem_final);
$sql->bindValue(':fkUsuario', $id_user);
$sql->bindValue(':id', $id_mural, PDO::PARAM_INT);

// Executando a consulta SQL
$sql->execute();

// Verificando se a atualização foi bem-sucedida
if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "erro"]);
}
?>