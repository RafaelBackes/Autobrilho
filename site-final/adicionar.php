<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $numero = $_POST['numero'];
    $data = $_POST['data'];
    $turno = $_POST['turno'];

    $sql_check = "SELECT * FROM agendamentos WHERE data = '$data' AND turno = '$turno'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "Este horário já está ocupado. Por favor, escolha outro.";
    } else {
        $sql_insert = "INSERT INTO agendamentos (nome, numero, data, turno) VALUES ('$nome', '$numero', '$data', '$turno')";

        if ($conn->query($sql_insert) === TRUE) {
            echo "Agendamento adicionado com sucesso.";
        } else {
            echo "Erro: " . $sql_insert . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
