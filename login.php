<?php
include_once 'config/auth.php';
include_once 'config/database.php';

if (isLoggedIn()) {
    header("Location: admin/home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            header("Location: admin/home.php");
            exit();
        } else {
            $erro = "Senha incorreta";
        }
    } else {
        $erro = "Usuário não encontrado";
    }
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Área do Proprietário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form">
        <div class="card">
            <h1 class="title">Login - Área do Proprietário</h1>
            
            <?php if (isset($erro)): ?>
                <div class="error-message"><?php echo $erro; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="senha" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn">Entrar</button>
                </div>
            </form>
            
            <!-- Link para a página de cadastro de novo usuário -->
            <div class="form-group">
                <p>Ainda não tem uma conta? <a href="cadastrar_usuario.php">Cadastrar Novo Usuário</a></p>
            </div>
        </div>
    </div>
</body>
</html>
