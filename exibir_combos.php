<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calcbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT * FROM combos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lista de Combos</title>
</head>
<body>
    <h1>Combos Cadastrados</h1>
    <table border="1">
        <tr>
            <th>Nome do Combo</th>
            <th>Preço</th>
            <th>Margem de Lucro (%)</th>
            <th>Foto</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nome_combo']); ?></td>
                <td>R$<?php echo htmlspecialchars($row['preco']); ?></td>
                <td><?php echo htmlspecialchars($row['margem_lucro']); ?>%</td>
                <td>
                    <img src="<?php echo htmlspecialchars($row['url_foto']); ?>" alt="Foto do Combo" style="max-width: 100px;">
                </td>
                <td>
                    <a href="edit_combo.php?id=<?php echo $row['id']; ?>">Editar</a>
                    |
                    <a href="delete_combo.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este combo?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
