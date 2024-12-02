<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/calcBoiBrabo/config/auth.php';
requireLogin(); // Força autenticação em todas as páginas admin
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Calculadora de Combos</title>
    <link rel="stylesheet" href="/calcBoiBrabo/css/style.css"> <!-- Caminho para o CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <nav class="nav-container">
            <div class="logo-container">
                <a href="home.php"><img src="../uploads/logo-boi.png" alt="Logo" class="header-logo"></a>
            </div>
            <ul class="nav-links">
                <li><a href="/calcBoiBrabo/admin/calculadora.php">Calculadora</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">Itens <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="/calcBoiBrabo/admin/cadastro_itens.php">Cadastrar Item</a></li>
                        <li><a href="/calcBoiBrabo/admin/gerenciar_itens.php">Gerenciar Itens</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">Combos <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="/calcBoiBrabo/admin/cadastro_combo.php">Cadastrar Combo</a></li>
                        <li><a href="/calcBoiBrabo/admin/gerenciar_combos.php">Gerenciar Combos</a></li>
                    </ul>
                </li>
                <li><a href="../logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>