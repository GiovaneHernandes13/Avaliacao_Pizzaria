<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Administrativa</title>
    <style>
        body {
            background-image: url('./img/teladeFundo2.webp');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: Arial, sans-serif;
        }

        h1 {
            display: flex;
            justify-content: center;
            background-color: black;
            color: #deb887;
            height: 70px;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
            align-items: center;
            margin: 0;
        }    

        .nav-bar {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: black;
            height: 560px;
            width: 250px;
            gap: 10px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            margin-top: 10px;
        }

        .caminhos {
            text-decoration: none;
            color: black;
            gap: 10px;
            background-color: #deb887;
            height: 50px;
            width: 200px;
            text-align: center;
            justify-content: center;
            display: flex;
            flex-direction: column;
            margin-top: 30px;
            border-radius: 5px;
            font-size: 22px;
        }

        .caminhos:hover {
            background-color:bisque;
            color: black;
        }
    </style>
</head>
<body>
    <h1>Bem-vindo à Área Administrativa</h1>
    <nav class="nav-bar">
        <a class="caminhos" href="./pizzas/indexPizzas.php">Gerenciamento de Pizzas</a>
        <a class="caminhos" href="./Funcionarios/funcionarios.php">Gerenciamento de Funcionarios</a>
        <a class="caminhos" href="./Cliente/cliente.php">Gerenciamento de Clientes</a>
        <a class="caminhos" href="./administradores/adm.php">Gerenciamento de Administradores</a>
        <a class="caminhos" href="./pedido/pedido.php">Gerenciamento de Pedido</a>
        <a class="caminhos" href="./Funcoes/funcoes.php">Gerenciamento de Funçoes</a>
    </nav>
</body>
</html>
