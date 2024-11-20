<?php include 'header.php'; ?>

<main class="home-container">
    <section class="hero-section">
        <h1>Descubra Nossos Combos</h1>
        <p>Seleções especiais preparadas com ingredientes de qualidade</p>
    </section>

    <section class="combos-grid">
        <?php
        include 'config/database.php';

        $sql = "SELECT * FROM combos ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0):
            while($combo = $result->fetch_assoc()):
        ?>
            <div class="combo-card">
                <div class="combo-image">
                    <img src="<?php echo htmlspecialchars($combo['url_foto']); ?>" 
                         alt="<?php echo htmlspecialchars($combo['nome_combo']); ?>">
                </div>
                <div class="combo-info">
                    <h2><?php echo htmlspecialchars($combo['nome_combo']); ?></h2>
                    <p class="combo-price">R$ <?php echo number_format($combo['preco'], 2, ',', '.'); ?></p>
                    <p class="combo-description">
                        <?php echo nl2br(htmlspecialchars($combo['descricao'] ?? '')); ?>
                    </p>
                </div>
            </div>
        <?php 
            endwhile;
        else:
        ?>
            <p class="no-combos">Nenhum combo disponível no momento.</p>
        <?php 
        endif;
        $conn->close();
        ?>
    </section>
</main>

<?php include 'footer.php'; ?>