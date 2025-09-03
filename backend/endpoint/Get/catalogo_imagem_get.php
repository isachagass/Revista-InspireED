<?php
require '../database.php';

try {
    $sql = "SELECT Catalogo_titulo, Catalogo_sinopse, Catalogo_img, Catalogo_link, Catalogo_autor, Catalogo_disponivel_biblioteca FROM catalogos";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obtém todos os registros de uma vez
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Adiciona o caminho correto para cada imagem
    $catalogos = array_map(function ($row) {
        return [
            "titulo" => $row["Catalogo_titulo"],
            "imagem" => "../backend/uploads/" . $row["Catalogo_img"],
            "sinopse" => $row["Catalogo_sinopse"], 
            "autor" => $row["Catalogo_autor"], 
            "link" => $row["Catalogo_link"], 
            "biblioteca" => $row["Catalogo_disponivel_biblioteca"] 
        ];
    }, $resultados);

    header('Content-Type: application/json');
    echo json_encode($catalogos);

} catch (PDOException $e) {
    echo json_encode(["erro" => "Erro ao buscar catálogos: " . $e->getMessage()]);
}
?>
