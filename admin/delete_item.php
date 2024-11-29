<?php
require_once '../check_auth.php';
require_once 'header_admin.php';
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $sql = "DELETE FROM itens WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: /admin/gerenciar_itens.php?sucesso=1");
    } else {
        header("Location: /admin/gerenciar_itens.php?erro=1");
    }
    exit();
}

header("Location: /admin/gerenciar_itens.php");
exit();
