<?php
require_once '../database.php';

header('Content-Type: application/json');
// $json = json_decode(file_get_contents("php://input"), true);


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Método inválido"]);
    exit;
}

$titulo_mural = $_POST["Mural_titulo"] ?? null;
$cont_mural = $_POST["Mural_cont"] ?? null;
$id_user_mural = $_POST["usuarios_idUsuarios"] ?? null;

$img_mural = null;

if (isset($_FILES["Mural_img"]) && $_FILES["Mural_img"]["error"] === 0) {
    $nomeArquivo = basename($_FILES["Mural_img"]["name"]);
    $caminhoDestino = "../../uploads/" . $nomeArquivo;

    

    // Tenta mover a imagem para a pasta correta
    if (move_uploaded_file($_FILES["Mural_img"]["tmp_name"], $caminhoDestino)) {
        $img_mural = $nomeArquivo;
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao salvar imagem"]);
        exit;
    }
} else {
    // echo json_encode(["status" => "sucess", "message" => "Imagem não enviada, dada com null"]);
    $img_mural = null;
    
}

if (!$titulo_mural) {
    echo json_encode(["status" => "error", "message" => "Campos obrigatórios ausentes"]);
    exit;
}


try {
    $sql = $conn->prepare("INSERT INTO murais (Mural_titulo, Mural_cont, Mural_img, usuarios_idUsuarios) 
                       VALUES (:titulo, :conteudo, :img, :fkUsuario)");

    $sql->bindValue(':titulo', $titulo_mural);
    $sql->bindValue(':conteudo', $cont_mural);
    $sql->bindValue(':img', $img_mural);
    $sql->bindValue(':fkUsuario', $id_user_mural);

    $sql->execute();

    if ($sql->rowCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Aviso cadastrado com sucesso"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao inserir no banco de dados"]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erro no banco de dados: " . $e->getMessage()]);
}


