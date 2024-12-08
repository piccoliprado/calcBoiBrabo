<?php
require_once 'header_admin.php';
require_once '../config/database.php';

$sql = "SELECT * FROM combos";
$result = $conn->query($sql);
?>

<div class="gerenciar-container">
    <div class="card-gerenciar">
        <h1>Gerenciar Combos</h1>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($row['url_foto']); ?>" alt="Foto do Combo" class="thumb-image"></td>
                    <td><?php echo htmlspecialchars($row['nome_combo']); ?></td>
                    <td class="valor">R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                    <td>
                        <a href="toggle_combo.php?id=<?php echo $row['id']; ?>&status=<?php echo $row['ativo'] ? '0' : '1'; ?>" 
                           class="btn-toggle <?php echo $row['ativo'] ? 'ativo' : ''; ?>">
                            <i class="fas fa-toggle-<?php echo $row['ativo'] ? 'on' : 'off'; ?>"></i>
                            <?php echo $row['ativo'] ? 'Ativo' : 'Inativo'; ?>
                        </a>
                    </td>
                    <td class="actions">
                        <a href="edit_combo.php?id=<?php echo $row['id']; ?>" class="btn-edit">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="delete_combo.php?id=<?php echo $row['id']; ?>" 
                           class="btn-delete"
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