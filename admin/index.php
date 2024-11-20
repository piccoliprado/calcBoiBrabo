<?php
include '../header.php';  // Ajustado o caminho do header pois agora está na pasta admin

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
    <!-- Menu de navegação para as novas funcionalidades -->
    <div class="navigation">
        <h2>Menu de Itens</h2>
        <ul>
            <li><a href="exibir_itens.php">Listar Itens</a></li>
            <li><a href="exibir_combos.php">Listar Combos</a></li>
        </ul>
    </div>

    <div class="card">
        <h1 class="title">Combos Disponíveis</h1>
        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while($row = $result->fetch_assoc()): ?>
                    <li>
                        <h2><?php echo htmlspecialchars($row['nome_combo']); ?></h2>
                        <img src="<?php echo htmlspecialchars($row['url_foto']); ?>" alt="Foto do Combo" style="max-width: 100%; height: auto;">
                        <p>Preço: R$<?php echo htmlspecialchars($row['preco']); ?></p>
                        <p>Margem de Lucro: <?php echo htmlspecialchars($row['margem_lucro']); ?>%</p>
                        
                        <!-- Links para Editar e Excluir -->
                        <a href="edit_combo.php?id=<?php echo $row['id']; ?>">Editar</a> | 
                        <a href="delete_combo.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este combo?');">Excluir</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Nenhum combo disponível.</p>
        <?php endif; ?>
    </div>
</div>

<?php 
$conn->close();
?>