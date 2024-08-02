<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM agendamentos WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Agendamento não encontrado.";
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $numero = $_POST['numero'];
    $data = $_POST['data'];
    $turno = $_POST['turno'];

    $sql_update = "UPDATE agendamentos SET nome='$nome', numero='$numero', data='$data', turno='$turno' WHERE id=$id";

    if ($conn->query($sql_update) === TRUE) {
        echo "Agendamento atualizado com sucesso.";
    } else {
        echo "Erro: " . $sql_update . "<br>" . $conn->error;
    }

    $conn->close();
    header("Location: admin.php");
    exit;
} else {
    echo "Ação inválida.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agendamento</title>
</head>
<body>
    <div class="container">
        <h2>Editar Agendamento</h2>
        <form action="editar.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="input-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $row['nome']; ?>" required>
            </div>
            <div class="input-group">
                <label for="numero">Número:</label>
                <input type="text" id="numero" name="numero" value="<?php echo $row['numero']; ?>" required pattern="\d{8,9}" title="Digite um número de telefone válido (8 ou 9 dígitos)">
            </div>
            <div class="input-group">
                <label for="data">Data:</label>
                <input type="date" id="data" name="data" value="<?php echo $row['data']; ?>" required>
            </div>
            <div class="input-group">
                <label for="turno">Turno:</label>
                <select id="turno" name="turno" required>
                    <option value="manhã" <?php if ($row['turno'] == 'manhã') echo 'selected'; ?>>Manhã</option>
                    <option value="tarde" <?php if ($row['turno'] == 'tarde') echo 'selected'; ?>>Tarde</option>
                </select>
            </div>
            <button type="submit">Atualizar Agendamento</button>
        </form>
    </div>
</body>
</html>
