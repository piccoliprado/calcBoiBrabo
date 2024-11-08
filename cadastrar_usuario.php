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

// Recebe os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha

// Verifica se o email já existe
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Email já existe
    echo '
    <div class="error-message">
        <div class="error-card">
            <h2>Erro</h2>
            <p>Este email já está cadastrado. Por favor, faça login ou use outro email.</p>
            <a href="login.html" class="btn"><button>Ir para Login</button></a>
        </div>
    </div>';
} else {
    // Insere o usuário no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

    if ($conn->query($sql) === TRUE) {
        // Cadastro bem-sucedido, redireciona para a página de login
        header("Location: login.html"); // Altere "login.html" para o nome do seu arquivo de login
        exit();
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
