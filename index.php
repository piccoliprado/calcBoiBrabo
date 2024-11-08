<?php
include 'header.php';

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

<div class="form">
    <div class="card">
        <h1 class="title">Combos Disponíveis</h1>
        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while($row = $result->fetch_assoc()): ?>
                    <li>
                        <h2><?php echo htmlspecialchars($row['nome_combo']); ?></h2>
                        <img src="<?php echo 'uploads/' . htmlspecialchars($row['foto']); ?>" alt="Foto do Combo" style="max-width: 100%; height: auto;">
                        <p>Preço: R$<?php echo htmlspecialchars($row['preco']); ?></p>
                        <p>Margem de Lucro: <?php echo htmlspecialchars($row['margem_lucro']); ?>%</p>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Nenhum combo disponível.</p>
        <?php endif; ?>

<?php $conn->close(); ?>
