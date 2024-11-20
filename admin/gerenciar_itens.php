<?php
include 'header.php';
include 'config/database.php';

$sql = "SELECT * FROM itens";
$result = $conn->query($sql);
?>

<div class="container">
    <div class="card">
        <h1 class="title">Gerenciar Itens</h1>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Custo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nome']); ?></td>
                    <td>R$ <?php echo number_format($row['custo'], 2, ',', '.'); ?></td>
                    <td class="actions">
                        <a href="edit_item.php?id=<?php echo $row['id']; ?>" class="edit-btn">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="delete_item.php?id=<?php echo $row['id']; ?>" 
                           class="delete-btn"
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