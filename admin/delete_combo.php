<?php
require_once '../check_auth.php';
require_once 'header_admin.php';
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Primeiro busca a imagem atual para deletar
    $sql = "SELECT url_foto FROM combos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $combo = $result->fetch_assoc();
        if (file_exists($combo['url_foto'])) {
            unlink($combo['url_foto']); // Remove a imagem antiga
        }
    }

    // Deleta o combo
    $sql = "DELETE FROM combos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: /admin/gerenciar_combos.php?sucesso=1");
    } else {
        header("Location: /admin/gerenciar_combos.php?erro=1");
    }
    exit();
}

header("Location: /admin/gerenciar_combos.php");
exit();