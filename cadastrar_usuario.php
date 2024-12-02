<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calcbc"; // Substitua pelo nome do seu banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$erro = ""; // Variável para armazenar mensagens de erro

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário e faz uma validação simples
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $senhaConfirmada = $_POST['senha_confirmada'];

    if (empty($nome) || empty($email) || empty($senha) || empty($senhaConfirmada)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif ($senha !== $senhaConfirmada) {
        $erro = "As senhas não coincidem.";
    } else {
        // Criptografa a senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Verifica se o email já existe no banco de dados
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $erro = "Este email já está cadastrado. Por favor, faça login ou use outro email.";
        } else {
            // Insere o usuário no banco de dados
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senhaHash')";

            if ($conn->query($sql) === TRUE) {
                // Cadastro bem-sucedido, redireciona para a página de login
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
    <link rel="stylesheet" href="css/style.css"> <!-- Inclua o link para seu CSS -->
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
