<?php
require_once '../database.php';

header('Content-Type: application/json');



// Verifica se os dados foram recebidos corretamente
if (!isset($_FILES['arquivo'])) {
    echo json_encode(["status" => "error", "message" => "Nenhum dado recebido"]);
    exit;
}

$arquivo = $_FILES['arquivo'];
$nomeArquivo = basename($arquivo["name"]);
$pastaDestino = "../../uploads/";

$caminhoFinal = $pastaDestino . $nomeArquivo;

if(!move_uploaded_file($arquivo["tmp_name"], $caminhoFinal)) {
    echo json_encode(["status" => "error", "message" => "Erro ao salvar arquivo"]);
    exit;
}

$caminhoBanco = "uploads/". $nomeArquivo;


try{
    $sql = $conn->prepare(query: "INSERT INTO catalogos VALUE(NULL, :titulo, :sinopse, :img, :fkUsuario)");
    $sql->bindValue(':titulo', "teste com img");
    $sql->bindValue(':sinopse', "teste com imagem");
    $sql->bindValue(':img', $caminhoBanco);
    $sql->bindValue(':fkUsuario', 2);
    
    
    
    $sql->execute();

    echo json_encode(["status" => "success", "message" => "Arquivo enviado com sucesso!", "path" => $caminhoBanco]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erro no banco de dados: " . $e->getMessage()]);
}




