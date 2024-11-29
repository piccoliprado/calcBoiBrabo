<?php
require_once '../check_auth.php';
require_once 'header_admin.php';
require_once '../config/database.php';

$erro = null;
$sucesso = null;

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM combos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $combo = $result->fetch_assoc();
    } else {
        header("Location: /admin/gerenciar_combos.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST['id'];
    $nome_combo = $conn->real_escape_string($_POST['nome_combo']);
    $preco = (float)$_POST['preco'];
    $margem_lucro = (float)$_POST['margem_lucro'];

    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "../uploads/";
        $imageFileType = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $newFileName = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $newFileName;

        if (getimagesize($_FILES["foto"]["tmp_name"]) !== false) {
            // Remove a imagem antiga se existir
            if (file_exists($combo['url_foto'])) {
                unlink($combo['url_foto']);
            }

            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $sql = "UPDATE combos SET nome_combo = ?, preco = ?, margem_lucro = ?, url_foto = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sddsi", $nome_combo, $preco, $margem_lucro, $target_file, $id);
            }
        } else {
            $erro = "O arquivo enviado não é uma imagem válida.";
        }
    } else {
        $sql = "UPDATE combos SET nome_combo = ?, preco = ?, margem_lucro = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sddi", $nome_combo, $preco, $margem_lucro, $id);
    }

    if (!$erro && $stmt->execute()) {
        $sucesso = "Combo atualizado com sucesso!";
    } else {
        $erro = $erro ?: "Erro ao atualizar o combo.";
    }
}

include '../header.php';
?>

<div class="container">
    <div class="card">
        <h2 class="title">Editar Combo</h2>
        
        <?php if ($erro): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>
        
        <?php if ($sucesso): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($sucesso); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $combo['id']; ?>">
            
            <div class="form-group">
                <label>Nome do Combo</label>
                <input type="text" name="nome_combo" value="<?php echo htmlspecialchars($combo['nome_combo']); ?>" required>
            </div>

            <div class="form-group">
                <label>Preço</label>
                <input type="number" step="0.01" name="preco" value="<?php echo htmlspecialchars($combo['preco']); ?>" required>
            </div>

            <div class="form-group">
                <label>Margem de Lucro (%)</label>
                <input type="number" step="0.01" name="margem_lucro" value="<?php echo htmlspecialchars($combo['margem_lucro']); ?>" required>
            </div>

            <div class="form-group">
                <label>Nova Foto</label>
                <input type="file" name="foto">
                <?php if ($combo['url_foto']): ?>
                    <p>Foto atual:</p>
                    <img src="<?php echo htmlspecialchars($combo['url_foto']); ?>" alt="Foto atual" style="max-width: 200px;">
                <?php endif; ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Atualizar Combo</button>
                <a href="/admin/gerenciar_combos.php" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>