<?php
include 'header.php'; // Inclui o cabeçalho
include 'config/database.php';

// Consultar os dados no banco
$sql = "SELECT * FROM combos ORDER BY id DESC";
$result = $conn->query($sql);
?>

<main class="container" style="padding-top: 80px;">
    <section class="combos-grid">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($combo = $result->fetch_assoc()): ?>
                <div class="combo-card">
                    <img src="<?php echo htmlspecialchars($combo['url_foto']); ?>" 
                         alt="<?php echo htmlspecialchars($combo['nome_combo']); ?>">
                    <div class="combo-info">
                        <h2><?php echo htmlspecialchars($combo['nome_combo']); ?></h2>
                        <p class="preco">R$ <?php echo number_format($combo['preco'], 2, ',', '.'); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhum combo disponível no momento.</p>
        <?php endif; ?>
    </section>
</main>

<?php
$conn->close(); // Fecha a conexão com o banco
include 'footer.php'; // Inclui o rodapé
?>