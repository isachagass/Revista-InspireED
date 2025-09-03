<?php
require_once '../database.php';

header('Content-Type: application/json');


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Método inválido"]);
    exit;
}

$atividade_titulo = $_POST['Atividade_titulo'] ?? null;
$atividade_cont = $_POST['Atividade_cont'] ?? null;
$atividade_exp = $_POST['Atividade_exp'] ?? null;
$materia_id = $_POST['Matéria_idMatéria'] ?? null;
$usuario_id = $_POST['Usuarios_idUsuarios'] ?? null;

$alternativa_A = $_POST['Atividade_alternativaA'] ?? null;
$alternativa_B = $_POST['Atividade_alternativaB'] ?? null;
$alternativa_C = $_POST['Atividade_alternativaC'] ?? null;
$alternativa_D = $_POST['Atividade_alternativaD'] ?? null;
$alternativa_correta = $_POST['Atividade_alternativa_correta'] ?? null;


if (isset($_FILES["Atividade_img"]) && $_FILES["Atividade_img"]["error"] === 0) {
    $nomeArquivo = basename($_FILES["Atividade_img"]["name"]);
    $caminhoDestino = "../../uploads/" . $nomeArquivo;

    

    // Tenta mover a imagem para a pasta correta
    if (move_uploaded_file($_FILES["Atividade_img"]["tmp_name"], $caminhoDestino)) {
        $atividade_img = $nomeArquivo;
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao salvar imagem"]);
        exit;
    }
} else {
    $atividade_img = null;

}


if (!$atividade_titulo || !$atividade_cont || !$atividade_exp || !$materia_id || !$usuario_id || !$alternativa_A || !$alternativa_B || !$alternativa_C || !$alternativa_D || !$alternativa_correta) {
    echo json_encode(["status" => "error", "message" => "Campos obrigatórios ausentes"]);
    exit;
}

try{
    $sql = $conn->prepare("INSERT INTO atividades (Atividade_titulo, Atividade_cont, Atividade_exp, Atividade_img, Matéria_idMatéria, Usuarios_idUsuarios, Atividade_alternativaA, Atividade_alternativaB, Atividade_alternativaC, Atividade_alternativaD, Atividade_alternativa_correta) VALUES (:titulo, :conteudo, :exp, :img, :fkmateria, :fkUsuario, :alternativaA, :alternativaB, :alternativaC, :alternativaD, :alternativaCorreta)");

    $sql->bindValue(':titulo', $atividade_titulo);
    $sql->bindValue(':img', $atividade_img);
    $sql->bindValue(':conteudo', $atividade_cont);
    $sql->bindValue(':exp', $atividade_exp);
    $sql->bindValue(':fkmateria', $materia_id);
    $sql->bindValue(':fkUsuario', $usuario_id);
    $sql->bindValue(':alternativaA', $alternativa_A);
    $sql->bindValue(':alternativaB', $alternativa_B);
    $sql->bindValue(':alternativaC', $alternativa_C);
    $sql->bindValue(':alternativaD', $alternativa_D);
    $sql->bindValue(':alternativaCorreta', $alternativa_correta);
    
    
    
    $sql->execute();

    if ($sql->rowCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Conteúdo cadastrado com sucesso"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao inserir no banco de dados"]);
    }

} catch(PDOException $e){
    echo json_encode(["status" => "error", "message" => "Erro no banco de dados: " . $e->getMessage()]);
}





