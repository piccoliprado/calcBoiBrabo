<?php
require_once 'check_auth.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calcbc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o ID do combo foi enviado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM combos WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $combo = $result->fetch_assoc();
    } else {
        echo "Combo não encontrado!";
        exit;
    }
}

// Atualiza o combo após o envio do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome_combo = $_POST['nome_combo'];
    $preco = $_POST['preco'];
    $margem_lucro = $_POST['margem_lucro'];

    // Verifica se uma nova imagem foi enviada
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Faz o upload da nova imagem, se válida
        if (getimagesize($_FILES["foto"]["tmp_name"]) !== false) {
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
            $sql = "UPDATE combos SET nome_combo = '$nome_combo', preco = '$preco', margem_lucro = '$margem_lucro', url_foto = '$target_file' WHERE id = $id";
        } else {
            echo "Erro: Arquivo não é uma imagem.";
            exit();
        }
    } else {
        // Atualiza o combo sem alterar a imagem
        $sql = "UPDATE combos SET nome_combo = '$nome_combo', preco = '$preco', margem_lucro = '$margem_lucro' WHERE id = $id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Combo atualizado com sucesso!";
        header("Location: index.php"); // Redireciona para a página inicial após atualização
        exit();
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Combo</title>
</head>
<body>
    <form class="form" action="edit_combo.php?id=<?php echo $combo['id']; ?>" method="POST" enctype="multipart/form-data">
        <div class="card">
            <h2 class="title">Editar Combo</h2>
            
            <input type="hidden" name="id" value="<?php echo $combo['id']; ?>">

            <div class="card-group">
                <label>Nome do Combo</label>
                <input type="text" name="nome_combo" value="<?php echo htmlspecialchars($combo['nome_combo']); ?>" required>
            </div>

            <div class="card-group">
                <label>Preço</label>
                <input type="number" step="0.01" name="preco" value="<?php echo htmlspecialchars($combo['preco']); ?>" required>
            </div>

            <div class="card-group">
                <label>Margem de Lucro (%)</label>
                <input type="number" step="0.01" name="margem_lucro" value="<?php echo htmlspecialchars($combo['margem_lucro']); ?>" required>
            </div>

            <div class="card-group">
                <label>Foto do Combo</label>
                <input type="file" name="foto">
                <p>Foto atual: <img src="<?php echo $combo['url_foto']; ?>" alt="Foto atual" style="max-width: 100px;"></p>
            </div>

            <div class="card-group btn">
                <button type="submit">Atualizar Combo</button>
            </div>
        </div>
    </form>
</body>
</html>

<?php $conn->close(); ?>
