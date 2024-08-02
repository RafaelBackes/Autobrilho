<?php
include 'conexao.php'; // Inclui o arquivo de conexão

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $numero = $_POST['numero'];
    $data = $_POST['data'];
    $turno = $_POST['turno'];

    // Verificar se a data e o turno já estão ocupados
    $sql_check = "SELECT * FROM agendamentos WHERE data = '$data' AND turno = '$turno'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $message = "Este horário já está ocupado. Por favor, escolha outro.";
    } else {
        $sql_insert = "INSERT INTO agendamentos (nome, numero, data, turno) VALUES ('$nome', '$numero', '$data', '$turno')";

        if ($conn->query($sql_insert) === TRUE) {
            // Adicionar o código do país e DDD ao número do usuário
            $numero_completo = "55051" . $numero;
            $whatsapp_url = "https://api.whatsapp.com/send?phone=$numero_completo&text=" . urlencode("Novo agendamento:\nNome: $nome\nNúmero: $numero\nData: $data\nTurno: $turno");
            $message = "Agendado com sucesso.";
        } else {
            $message = "Erro: " . $sql_insert . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento - Lavagem Automotiva</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos CSS conforme o layout desejado */
    </style>
</head>
<body>
    <div class="container">
        <div class="agendamento-form">
            <h2>Agendamento</h2>
            <?php if (!empty($message)): ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>
            <form id="agendamentoForm" action="agendar.php" method="post">
                <div class="input-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>
                </div>
                <div class="input-group">
                    <label for="numero">Número:</label>
                    <input type="text" id="numero" name="numero" placeholder="Digite seu número de telefone" required pattern="\d{8,9}" title="Digite um número de telefone válido (8 ou 9 dígitos)">
                </div>
                <div class="input-group">
                    <label for="data">Data:</label>
                    <input type="date" id="data" name="data" required>
                </div>
                <div class="input-group">
                    <label for="turno">Turno:</label>
                    <select id="turno" name="turno" required>
                        <option value="">Selecione o turno</option>
                        <option value="manhã">Manhã</option>
                        <option value="tarde">Tarde</option>
                    </select>
                </div>
                <button type="submit">Agendar</button>
            </form>
        </div>
    </div>
</body>
</html>
