<?php
include 'header.php';
include 'config/database.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM combos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $combo = $result->fetch_assoc();
?>
        <div class="container" style="padding-top: 80px;">
            <div class="combo-detalhes">
                <div class="combo-imagem">
                    <img src="<?php echo htmlspecialchars($combo['url_foto']); ?>" 
                         alt="<?php echo htmlspecialchars($combo['nome_combo']); ?>"
                         onerror="this.src='uploads/placeholder.jpg'">
                </div>
                <div class="combo-info">
                    <h1><?php echo htmlspecialchars($combo['nome_combo']); ?></h1>
                    <div class="descricao">
                        <?php echo nl2br(htmlspecialchars($combo['descricao'])); ?>
                    </div>
                    <p class="preco">R$ <?php echo number_format($combo['preco'], 2, ',', '.'); ?></p>
                    
                    <a href="https://wa.me/SEUNUMERO?text=Olá! Gostaria de reservar o combo <?php echo urlencode($combo['nome_combo']); ?>" 
                       class="btn-reservar" target="_blank">
                        Reservar via WhatsApp
                    </a>
                </div>
            </div>
        </div>
<?php
    }
}
include 'footer.php';
?>