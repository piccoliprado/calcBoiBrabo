document.addEventListener("DOMContentLoaded", function() {
    const selecaoCarne = document.getElementById("carne");
    const adicional1 = document.getElementById("adicional1");
    const adicional2 = document.getElementById("adicional2");
    const custoCompra = document.getElementById("custoCompra");
    const precoVenda = document.getElementById("precoVenda");
    const margemLucro = document.getElementById("margemLucro");

    selecaoCarne.addEventListener("change", atualizarTotal);
    adicional1.addEventListener("change", atualizarTotal);
    adicional2.addEventListener("change", atualizarTotal);

    function atualizarTotal() {
        const opcoesSelecionadas = selecaoCarne.value.split(",");
        const precoCarne = parseFloat(opcoesSelecionadas[0]);
        const precoAdicional1 = adicional1.checked ? parseFloat(adicional1.value) : 0;
        const precoAdicional2 = adicional2.checked ? parseFloat(adicional2.value) : 0;
        const quantidade = parseInt(document.getElementById("quantity").value) || 1;
    
        const custoCompra = (precoCarne + precoAdicional1 + precoAdicional2) * quantidade;
        custoCompra.textContent = "R$" + custoCompra.toFixed(2);
    
        const precoVenda = (parseFloat(opcoesSelecionadas[2]) + precoAdicional1 + precoAdicional2) * quantidade;
        precoVenda.textContent = "R$" + precoVenda.toFixed(2);
    
        const margemLucro = ((precoVenda - custo) / precoVenda) * 100;
        margemLucro.textContent = margemLucro.toFixed(2) + "%";    
    }
    atualizarTotal();
});
