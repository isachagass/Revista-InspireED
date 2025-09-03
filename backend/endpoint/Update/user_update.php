
<?php
require_once '../database.php';

header("Content-Type: application/json");

$id_user = $_POST['idUsuarios'] ?? null;
$nome = $_POST['Usuario_nome'] ?? null;
$email = $_POST['Usuario_email'] ?? null;
$senha = $_POST['Usuario_senha'] ?? null;
$nivel = $_POST['Usuario_nivel'] ?? null;

$imagem_final = $_POST["Usuario_img"] ?? null;



// Captura a imagem
// Captura a imagem
if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] === 0) {
    $nomeArquivo = basename($_FILES["imagem"]["name"]);
    $caminhoDestino = "../../uploads/" . $nomeArquivo;

    if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoDestino)) {
        $imagem_final = $nomeArquivo;
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao salvar imagem"]);
        exit;
    }
} else if (!empty($_POST["imagem_antiga"])) {
    $imagem_final = $_POST["imagem_antiga"];
} else {
    $imagem_final = null; // <-- aqui está a mudança
}


$sql = $conn->prepare("UPDATE usuarios SET Usuario_nome = :nome, Usuario_email = :email, Usuario_senha= :senha, Usuario_nivel = :nivel, Usuario_img = :img WHERE idUsuarios = :id");
$sql->bindValue(':nome', $nome);
$sql->bindValue(':email', $email);
$sql->bindValue(':senha', $senha);
$sql->bindValue(':nivel', $nivel);
$sql->bindValue(':img', $imagem_final);
$sql->bindValue(':id', $id_user, PDO::PARAM_INT);

$sql->execute();

if ($sql->rowCount() > 0) {
    echo json_encode([
        "status" => "success",
        "Usuario_img" => $imagem_final
]);
} else {
    echo json_encode([
        "status" => "erro",
        "Usuario_imagem" => $imagem_final
]);
}