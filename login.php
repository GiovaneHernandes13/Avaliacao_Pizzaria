<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Área Administrativa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10;
            padding: 10 ;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color:antiquewhite;
        }
          
        form {
            background-color: #fff;
            padding: 60px 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        
        }
        label, input {
            display: block;
            margin-bottom: 15px;
            border-radius: 5px;
            padding: 10px 40px;
        }

        h2{
            text-align: center;
        }
        input[type="submit"] {
            background-color:blue;
            color: #fff;
            padding: 10px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
          
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
         
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h2>Login</h2>
    <h2>Área Administrativa</h2>
    <label for="usuario">Usuário:</label>
    <input type="text" id="usuario" name="usuario" required>
    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required>
    <input type="submit" value="Login">
    <?php
    if (isset($login_error)) {
        echo "<div class='error'>$login_error</div>";
    }
    ?>
</form>

</body>
</html>
<?php
session_start();

// Verificar se os campos foram submetidos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Pizzaria";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Recuperar dados do formulário
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Consulta SQL para verificar se o administrador existe e a senha está correta
    $sql = "SELECT * FROM Administradores WHERE usuario = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Senha e usuário corretos, iniciar sessão e redirecionar para a área administrativa
        $_SESSION['admin_id'] = $row['adm_id'];
        $_SESSION['admin_nome'] = $row['nome'];
        header("Location: Administrativa/index.php");
        exit();
    } else {
        // Usuário ou senha incorretos, exibir mensagem de erro
        $login_error = "Usuário ou senha incorretos.";
    }

    $stmt->close();
    $conn->close();
}
?>
