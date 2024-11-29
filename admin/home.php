<?php
require_once 'check_auth.php';
require_once 'header_admin.php';
require_once '../config/database.php';

// Buscar estatísticas
$sql = "SELECT COUNT(*) as total_combos FROM combos";
$result = $conn->query($sql);
$total_combos = $result->fetch_assoc()['total_combos'];

$sql = "SELECT COUNT(*) as total_itens FROM itens";
$result = $conn->query($sql);
$total_itens = $result->fetch_assoc()['total_itens'];

// Buscar últimos combos cadastrados
$sql = "SELECT * FROM combos ORDER BY id DESC LIMIT 5";
$ultimos_combos = $conn->query($sql);

// Buscar últimos itens cadastrados
$sql = "SELECT * FROM itens ORDER BY id DESC LIMIT 5";
$ultimos_itens = $conn->query($sql);
?>

<div class="container">
    <div class="dashboard-grid">
        <div class="welcome-section">
            <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></h1>
            <p>Painel de Controle - Gerenciamento de Combos e Itens</p>
        </div>

        <div class="stats-section">
            <div class="stat-card">
                <i class="fas fa-hamburger"></i>
                <h3>Total de Combos</h3>
                <p><?php echo $total_combos; ?></p>
                <a href="gerenciar_combos.php" class="btn">Gerenciar Combos</a>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-list"></i>
                <h3>Total de Itens</h3>
                <p><?php echo $total_itens; ?></p>
                <a href="gerenciar_itens.php" class="btn">Gerenciar Itens</a>
            </div>
        </div>

        <div class="quick-actions">
            <h2>Ações Rápidas</h2>
            <div class="actions-grid">
                <a href="cadastro_combo.php" class="action-card">
                    <i class="fas fa-plus-circle"></i>
                    <span>Novo Combo</span>
                </a>
                <a href="cadastro_itens.php" class="action-card">
                    <i class="fas fa-plus"></i>
                    <span>Novo Item</span>
                </a>
                <a href="calculadora.php" class="action-card">
                    <i class="fas fa-calculator"></i>
                    <span>Calculadora</span>
                </a>
            </div>
        </div>

        <div class="recent-items">
            <div class="recent-section">
                <h2>Últimos Combos Cadastrados</h2>
                <div class="recent-grid">
                    <?php while ($combo = $ultimos_combos->fetch_assoc()): ?>
                        <div class="recent-card">
                            <img src="<?php echo htmlspecialchars($combo['url_foto']); ?>" 
                                 alt="<?php echo htmlspecialchars($combo['nome_combo']); ?>"
                                 class="recent-thumb">
                            <div class="recent-info">
                                <h3><?php echo htmlspecialchars($combo['nome_combo']); ?></h3>
                                <p>R$ <?php echo number_format($combo['preco'], 2, ',', '.'); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="recent-section">
                <h2>Últimos Itens Cadastrados</h2>
                <table class="recent-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Custo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = $ultimos_itens->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['nome']); ?></td>
                                <td>R$ <?php echo number_format($item['custo'], 2, ',', '.'); ?></td>
                                <td>
                                    <a href="edit_item.php?id=<?php echo $item['id']; ?>" 
                                       class="btn-small">Editar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $conn->close(); ?>