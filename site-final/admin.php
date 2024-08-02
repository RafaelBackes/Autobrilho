<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração - Lavagem Automotiva</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Administração de Agendamentos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Turno</th>
                    <th>Número</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'conexao.php';
                $sql = "SELECT * FROM agendamentos";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nome']}</td>
                                <td>{$row['data']}</td>
                                <td>{$row['turno']}</td>
                                <td>{$row['numero']}</td>
                                <td>
                                    <a href='editar.php?id={$row['id']}'>Editar</a> |
                                    <a href='excluir.php?id={$row['id']}'>Excluir</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum agendamento encontrado</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        <h3>Adicionar Novo Agendamento</h3>
        <form action="adicionar.php" method="post">
            <div class="input-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="input-group">
                <label for="numero">Número:</label>
                <input type="text" id="numero" name="numero" required pattern="\d{8,9}" title="Digite um número de telefone válido (8 ou 9 dígitos)">
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
            <button type="submit">Adicionar Agendamento</button>
        </form>
        <br>
        <button onclick="window.location.href='index.html'" class="back-button">Voltar ao Site</button>
    </div>
</body>
</html>
