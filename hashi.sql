-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/08/2026 às 20:42
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `hashi`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `id_endereco_cliente` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `telefone` char(15) DEFAULT NULL,
  `tipo_entrega` enum('entrega','retirda') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `id_endereco_cliente`, `nome`, `telefone`, `tipo_entrega`) VALUES
(12, NULL, '1', '1', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos_cliente`
--

CREATE TABLE `enderecos_cliente` (
  `id_endereco_cliente` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `obs_endereco` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `enderecos_cliente`
--

INSERT INTO `enderecos_cliente` (`id_endereco_cliente`, `id_cliente`, `rua`, `numero`, `bairro`, `obs_endereco`) VALUES
(8, 12, '1', 1, '', NULL),
(9, 12, '', 0, 'Alto do Vale II', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos_fornecedor`
--

CREATE TABLE `enderecos_fornecedor` (
  `id_endereco_fornecedor` int(11) NOT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id_fornecedor` int(11) NOT NULL,
  `id_endereco_fornecedor` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_venda`
--

CREATE TABLE `itens_venda` (
  `id_item` int(11) NOT NULL,
  `id_venda` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `valor` float(10,2) DEFAULT NULL,
  `obs` varchar(255) DEFAULT NULL,
  `forma_pagamento` enum('dinheiro','cartao','pix','fiado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_endereco_cliente` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `total` float(10,2) DEFAULT NULL,
  `forma_pagamento` enum('dinheiro','cartao','pix','fiado') NOT NULL,
  `obs_pagamento` varchar(255) DEFAULT NULL,
  `tipo_entrega` enum('entrega','retirada') NOT NULL,
  `status` enum('criado','aceito','preparando','pronto','saiu para entrega','entregue') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `id_cliente`, `id_endereco_cliente`, `id_produto`, `data`, `total`, `forma_pagamento`, `obs_pagamento`, `tipo_entrega`, `status`) VALUES
(23, 12, 8, NULL, '2026-08-10 03:59:52', 90.00, 'dinheiro', '1', '', 'aceito'),
(24, 12, NULL, NULL, '2026-08-10 04:00:07', 62.00, 'dinheiro', '', 'retirada', 'aceito'),
(25, 12, 9, NULL, '2026-08-11 15:19:04', 120.00, 'cartao', '', '', 'criado');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_endereco_cliente` (`id_endereco_cliente`);

--
-- Índices de tabela `enderecos_cliente`
--
ALTER TABLE `enderecos_cliente`
  ADD PRIMARY KEY (`id_endereco_cliente`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices de tabela `enderecos_fornecedor`
--
ALTER TABLE `enderecos_fornecedor`
  ADD PRIMARY KEY (`id_endereco_fornecedor`);

--
-- Índices de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id_fornecedor`),
  ADD KEY `id_endereco_fornecedor` (`id_endereco_fornecedor`);

--
-- Índices de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_venda` (`id_venda`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_fornecedor` (`id_fornecedor`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id_venda`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_produto` (`id_produto`),
  ADD KEY `id_endereco_cliente` (`id_endereco_cliente`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `enderecos_cliente`
--
ALTER TABLE `enderecos_cliente`
  MODIFY `id_endereco_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `enderecos_fornecedor`
--
ALTER TABLE `enderecos_fornecedor`
  MODIFY `id_endereco_fornecedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`id_endereco_cliente`) REFERENCES `enderecos_cliente` (`id_endereco_cliente`);

--
-- Restrições para tabelas `enderecos_cliente`
--
ALTER TABLE `enderecos_cliente`
  ADD CONSTRAINT `id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Restrições para tabelas `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD CONSTRAINT `fornecedores_ibfk_1` FOREIGN KEY (`id_endereco_fornecedor`) REFERENCES `enderecos_fornecedor` (`id_endereco_fornecedor`);

--
-- Restrições para tabelas `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD CONSTRAINT `itens_venda_ibfk_1` FOREIGN KEY (`id_venda`) REFERENCES `vendas` (`id_venda`),
  ADD CONSTRAINT `itens_venda_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`);

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`);

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `id_endereco_cliente` FOREIGN KEY (`id_endereco_cliente`) REFERENCES `enderecos_cliente` (`id_endereco_cliente`),
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `vendas_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
