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
    $sql = "SELECT * FROM itens WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        echo "Item não encontrado!";
        exit;
    }
}

// Atualiza o item após o envio do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $custo = $_POST['custo'];

    $sql = "UPDATE itens SET nome = '$nome', custo = '$custo' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Item atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Item</title>
</head>
<body>
    <h1>Editar Item</h1>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
        <label>Nome do Item:</label>
        <input type="text" name="nome" value="<?php echo $item['nome']; ?>" required><br>
        <label>Custo:</label>
        <input type="number" step="0.01" name="custo" value="<?php echo $item['custo']; ?>" required><br>
        <button type="submit">Atualizar Item</button>
    </form>
</body>
</html>

<?php $conn->close(); ?>
