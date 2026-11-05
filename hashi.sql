-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/11/2026 às 20:39
-- Versão do servidor: 10.11.16-MariaDB
-- Versão do PHP: 8.5.12

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
(20, NULL, 'Rodrigo', '123456', NULL),
(21, NULL, '1', '1', NULL),
(22, NULL, 'teste', 'teste', NULL),
(23, NULL, '', '', NULL),
(24, NULL, 'Ana Luiza Souza Silva', '19995543913', NULL),
(25, NULL, 'gabi', ']', NULL),
(26, NULL, '~~', '´~', NULL),
(27, NULL, 'juninho', '3', NULL),
(28, NULL, 'balcao', 'balcao', NULL),
(29, NULL, 'balcao', 'ba', NULL),
(30, NULL, 'ana', '19992638023', NULL),
(31, NULL, '.', '.', NULL),
(32, NULL, 'elen', '19992694552', NULL),
(33, NULL, '-', '1999291164', NULL),
(34, NULL, 'leda', '19991252124', NULL),
(35, NULL, 'soraia', '19992720474', NULL),
(36, NULL, 'ana', '19991066156', NULL),
(37, NULL, 'neta', '19995103239', NULL),
(38, NULL, 'lucimar', '19996876555', NULL),
(39, NULL, 'rita', '19991679225', NULL),
(40, NULL, 'Sueli Paulo Setubal', '19993693580', NULL),
(41, NULL, 'Higor Augusto', '19991388035', NULL),
(42, NULL, 'Andrea', '19994313515', NULL),
(43, NULL, 'Clara Prado', '19991587136', NULL),
(44, NULL, 'Jessica', '19991100403', NULL),
(45, NULL, 'Melena Albano', '19992694968', NULL),
(46, NULL, '.', '19992911464', NULL),
(47, NULL, 'Thiego 19', '19993357218', NULL),
(48, NULL, 'Adriano Leite', '16997006470', NULL),
(49, NULL, 'Catita', '19982923240', NULL),
(50, NULL, 'Lia Clinte Correia', '16988290630', NULL),
(51, NULL, 'Robson', '19991877454', NULL),
(52, NULL, 'Douglas', '19992819891', NULL),
(53, NULL, 'Raquel', '19997243046', NULL),
(54, NULL, 'Hello', '19984205603', NULL),
(55, NULL, 'Fabiana Veronez', '19992991700', NULL),
(56, NULL, 'Eduardo', '19991808312', NULL),
(57, NULL, 'Aline Bianche', '19997071152', NULL),
(58, NULL, 'Lorena/ Paty Perissinoto', '19994007835', NULL),
(59, NULL, 'Natalia Suano', '19993054155', NULL),
(60, NULL, 'Ifood - Kafia Abrao', '5948', NULL),
(61, NULL, 'Mesa 1', 'Mesa 1', NULL),
(62, NULL, 'Marina', '19993664139', NULL),
(63, NULL, 'Ifood - Franciely Fernanda', '8356', NULL),
(64, NULL, 'Mesa 2', 'Mesa 2', NULL),
(65, NULL, 'Ifood - Roberta da Cruz Francisco', '3917', NULL),
(66, NULL, 'Eduardo Ana Amelia', '19992603999', NULL),
(67, NULL, 'Maycon Felipe', '19984369343', NULL),
(68, NULL, 'Ifood - Giovana Brunchport', '6009', NULL),
(69, NULL, 'Patricia', '19993464227', NULL),
(70, NULL, 'Silvia', '19989481691', NULL),
(71, NULL, 'Luzia Silva', '19999284571', NULL),
(72, NULL, 'Maria Pelvine', '19995305453', NULL),
(73, NULL, 'Paula Cras Lopes', '19993787242', NULL),
(74, NULL, 'Leandro', '19989684968', NULL),
(75, NULL, 'Didô', '19981149694', NULL),
(76, NULL, 'Ifood - Giovanna Santos', '3606', NULL),
(77, NULL, 'Thais', '19994937679', NULL),
(78, NULL, 'Ifood - Leticia Lippi', '7547', NULL),
(79, NULL, 'nany', '19991453135', NULL),
(80, NULL, 'cuca', '19999808585', NULL),
(81, NULL, 'gabriel', '19994848561', NULL),
(82, NULL, '19986110353', 'mariao', NULL),
(83, NULL, 'sergio', '19971095062', NULL),
(84, NULL, 'andressa', '19986092382', NULL),
(85, NULL, 'fran', '19994996903', NULL),
(86, NULL, 'silvana', '11973784858', NULL),
(87, NULL, 'isa', '19989264357', NULL),
(88, NULL, 'sofia', '19992134824', NULL),
(89, NULL, '19994689917', 'gabi', NULL),
(90, NULL, 'maria', '19994352345', NULL),
(91, NULL, 'juninho', '19992014763', NULL),
(92, NULL, 'vitoria', '19997217338', NULL),
(93, NULL, 'vanessa', '11989064597', NULL),
(94, NULL, 'mb', '19994212673', NULL),
(95, NULL, 'bruno', '19994254739', NULL),
(96, NULL, 'fabi', '19991152070', NULL),
(97, NULL, 'jenyfer', '19994305948', NULL),
(98, NULL, 'maria', '19995889266', NULL),
(99, NULL, 'anderson', '19994067088', NULL),
(100, NULL, 'mary', '19992528357', NULL),
(101, NULL, 'lilian', '19984541720', NULL),
(102, NULL, 'giovana', '19989983280', NULL),
(103, NULL, 'kelen', '19989887204', NULL),
(104, NULL, 'leticia', '19991861381', NULL),
(105, NULL, 'marcia', '19991677378', NULL),
(106, NULL, 'Sonia Haitman', '19992434288', NULL);

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
(21, 17, '1', 11, 'Cohab II', NULL),
(22, 22, '', 0, '', NULL),
(23, 22, 'teste', 1, 'Alto do Vale II', NULL),
(24, 24, 'Rua Dom Tomaz Vaqueiro', 948, 'Centro', NULL),
(25, 25, 'av transamozonica', 1235, 'Gatolândia', NULL),
(26, 26, 'agilberto figueiredo dos santos', 215, 'São Domingos', NULL),
(27, 27, 'antonio souza', 81, 'Aparecida', NULL),
(28, 30, 'helio franzone', 101, 'São Domingos', NULL),
(29, 32, 'belchior de souza', 307, 'Nenê Pereira Lima', NULL),
(30, 33, 'pedro boaratti', 175, 'Cohab II', NULL),
(31, 34, 'orlando espanha', 203, 'Maziero', NULL),
(32, 35, 'angelim carrara', 170, 'José Justi', NULL),
(33, 36, 'belo horizonte', 86, 'Vila Quintino', NULL),
(34, 37, 'domiciano custodio dias', 356, 'Vila Carvalho', NULL),
(35, 38, 'gabriel pinheiro', 713, 'Centro', NULL),
(36, 39, 'jd lavinia', 258, 'Vila Quintino', NULL),
(37, 40, 'Rua Agilberto Figueredo dos Santos', 215, 'São Domingos', NULL),
(38, 41, 'Rua Catharina Pisani Bedin', 101, 'Gildo Geraldo', NULL),
(39, 42, 'Rua Ary monteiro Dias', 211, 'Samanbaia', NULL),
(40, 43, 'Rua Primo Favero', 57, 'São Luiz', NULL),
(41, 44, 'Rua Sebastião Alves dos Santos', 57, 'Vila Carvalho', NULL),
(42, 46, 'Rua Pedro Boratt', 175, 'Cohab II', NULL),
(43, 48, 'Rua Galileu de Luna', 335, 'Alvorada', NULL),
(44, 50, 'Rua Saldanha Marinho', 686, 'Centro', NULL),
(45, 51, 'Rua Professor José Germano Silva', 172, 'Mocoquinha', NULL),
(46, 52, 'Rua Aristoteles A F Costa', 64, 'Anita Venturi Pricoli', NULL),
(47, 53, 'Av. José Alves Pinto', 333, 'São Luiz', NULL),
(48, 54, 'Rua Dr. Alcindo de Figueredo', 339, 'São Domingos', NULL),
(49, 55, 'Rua Venezuela', 87, 'Lavínia', NULL),
(50, 56, 'Rua Major Albertin Nogueira', 288, 'São Domingos', NULL),
(51, 57, 'Rua Cajuru', 142, 'Santa Maria', NULL),
(52, 59, 'Rua Paulo Abelardi', 896, 'Botânico', NULL),
(53, 60, 'Rua Antonio Rabelo Cisterma', 73, 'São Domingos', NULL),
(54, 62, 'Rua Pará', 435, 'Vila Santa Rosa', NULL),
(55, 63, 'Av. São Paulo', 205, 'Vila Lambari', NULL),
(56, 65, 'Rua Crispim Bastos Sobrinho', 407, 'Gilberto Rossetti', NULL),
(57, 66, 'Rua Curitiba', 75, 'Vila Quintino', NULL),
(58, 67, 'Rua Hélio Franzzoni', 342, 'São Domingos', NULL),
(59, 68, 'Rua Paschoal Raniere Mazili', 749, 'Centro', NULL),
(60, 69, 'Rua Domingos Giglio', 78, 'Brás', NULL),
(61, 70, 'Rua Maranhão', 119, 'Vila Santa Rosa', NULL),
(62, 71, 'Rua Miguel Nalfel', 120, 'Vila Naufel', NULL),
(63, 73, 'Rua Ângelo Abeline', 206, 'Vale Verde', NULL),
(64, 74, 'Rua Pedro Costal Pecin', 492, 'Nelson Niero', NULL),
(65, 75, 'Rua Pedro Picoli', 301, 'Chico Piscina', NULL),
(66, 76, 'Rua Fortunato Negri', 399, 'Alvorada', NULL),
(67, 77, 'Rua Otávio Erasmo Santiago', 212, 'Nenê Pereira Lima', NULL),
(68, 78, 'Rua Maria Zelia Palma Maziero', 130, 'Chico Piscina', NULL),
(69, 79, 'joao batista de carvalho', 50, 'Alvorada', NULL),
(70, 80, 'guatemala', 428, 'Chico Piscina', NULL),
(71, 81, 'luis antonio fernandes dia', 281, 'São Luiz', NULL),
(72, 82, 'paschoal ranieri mazili', 782, 'Santa Cecília', NULL),
(73, 83, 'professor jose barreto coelho', 298, 'Vila Quintino', NULL),
(74, 84, 'carlos alberto orestes', 157, 'Miguel Gomes', NULL),
(75, 85, 'heroino machado', 65, 'Vila Carvalho', NULL),
(76, 86, 'wenceslau bras', 216, 'Mocoquinha', NULL),
(77, 87, 'capitao francisco muniz barreto', 20, 'Chico Piscina', NULL),
(78, 88, 'eder ferreira da costa', 80, 'Lago dos Ipês', NULL),
(79, 89, 'avenida transamazonica', 1235, 'Gatolândia', NULL),
(80, 90, 'geraldo carlos santiago', 275, 'São Domingos', NULL),
(81, 91, 'antonio souza lima', 81, 'Aparecida', NULL),
(82, 92, 'domingos giglio', 59, 'Brás', NULL),
(83, 93, 'menotti pratali', 25, 'Nelson Niero', NULL),
(84, 94, 'claudio de souza xavier', 52, 'Botânico', NULL),
(85, 95, 'venilia quilice lopes', 204, 'Carlito Quilici', NULL),
(86, 94, 'claudio de souza xavier', 52, 'José André de Lima', NULL),
(87, 58, 'nicola menechino', 51, 'São José', NULL),
(88, 96, 'belmiro vincinaca', 133, 'Anita Venturi Pricoli', NULL),
(89, 97, 'abrahao venturi', 420, 'Cohab II', NULL),
(90, 98, 'paulo abelardi', 593, 'Botânico', NULL),
(91, 99, 'lauro grespan', 86, 'Anita Venturi Pricoli', NULL),
(92, 100, 'sebastiana queranza daniel', 168, 'Mocoquinha', NULL),
(93, 101, 'manoel martins pierre', 85, 'Chico Piscina', NULL),
(94, 102, 'padre manoel joaquim das dores', 344, 'Vila Santa Cruz', NULL),
(95, 104, 'jose alves furquim', 116, 'Alto do Vale II', NULL),
(96, 105, 'antonio cristovan', 356, 'Vila Mariana', NULL),
(97, 106, 'Rua Cuiabá', 89, 'Vila Quintino', NULL);

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
  `valor_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `obs_produto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_venda`
--

INSERT INTO `itens_venda` (`id_item`, `id_venda`, `id_produto`, `valor_unitario`, `subtotal`, `quantidade`, `obs_produto`) VALUES
(40, 115, 81, 80.00, 80.00, 1, ''),
(41, 116, 46, 38.00, 38.00, 1, ''),
(42, 117, 85, 65.00, 130.00, 2, ''),
(43, 117, 29, 45.00, 45.00, 1, ''),
(44, 118, 79, 55.00, 55.00, 1, ''),
(45, 118, 38, 14.00, 14.00, 1, ''),
(46, 119, 22, 35.00, 105.00, 3, ''),
(47, 120, 85, 65.00, 65.00, 1, ''),
(48, 120, 36, 35.00, 35.00, 1, ''),
(49, 121, 79, 55.00, 55.00, 1, ''),
(50, 121, 95, 10.00, 10.00, 1, ''),
(51, 122, 43, 10.00, 20.00, 2, ''),
(52, 123, 85, 65.00, 65.00, 1, ''),
(53, 124, 79, 55.00, 110.00, 2, ''),
(54, 125, 85, 65.00, 65.00, 1, ''),
(55, 125, 95, 10.00, 10.00, 1, ''),
(56, 126, 89, 110.00, 110.00, 1, ''),
(57, 127, 81, 80.00, 80.00, 1, ''),
(58, 127, 43, 10.00, 10.00, 1, ''),
(59, 127, 95, 10.00, 10.00, 1, ''),
(60, 127, 118, 6.00, 6.00, 1, ''),
(61, 128, 89, 110.00, 110.00, 1, ''),
(62, 129, 46, 38.00, 152.00, 4, ''),
(63, 130, 52, 32.00, 64.00, 2, ''),
(64, 130, 61, 20.00, 20.00, 1, ''),
(65, 131, 85, 65.00, 65.00, 1, ''),
(66, 132, 83, 130.00, 130.00, 1, ''),
(67, 132, 110, 15.00, 15.00, 1, ''),
(68, 133, 142, 10.00, 30.00, 3, ''),
(69, 133, 141, 10.00, 30.00, 3, ''),
(70, 134, 79, 55.00, 55.00, 1, ''),
(71, 135, 85, 65.00, 65.00, 1, ''),
(72, 136, 45, 38.00, 38.00, 1, ''),
(73, 136, 106, 6.00, 6.00, 1, ''),
(74, 137, 82, 105.00, 105.00, 1, ''),
(75, 137, 109, 15.00, 15.00, 1, ''),
(76, 138, 88, 40.00, 40.00, 1, ''),
(77, 139, 49, 38.00, 38.00, 1, ''),
(78, 140, 52, 32.00, 32.00, 1, ''),
(79, 141, 46, 38.00, 38.00, 1, ''),
(80, 141, 142, 10.00, 20.00, 2, ''),
(81, 142, 22, 35.00, 35.00, 1, ''),
(82, 143, 32, 25.00, 50.00, 2, ''),
(83, 143, 77, 23.00, 23.00, 1, ''),
(84, 144, 81, 80.00, 80.00, 1, ''),
(85, 144, 107, 8.00, 8.00, 1, ''),
(86, 145, 89, 110.00, 110.00, 1, ''),
(88, 147, 143, 30.00, 30.00, 1, ''),
(89, 148, 81, 80.00, 80.00, 1, ''),
(90, 148, 95, 10.00, 10.00, 1, ''),
(91, 148, 107, 8.00, 8.00, 1, ''),
(92, 149, 123, 6.00, 24.00, 4, ''),
(93, 150, 85, 65.00, 65.00, 1, ''),
(96, 153, 80, 65.00, 65.00, 1, ''),
(100, 155, 82, 105.00, 105.00, 1, ''),
(101, 155, 95, 10.00, 10.00, 1, ''),
(102, 155, 61, 20.00, 20.00, 1, ''),
(103, 156, 123, 6.00, 12.00, 2, ''),
(104, 156, 126, 3.00, 3.00, 1, ''),
(107, 159, 85, 65.00, 65.00, 1, ''),
(108, 160, 124, 6.00, 12.00, 2, ''),
(109, 161, 122, 6.00, 24.00, 4, ''),
(110, 162, 57, 35.00, 35.00, 1, ''),
(111, 163, 79, 55.00, 55.00, 1, ''),
(112, 164, 79, 55.00, 55.00, 1, ''),
(113, 165, 122, 6.00, 6.00, 1, ''),
(114, 166, 28, 33.00, 33.00, 1, ''),
(115, 167, 79, 55.00, 55.00, 1, ''),
(116, 168, 85, 65.00, 65.00, 1, ''),
(117, 169, 121, 6.00, 12.00, 2, ''),
(118, 170, 85, 65.00, 65.00, 1, ''),
(121, 172, 61, 20.00, 40.00, 2, ''),
(122, 172, 105, 6.00, 12.00, 2, ''),
(124, 174, 34, 40.00, 40.00, 1, ''),
(125, 174, 79, 55.00, 55.00, 1, ''),
(126, 175, 89, 110.00, 110.00, 1, ''),
(127, 176, 80, 65.00, 65.00, 1, ''),
(128, 177, 46, 38.00, 76.00, 2, ''),
(129, 178, 43, 10.00, 10.00, 1, ''),
(130, 178, 63, 50.00, 50.00, 1, ''),
(131, 179, 95, 10.00, 10.00, 1, ''),
(132, 179, 80, 65.00, 65.00, 1, ''),
(133, 180, 85, 65.00, 65.00, 1, ''),
(134, 181, 85, 65.00, 65.00, 1, ''),
(135, 182, 23, 35.00, 35.00, 1, ''),
(136, 183, 52, 32.00, 32.00, 1, ''),
(137, 184, 63, 50.00, 50.00, 1, ''),
(138, 185, 114, 6.00, 6.00, 1, ''),
(139, 185, 120, 7.00, 7.00, 1, ''),
(140, 186, 80, 65.00, 65.00, 1, ''),
(141, 187, 46, 38.00, 38.00, 1, ''),
(142, 188, 123, 6.00, 6.00, 1, ''),
(143, 189, 123, 6.00, 6.00, 1, ''),
(144, 190, 90, 150.00, 150.00, 1, ''),
(145, 190, 92, 5.00, 5.00, 1, ''),
(146, 190, 110, 15.00, 15.00, 1, ''),
(147, 191, 37, 18.00, 18.00, 1, ''),
(148, 191, 142, 10.00, 100.00, 10, ''),
(149, 191, 61, 20.00, 20.00, 1, ''),
(150, 192, 32, 25.00, 25.00, 1, ''),
(151, 193, 89, 110.00, 110.00, 1, ''),
(153, 195, 89, 110.00, 110.00, 1, ''),
(154, 196, 83, 130.00, 130.00, 1, ''),
(155, 197, 80, 65.00, 65.00, 1, ''),
(156, 198, 58, 5.00, 5.00, 1, ''),
(157, 198, 89, 110.00, 110.00, 1, ''),
(158, 199, 83, 130.00, 130.00, 1, ''),
(159, 199, 57, 35.00, 35.00, 1, ''),
(160, 200, 85, 65.00, 65.00, 1, ''),
(161, 201, 80, 65.00, 65.00, 1, ''),
(162, 202, 61, 20.00, 20.00, 1, ''),
(163, 203, 142, 10.00, 20.00, 2, ''),
(164, 204, 85, 65.00, 65.00, 1, ''),
(165, 205, 43, 10.00, 20.00, 2, ''),
(166, 206, 85, 65.00, 65.00, 1, ''),
(168, 208, 85, 65.00, 65.00, 1, ''),
(169, 209, 32, 25.00, 25.00, 1, ''),
(170, 209, 111, 6.00, 6.00, 1, ''),
(171, 211, 91, 35.00, 35.00, 1, 'Rodana com apenas ceviche de salmão'),
(172, 211, 43, 10.00, 10.00, 1, 'Meia porção de hot roll');

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
(131, 'Suco de 1,3L (uva)', 'suco', 12.00, ''),
(141, 'Oniguiri (Shimeji)', 'entrada', 10.00, ''),
(142, 'Oniguiri (salmão)', 'entrada', 10.00, ''),
(143, 'Promoção de Oniguiri', 'promocao', 30.00, '');

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
  `forma_pagamento` enum('dinheiro','cartao','pix','fiado','ifood') NOT NULL,
  `obs_pagamento` varchar(255) DEFAULT NULL,
  `tipo_entrega` enum('entregar','retirada') NOT NULL,
  `status` enum('criado','aceito','preparando','pronto','saiu_para_entrega','entregue') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `id_cliente`, `id_endereco_cliente`, `id_produto`, `data`, `total`, `forma_pagamento`, `obs_pagamento`, `tipo_entrega`, `status`) VALUES
(115, 40, 37, NULL, '2026-10-29 17:51:25', 86.00, 'pix', '', 'entregar', 'entregue'),
(116, 41, 38, NULL, '2026-10-29 17:54:00', 44.00, 'pix', 'Poke: arroz jap., couve, tomate, cebola, sonomnono, abacate, kani, alga, tare', 'entregar', 'entregue'),
(117, 42, 39, NULL, '2026-10-29 18:05:16', 181.00, 'pix', '', 'entregar', 'entregue'),
(118, 43, 40, NULL, '2026-10-29 18:55:18', 75.00, 'pix', '', 'entregar', 'entregue'),
(119, 44, 41, NULL, '2026-10-29 19:33:44', 111.00, 'fiado', '', 'entregar', 'entregue'),
(120, 45, NULL, NULL, '2026-10-29 19:42:22', 100.00, 'dinheiro', '', 'retirada', 'entregue'),
(121, 46, 42, NULL, '2026-10-29 20:51:17', 71.00, 'dinheiro', '', 'entregar', 'entregue'),
(122, 47, NULL, NULL, '2026-10-30 17:21:09', 20.00, 'dinheiro', 'O cliente vai vir retirar as 22:40', 'retirada', 'entregue'),
(123, 48, 43, NULL, '2026-10-30 17:27:53', 71.00, 'dinheiro', 'Combinado sem os hots', 'entregar', 'entregue'),
(124, 49, NULL, NULL, '2026-10-30 18:28:26', 110.00, 'dinheiro', '', 'retirada', 'entregue'),
(125, 50, 44, NULL, '2026-10-30 18:34:41', 81.00, 'dinheiro', '', 'entregar', 'entregue'),
(126, 51, 45, NULL, '2026-10-30 18:39:06', 116.00, 'cartao', '', 'entregar', 'entregue'),
(127, 28, NULL, NULL, '2026-10-30 18:40:35', 106.00, 'dinheiro', '', 'retirada', 'entregue'),
(128, 52, 46, NULL, '2026-10-30 18:55:02', 116.00, 'pix', 'Sem tomate', 'entregar', 'entregue'),
(129, 53, 47, NULL, '2026-10-30 19:21:11', 158.00, 'cartao', 'Poke(1): Arroz jap., manga, sonomono, shoyo, tarê     Poke(3): Arroz jap., couve, batata, sonomono, manga, tomate, shoyo, tarê', 'entregar', 'entregue'),
(130, 54, 48, NULL, '2026-10-30 19:35:52', 90.00, 'pix', '', 'entregar', 'entregue'),
(131, 55, 49, NULL, '2026-10-30 19:37:03', 71.00, 'pix', '', 'entregar', 'entregue'),
(132, 56, 50, NULL, '2026-10-30 19:40:33', 151.00, 'dinheiro', '', 'entregar', 'entregue'),
(133, 57, 51, NULL, '2026-10-30 19:56:59', 66.00, 'cartao', '', 'entregar', 'entregue'),
(134, 58, NULL, NULL, '2026-10-30 20:02:57', 55.00, 'dinheiro', '', 'retirada', 'entregue'),
(135, 59, 52, NULL, '2026-10-30 20:10:14', 71.00, 'dinheiro', '', 'entregar', 'entregue'),
(136, 60, 53, NULL, '2026-10-30 20:12:02', 50.00, 'ifood', 'Poke: Bifum, cream cheese, couve, sonomono, kani, cenoura, shoyo', 'entregar', 'entregue'),
(137, 61, NULL, NULL, '2026-10-30 20:28:45', 120.00, 'dinheiro', '', 'retirada', 'entregue'),
(138, 62, 54, NULL, '2026-10-30 20:47:59', 46.00, 'pix', 'Sem nada Doce', 'entregar', 'entregue'),
(139, 63, 55, NULL, '2026-10-30 20:57:05', 44.00, 'ifood', 'Poke: Arroz jap., cream cheese, couve, batata, tomate, sonomono, cebola, manga, kani , alga, shhoyo, ponzo,tare', 'entregar', 'entregue'),
(140, 64, NULL, NULL, '2026-10-30 21:00:08', 32.00, 'cartao', '', 'retirada', 'entregue'),
(141, 28, NULL, NULL, '2026-10-30 21:02:19', 58.00, 'pix', 'Poke: Arroz Jap., Completo sem alface', 'retirada', 'entregue'),
(142, 65, 56, NULL, '2026-10-30 21:04:55', 41.00, 'ifood', '', 'entregar', 'entregue'),
(143, 66, 57, NULL, '2026-10-30 21:20:08', 79.00, 'cartao', '', 'entregar', 'entregue'),
(144, 67, 58, NULL, '2026-10-30 21:30:52', 94.00, 'pix', '', 'entregar', 'entregue'),
(145, 28, NULL, NULL, '2026-10-30 22:04:40', 110.00, 'dinheiro', '', 'retirada', 'entregue'),
(147, 68, 59, NULL, '2026-10-31 17:41:58', 36.00, 'ifood', '', 'entregar', 'entregue'),
(148, 69, 60, NULL, '2026-10-31 17:44:54', 104.00, 'cartao', '', 'entregar', 'entregue'),
(149, 28, NULL, NULL, '2026-10-31 17:45:44', 24.00, 'dinheiro', '', 'retirada', 'entregue'),
(150, 70, 61, NULL, '2026-10-31 17:58:13', 71.00, 'cartao', '', 'entregar', 'entregue'),
(153, 71, 62, NULL, '2026-10-31 18:37:42', 71.00, 'cartao', '', 'entregar', 'entregue'),
(155, 72, NULL, NULL, '2026-10-31 18:41:51', 135.00, 'dinheiro', '', 'retirada', 'entregue'),
(156, 28, NULL, NULL, '2026-10-31 18:47:49', 15.00, 'dinheiro', '', 'retirada', 'entregue'),
(159, 73, 63, NULL, '2026-10-31 18:56:24', 71.00, 'pix', '', 'entregar', 'entregue'),
(160, 28, NULL, NULL, '2026-10-31 18:59:48', 12.00, 'cartao', '', 'retirada', 'entregue'),
(161, 28, NULL, NULL, '2026-10-31 19:07:08', 24.00, 'dinheiro', '', 'retirada', 'entregue'),
(162, 74, 64, NULL, '2026-10-31 19:08:33', 41.00, 'pix', '', 'entregar', 'entregue'),
(163, 75, 65, NULL, '2026-10-31 19:23:34', 61.00, 'cartao', '', 'entregar', 'entregue'),
(164, 76, 66, NULL, '2026-10-31 19:46:11', 61.00, 'ifood', '', 'entregar', 'entregue'),
(165, 28, NULL, NULL, '2026-10-31 20:21:59', 6.00, 'cartao', '', 'retirada', 'entregue'),
(166, 28, NULL, NULL, '2026-10-31 20:30:28', 33.00, 'dinheiro', '', 'retirada', 'entregue'),
(167, 77, 67, NULL, '2026-10-31 21:28:01', 61.00, 'cartao', '', 'entregar', 'entregue'),
(168, 78, 68, NULL, '2026-10-31 21:30:46', 71.00, 'cartao', '', 'entregar', 'entregue'),
(169, 28, NULL, NULL, '2026-10-31 21:58:13', 12.00, 'cartao', '', 'retirada', 'entregue'),
(170, 28, NULL, NULL, '2026-10-31 22:01:20', 65.00, 'dinheiro', '', 'retirada', 'entregue'),
(172, 61, NULL, NULL, '2026-10-31 22:31:11', 52.00, 'dinheiro', '', 'retirada', 'entregue'),
(174, 79, 69, NULL, '2026-11-01 18:44:41', 101.00, 'pix', '', 'entregar', 'entregue'),
(175, 80, 70, NULL, '2026-11-01 19:01:55', 116.00, 'cartao', '', 'entregar', 'entregue'),
(176, 81, 71, NULL, '2026-11-01 19:13:16', 71.00, 'cartao', '', 'entregar', 'entregue'),
(177, 28, NULL, NULL, '2026-11-01 19:22:37', 76.00, 'cartao', '', 'retirada', 'entregue'),
(178, 82, 72, NULL, '2026-11-01 19:46:24', 66.00, 'fiado', '', 'entregar', 'entregue'),
(179, 83, 73, NULL, '2026-11-01 19:51:34', 81.00, 'cartao', '', 'entregar', 'entregue'),
(180, 84, 74, NULL, '2026-11-01 19:58:28', 71.00, 'cartao', '', 'entregar', 'entregue'),
(181, 85, 75, NULL, '2026-11-01 20:07:00', 71.00, 'pix', '', 'entregar', 'entregue'),
(182, 86, 76, NULL, '2026-11-01 20:42:53', 41.00, 'pix', '', 'entregar', 'entregue'),
(183, 87, 77, NULL, '2026-11-01 21:12:20', 38.00, 'pix', '', 'entregar', 'entregue'),
(184, 28, NULL, NULL, '2026-11-01 21:13:31', 50.00, 'cartao', '', 'retirada', 'entregue'),
(185, 28, NULL, NULL, '2026-11-01 21:21:48', 13.00, 'dinheiro', '', 'retirada', 'entregue'),
(186, 88, 78, NULL, '2026-11-01 21:36:29', 71.00, 'cartao', '', 'entregar', 'entregue'),
(187, 89, 79, NULL, '2026-11-01 21:54:03', 44.00, 'dinheiro', '', 'entregar', 'entregue'),
(188, 28, NULL, NULL, '2026-11-01 22:08:38', 6.00, 'dinheiro', '', 'retirada', 'entregue'),
(189, 28, NULL, NULL, '2026-11-01 22:09:50', 6.00, 'dinheiro', '', 'retirada', 'entregue'),
(190, 90, 80, NULL, '2026-11-02 17:05:02', 176.00, 'pix', 'trocar shimeji e guioza por huramaki de queijo', 'entregar', 'entregue'),
(191, 91, 81, NULL, '2026-11-02 18:26:51', 144.00, 'cartao', '', 'entregar', 'entregue'),
(192, 92, 82, NULL, '2026-11-02 18:32:41', 31.00, 'pix', '', 'entregar', 'entregue'),
(193, 93, 83, NULL, '2026-11-02 18:56:40', 116.00, 'pix', '', 'entregar', 'entregue'),
(195, 95, 85, NULL, '2026-11-02 19:03:44', 116.00, 'cartao', '', 'entregar', 'entregue'),
(196, 94, 86, NULL, '2026-11-02 19:15:07', 136.00, 'cartao', '', 'entregar', 'entregue'),
(197, 58, 87, NULL, '2026-11-02 19:18:46', 71.00, 'pix', '', 'entregar', 'entregue'),
(198, 96, 88, NULL, '2026-11-02 19:22:12', 121.00, 'cartao', '', 'entregar', 'entregue'),
(199, 97, 89, NULL, '2026-11-02 19:25:29', 171.00, 'dinheiro', 'troco p 200', 'entregar', 'entregue'),
(200, 98, 90, NULL, '2026-11-02 19:29:14', 71.00, 'pix', '', 'entregar', 'entregue'),
(201, 99, 91, NULL, '2026-11-02 19:50:13', 71.00, 'cartao', '', 'entregar', 'entregue'),
(202, 100, 92, NULL, '2026-11-02 20:14:33', 26.00, 'pix', '', 'entregar', 'entregue'),
(203, 28, NULL, NULL, '2026-11-02 20:37:59', 20.00, 'dinheiro', '', 'retirada', 'entregue'),
(204, 101, 93, NULL, '2026-11-03 19:08:13', 71.00, 'pix', '', 'entregar', 'entregue'),
(205, 28, NULL, NULL, '2026-11-03 19:09:23', 20.00, 'dinheiro', '', 'retirada', 'entregue'),
(206, 102, 94, NULL, '2026-11-03 19:46:17', 71.00, 'pix', '', 'entregar', 'entregue'),
(208, 104, 95, NULL, '2026-11-03 20:07:47', 71.00, 'dinheiro', '', 'entregar', 'entregue'),
(209, 105, 96, NULL, '2026-11-03 20:11:32', 37.00, 'cartao', '', 'entregar', 'entregue'),
(210, 106, 97, NULL, '2026-11-05 16:37:48', 51.00, 'pix', '', 'entregar', 'criado'),
(211, 106, 97, NULL, '2026-11-05 16:39:23', 51.00, 'pix', '', 'entregar', 'criado');

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
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de tabela `enderecos_cliente`
--
ALTER TABLE `enderecos_cliente`
  MODIFY `id_endereco_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

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
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

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
