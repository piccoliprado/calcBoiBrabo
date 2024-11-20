<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calcbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT * FROM itens";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lista de Itens</title>
</head>
<body>
    <h1>Itens Cadastrados</h1>
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>Custo</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['custo']; ?></td>
                <td>
                    <a href="edit_item.php?id=<?php echo $row['id']; ?>">Editar</a>
                    |
                    <a href="delete_item.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
