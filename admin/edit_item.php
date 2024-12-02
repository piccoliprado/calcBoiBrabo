<?php
require_once 'check_auth.php';
require_once 'header_admin.php';
require_once '../config/database.php';

$erro = null;
$sucesso = null;

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM itens WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        header("Location: /admin/gerenciar_itens.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST['id'];
    $nome = $conn->real_escape_string($_POST['nome']);
    $custo = (float)$_POST['custo'];

    $sql = "UPDATE itens SET nome = ?, custo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi", $nome, $custo, $id);
    
    if ($stmt->execute()) {
        $sucesso = "Item atualizado com sucesso!";
    } else {
        $erro = "Erro ao atualizar o item.";
    }
}

//include '../header.php';
?>

<div class="container">
    <div class="card">
        <h2 class="title">Editar Item</h2>
        
        <?php if ($erro): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>
        
        <?php if ($sucesso): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($sucesso); ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
            
            <div class="form-group">
                <label>Nome do Item</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($item['nome']); ?>" required>
            </div>

            <div class="form-group">
                <label>Custo</label>
                <input type="number" step="0.01" name="custo" value="<?php echo htmlspecialchars($item['custo']); ?>" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Atualizar Item</button>
                <a href="/admin/gerenciar_itens.php" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>