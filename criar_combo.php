<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calcbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_combo = $_POST['nome_combo'];
    $preco = $_POST['preco'];
    $margem_lucro = $_POST['margem_lucro'];

    // Processar upload da imagem
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar se o arquivo é uma imagem
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Arquivo não é uma imagem.";
        $uploadOk = 0;
    }

    // Verificar se o upload é permitido
    if ($uploadOk == 1 && move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO combos (nome_combo, preco, margem_lucro, foto)
                VALUES ('$nome_combo', '$preco', '$margem_lucro', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "Novo combo cadastrado com sucesso!";
            header("Location: index.php");
            exit();
        } else {
            echo "Erro ao cadastrar combo: " . $conn->error;
        }
    } else {
        echo "Erro no upload da imagem.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Combo</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
    <form class="form" action="cadastro_combo.php" method="POST" enctype="multipart/form-data">
        <div class="card">
            <h2 class="title">Cadastrar Combo</h2>
            
            <div class="card-group">
                <label>Nome do Combo</label>
                <input type="text" name="nome_combo" placeholder="Digite o nome do combo" required>
            </div>

            <div class="card-group">
                <label>Preço</label>
                <input type="number" step="0.01" name="preco" placeholder="Digite o preço" required>
            </div>

            <div class="card-group">
                <label>Margem de Lucro (%)</label>
                <input type="number" step="0.01" name="margem_lucro" placeholder="Digite a margem de lucro" required>
            </div>

            <div class="card-group">
                <label>Foto do Combo</label>
                <input type="file" name="foto" required>
            </div>

            <div class="card-group btn">
                <button type="submit">Cadastrar Combo</button>
            </div>
        </div>
    </form>
</body>
</html>
