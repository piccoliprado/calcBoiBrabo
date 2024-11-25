<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/auth.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Combos</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <nav class="nav-container">
            <div class="logo-container">
                <a href="/"><img src="/uploads/logo-boi.png" alt="Logo" class="header-logo"></a>
            </div>
            
            <?php if (isLoggedIn()): ?>
                <ul class="nav-links">
                    <li><a href="/admin/calculadora.php">Calculadora</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">Itens</a>
                        <ul class="dropdown-menu">
                            <li><a href="/admin/cadastro_itens.php">Cadastrar Item</a></li>
                            <li><a href="/admin/gerenciar_itens.php">Gerenciar Itens</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">Combos</a>
                        <ul class="dropdown-menu">
                            <li><a href="/admin/cadastro_combo.php">Cadastrar Combo</a></li>
                            <li><a href="/admin/gerenciar_combos.php">Gerenciar Combos</a></li>
                        </ul>
                    </li>
                    <li><a href="/logout.php">Sair</a></li>
                </ul>
            <?php else: ?>
                <ul class="nav-links">
                    <li><a href="/login.php" class="login-btn">Área do Proprietário</a></li>
                </ul>
            <?php endif; ?>
        </nav>
    </header>
</body>
</html>