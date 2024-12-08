<?php
include 'header.php'; // Inclui o cabeçalho
include 'config/database.php';

// Consultar os dados no banco
$sql = "SELECT * FROM combos WHERE ativo = 1 ORDER BY id DESC";
$result = $conn->query($sql);
?>

<main class="container" style="padding-top: 80px;">
    <section class="combos-grid">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($combo = $result->fetch_assoc()): ?>
                <div class="combo-card" onclick="mostrarDetalhes(<?php echo htmlspecialchars($combo['id']); ?>)">
                    <div class="combo-image">
                        <?php
                        $imageUrl = $combo['url_foto'];
                        // Se o caminho não começar com /, adiciona
                        if (strpos($imageUrl, '/') !== 0) {
                        $imageUrl = '/' . $imageUrl;
                        }
                        ?>
                        <img src="<?php echo htmlspecialchars($imageUrl); ?>" 
                            alt="<?php echo htmlspecialchars($combo['nome_combo']); ?>"
                            style="width: 100%; height: 100%; object-fit: cover;"
                            onerror="this.src='/uploads/placeholder.jpg'">
                    </div>
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