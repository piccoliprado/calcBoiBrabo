<?php
require_once 'check_auth.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calcbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $custo = $_POST['custo'];

    $sql = "INSERT INTO itens (nome, custo) VALUES ('$nome', '$custo')";
    if ($conn->query($sql) === TRUE) {
        echo "Item cadastrado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Itens</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Cadastrar Novo Item</h1>
    <form method="POST" action="">
        <label>Nome do Item:</label>
        <input type="text" name="nome" required><br>
        <label>Custo:</label>
        <input type="number" step="0.01" name="custo" required><br>
        <button type="submit">Cadastrar Item</button>
    </form>
</body>
</html>

<?php $conn->close(); ?>