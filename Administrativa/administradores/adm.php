<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Administradores</title>
</head>
<style>

    body {
        font-family: Arial, sans-serif;
    }

    .container{
        display: flex;
        justify-content: space-between;
        flex-direction: column;
    }

    .container-formulario {
        display: flex;
        justify-content: space-between;
        border: royalblue;
    }

    .section {
        width: 45%;
        margin-bottom: 30px;
        padding: 20px;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    h2 {
        color: #5100ff;
        margin-top: 0;
    }

    .form-container {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        color: #555;
    }

    .form-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-button {
        background-color: #f91010;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .form-button:hover {
        background-color: #9b2436;
    }

    .container-formulario2 {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
    }

    .box-excluir,
    .box-listar {
        width: 45%;
        padding: 20px;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .containerLista {
        margin-bottom: 20px;
    }

    .admin-item {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        text-align: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        margin-bottom: 10px;
    }

    .botao {
        background-color: red;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .botao:hover {
        background-color: darkred;
    }

    .nav-bar{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 30px;
        background-color: rgb(204, 60, 60);
        height: 80px;
        width: 100%;
        gap: 10px;
        border-radius: 10px;
    }

    .caminhos{
        text-decoration: none;
        color: white;
        gap: 10px;
        background-color:rgb(255, 70, 70);
        height: 50px;
        width: 200px;
        text-align: center;
        justify-content: center;
        border-radius: 5px;
        font-size: 22px;
        align-items: center;
    }

    .caminhos:hover{
        background-color:rgb(255, 141, 141)
    }


    .botaovoltar{
        display: flex;
        justify-content: center;
        align-items: center;
        background-color:#5100ff;
        color: white;
        text-decoration: none;
        height: 40px;
        width: 200px;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .botaovoltar:hover{
        background-color: #5100ff;
    }

    .admin-item{
        justify-content: space-betweenq;
    }
</style>
<body>
    <a class="botaovoltar" href="../index.php">MENU PRINCIPAL</a>
    <nav class="nav-bar">
        <a class="caminhos" href="../pizzas/indexPizzas.php">Gerenciamento de Pizzas</a>
        <a class="caminhos" href="../Funcionarios/funcionarios.php">Gerenciamento de Funcionarios</a>
        <a class="caminhos" href="../Cliente/cliente.php">Gerenciamento de Clientes</a>
        <a class="caminhos" href="../administradores/adm.php">Gerenciamento de Administradores</a>
        <a class="caminhos" href="../pedido/pedido.php">Gerenciamento de Pedido</a>
        <a class="caminhos" href="../Funcoes/funcoes.php">Gerenciamento de Funçoes</a>
    </nav>

    <h1>Gerenciamento de Administradores</h1>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Pizzaria";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        if ($action == 'add') {
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];
            $nome = $_POST['nome'];

            $sql = "INSERT INTO Administradores (usuario, senha, nome) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $usuario, $senha, $nome);

            if ($stmt->execute()) {
                echo "<p>Administrador criado com sucesso!</p>";
            } else {
                echo "<p>Erro ao criar o administrador: " . $conn->error . "</p>";
            }

            $stmt->close();
        } elseif ($action == 'edit') {
            $adm_id = $_POST['adm_id'];
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];
            $nome = $_POST['nome'];

            $sql = "UPDATE Administradores SET usuario=?, senha=?, nome=? WHERE adm_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $usuario, $senha, $nome, $adm_id);

            if ($stmt->execute()) {
                echo "<p>Administrador atualizado com sucesso!</p>";
            } else {
                echo "<p>Erro ao atualizar o administrador: " . $conn->error . "</p>";
            }

            $stmt->close();
        } elseif ($action == 'delete') {
            $adm_id = $_POST['adm_id'];

            $sql = "DELETE FROM Administradores WHERE adm_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $adm_id);

            if ($stmt->execute()) {
                echo "<p>Administrador excluído com sucesso!</p>";
            } else {
                echo "<p>Erro ao excluir o administrador: " . $conn->error . "</p>";
            }

            $stmt->close();
        }
    }
    ?>

    <div class="container-formulario">
        <div class="section" id="criar">
            <h2>Criar Novo Administrador</h2>
            <div class="form-container">
                <form action="?action=add" method="post">
                    <div class="form-group">
                        <label for="usuario" class="form-label">Usuário:</label>
                        <input type="text" id="usuario" name="usuario" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="senha" class="form-label">Senha:</label>
                        <input type="password" id="senha" name="senha" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" id="nome" name="nome" class="form-input" required>
                    </div>
                    <button type="submit" class="form-button">Criar Administrador</button>
                </form>
            </div>
        </div>
        <div class="section" id="atualizar">
            <h2>Atualizar Administrador</h2>
            <div class="form-container">
                <form action="?action=edit" method="post">
                    <div class="form-group">
                        <label for="adm_id" class="form-label">ID do Administrador:</label>
                        <input type="text" id="adm_id" name="adm_id" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="usuario" class="form-label">Usuário:</label>
                        <input type="text" id="usuario" name="usuario" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="senha" class="form-label">Senha:</label>
                        <input type="password" id="senha" name="senha" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" id="nome" name="nome" class="form-input" required>
                    </div>
                    <button type="submit" class="form-button">Atualizar Administrador</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container-formulario2">
        <div class="box-excluir" id="excluir">
            <h2>Excluir Administrador</h2>
            <div class="container">
                <?php
                $sql = "SELECT * FROM Administradores";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='admin-item'>" .
                                "<span>" . $row["nome"] . "</span>" .
                                "<form action='?action=delete' method='post' style='display:inline;'>
                                    <input type='hidden' name='adm_id' value='" . $row["adm_id"] . "'>
                                    <button class='botao' type='submit'>Excluir</button>
                                </form>" .
                             "</div>";
                    }
                } else {
                    echo "<div class='admin-item'><span>Nenhum administrador encontrado</span></div>";
                }
                ?>
            </div>
        </div>
        <div class="box-listar" id="listar">
            <h2>Listar Administradores</h2>
            <div class="container-lista">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuário</th>
                            <th>Nome</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM Administradores";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>" .
                                        "<td>" . $row["adm_id"]. "</td>" . 
                                        "<td>" . $row["usuario"] . "</td>" . 
                                        "<td>" . $row["nome"] . "</td>" .
                                    "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhum administrador encontrado</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    $conn->close();
    ?>
</body>
</html>
