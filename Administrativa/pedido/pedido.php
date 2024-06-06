<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Pedidos</title>
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

    <h1>Gerenciamento de Pedidos</h1>

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
            $cliente_id = $_POST['cliente_id'];
            $data_pedido = $_POST['data_pedido'];
            $status = $_POST['status'];
            $pizzas_selecionadas = isset($_POST['pizzas']) ? $_POST['pizzas'] : [];
            $quantidades = isset($_POST['quantidades']) ? $_POST['quantidades'] : [];
            $total = 0;

           
            foreach ($pizzas_selecionadas as $index => $pizza_id) {
                $result = $conn->query("SELECT Preco FROM Pizzas WHERE PizzaID = $pizza_id");
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $quantidade = $quantidades[$index];
                    $total += $row['Preco'] * $quantidade;
                }
            }

            $sql = "INSERT INTO Pedidos (ClienteID, DataPedido, Status, Total) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isss", $cliente_id, $data_pedido, $status, $total);

            if ($stmt->execute()) {
                echo "<p>Pedido criado com sucesso!</p>";
            } else {
                echo "<p>Erro ao criar o pedido: " . $conn->error . "</p>";
            }

            $stmt->close();
        } elseif ($action == 'edit') {
            $pedido_id = $_POST['pedido_id'];
            $cliente_id = $_POST['cliente_id'];
            $data_pedido = $_POST['data_pedido'];
            $status = $_POST['status'];
            $pizzas_selecionadas = isset($_POST['pizzas']) ? $_POST['pizzas'] : [];
            $quantidades = isset($_POST['quantidades']) ? $_POST['quantidades'] : [];
            $total = 0;

            $sql = "UPDATE Pedidos SET ClienteID = ?, DataPedido = ?, Status = ?, Total = ? WHERE PedidoID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssi", $cliente_id, $data_pedido, $status, $total, $pedido_id);

            if ($stmt->execute()) {
                echo "<p>Pedido atualizado com sucesso!</p>";
            } else {
                echo "<p>Erro ao atualizar o pedido: " . $conn->error . "</p>";
            }

            $stmt->close();
        } elseif ($action == 'delete') {
            $pedido_id = $_POST['pedido_id'];

            $sql = "DELETE FROM Pedidos WHERE PedidoID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $pedido_id);

            if ($stmt->execute()) {
                echo "<p>Pedido excluído com sucesso!</p>";
            } else {
                echo "<p>Erro ao excluir o pedido: " . $conn->error . "</p>";
            }

            $stmt->close();
        }
    }

    // Obter clientes
    $clientes_result = $conn->query("SELECT * FROM Clientes");

    // Obter pizzas
    $pizzas_result = $conn->query("SELECT * FROM Pizzas");
    ?>

    <div class="container-formulario">
        <div class="section" id="criar">
            <h2>Criar Novo Pedido</h2>
            <div class="form-container">
                <form action="?action=add" method="post">
                    <div class="form-group">
                        <label for="cliente_id" class="form-label">Cliente:</label>
                        <select name="cliente_id" id="cliente_id" class="form-select" required>
                            <option value="">Selecione o cliente</option>
                            <?php while($cliente = $clientes_result->fetch_assoc()): ?>
                                <option value="<?php echo $cliente['ClienteID']; ?>"><?php echo $cliente['Nome']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="data_pedido" class="form-label">Data do Pedido:</label>
                        <input type="datetime-local" id="data_pedido" name="data_pedido" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status:</label>
                        <input type="text" id="status" name="status" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pizzas:</label>
                        <?php while($pizza = $pizzas_result->fetch_assoc()): ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="pizzas[]" value="<?php echo $pizza['PizzaID']; ?>">
                                    <?php echo $pizza['Nome']; ?> - R$ <?php echo number_format($pizza['Preco'], 2, ',', '.'); ?>
                                </label>
                                <label for="quantidade_<?php echo $pizza['PizzaID']; ?>">Quantidade:</label>
                                <input type="number" id="quantidade_<?php echo $pizza['PizzaID']; ?>" name="quantidades[]" value="1" min="1">
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <button type="submit" class="form-button">Criar Pedido</button>
                </form>
            </div>
        </div>
        <div class="section" id="atualizar">
            <h2>Atualizar Pedido</h2>
            <div class="form-container">
                <form action="?action=edit" method="post">
                    <div class="form-group">
                        <label for="pedido_id" class="form-label">ID do Pedido:</label>
                        <input type="text" id="pedido_id" name="pedido_id" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="cliente_id" class="form-label">Cliente:</label>
                        <select name="cliente_id" id="cliente_id" class="form-select" required>
                            <option value="">Selecione o cliente</option>
                            <?php
                            $clientes_result = $conn->query("SELECT * FROM Clientes");
                            while($cliente = $clientes_result->fetch_assoc()): ?>
                                <option value="<?php echo $cliente['ClienteID']; ?>"><?php echo $cliente['Nome']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="data_pedido" class="form-label">Data do Pedido:</label>
                        <input type="datetime-local" id="data_pedido" name="data_pedido" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status:</label>
                        <input type="text" id="status" name="status" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pizzas:</label>
                        <?php
                        $pizzas_result = $conn->query("SELECT * FROM Pizzas");
                        while($pizza = $pizzas_result->fetch_assoc()): ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="pizzas[]" value="<?php echo $pizza['PizzaID']; ?>">
                                <?php echo $pizza['Nome']; ?> - R$ <?php echo number_format($pizza['Preco'], 2, ',', '.'); ?>
                            </label>
                            <label for="quantidade_<?php echo $pizza['PizzaID']; ?>">Quantidade:</label>
                            <input type="number" id="quantidade_<?php echo $pizza['PizzaID']; ?>" name="quantidades[]" value="1" min="1">
                            </div>
                            <?php endwhile; ?>
                            </div>
                            <button type="submit" class="form-button">Atualizar Pedido</button>
                            </form>
                            </div>
                    </div>
</div>
<div class="container-formulario2">
<div class="box-excluir" id="excluir">
<h2>Excluir Pedido</h2>
<div class="container">
<?php
$sql = "SELECT * FROM Pedidos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
echo "<div class='pedido-item'>" .
"<span>Pedido #" . $row["PedidoID"] . " - Cliente ID: " . $row["ClienteID"] . "</span>" .
"<form action='?action=delete' method='post' style='display:inline;'>
    <input type='hidden' name='pedido_id' value='" . $row["PedidoID"] . "'>
    <button class='botao' type='submit'>Excluir</button>
</form>" .
"</div>";
}
} else {
echo "<div class='pedido-item'><span>Nenhum pedido encontrado</span></div>";
}
?>
</div>
</div>
<div class="box-listar" id="listar">
<h2>Listar Pedidos</h2>
<div class="container-lista">
<table>
<thead>
<tr>
<th>ID</th>
<th>Cliente ID</th>
<th>Data do Pedido</th>
<th>Status</th>
<th>Total</th>
</tr>
</thead>
<tbody>
<?php
$sql = "SELECT * FROM Pedidos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
echo "<tr>" .
        "<td>" . $row["PedidoID"]. "</td>" . 
        "<td>" . $row["ClienteID"] . "</td>" . 
        "<td>" . $row["DataPedido"] . "</td>" .
        "<td>" . $row["Status"] . "</td>" .
        "<td>" . number_format($row["Total"], 2, ',', '.') . "</td>" .
    "</tr>";
}
} else {
echo "<tr><td colspan='5'>Nenhum pedido encontrado</td></tr>";
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
