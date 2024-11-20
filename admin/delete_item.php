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

// Verifica se o ID do item foi enviado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Exclui o item do banco de dados
    $sql = "DELETE FROM itens WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Item excluído com sucesso!";
    } else {
        echo "Erro ao excluir: " . $conn->error;
    }
} else {
    echo "ID do item não especificado.";
}

$conn->close();
?>
