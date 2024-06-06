<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Funções</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
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
        justify-content: space-between;
        align-items: center;
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

    <h1>Gerenciamento de Funções</h1>

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
            $descricao = $_POST['descricao'];

            $sql = "INSERT INTO Funcoes (Descricao) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $descricao);

            if ($stmt->execute()) {
                echo "<p>Função criada com sucesso!</p>";
            } else {
                echo "<p>Erro ao criar a função: " . $conn->error . "</p>";
            }

            $stmt->close();
        } elseif ($action == 'edit') {
            $funcao_id = $_POST['funcao_id'];
            $descricao = $_POST['descricao'];

            $sql = "UPDATE Funcoes SET Descricao = ? WHERE FuncaoID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $descricao, $funcao_id);

            if ($stmt->execute()) {
                echo "<p>Função atualizada com sucesso!</p>";
            } else {
                echo "<p>Erro ao atualizar a função: " . $conn->error . "</p>";
            }

            $stmt->close();
        } elseif ($action == 'delete') {
            $funcao_id = $_POST['funcao_id'];

            $sql = "DELETE FROM Funcoes WHERE FuncaoID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $funcao_id);

            if ($stmt->execute()) {
                echo "<p>Função excluída com sucesso!</p>";
            } else {
                echo "<p>Erro ao excluir a função: " . $conn->error . "</p>";
            }

            $stmt->close();
        }
    }

    // Obter funções
    $funcoes_result = $conn->query("SELECT * FROM Funcoes");
    ?>

    <div class="container-formulario">
        <div class="section" id="criar">
            <h2>Criar Nova Função</h2>
            <div class="form-container">
                <form action="?action=add" method="post">
                    <div class="form-group">
                        <label for="descricao" class="form-label">Descrição:</label>
                        <input type="text" id="descricao" name="descricao" class="form-input" required>
                    </div>
                    <button type="submit" class="form-button">Criar Função</button>
                </form>
            </div>
        </div>
        <div class="section" id="atualizar">
            <h2>Atualizar Função</h2>
            <div class="form-container">
                <form action="?action=edit" method="post">
                    <div class="form-group">
                        <label for="funcao_id" class="form-label">ID da Função:</label>
                        <input type="text" id="funcao_id" name="funcao_id" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="descricao" class="form-label">Descrição:</label>
                        <input type="text" id="descricao" name="descricao" class="form-input" required>
                    </div>
                    <button type="submit" class="form-button">Atualizar Função</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container-formulario2">
        <div class="box-excluir" id="excluir">
            <h2>Excluir Função</h2>
            <div class="container">
                <?php
                if ($funcoes_result->num_rows > 0) {
                    while($row = $funcoes_result->fetch_assoc()) {
                        echo "<div class='funcao-item'>" .
                            "<span>Função #" . $row["FuncaoID"] . " - Descrição: " . $row["Descricao"] . "</span>" .
                            "<form action='?action=delete' method='post' style='display:inline;'>
                                <input type='hidden' name='funcao_id' value='" . $row["FuncaoID"] . "'>
                                <button class='botao' type='submit'>Excluir</button>
                            </form>" .
                            "</div>";
                    }
                } else {
                    echo "<div class='funcao-item'><span>Nenhuma função encontrada</span></div>";
                }
                ?>
            </div>
        </div>
        <div class="box-listar" id="listar">
            <h2>Listar Funções</h2>
            <div class="container-lista">
                <table>
                    <thead>
                    <tr>
                        <th>ID
                        <th>Descrição</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $funcoes_result = $conn->query("SELECT * FROM Funcoes");
                        if ($funcoes_result->num_rows > 0) {
                            while($row = $funcoes_result->fetch_assoc()) {
                                echo "<tr>" .
                                    "<td>" . $row["FuncaoID"]. "</td>" . 
                                    "<td>" . $row["Descricao"] . "</td>" . 
                                "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>Nenhuma função encontrada</td></tr>";
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
