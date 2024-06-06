<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Funcionários</title>
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
            display: flex;
            flex-direction: column;
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


        .funcionario-item{
            display: flex;
            justify-content: space-between;
           
        }
    </style>
</head>
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

    <h1>Gerenciamento de Funcionários</h1>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Pizzaria";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function getFuncoes($conn) {
        $sql = "SELECT * FROM Funcoes";
        $result = $conn->query($sql);
        $funcoes = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $funcoes[] = $row;
            }
        }
        return $funcoes;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        if ($action == 'add') {
            $nome = $_POST['nome'];
            $telefone = $_POST['telefone'];
            $email = $_POST['email'];
            $endereco = $_POST['endereco'];
            $funcoes = isset($_POST['funcoes']) ? $_POST['funcoes'] : [];

            $sql = "INSERT INTO Funcionarios (Nome, Telefone, Email, Endereco) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $nome, $telefone, $email, $endereco);

            if ($stmt->execute()) {
                $funcionarioID = $stmt->insert_id;
                foreach ($funcoes as $funcaoID) {
                    $sqlFuncoes = "INSERT INTO FuncionarioFuncoes (FuncionarioID, FuncaoID) VALUES (?, ?)";
                    $stmtFuncoes = $conn->prepare($sqlFuncoes);
                    $stmtFuncoes->bind_param("ii", $funcionarioID, $funcaoID);
                    $stmtFuncoes->execute();
                }
                echo "<p>Funcionário criado com sucesso!</p>";
            } else {
                echo "<p>Erro ao criar o funcionário: " . $conn->error . "</p>";
            }

            $stmt->close();
        } elseif ($action == 'edit') {
            $funcionarioID = $_POST['funcionarioID'];
            $nome = $_POST['nome'];
            $telefone = $_POST['telefone'];
            $email = $_POST['email'];
            $endereco = $_POST['endereco'];
            $funcoes = isset($_POST['funcoes']) ? $_POST['funcoes'] : [];

            $sql = "UPDATE Funcionarios SET Nome=?, Telefone=?, Email=?, Endereco=? WHERE FuncionarioID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $nome, $telefone, $email, $endereco, $funcionarioID);

            if ($stmt->execute()) {
                $sqlDeleteFuncoes = "DELETE FROM FuncionarioFuncoes WHERE FuncionarioID=?";
                $stmtDeleteFuncoes = $conn->prepare($sqlDeleteFuncoes);
                $stmtDeleteFuncoes->bind_param("i", $funcionarioID);
                $stmtDeleteFuncoes->execute();

                foreach ($funcoes as $funcaoID) {
                    $sqlFuncoes = "INSERT INTO FuncionarioFuncoes (FuncionarioID, FuncaoID) VALUES (?, ?)";
                    $stmtFuncoes = $conn->prepare($sqlFuncoes);
                    $stmtFuncoes->bind_param("ii", $funcionarioID, $funcaoID);
                    $stmtFuncoes->execute();
                }
                echo "<p>Funcionário atualizado com sucesso!</p>";
            } else {
                echo "<p>Erro ao atualizar o funcionário: " . $conn->error . "</p>";
            }

            $stmt->close();
        } elseif ($action == 'delete') {
            $funcionarioID = $_POST['funcionarioID'];

            $sql = "DELETE FROM Funcionarios WHERE FuncionarioID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $funcionarioID);

            if ($stmt->execute()) {
                $sqlDeleteFuncoes = "DELETE FROM FuncionarioFuncoes WHERE FuncionarioID=?";
                $stmtDeleteFuncoes = $conn->prepare($sqlDeleteFuncoes);
                $stmtDeleteFuncoes->bind_param("i", $funcionarioID);
                $stmtDeleteFuncoes->execute();
                echo "<p>Funcionário excluído com sucesso!</p>";
            } else {
                echo "<p>Erro ao excluir o funcionário: " . $conn->error . "</p>";
            }

            $stmt->close();
        }
    }

    $funcoes = getFuncoes($conn);
    ?>

    <div class="container-formulario">
        <div class="section" id="criar">
            <h2>Criar Novo Funcionário</h2>
            <div class="form-container">
                <form action="?action=add" method="post">
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" id="nome" name="nome" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="telefone" class="form-label">Telefone:</label>
                        <input type="text" id="telefone" name="telefone" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email:</label>
                        <input type="text" id="email" name="email" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="endereco" class="form-label">Endereço:</label>
                        <input type="text" id="endereco" name="endereco" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="funcoes" class="form-label">Funções:</label>
                        <?php foreach ($funcoes as $funcao): ?>
                            <div>
                                <input type="checkbox" id="funcao_<?php echo $funcao['FuncaoID']; ?>" name="funcoes[]" value="<?php echo $funcao['FuncaoID']; ?>">
                                <label for="funcao_<?php echo $funcao['FuncaoID']; ?>"><?php echo $funcao['Descricao']; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="form-button">Criar Funcionário</button>
                </form>
            </div>
        </div>
        <div class="section" id="atualizar">
            <h2>Atualizar Funcionário</h2>
            <div class="form-container">
                <form action="?action=edit" method="post">
                    <div class="form-group">
                        <label for="funcionarioID" class="form-label">ID do Funcionário:</label>
                        <input type="text" id="funcionarioID" name="funcionarioID" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" id="nome" name="nome" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="telefone" class="form-label">Telefone:</label>
                        <input type="text" id="telefone" name="telefone" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email:</label>
                        <input type="text" id="email" name="email" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="endereco" class="form-label">Endereço:</label>
                        <input type="text" id="endereco" name="endereco" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="funcoes" class="form-label">Funções:</label>
                        <?php foreach ($funcoes as $funcao): ?>
                            <div>
                                <input type="checkbox" id="funcao_<?php echo $funcao['FuncaoID']; ?>" name="funcoes[]" value="<?php echo $funcao['FuncaoID']; ?>">
                                <label for="funcao_<?php echo $funcao['FuncaoID']; ?>"><?php echo $funcao['Descricao']; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="form-button">Atualizar Funcionário</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container-formulario2">
        <div class="box-excluir" id="excluir">
            <h2>Excluir Funcionário</h2>
            <div class="container">
                <?php
                $sql = "SELECT * FROM Funcionarios";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='funcionario-item'>" .
                                "<span>" . $row["Nome"] . "</span>" .
                                "<form action='?action=delete' method='post' style='display:inline;'>
                                    <input type='hidden' name='funcionarioID' value='" . $row["FuncionarioID"] . "'>
                                    <button class='botao' type='submit'>Excluir</button>
                                </form>" .
                             "</div>";
                    }
                } else {
                    echo "<div class='funcionario-item'><span>Nenhum funcionário encontrado</span></div>";
                }
                ?>
            </div>
        </div>
        <div class="box-listar" id="listar">
            <h2>Listar Funcionários</h2>
            <div class="container-lista">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>Endereço</th>
                            <th>Funções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT f.FuncionarioID, f.Nome, f.Telefone, f.Email, f.Endereco, GROUP_CONCAT(fn.Descricao SEPARATOR ', ') as Funcoes
                                FROM Funcionarios f
                                LEFT JOIN FuncionarioFuncoes ff ON f.FuncionarioID = ff.FuncionarioID
                                LEFT JOIN Funcoes fn ON ff.FuncaoID = fn.FuncaoID
                                GROUP BY f.FuncionarioID";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>" .
                                        "<td>" . $row["FuncionarioID"] . "</td>" . 
                                        "<td>" . $row["Nome"] . "</td>" . 
                                        "<td>" . $row["Telefone"] . "</td>" . 
                                        "<td>" . $row["Email"] . "</td>" . 
                                        "<td>" . $row["Endereco"] . "</td>" . 
                                        "<td>" . $row["Funcoes"] . "</td>" . 
                                    "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Nenhum funcionário encontrado</td></tr>";
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
