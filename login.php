<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calcbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Recebe os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Consulta o banco de dados
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verifica a senha
    if (password_verify($senha, $row['senha'])) {
        // Redireciona para index.php em caso de login bem-sucedido
        header("Location: index.php");
        exit();
    } else {
        $mensagem = "Senha incorreta.";
    }
} else {
    $mensagem = "Usuário não encontrado.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form">
        <div class="card">
            <h1 class="title">Login</h1>
            <?php if (isset($mensagem)): ?>
                <p class="error-message"><?php echo $mensagem; ?></p>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="card-group">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Digite seu email" required>
                </div>
                <div class="card-group">
                    <label>Senha</label>
                    <input type="password" name="senha" placeholder="Digite sua senha" required>
                </div>
                <div class="card-group btn">
                    <button type="submit">Acessar</button>
                </div>
                <p><a href="cadastro_usuario.php">Criar uma conta</a></p>
            </form>
        </div>
    </div>
</body>
</html>
