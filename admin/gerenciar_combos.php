<?php
require_once 'header_admin.php';
require_once '../config/database.php';

$sql = "SELECT * FROM combos";
$result = $conn->query($sql);
?>

<div class="container">
    <div class="card">
        <h1 class="title">Gerenciar Combos</h1>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nome do Combo</th>
                    <th>Preço</th>
                    <th>Margem de Lucro</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nome_combo']); ?></td>
                    <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo $row['margem_lucro']; ?>%</td>
                    <td>
                        <img src="<?php echo htmlspecialchars($row['url_foto']); ?>" 
                             alt="Foto do Combo" 
                             class="thumb-image">
                    </td>
                    <td class="actions">
                        <a href="edit_combo.php?id=<?php echo $row['id']; ?>" class="edit-btn">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="delete_combo.php?id=<?php echo $row['id']; ?>" 
                           class="delete-btn"
                           onclick="return confirm('Tem certeza que deseja excluir este combo?')">
                            <i class="fas fa-trash"></i> Excluir
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $conn->close(); ?>