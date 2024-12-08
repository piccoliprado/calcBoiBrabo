<?php
require_once '../config/database.php';
require_once 'check_auth.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = (int)$_GET['id'];
    $status = (int)$_GET['status'];
    
    $sql = "UPDATE combos SET ativo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $status, $id);
    
    if ($stmt->execute()) {
        header("Location: gerenciar_combos.php?sucesso=1");
    } else {
        header("Location: gerenciar_combos.php?erro=1");
    }
    exit();
}