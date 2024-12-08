<?php
require_once 'header_admin.php';
require_once '../config/database.php';

// Buscar todos os itens disponíveis
$sql = "SELECT * FROM itens ORDER BY nome ASC";
$result = $conn->query($sql);
$itens = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $itens[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/calcBoiBrabo/css/calculadora.css">
    <title>Calculadora de Combos</title>
    <!-- Estilos específicos para a calculadora -->
    <style>
        .card {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-control {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Calculadora de Combos</h1>
        
        <!-- Formulário principal -->
        <form id="comboForm" method="POST" action="salvar_combo.php" enctype="multipart/form-data">
            <!-- Card do Nome do Combo -->
            <div class="card">
                <h3>Nome do Combo</h3>
                <input type="text" name="nome_combo" id="nome_combo" class="form-control" required>
            </div>

            <!-- Card da Descrição -->
            <div class="card">
                <h3>Descrição do Combo</h3>
                <textarea name="descricao" id="descricao" class="form-control" rows="4" 
                          placeholder="Descreva os itens que compõem este combo..." required></textarea>
            </div>

            <!-- Card de Seleção de Itens -->
            <div class="card">
                <h3>Selecione os Itens</h3>
                <select id="itemSelect" class="form-control" onchange="adicionarItem()">
                    <option value="">Selecione um item...</option>
                    <?php foreach ($itens as $item): ?>
                        <option value="<?php echo $item['id']; ?>" 
                                data-custo="<?php echo $item['custo']; ?>"
                                data-nome="<?php echo htmlspecialchars($item['nome']); ?>">
                            <?php echo htmlspecialchars($item['nome']); ?> - 
                            R$ <?php echo number_format($item['custo'], 2, ',', '.'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Lista de itens selecionados -->
                <div id="itensSelecionados">
                    <h4>Itens do Combo:</h4>
                    <ul id="listaItens"></ul>
                    <p>Custo Total: R$ <span id="custoTotal">0,00</span></p>
                </div>
            </div>

            <!-- Card da Margem de Lucro -->
            <div class="card">
                <h3>Definir Preço e Margem</h3>
                <div>
                    <label>Preço de Venda (R$):</label>
                    <input type="number" step="0.01" id="precoVenda" name="preco" class="form-control" required>
                </div>
                <div id="margemLucro">
                    <p>Margem de Lucro: <span id="margemValor">0</span>%</p>
                    <p id="margemStatus"></p>
                </div>
            </div>

            <!-- Input hidden para armazenar os itens selecionados -->
            <input type="hidden" name="itens_selecionados" id="itensHidden">
            
            <!-- Card da Foto -->
            <div class="card">
                <h3>Foto do Combo</h3>
                <input type="file" name="foto" class="form-control" required accept="image/*">
            </div>

            <button type="submit" class="add-item-btn">Salvar Combo</button>
        </form>
    </div>

    <script>
    // Variáveis globais
    let itensSelecionados = [];
    let custoTotal = 0;

    // Função para adicionar item ao combo
    function adicionarItem() {
        const select = document.getElementById('itemSelect');
        const option = select.options[select.selectedIndex];
        
        if (!option.value) return;

        const item = {
            id: option.value,
            nome: option.dataset.nome,
            custo: parseFloat(option.dataset.custo)
        };

        itensSelecionados.push(item);
        atualizarListaItens();
        calcularCustoTotal();
        atualizarMargem();
        
        select.selectedIndex = 0;
    }

    // Função para remover item do combo
    function removerItem(index) {
        itensSelecionados.splice(index, 1);
        atualizarListaItens();
        calcularCustoTotal();
        atualizarMargem();
    }

    // Atualiza a lista visual de itens
    function atualizarListaItens() {
        const lista = document.getElementById('listaItens');
        const itensHidden = document.getElementById('itensHidden');
        
        lista.innerHTML = '';
        itensSelecionados.forEach((item, index) => {
            lista.innerHTML += `
                <li>
                    ${item.nome} - R$ ${item.custo.toFixed(2)}
                    <button type="button" onclick="removerItem(${index})">Remover</button>
                </li>
            `;
        });

        itensHidden.value = JSON.stringify(itensSelecionados.map(item => item.id));
    }

    // Calcula o custo total dos itens
    function calcularCustoTotal() {
        custoTotal = itensSelecionados.reduce((total, item) => total + item.custo, 0);
        document.getElementById('custoTotal').textContent = custoTotal.toFixed(2);
    }

    // Atualiza o cálculo da margem de lucro
    function atualizarMargem() {
        const precoVenda = parseFloat(document.getElementById('precoVenda').value) || 0;
        if (custoTotal > 0 && precoVenda > 0) {
            const margem = ((precoVenda - custoTotal) / precoVenda) * 100;
            const margemValor = document.getElementById('margemValor');
            const margemStatus = document.getElementById('margemStatus');
            
            margemValor.textContent = margem.toFixed(2);
            
            if (margem > 0) {
                margemStatus.textContent = '✅ Margem Positiva';
                margemStatus.style.color = 'green';
            } else {
                margemStatus.textContent = '❌ Margem Negativa';
                margemStatus.style.color = 'red';
            }
        }
    }

    // Adiciona listener para o input de preço
    document.getElementById('precoVenda').addEventListener('input', atualizarMargem);
    </script>
</body>
</html>