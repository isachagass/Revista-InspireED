<?php
require_once '../database.php';

header('Content-Type: application/json');

// PEGAR O JSON DO CORPO DA REQUISIÇÃO
// TRATAMENTO DE DADOS via FormData ($_POST)
$titulo     = $_POST["Catalogo_titulo"] ?? null;
$sinopse    = $_POST["Catalogo_sinopse"] ?? null;
$link       = $_POST["Catalogo_link"] ?? null;
$autor      = $_POST["Catalogo_autor"] ?? null;
$disponivel = $_POST["Catalogo_disponivel_biblioteca"] ?? null;
$id_user    = $_POST["Usuarios_idUsuarios"] ?? null;
$id_livro   = $_POST["idCatalogos"] ?? null;

$imagem_final = $_POST["Catalogo_img"] ?? null;


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
if (!$titulo || !$id_livro || !$id_user || !$disponivel || !$autor || !$link || !$sinopse || !$imagem_final) {
    echo json_encode(["status" => "erro", "message" => "Dados incompletos"]);
    exit;
}

// SQL
$sql = $conn->prepare("UPDATE catalogos SET 
    Catalogo_titulo = :titulo, 
    Catalogo_sinopse = :conteudo, 
    Catalogo_img = :img, 
    Catalogo_link = :link, 
    Catalogo_autor = :autor, 
    Catalogo_disponivel_biblioteca = :disponivel, 
    Usuarios_idUsuarios = :fkUsuario 
    WHERE idCatalogos = :id"
);

// BIND
$sql->bindValue(':titulo', $titulo);
$sql->bindValue(':conteudo', $sinopse);
$sql->bindValue(':img', $imagem_final);
$sql->bindValue(':link', $link);
$sql->bindValue(':autor', $autor);
$sql->bindValue(':disponivel', $disponivel);
$sql->bindValue(':fkUsuario', $id_user);
$sql->bindValue(':id', $id_livro, PDO::PARAM_INT);

// EXECUTA
$sql->execute();

// RETORNA STATUS
if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "erro"]);
}
