
<?php
require_once '../database.php';

header('Content-Type: application/json');
// $json = json_decode(file_get_contents("php://input"), true);

$id_atividade = $_POST["idAtividades"] ?? null;
$titulo         = $_POST["Atividade_titulo"] ?? null;
$conteudo       = $_POST["Atividade_cont"] ?? null;
$explicacao     = $_POST["Atividade_exp"] ?? null;
$imagem         = $_POST["Atividade_img"] ?? null;
$id_materia     = $_POST["Matéria_idMatéria"] ?? null;
$id_usuario     = $_POST["Usuarios_idUsuarios"] ?? null;
$alternativa_A  = $_POST["Atividade_alternativaA"] ?? null;
$alternativa_B  = $_POST["Atividade_alternativaB"] ?? null;
$alternativa_C  = $_POST["Atividade_alternativaC"] ?? null;
$alternativa_D  = $_POST["Atividade_alternativaD"] ?? null;
$correta        = $_POST["Atividade_alternativa_correta"] ?? null;

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

if (!$titulo || !$id_materia || !$id_usuario || !$conteudo || !$explicacao || !$imagem || !$alternativa_A || !$alternativa_B || !$alternativa_C || !$alternativa_D || !$correta) {
    echo json_encode(["status" => "erro", "message" => "Dados incompletos"]);
    exit;
}



$sql = $conn->prepare("UPDATE Atividades SET 
    Atividade_titulo = :titulo, 
    Atividade_cont = :conteudo, 
    Atividade_exp = :explicacao, 
    Atividade_img = :img, 
    Atividade_alternativaA = :alternativaA, 
    Atividade_alternativaB = :alternativaB, 
    Atividade_alternativaC = :alternativaC, 
    Atividade_alternativaD = :alternativaD, 
    Atividade_alternativa_correta = :correta, 
    Usuarios_idUsuarios = :fkUsuario, 
    Matéria_idMatéria = :fkMateria 
    WHERE idAtividades = :id"
);

// BIND
$sql->bindValue(':titulo', $titulo);
$sql->bindValue(':conteudo', $conteudo);
$sql->bindValue(':explicacao', $explicacao);
$sql->bindValue(':img', $imagem);
$sql->bindValue(':alternativaA', $alternativa_A);
$sql->bindValue(':alternativaB', $alternativa_B);
$sql->bindValue(':alternativaC', $alternativa_C);
$sql->bindValue(':alternativaD', $alternativa_D);
$sql->bindValue(':correta', $correta);
$sql->bindValue(':fkUsuario', $id_usuario);
$sql->bindValue(':fkMateria', $id_materia);
$sql->bindValue(':id', $id_atividade, PDO::PARAM_INT);

$sql->execute();

if ($sql->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "erro"]);
}