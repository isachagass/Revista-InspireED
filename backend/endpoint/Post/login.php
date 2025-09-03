<?php
require_once '../database.php';

header('Content-Type: application/json');

// Obtendo o JSON enviado
$json = json_decode(file_get_contents("php://input"), true);

// Verificando se os campos obrigatórios foram recebidos
if (!isset($json['Usuario_email']) || !isset($json['Usuario_senha'])) {
    echo json_encode(["status" => "erro", "mensagem" => "Campos obrigatórios ausentes"]);
    exit;
}

$email = $json['Usuario_email'];
$senha = $json['Usuario_senha'];


$sql = "SELECT Usuario_senha, Usuario_nivel, Usuario_nome, idUsuarios, Usuario_img FROM usuarios WHERE Usuario_email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":email", $email, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);




if ($result) {
    // Verificando a senha (se estiver armazenada como hash, use password_verify())
    if ($senha === $result["Usuario_senha"]) {
        echo json_encode([
            "status" => "success", 
            "mensagem" => "Login realizado com sucesso",
            "nivel" => $result["Usuario_nivel"],
            "nome" => $result["Usuario_nome"],
            "email" => $email,
            "senha" => $result["Usuario_senha"],
            "id_user" => $result["idUsuarios"],
            "img" => $result["Usuario_img"],
        ]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Senha incorreta"]);
    }
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Usuário não encontrado"]);
}
