<?php
include 'header.php';
include 'config/database.php';

$sql = "SELECT * FROM combos ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Combos</title>
</head>
<body>
    <main class="container">
        <section class="combos-grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($combo = $result->fetch_assoc()): ?>
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
</body>
</html>

<?php $conn->close(); ?>