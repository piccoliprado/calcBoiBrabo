<?php
require_once 'check_auth.php';
require_once 'header_admin.php';
require_once '../config/database.php';

$sql = "SELECT COUNT(*) as total_combos FROM combos";
$result = $conn->query($sql);
$total_combos = $result->fetch_assoc()['total_combos'];

$sql = "SELECT COUNT(*) as total_itens FROM itens";
$result = $conn->query($sql);
$total_itens = $result->fetch_assoc()['total_itens'];

$sql = "SELECT * FROM combos ORDER BY id DESC LIMIT 5";
$ultimos_combos = $conn->query($sql);

$sql = "SELECT * FROM itens ORDER BY id DESC LIMIT 5";
$ultimos_itens = $conn->query($sql);
?>

<div class="dashboard-container">
    <div class="welcome-card">
        <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></h1>
        <p>Painel de Controle - Gerenciamento de Combos e Itens</p>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <i class="fas fa-hamburger"></i>
            <h3>Total de Combos</h3>
            <p><?php echo $total_combos; ?></p>
        </div>
        
        <div class="stat-card">
            <i class="fas fa-list"></i>
            <h3>Total de Itens</h3>
            <p><?php echo $total_itens; ?></p>
        </div>
    </div>
</div>

        <div class="quick-actions">
            <h2>Ações Rápidas</h2>
            <div class="actions-grid">
                <a href="calculadora.php" class="action-card">
                    <i class="fas fa-plus-circle"></i>
                    <span>Novo Combo</span>
                </a>
                <a href="cadastro_itens.php" class="action-card">
                    <i class="fas fa-plus"></i>
                    <span>Novo Item</span>
                </a>
            </div>
        </div>

        <div class="recent-items-section">
            <h2><i class="fas fa-burger"></i> Últimos Combos Cadastrados</h2>
            <div class="recent-grid">
                <?php
                $sql = "SELECT nome_combo, preco, url_foto, DATE_FORMAT(data_cadastro, '%d/%m/%Y às %H:%i') as data 
                        FROM combos 
                        ORDER BY data_cadastro DESC 
                        LIMIT 3";
                $ultimos_combos = $conn->query($sql);
        
                while($combo = $ultimos_combos->fetch_assoc()): ?>
                    <div class="recent-combo-card">
                        <div class="combo-image">
                            <img src="<?php echo htmlspecialchars($combo['url_foto']); ?>" 
                                 alt="<?php echo htmlspecialchars($combo['nome_combo']); ?>">
                        </div>
                    <div class="combo-info">
                        <h3><?php echo htmlspecialchars($combo['nome_combo']); ?></h3>
                        <p class="price">R$ <?php echo number_format($combo['preco'], 2, ',', '.'); ?></p>
                        <p class="date">Cadastrado em <?php echo $combo['data']; ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    <h2 style="margin-top: 2rem;"><i class="fas fa-list"></i> Últimos Itens Cadastrados</h2>
    <table class="recent-items-table">
        <tbody>
            <?php
            $sql = "SELECT nome, custo, DATE_FORMAT(data_cadastro, '%d/%m/%Y às %H:%i') as data 
                    FROM itens 
                    ORDER BY data_cadastro DESC 
                    LIMIT 5";
            $ultimos_itens = $conn->query($sql);
            
            while($item = $ultimos_itens->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['nome']); ?></td>
                    <td class="item-cost">R$ <?php echo number_format($item['custo'], 2, ',', '.'); ?></td>
                    <td class="item-date">Cadastrado em <?php echo $item['data']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php $conn->close(); ?>