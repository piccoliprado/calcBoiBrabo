<?php
require_once 'check_auth.php';
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
    $nome_combo = $_POST['nome_combo'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $margem_lucro = $_POST['margem_lucro'];


    if (!empty($_FILES['foto']['name'])) {
        $sql = "UPDATE combos SET nome_combo = ?, preco = ?, descricao = ?, margem_lucro = ?, url_foto = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if(!$stmt->bind_param("sssdsi", $nome_combo, $preco, $descricao, $margem_lucro, $target_file, $id)) {
            echo "Erro no bind_param: " . $stmt->error;
        }
    } else {
        $sql = "UPDATE combos SET nome_combo = ?, preco = ?, descricao = ?, margem_lucro = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if(!$stmt->bind_param("sssdi", $nome_combo, $preco, $descricao, $margem_lucro, $id)) {
            echo "Erro no bind_param: " . $stmt->error;
        }
    }

    if ($stmt->execute()) {
        
        $verify_sql = "SELECT * FROM combos WHERE id = ?";
        $verify_stmt = $conn->prepare($verify_sql);
        $verify_stmt->bind_param("i", $id);
        $verify_stmt->execute();
        $result = $verify_stmt->get_result();
        $saved_data = $result->fetch_assoc();
                
        $sucesso = "Combo atualizado com sucesso!";
    } else {
        $erro = "Erro ao atualizar o combo: " . $stmt->error;
    }
}

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
                <label>Descrição do Combo</label>
                <textarea name="descricao" class="form-control" rows="4"><?php echo htmlspecialchars($combo['descricao'] ?? ''); ?></textarea>
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