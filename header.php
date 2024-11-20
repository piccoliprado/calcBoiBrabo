<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Calculadora de Combos</title>
    <!-- Adicionando ícones do Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <nav class="nav-container">
            <div class="logo-container">
                <img src="uploads/logo-boi.png" alt="Logo" class="header-logo">
            </div>
            <ul class="nav-links">
                <!-- Dropdown Itens -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        Itens <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="cadastro_itens.php">Cadastrar Item</a></li>
                        <li><a href="gerenciar_itens.php">Exibir Itens</a></li>
                    </ul>
                </li>
                
                <!-- Dropdown Combos -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        Combos <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="cadastro_combo.php">Cadastrar Combo</a></li>
                        <li><a href="gerenciar_combos.php">Exibir Combos</a></li>
                    </ul>
                </li>
                
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>