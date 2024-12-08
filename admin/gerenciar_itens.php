<?php
require_once 'header_admin.php';
require_once '../config/database.php';

$sql = "SELECT * FROM itens";
$result = $conn->query($sql);
?>

<div class="gerenciar-container">
    <div class="card-gerenciar">
        <h1>Gerenciar Itens</h1>
        
        <?php if (isset($_GET['sucesso'])): ?>
            <div class="message success">Item atualizado com sucesso!</div>
        <?php endif; ?>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Custo</th>
                    <th>Unidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nome']); ?></td>
                    <td class="valor">R$ <?php echo number_format($row['custo'], 2, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($row['unidade_medida']); ?></td>
                    <td class="actions">
                        <a href="edit_item.php?id=<?php echo $row['id']; ?>" class="btn-edit">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="delete_item.php?id=<?php echo $row['id']; ?>" 
                           class="btn-delete"
                           onclick="return confirm('Tem certeza que deseja excluir este item?')">
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