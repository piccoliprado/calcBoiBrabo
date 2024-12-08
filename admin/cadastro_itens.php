<?php
require_once 'check_auth.php';
require_once 'header_admin.php';
require_once '../config/database.php';

$message = '';
$messageType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $conn->real_escape_string($_POST['nome']);
    $custo = $_POST['custo'];
    $unidade_medida = $_POST['unidade_medida'];

    $sql = "INSERT INTO itens (nome, custo) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sd", $nome, $custo);
    
    if ($stmt->execute()) {
        $message = "Item cadastrado com sucesso!";
        $messageType = "success";
    } else {
        $message = "Erro ao cadastrar item: " . $conn->error;
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Itens - Boi Brabo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cadastro-item.css">
    <link rel="stylesheet" href="/calcBoiBrabo/css/admin-header.css">
</head>
<body>
    <div class="cadastro-container">
        <div class="card-cadastro">
            <h2>Cadastrar Novo Item</h2>
            
            <?php if ($message): ?>
                <div class="message <?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="form-cadastro">
                <div class="form-group">
                    <label for="nome">Nome do Item:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>

                <div class="form-group">
                    <label for="unidade_medida">Unidade de Medida:</label>
                    <select id="unidade_medida" name="unidade_medida" required>
                        <option value="KG">Quilograma (KG)</option>
                        <option value="UN">Unidade (UN)</option>
                        <option value="PC">Peça (PC)</option>
                        <option value="GR">Grama (GR)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="custo">Custo (R$):</label>
                    <input type="number" id="custo" name="custo" step="0.01" required>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn-cadastrar">Cadastrar Item</button>
                    <a href="gerenciar_itens.php" class="btn-voltar">Voltar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>