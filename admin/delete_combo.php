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

// Verifica se o ID do combo foi enviado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Exclui o combo do banco de dados
    $sql = "DELETE FROM combos WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Combo excluído com sucesso!";
        header("Location: index.php"); // Redireciona de volta para a página inicial após exclusão
        exit();
    } else {
        echo "Erro ao excluir: " . $conn->error;
    }
} else {
    echo "ID do combo não especificado.";
}

$conn->close();
?>
