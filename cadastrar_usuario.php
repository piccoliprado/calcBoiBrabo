<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calcbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $senhaConfirmada = $_POST['senha_confirmada'];

    if (empty($nome) || empty($email) || empty($senha) || empty($senhaConfirmada)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif ($senha !== $senhaConfirmada) {
        $erro = "As senhas não coincidem.";
    } else {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $erro = "Este email já está cadastrado. Por favor, faça login ou use outro email.";
        } else {
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senhaHash')";

            if ($conn->query($sql) === TRUE) {
                header("Location: login.php");
                exit();
            } else {
                $erro = "Erro ao cadastrar o usuário: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Usuário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form">
        <div class="card">
            <h1 class="title">Cadastro de Novo Usuário</h1>

            <?php if (!empty($erro)): ?>
                <div class="error-message"><?php echo $erro; ?></div>
            <?php endif; ?>

            <form method="POST" action="cadastrar_usuario.php">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" required>
                </div>

                <div class="form-group">
                    <label for="senha_confirmada">Confirmar Senha</label>
                    <input type="password" name="senha_confirmada" id="senha_confirmada" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn">Cadastrar</button>
                </div>
            </form>

            <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
        </div>
    </div>
</body>
</html>
