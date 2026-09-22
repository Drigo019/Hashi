-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/09/2026 às 19:16
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
(13, NULL, 'Rodrigo', '19 992343495', NULL),
(14, NULL, 'Rodrigo', '123456789', NULL),
(15, NULL, 'Rodrigo', '19 992343496', NULL),
(16, NULL, 'Rodrigo', '19 992343498', NULL),
(17, NULL, 'Rodrigo', '19 992343499', NULL),
(18, NULL, 'Rodrigo', '19 992343491', NULL),
(19, NULL, 'Rodrigo', '19 992343492', NULL),
(20, NULL, 'Rodrigo', '123456', NULL);

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
(20, 17, '1', 1, 'Cohab II', NULL),
(21, 17, '1', 11, 'Cohab II', NULL);

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
  `nome` varchar(255) DEFAULT NULL,
  `categoria` enum('prato quente','entrada','poke','temaki','hot roll','hossomaki','uramaki','especial','combinado','sobremesa','refrigerante','cerveja','agua','suco','promocao') DEFAULT NULL,
  `valor` float(10,2) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome`, `categoria`, `valor`, `descricao`) VALUES
(21, 'Bentô box teppan de salmão', 'prato quente', 55.00, ''),
(22, 'Bentô box de tilápia', 'prato quente', 35.00, ''),
(23, 'Bentô box de yakisoba ', 'prato quente', 35.00, ''),
(24, 'Bentô box de shimeji', 'prato quente', 35.00, ''),
(25, 'Bentô box de frango xadrez', 'prato quente', 35.00, ''),
(26, 'Bentô box de frango com laranja', 'prato quente', 35.00, ''),
(27, 'Lombo agridoce', 'prato quente', 33.00, ''),
(28, 'Frango com laranja', 'prato quente', 33.00, ''),
(29, 'Peixe frito', 'prato quente', 45.00, ''),
(30, 'Frango xadez', 'prato quente', 33.00, ''),
(31, 'Yakisoba vegetariano', 'prato quente', 22.00, ''),
(32, 'Yakisoba tradicional', 'prato quente', 25.00, ''),
(33, 'Yakisoba de camarão', 'prato quente', 37.00, ''),
(34, 'Ceviche de tilápia', 'entrada', 40.00, ''),
(35, 'Ceviche de salmão', 'entrada', 65.00, ''),
(36, 'Shimeji na manteiga', 'entrada', 35.00, ''),
(37, 'Guioza ', 'entrada', 18.00, ''),
(38, 'Harumaki tradicional', 'entrada', 14.00, ''),
(39, 'Harumaki 2 queijos', 'entrada', 14.00, ''),
(40, 'Harumaki vegetariano', 'entrada', 14.00, ''),
(41, 'Harumaki de camarão ', 'entrada', 16.00, ''),
(42, 'Sonomono', 'entrada', 8.00, ''),
(43, 'Oniguiri', 'entrada', 10.00, ''),
(44, 'Tartare', 'entrada', 30.00, ''),
(45, 'Poke só salmão ', 'poke', 38.00, ''),
(46, 'Poke salmão filadélfia ', 'poke', 38.00, ''),
(47, 'Poke shimeji', 'poke', 38.00, ''),
(48, 'Poke tilápia crisp', 'poke', 38.00, ''),
(49, 'Poke camarão crisp', 'poke', 38.00, ''),
(50, 'Poke frango crisp', 'poke', 38.00, ''),
(51, 'Acrécimo de proteína ', 'poke', 12.00, ''),
(52, 'Temaki filadélfia', 'temaki', 32.00, ''),
(53, 'Temaki só salmão ', 'temaki', 33.00, ''),
(54, 'Temaki salmão crisp', 'temaki', 33.00, ''),
(55, 'Temaki camarão crisp', 'temaki', 33.00, ''),
(56, 'Temaki de shimeji', 'temaki', 30.00, ''),
(57, 'Temaki hot ', 'temaki', 35.00, ''),
(58, 'Fritar temaki ', 'temaki', 5.00, ''),
(59, 'Temaki sem arroz', 'temaki', 10.00, ''),
(60, 'Mini hot ', 'hot roll', 18.00, ''),
(61, 'Hot roll', 'hot roll', 20.00, ''),
(62, 'Ebi hot ', 'hot roll', 22.00, ''),
(63, 'Super hot ', 'hot roll', 50.00, ''),
(64, 'Hossomaki de kani ', 'hossomaki', 14.00, ''),
(65, 'Hossomaki de salmão', 'hossomaki', 16.00, ''),
(66, 'Hossomaki de Pepino', 'hossomaki', 14.00, ''),
(67, 'Hossomaki de salmão grelhado', 'hossomaki', 18.00, ''),
(68, 'Uramaki de salmão filadélfia', 'uramaki', 16.00, ''),
(69, 'Uramaki de kani', 'uramaki', 18.00, ''),
(70, 'Uramaki de camarão crisp', 'uramaki', 18.00, ''),
(71, 'Uramaki de salmão grelhado', 'uramaki', 18.00, ''),
(72, 'Sashimi de salmão ', 'especial', 25.00, ''),
(73, 'Sashimi de tilápia', 'especial', 20.00, ''),
(74, 'Jyo de salmão', 'especial', 20.00, ''),
(75, 'Jyo massaricado', 'especial', 25.00, ''),
(76, 'Ebi jyo', 'especial', 25.00, ''),
(77, 'Dragon de salmão', 'especial', 23.00, ''),
(78, 'Dragon de shimeji', 'especial', 23.00, ''),
(79, 'Combinado 1', 'combinado', 55.00, ''),
(80, 'Combinado 2', 'combinado', 65.00, ''),
(81, 'Combinado 3', 'combinado', 80.00, ''),
(82, 'Combinado 4', 'combinado', 105.00, ''),
(83, 'Combiando 5', 'combinado', 130.00, ''),
(84, 'Combinado 6', 'combinado', 120.00, ''),
(85, 'Combiando 40 peças (especial)', 'combinado', 65.00, ''),
(86, 'Hiroshima', 'combinado', 100.00, ''),
(87, 'Express', 'combinado', 65.00, ''),
(88, 'Combiando de 15 peças', 'combinado', 40.00, ''),
(89, 'Rodízio Delivery', 'combinado', 110.00, ''),
(90, 'Rodízio Casal', 'combinado', 150.00, ''),
(91, 'Rodana do rodízio', 'combinado', 35.00, ''),
(92, 'Fritar o temaki ', 'combinado', 5.00, ''),
(93, 'Combinado todo salmão ', 'combinado', 10.00, ''),
(94, 'Combinado sem nada cru', 'combinado', 10.00, ''),
(95, 'Acrécimo de hot', 'combinado', 10.00, ''),
(96, 'Promo hot', 'promocao', 50.00, ''),
(97, 'Yakisoba vegetariano (com guioza)', 'promocao', 38.00, ''),
(98, 'Yakisoba tradicional (com guioza)', 'promocao', 38.00, ''),
(100, 'Frango com laranja (com guiza)', 'promocao', 38.00, ''),
(101, 'Frango xadez (com guioza)', 'promocao', 38.00, ''),
(102, 'Lombo agridoce (com guioza)', 'promocao', 38.00, ''),
(103, 'Harumaki de banana com chocolate', 'sobremesa', 14.00, ''),
(104, 'Hot roll de banana com chocolate', 'sobremesa', 14.00, ''),
(105, 'Coca lata normal', 'refrigerante', 6.00, ''),
(106, 'Coca lata zero', 'refrigerante', 6.00, ''),
(107, 'Coca 600ml normal', 'refrigerante', 8.00, ''),
(108, 'Coca 600ml zero', 'refrigerante', 8.00, ''),
(109, 'Coca 1,5L normal', 'refrigerante', 15.00, ''),
(110, 'Coca 1,5L zero', 'refrigerante', 15.00, ''),
(111, 'Guaraná lata normal', 'refrigerante', 6.00, ''),
(112, 'Guaraná lata zero', 'refrigerante', 6.00, ''),
(113, 'Guaraná 1L ', 'refrigerante', 7.00, ''),
(114, 'Fanta lata (laranja)', 'refrigerante', 6.00, ''),
(115, 'Fanta lata (uva)', 'refrigerante', 6.00, ''),
(116, 'Tonica lata normal', 'refrigerante', 6.00, ''),
(117, 'Tonica lata zero ', 'refrigerante', 6.00, ''),
(118, 'Sprite lata ', 'refrigerante', 6.00, ''),
(119, 'H2O limão 500ml ', 'refrigerante', 7.00, ''),
(120, 'H2O limoneto 500ml ', 'refrigerante', 7.00, ''),
(121, 'Brahma lata', 'cerveja', 6.00, ''),
(122, 'Skol lata', 'cerveja', 6.00, ''),
(123, 'Antartica lata', 'cerveja', 6.00, ''),
(124, 'Amistel lata', 'cerveja', 6.00, ''),
(125, 'Heniken', 'cerveja', 9.00, ''),
(126, 'Aguá sem gás', 'agua', 3.00, ''),
(127, 'Aguá com gás', 'agua', 4.00, ''),
(128, 'Suco delvale lata (uva)', 'suco', 7.00, ''),
(129, 'Suco delvale lata (pecego)', 'suco', 7.00, ''),
(130, 'Suco de 1,3L (laranja)', 'suco', 12.00, ''),
(131, 'Suco de 1,3L (uva)', 'suco', 12.00, '');

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
  `tipo_entrega` enum('entregar','retirada') NOT NULL,
  `status` enum('criado','aceito','preparando','pronto','saiu para entrega','entregue') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `id_cliente`, `id_endereco_cliente`, `id_produto`, `data`, `total`, `forma_pagamento`, `obs_pagamento`, `tipo_entrega`, `status`) VALUES
(58, 17, 20, NULL, '2026-08-24 04:29:54', 6.00, 'dinheiro', '', 'entregar', 'criado'),
(59, 17, 21, NULL, '2026-08-24 04:30:08', 6.00, 'dinheiro', '', 'entregar', 'entregue'),
(60, 17, 20, NULL, '2026-08-24 07:08:24', 61.00, 'pix', 'sem Tarê', 'entregar', 'criado'),
(62, 15, NULL, NULL, '2026-09-07 20:05:10', 240000.00, 'dinheiro', '', 'retirada', 'criado');

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
  ADD PRIMARY KEY (`id_produto`);

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
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `enderecos_cliente`
--
ALTER TABLE `enderecos_cliente`
  MODIFY `id_endereco_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

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
