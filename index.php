<?php
include 'header.php';
include 'config/database.php';

$sql = "SELECT * FROM combos ORDER BY id DESC";
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
                        if (strpos($imageUrl, '../') === 0) {
                            $imageUrl = substr($imageUrl, 3);
                        }
                        ?>
                        <img src="<?php echo htmlspecialchars($imageUrl); ?>"
                             alt="<?php echo htmlspecialchars($combo['nome_combo']); ?>">
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
$conn->close();
include 'footer.php';
?>