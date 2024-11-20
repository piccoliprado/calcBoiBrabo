<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config/database.php';
    
    $email = $conn->real_escape_string($_POST['email']);
    $senha = $_POST['senha'];
    
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header("Location: admin/index.php");
            exit();
        } else {
            $erro = "Senha incorreta";
        }
    } else {
        $erro = "Usuário não encontrado";
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Área do Proprietário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <form class="login-form" method="POST">
            <h2>Área do Proprietário</h2>
            <?php if (isset($erro)): ?>
                <div class="erro"><?php echo $erro; ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            
            <button type="submit">Entrar</button>
            <a href="home.php" class="voltar">Voltar para Home</a>
        </form>
    </div>
</body>
</html>