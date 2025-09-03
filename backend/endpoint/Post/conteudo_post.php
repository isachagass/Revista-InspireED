<?php
// Conexão com o banco de dados
require_once '../database.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Método inválido"]);
    exit;
}

// Captura os dados corretamente e evita erro de acesso a valores nulos
$conteudo_titulo = $_POST['Conteudo_titulo'] ?? null;
$conteudo_cont = $_POST['Conteudo_cont'] ?? null;
$conteudo_tipo = $_POST['Conteudo_tipo'] ?? null;
$materia_id = $_POST['Materia_idMateria'] ?? null;
$usuario_id = $_POST['Usuarios_idUsuarios'] ?? null;
$conteudo_autor = $_POST['Conteudo_autor'] ?? null;
$conteudo_link = $_POST['Conteudo_link'] ?? null;
$conteudo_status = $_POST['Conteudo_status'] ?? null;

if (isset($_FILES["Conteudo_img"]) && $_FILES["Conteudo_img"]["error"] === 0) {
    $nomeArquivo = basename($_FILES["Conteudo_img"]["name"]);
    $caminhoDestino = "../../uploads/" . $nomeArquivo;

    

    // Tenta mover a imagem para a pasta correta
    if (move_uploaded_file($_FILES["Conteudo_img"]["tmp_name"], $caminhoDestino)) {
        $conteudo_img = $nomeArquivo;
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao salvar imagem"]);
        exit;
    }
} else {
    // echo json_encode(["status" => "error", "message" => "Imagem não enviada"]);
    $conteudo_img = null;
    // exit;
}



// Verifica se os campos obrigatórios estão preenchidos
if (!$conteudo_titulo || !$materia_id || !$usuario_id || !$conteudo_tipo || !$conteudo_status) {
    echo json_encode(["status" => "error", "message" => "Campos obrigatórios ausentes"]);
    exit;
}

try {
    // Prepara a query SQL para inserir os dados
    $sql = $conn->prepare("INSERT INTO conteudos (
        Conteudo_titulo, Conteudo_img, Conteudo_cont, Conteudo_tipo,
        Usuarios_idUsuarios, Matéria_idMatéria, Conteudo_status,
        Conteudo_autor, Conteudo_link
    ) VALUES (
        :titulo, :img, :conteudo, :tipo,
        :fkUsuario, :fkMateria, :conteudo_status,
        :conteudo_autor, :conteudo_link
    )");
    
    $sql->bindValue(':titulo', $conteudo_titulo);
    $sql->bindValue(':img', $conteudo_img);
    $sql->bindValue(':conteudo', $conteudo_cont);
    $sql->bindValue(':tipo', $conteudo_tipo);
    $sql->bindValue(':fkUsuario', $usuario_id);
    $sql->bindValue(':fkMateria', $materia_id);
    $sql->bindValue(':conteudo_status', $conteudo_status);
    $sql->bindValue(':conteudo_autor', $conteudo_autor);
    $sql->bindValue(':conteudo_link', $conteudo_link);
    
    $sql->execute();

    // Se inseriu no banco, retorna sucesso
    if ($sql->rowCount() > 0) {
        echo json_encode(["status" => "success", "message" => "Conteúdo cadastrado com sucesso"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao inserir no banco de dados"]);
    }

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erro no banco de dados: " . $e->getMessage()]);
}

?>
