<?php
require_once '../config/database.php';
require_once '../config/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_combo = $conn->real_escape_string($_POST['nome_combo']);
    $preco = floatval($_POST['preco']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $itens = json_decode($_POST['itens_selecionados']);
    
    if (empty($nome_combo) || empty($descricao) || empty($itens) || $preco <= 0) {
        header("Location: calculadora.php?erro=dados_invalidos");
        exit();
    }
    
    $sql = "SELECT SUM(custo) as custo_total FROM itens WHERE id IN (" . implode(',', $itens) . ")";
    $result = $conn->query($sql);
    $custoTotal = $result->fetch_assoc()['custo_total'];
    $margem_lucro = (($preco - $custoTotal) / $preco) * 100;

    $target_dir = "../uploads/";
    $filename = uniqid() . '_' . basename($_FILES["foto"]["name"]);
    $target_file = $target_dir . $filename;

    $url_foto = "/uploads/" . $filename;
    
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO combos (nome_combo, preco, margem_lucro, url_foto, descricao) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sddss", $nome_combo, $preco, $margem_lucro, $url_foto, $descricao);
        
        if (!$stmt) {
            header("Location: calculadora.php?erro=prepare_error");
            exit();
        }
        
        $stmt->bind_param("sddss", $nome_combo, $preco, $margem_lucro, $target_file, $descricao);
        
        if ($stmt->execute()) {
            $combo_id = $conn->insert_id;
            
            $sucessoItens = true;
            foreach ($itens as $item_id) {
                $sql = "INSERT INTO combo_itens (combo_id, item_id) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $combo_id, $item_id);
                if (!$stmt->execute()) {
                    $sucessoItens = false;
                    break;
                }
            }
            
            if ($sucessoItens) {
                header("Location: gerenciar_combos.php?sucesso=1");
                exit();
            }
        }
    }
    
    header("Location: calculadora.php?erro=1");
    exit();
}
?>