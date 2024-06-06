-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 06/06/2024 às 06:13
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `Pizzaria`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `Administradores`
--

CREATE TABLE `Administradores` (
  `adm_id` int(11) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Administradores`
--

INSERT INTO `Administradores` (`adm_id`, `usuario`, `senha`, `nome`) VALUES
(1, 'Giovane', '123456', 'MeuNome'),
(5, 'Samira', '30112004', 'Samira');

-- --------------------------------------------------------

--
-- Estrutura para tabela `Clientes`
--

CREATE TABLE `Clientes` (
  `ClienteID` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Telefone` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Endereco` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Clientes`
--

INSERT INTO `Clientes` (`ClienteID`, `Nome`, `Telefone`, `Email`, `Endereco`) VALUES
(9, 'Samira', '(14) 99128-3460', 'samira30112004@gmail.com', 'Rua Antonio de Freitas Pereira'),
(10, 'Giovane', '94821741', 'giovan3e@gmail.com', 'R Sobe e Desce'),
(11, 'Carlos Roberto', '(14) 99765-6732', 'carlos@icloud.com', 'Rua dois de novembro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `FuncionarioFuncoes`
--

CREATE TABLE `FuncionarioFuncoes` (
  `FuncionarioID` int(11) NOT NULL,
  `FuncaoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `FuncionarioFuncoes`
--

INSERT INTO `FuncionarioFuncoes` (`FuncionarioID`, `FuncaoID`) VALUES
(1, 1),
(12, 8),
(13, 6),
(14, 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Funcionarios`
--

CREATE TABLE `Funcionarios` (
  `FuncionarioID` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Telefone` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Endereco` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Funcionarios`
--

INSERT INTO `Funcionarios` (`FuncionarioID`, `Nome`, `Telefone`, `Email`, `Endereco`) VALUES
(1, 'Giovane', '94821741', 'giovan3e@gmail.com', 'R Sobe e Desce'),
(12, 'Kebinho', '(14) 99765-6732', 'klebinho@gmail.com', 'Rua dois de novembro'),
(13, 'Carlinhos', '(14) 99152-6835', 'Carlinhos@gmail.com', 'Rua da misericordia'),
(14, 'Irineu', '(14) 99746-7539', 'Irineu@gmail.com', 'Rua do Irineu');

-- --------------------------------------------------------

--
-- Estrutura para tabela `Funcoes`
--

CREATE TABLE `Funcoes` (
  `FuncaoID` int(11) NOT NULL,
  `Descricao` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Funcoes`
--

INSERT INTO `Funcoes` (`FuncaoID`, `Descricao`) VALUES
(1, 'Pizzaiolo'),
(6, 'Entregador'),
(7, 'Garçon'),
(8, 'Recepicionista');

-- --------------------------------------------------------

--
-- Estrutura para tabela `Pedidos`
--

CREATE TABLE `Pedidos` (
  `PedidoID` int(11) NOT NULL,
  `ClienteID` int(11) DEFAULT NULL,
  `DataPedido` datetime NOT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Pedidos`
--

INSERT INTO `Pedidos` (`PedidoID`, `ClienteID`, `DataPedido`, `Status`, `Total`) VALUES
(20, 9, '2024-06-05 19:52:00', 'Urgente', 110.00),
(21, 9, '2024-06-05 19:52:00', 'Urgente', 110.00),
(22, 9, '2024-06-05 19:52:00', 'Urgente', 110.00),
(23, 9, '2024-06-05 20:15:00', 'Pedido realizado', 55.00),
(24, 9, '2024-06-05 20:15:00', 'Pedido realizado', 55.00),
(25, 9, '2024-06-05 20:15:00', 'Pedido realizado', 55.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Pizzas`
--

CREATE TABLE `Pizzas` (
  `PizzaID` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Descricao` text DEFAULT NULL,
  `Preco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Pizzas`
--

INSERT INTO `Pizzas` (`PizzaID`, `Nome`, `Descricao`, `Preco`) VALUES
(2, 'Calabresa', 'Calabresa, Cebola e Azeitonas', 55.00),
(3, 'Mussarela', 'Mussarela, rodelas de tomate e orégano', 63.00),
(4, 'Escarola', 'Escarola refogada, mussarela e orégano', 68.00),
(5, 'Marguerita', 'Mussarela, rodelas de tomate e manjericão', 61.00),
(6, 'Atum', 'Mussarela, atum, cebola e orégano', 68.00),
(7, 'Romana', 'Mussarela, aliche, queijo parmesão e orégano', 70.00),
(8, 'Calabresa', 'Mussarela, linguiça calabresa e cebola', 62.00),
(9, 'Napolitana', 'Mussarela, rodelas de tomate, queijo parmesão e orégano', 65.00),
(10, 'Brócolis', 'Brócolis refogado coberto com mussarela e alho', 67.00),
(11, 'Siciliana', 'Mussarela, bacon e champignon ao molho rose', 64.00),
(12, 'Lombinho', 'Mussarela, lombo defumado e cebola', 70.00),
(13, 'Portuguesa', 'Mussarela, ovos, palmito, pimentão, ervilha, presunto e cebola', 60.00),
(14, 'Alho e óleo', 'Mussarela, alho e queijo parmesão', 65.00),
(15, 'Palmito', 'Mussarela, palmito e orégano', 67.00),
(16, 'Camarão', 'Camarão, molho de tomate, mussarela e catupiry', 69.00),
(17, 'Toscana', 'Linguiça calabresa, bacon e catupiry', 64.00),
(18, 'Mineira', 'Mussarela, catupiry e milho verde', 66.00),
(19, 'Pepperoni', 'Mussarela, pepperoni e cebola', 63.00),
(20, 'Bacon', 'Mussarela coberta com bacon e orégano', 66.00),
(21, 'Mista', 'Mussarela, presunto e orégano', 63.00),
(22, 'Califórnia', 'Mussarela, presunto, salada de frutas e orégano', 68.00),
(23, 'Vegetariana', 'Mussarela, pimentão, cebola, azeitona, ervilha, tomate, palmito, milho e orégano', 65.00),
(24, 'Frango', 'Molho de tomate, mussarela e frango', 66.00),
(25, 'Frango com Catupiry', 'Molho de tomate, mussarela, frango e catupiry', 67.00),
(26, 'Bolonhesa', 'Mussarela, molho a bolonhesa e orégano', 67.00),
(27, '4 Queijos', 'Mussarela, provolone, parmesão e gorgonzola', 68.00),
(28, 'Mucca', 'Mussarela, molho especial e catupiry', 69.00),
(29, 'Moda da Casa', 'Mussarela, presunto, bacon e catupiry', 68.00),
(30, 'Especial', 'Mussarela, presunto, calabresa, cebola, bacon e catupiry', 70.00);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `Administradores`
--
ALTER TABLE `Administradores`
  ADD PRIMARY KEY (`adm_id`);

--
-- Índices de tabela `Clientes`
--
ALTER TABLE `Clientes`
  ADD PRIMARY KEY (`ClienteID`);

--
-- Índices de tabela `FuncionarioFuncoes`
--
ALTER TABLE `FuncionarioFuncoes`
  ADD PRIMARY KEY (`FuncionarioID`,`FuncaoID`),
  ADD KEY `FuncaoID` (`FuncaoID`);

--
-- Índices de tabela `Funcionarios`
--
ALTER TABLE `Funcionarios`
  ADD PRIMARY KEY (`FuncionarioID`);

--
-- Índices de tabela `Funcoes`
--
ALTER TABLE `Funcoes`
  ADD PRIMARY KEY (`FuncaoID`);

--
-- Índices de tabela `Pedidos`
--
ALTER TABLE `Pedidos`
  ADD PRIMARY KEY (`PedidoID`),
  ADD KEY `ClienteID` (`ClienteID`);

--
-- Índices de tabela `Pizzas`
--
ALTER TABLE `Pizzas`
  ADD PRIMARY KEY (`PizzaID`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `Administradores`
--
ALTER TABLE `Administradores`
  MODIFY `adm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `Clientes`
--
ALTER TABLE `Clientes`
  MODIFY `ClienteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `Funcionarios`
--
ALTER TABLE `Funcionarios`
  MODIFY `FuncionarioID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `Funcoes`
--
ALTER TABLE `Funcoes`
  MODIFY `FuncaoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `Pedidos`
--
ALTER TABLE `Pedidos`
  MODIFY `PedidoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `Pizzas`
--
ALTER TABLE `Pizzas`
  MODIFY `PizzaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `FuncionarioFuncoes`
--
ALTER TABLE `FuncionarioFuncoes`
  ADD CONSTRAINT `fk_funcionariofuncoes_funcionarios` FOREIGN KEY (`FuncionarioID`) REFERENCES `Funcionarios` (`FuncionarioID`),
  ADD CONSTRAINT `fk_funcionariofuncoes_funcoes` FOREIGN KEY (`FuncaoID`) REFERENCES `Funcoes` (`FuncaoID`);

--
-- Restrições para tabelas `Pedidos`
--
ALTER TABLE `Pedidos`
  ADD CONSTRAINT `fk_pedidos_clientes` FOREIGN KEY (`ClienteID`) REFERENCES `Clientes` (`ClienteID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
