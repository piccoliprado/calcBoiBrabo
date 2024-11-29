<?php
require_once 'check_auth.php';
require_once 'header_admin.php';
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_combo = $conn->real_escape_string($_POST['nome_combo']);
    $preco = $conn->real_escape_string($_POST['preco']);
    $margem_lucro = $conn->real_escape_string($_POST['margem_lucro']);

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (getimagesize($_FILES["foto"]["tmp_name"]) !== false) {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO combos (nome_combo, preco, margem_lucro, url_foto)
                    VALUES (?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdds", $nome_combo, $preco, $margem_lucro, $target_file);
            
            if ($stmt->execute()) {
                header("Location: gerenciar_combos.php");
                exit();
            } else {
                $erro = "Erro ao cadastrar combo: " . $conn->error;
            }
        } else {
            $erro = "Erro no upload da imagem.";
        }
    } else {
        $erro = "Arquivo não é uma imagem válida.";
    }
}
?>

<div class="container">
    <div class="card">
        <h2 class="title">Cadastrar Novo Combo</h2>
        
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nome do Combo</label>
                <input type="text" name="nome_combo" required class="form-control">
            </div>

            <div class="form-group">
                <label>Preço (R$)</label>
                <input type="number" step="0.01" name="preco" required class="form-control">
            </div>

            <div class="form-group">
                <label>Margem de Lucro (%)</label>
                <input type="number" step="0.01" name="margem_lucro" required class="form-control">
            </div>

            <div class="form-group">
                <label>Foto do Combo</label>
                <input type="file" name="foto" required class="form-control">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Cadastrar Combo</button>
                <a href="gerenciar_combos.php" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>