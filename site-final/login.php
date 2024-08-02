<?php
session_start();
include 'conexao.php'; // Inclua a conexão com o banco de dados

// Mensagem de erro padrão
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados enviados pelo formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar uma declaração SQL para evitar SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verificar se o usuário existe
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar se a senha está correta
        if ($password === $row['password']) {
            // Criar sessão de login
            $_SESSION['loggedin'] = true;
            $_SESSION['admin'] = $username;
            // Redirecionar para a página de administração
            header("Location: admin.php");
            exit();
        } else {
            $error_message = "Usuário ou senha incorretos.";
        }
    } else {
        $error_message = "Usuário ou senha incorretos.";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administração</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login de Administrador</h2>
        <?php   
        if (!empty($error_message)) {
            echo "<p class='error'>$error_message</p>";
        }
        ?>
        <form action="login.php" method="post">
            <div class="input-group">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
