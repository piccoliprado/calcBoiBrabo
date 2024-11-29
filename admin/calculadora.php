<?php
require_once 'header_admin.php';
require_once '../config/database.php';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Calculadora de Combos de Carnes</title>
</head>
<body>
    <h1>Calculadora de Combos de Carnes</h1>
    
    <div id="calculadora">
        <div class="opcao">
            <label for="carne">Escolha a carne:</label>
            <select id="carne" name="carne">
                <option value="0,10,20">Nenhuma carne</option>
                <option value="10,20,30">Carne 1 - $10</option>
                <option value="15,25,35">Carne 2 - $15</option>
                <option value="20,30,40">Carne 3 - $20</option>
            </select>
        </div>
        
        <div class="opcao">
            <label for="adicional1">Escolha os adicionais:</label>
            <input type="checkbox" id="adicional1" name="adicional1" value="5"> Adicional 1 - $5
            <input type="checkbox" id="adicional2" name="adicional2" value="7"> Adicional 2 - $7
        </div>

        <div class="opcao">
            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" value="1" min="1">
        </div>
        
        <div class="opcao">
            <label for="custo">Custo de Compra:</label>
            <input type="number" id="custoCompra" step="0,01" placeholder="Insira o cuto da Compra"></input>
        </div>

        <div class="opcao">
            <label for="preco">Preço de Venda:</label>
            <input type="number" id="precoVenda" step="0,01" placeholder="Insira o preço da Venda"></input>
        </div>

        <div class="opcao">
            <label for="margem">Margem de Lucro:</label>
            <span id="margemLucro"><?php echo calcularMargemLucro(); ?></span>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>

<?php
function calcularCusto() {

}

function calcularPrecoVenda() {
    
}

function calcularMargemLucro() {
    $custocompra = calcularCusto();
    $precoVenda = calcularPrecoVenda();
    
    if ($precoVenda > 0) {
        $margem = (($precoVenda - $custo) / $precoVenda) * 100;
        return number_format($margem, 2) . "%";
    } else {
        return "0%";
    }
}
?>
