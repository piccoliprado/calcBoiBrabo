<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Combos</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/detalhes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        function mostrarDetalhes(id) {
            window.location.href = `detalhes_combo.php?id=${id}`;
        }
    </script>
</head>
<body>
    <header class="main-header">
        <nav class="nav-container">
            <div class="logo-container">
                <a href="index.php"><img src="img/boilogo.png" alt="Logo" class="header-logo"></a>
            </div>
            <ul class="nav-links">
                <li><a href="login.php" class="login-btn">Área do Proprietário</a></li>
            </ul>
        </nav>
    </header>