<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_delete = "DELETE FROM agendamentos WHERE id = $id";

    if ($conn->query($sql_delete) === TRUE) {
        echo "Agendamento excluído com sucesso.";
    } else {
        echo "Erro: " . $sql_delete . "<br>" . $conn->error;
    }
} else {
    echo "ID do agendamento não fornecido.";
}

$conn->close();
header("Location: admin.php");
exit;
?>
