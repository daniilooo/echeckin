-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/03/2024 às 09:03
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `echeckin`
--

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `checkin_local_empresa_usuario`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `checkin_local_empresa_usuario` (
`ID_CHECKIN` int(11)
,`FK_LOCAL` int(11)
,`FK_EMPRESA` int(11)
,`FK_USUARIO` int(11)
,`OCORRENCIA` datetime
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `empresa_local_justificativa`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `empresa_local_justificativa` (
`ID_JUSTIFICATIVA` int(11)
,`FK_EMPRESA` int(11)
,`FK_USUARIO` int(11)
,`FK_LOCAL` int(11)
,`JUSTIFICATIVA` text
,`DATA_HORA` datetime
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `quant_usuario_cargo`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `quant_usuario_cargo` (
`ID_CARGO` int(11)
,`DESCRICAO_CARGO` varchar(30)
,`QUANTIDADE_USUARIOS_CARGO` bigint(21)
);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_cargos`
--

CREATE TABLE `tbl_cargos` (
  `ID_CARGO` int(11) NOT NULL,
  `DESCRICAO_CARGO` varchar(30) DEFAULT NULL,
  `STATUS_CARGO` int(11) DEFAULT NULL,
  `FK_NIVEL_ACESSO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_cargos`
--

/*
INSERT INTO `tbl_cargos` (`ID_CARGO`, `DESCRICAO_CARGO`, `STATUS_CARGO`, `FK_NIVEL_ACESSO`) VALUES
(1, 'CONTROLADOR DE ACESSO', 1, 4),
(2, 'OPERADOR DE ILHA', 1, 3),
(3, 'DESENVOLVEDOR', 1, 2),
(4, 'ADMINISTRADOR', 1, 1);
*/
-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_checkin`
--

CREATE TABLE `tbl_checkin` (
  `ID_CHECKIN` int(11) NOT NULL,
  `FK_LOCAL` int(11) NOT NULL,
  `FK_USUARIO` int(11) NOT NULL,
  `DATAHORA_CHECKIN` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_checkin`
--
/*
INSERT INTO `tbl_checkin` (`ID_CHECKIN`, `FK_LOCAL`, `FK_USUARIO`, `DATAHORA_CHECKIN`) VALUES
(1, 1, 1, '2024-03-06 16:32:14'),
(2, 2, 1, '2024-03-06 16:32:14'),
(3, 2, 1, '2024-03-06 16:32:14'),
(4, 2, 1, '2024-03-06 16:32:14'),
(5, 2, 1, '2024-03-06 16:32:14'),
(6, 2, 1, '2024-03-06 16:32:14'),
(7, 2, 1, '2024-03-06 16:32:14'),
(8, 5, 1, '2024-03-06 16:32:14'),
(9, 5, 1, '2024-03-06 16:32:14'),
(10, 5, 1, '2024-03-06 16:32:14'),
(11, 5, 1, '2024-03-06 16:32:14'),
(12, 6, 1, '2024-03-06 16:32:14'),
(13, 6, 1, '2024-03-06 16:32:14'),
(14, 6, 1, '2024-03-06 16:32:14'),
(15, 1, 1, '2024-03-06 16:32:14'),
(16, 1, 1, '2024-03-06 16:32:14'),
(17, 1, 1, '2024-03-06 16:32:14'),
(18, 1, 1, '2024-03-06 16:32:14'),
(19, 1, 1, '2024-03-06 16:32:14'),
(20, 4, 4, '2024-03-08 13:22:46'),
(21, 4, 4, '2024-03-08 13:23:05'),
(22, 3, 4, '2024-03-08 13:25:35'),
(23, 3, 4, '2024-03-08 13:26:41'),
(24, 3, 4, '2024-03-08 13:27:40'),
(25, 2, 4, '2024-03-14 16:35:07'),
(26, 2, 4, '2024-03-14 16:38:33'),
(27, 2, 4, '2024-03-14 16:39:27'),
(28, 2, 4, '2024-03-14 16:40:11'),
(29, 12, 11, '2024-03-14 16:51:38');
*/
-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_empresa`
--

CREATE TABLE `tbl_empresa` (
  `ID_EMPRESA` int(11) NOT NULL,
  `RAZAO_SOCIAL` varchar(30) DEFAULT NULL,
  `CNPJ` varchar(18) DEFAULT NULL,
  `STATUS_EMPRESA` int(11) DEFAULT NULL,
  `QTD_LOCAIS` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_empresa`
--
/*
INSERT INTO `tbl_empresa` (`ID_EMPRESA`, `RAZAO_SOCIAL`, `CNPJ`, `STATUS_EMPRESA`, `QTD_LOCAIS`) VALUES
(1, 'UDLOG - MATRIZ', '39.345.960/0001-29', 1, 4),
(2, 'F4F Consultoria', '39.345.960/0001-29', 1, 2),
(3, 'Guibor Log', '39.345.960/0001-29', 1, 3),
(4, 'UDLOG - Filial', '39.345.960/0001-29', 1, 2),
(5, 'EMPRESA TESTS', '39.345.960/0001-29', 1, 1);
*/
-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_erro`
--

CREATE TABLE `tbl_erro` (
  `ID_ERRO` int(11) NOT NULL,
  `DESC_ERRO` text NOT NULL,
  `LOCAL` text NOT NULL,
  `DATA` datetime NOT NULL,
  `FK_USUARIO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_erro`
--
/*
INSERT INTO `tbl_erro` (`ID_ERRO`, `DESC_ERRO`, `LOCAL`, `DATA`, `FK_USUARIO`) VALUES
(1, 'Table \'echeckin.tbl_empresas\' doesn\'t exist', 'DaoEmpresa.gerarListaEmpresas', '2024-02-27 16:15:19', 1),
(2, 'Table \'echeckin.tbl_empresas\' doesn\'t exist', 'DaoEmpresa.gerarListaEmpresas', '2024-02-27 16:17:18', 1),
(3, 'Table \'echeckin.tbl_empresas\' doesn\'t exist', 'DaoEmpresa.gerarListaEmpresas', '2024-02-27 16:18:06', 1),
(4, 'Table \'echeckin.tbl_empresas\' doesn\'t exist', 'DaoEmpresa.gerarListaEmpresas', '2024-02-27 16:20:36', 1),
(5, 'Table \'echeckin.tbl_empresas\' doesn\'t exist', 'DaoEmpresa.gerarListaEmpresas', '2024-02-27 16:20:50', 1),
(6, 'Table \'echeckin.tbl_empresas\' doesn\'t exist', 'DaoEmpresa.gerarListaEmpresas', '2024-02-27 16:20:51', 1),
(7, 'Table \'echeckin.tbl_empresas\' doesn\'t exist', 'DaoEmpresa.gerarListaEmpresas', '2024-02-27 16:25:59', 1),
(8, 'Table \'echeckin.tbl_empresas\' doesn\'t exist', 'DaoEmpresa.gerarListaEmpresas', '2024-02-27 16:25:59', 1),
(9, 'Table \'echeckin.tbl_empresas\' doesn\'t exist', 'DaoEmpresa.gerarListaEmpresas', '2024-02-27 16:25:59', 1),
(10, 'Table \'echeckin.tbl_empresas\' doesn\'t exist', 'DaoEmpresa.gerarListaEmpresas', '2024-02-27 16:25:59', 1),
(11, 'Unknown column \'FK_TIPO_LOCA\' in \'field list\'', 'DaoLocal.inserirLocal', '2024-02-28 09:55:58', 1),
(12, 'Unknown column \'FK_TIPO_LOCA\' in \'field list\'', 'DaoLocal.inserirLocal', '2024-02-28 10:03:34', 1),
(13, 'Unknown column \'FK_TIPO_LOCA\' in \'field list\'', 'DaoLocal.inserirLocal', '2024-02-28 10:19:38', 1),
(14, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.gerarListaCargo', '2024-02-29 13:45:55', 1),
(15, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.gerarListaCargo', '2024-02-29 13:46:33', 1),
(16, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.gerarListaCargo', '2024-02-29 16:39:05', 1),
(17, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:50:44', 4),
(18, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:50:44', 4),
(19, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:50:44', 4),
(20, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:50:44', 4),
(21, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:51:35', 4),
(22, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:51:35', 4),
(23, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:51:35', 4),
(24, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:51:35', 4),
(25, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:52:20', 4),
(26, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:52:20', 4),
(27, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:52:20', 4),
(28, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:52:20', 4),
(29, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:53:56', 4),
(30, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:53:56', 4),
(31, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:53:56', 4),
(32, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:53:56', 4),
(33, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:54:33', 4),
(34, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:54:33', 4),
(35, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:54:34', 4),
(36, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:54:34', 4),
(37, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:54:43', 4),
(38, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:54:43', 4),
(39, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:54:43', 4),
(40, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:54:43', 4),
(41, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:54:49', 4),
(42, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:54:49', 4),
(43, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:54:49', 4),
(44, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 11:54:49', 4),
(45, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 12:02:11', 4),
(46, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 12:02:11', 4),
(47, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 12:02:11', 4),
(48, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 12:02:11', 4),
(49, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 12:03:23', 4),
(50, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 12:03:23', 4),
(51, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 12:03:23', 4),
(52, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 12:03:24', 4),
(53, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:21:51', 4),
(54, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:21:51', 4),
(55, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:21:52', 4),
(56, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:21:52', 4),
(57, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:21:59', 4),
(58, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:21:59', 4),
(59, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:21:59', 4),
(60, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:21:59', 4),
(61, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:22:21', 4),
(62, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:22:21', 4),
(63, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:22:21', 4),
(64, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:22:21', 4),
(65, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:24:15', 4),
(66, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:24:15', 4),
(67, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:24:15', 4),
(68, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 13:24:15', 4),
(69, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:04:24', 4),
(70, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:04:24', 4),
(71, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:04:24', 4),
(72, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:04:24', 4),
(73, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:08:00', 4),
(74, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:08:00', 4),
(75, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:08:00', 4),
(76, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:08:01', 4),
(77, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:50:13', 4),
(78, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:50:13', 4),
(79, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:50:13', 4),
(80, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:50:13', 4),
(81, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:51:49', 4),
(82, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:51:49', 4),
(83, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:51:49', 4),
(84, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:51:49', 4),
(85, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:51:59', 4),
(86, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:51:59', 4),
(87, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:51:59', 4),
(88, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '2024-03-01 14:51:59', 4),
(89, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '0000-00-00 00:00:00', 4),
(90, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '0000-00-00 00:00:00', 4),
(91, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '0000-00-00 00:00:00', 4),
(92, 'Unknown column \'NIVEL_ACESSO\' in \'field list\'', 'DaoCargo.selecionarCargo', '0000-00-00 00:00:00', 4),
(93, 'Cannot add or update a child row: a foreign key constraint fails (`echeckin`.`tbl_usuario`, CONSTRAINT `fk_usuario_empresa` FOREIGN KEY (`EMPRESA`) REFERENCES `tbl_empresa` (`ID_EMPRESA`))', 'DaoUsuario.inserirUsuario', '0000-00-00 00:00:00', 1),
(94, 'Cannot add or update a child row: a foreign key constraint fails (`echeckin`.`tbl_usuario`, CONSTRAINT `fk_usuario_empresa` FOREIGN KEY (`EMPRESA`) REFERENCES `tbl_empresa` (`ID_EMPRESA`))', 'DaoUsuario.inserirUsuario', '0000-00-00 00:00:00', 1),
(95, 'Cannot add or update a child row: a foreign key constraint fails (`echeckin`.`tbl_usuario`, CONSTRAINT `fk_usuario_empresa` FOREIGN KEY (`EMPRESA`) REFERENCES `tbl_empresa` (`ID_EMPRESA`))', 'DaoUsuario.inserirUsuario', '0000-00-00 00:00:00', 1),
(96, 'Cannot add or update a child row: a foreign key constraint fails (`echeckin`.`tbl_usuario`, CONSTRAINT `fk_usuario_empresa` FOREIGN KEY (`EMPRESA`) REFERENCES `tbl_empresa` (`ID_EMPRESA`))', 'DaoUsuario.inserirUsuario', '0000-00-00 00:00:00', 1),
(97, 'Table \'echeckin.tbl_niveis_acesso2\' doesn\'t exist', 'DaoNivelAcesso.inserirNivelAcesso', '0000-00-00 00:00:00', 1),
(98, 'Table \'echeckin.tbl_niveis_acesso2\' doesn\'t exist', 'DaoNivelAcesso.inserirNivelAcesso', '0000-00-00 00:00:00', 1),
(99, 'Table \'echeckin.tbl_niveis_acesso2\' doesn\'t exist', 'DaoNivelAcesso.inserirNivelAcesso', '2024-03-07 13:03:04', 1),
(100, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 10:03:35', 4),
(101, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 10:03:36', 4),
(102, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 10:03:59', 4),
(103, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 10:03:04', 4),
(104, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 10:03:20', 4),
(105, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 10:03:53', 4),
(106, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 10:03:53', 4),
(107, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 10:03:53', 4),
(108, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:58', 4),
(109, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:59', 4),
(110, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:05', 4),
(111, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:06', 4),
(112, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:01', 4),
(113, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:06', 4),
(114, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:07', 4),
(115, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:08', 4),
(116, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:08', 4),
(117, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:08', 4),
(118, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:09', 4),
(119, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:09', 4),
(120, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:33', 4),
(121, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:34', 4),
(122, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:34', 4),
(123, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:34', 4),
(124, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:35', 4),
(125, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:48', 4),
(126, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:49', 4),
(127, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:49', 4),
(128, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:49', 4),
(129, 'Unknown column \'FK_USARIO\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:29', 4),
(130, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:37', 4),
(131, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:38', 4),
(132, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:38', 4),
(133, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:38', 4),
(134, 'Unknown column \'FK_LOCALFK_LOCAL\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:40', 4),
(135, 'Unknown column \'FK_LOCALFK_LOCAL\' in \'field list\'', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:40', 4),
(136, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:59', 4),
(137, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:19', 4),
(138, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:53', 4),
(139, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:33', 4),
(140, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:04', 4),
(141, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:05', 4),
(142, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:06', 4),
(143, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:06', 4),
(144, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:30', 4),
(145, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:23', 4),
(146, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:41', 4),
(147, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:42', 4),
(148, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:34', 4),
(149, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:35', 4),
(150, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:00', 4),
(151, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:51', 4),
(152, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:04', 4),
(153, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:04', 4),
(154, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:54', 1),
(155, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 11:03:21', 1),
(156, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 12:03:22', 1),
(157, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 12:03:13', 1),
(158, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 12:03:28', 1),
(159, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 12:03:28', 1),
(160, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 13:03:42', 1),
(161, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 13:03:08', 1),
(162, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 13:03:08', 1),
(163, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 13:03:09', 1),
(164, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 13:03:09', 1),
(165, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 13:03:21', 1),
(166, 'Commands out of sync; you can\'t run this command now', 'DaoJustificativa.gerarListaJustificativasPorEmpresa', '2024-03-11 13:03:22', 1),
(167, 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'->TBL_LOCAIS} SET FK_EMPRESA = ?, FK_TIPO_LOCAL = ?, DESC_LOCAL = ?, STATUS_L...\' at line 1', 'DaoLocal.alterarLocal', '2024-03-11 15:03:29', 4),
(168, 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'->TBL_LOCAIS} SET FK_EMPRESA = ?, FK_TIPO_LOCAL = ?, DESC_LOCAL = ?, STATUS_L...\' at line 1', 'DaoLocal.alterarLocal', '2024-03-11 15:03:37', 4),
(169, 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'->TBL_LOCAIS} SET FK_EMPRESA = ?, FK_TIPO_LOCAL = ?, DESC_LOCAL = ?, STATUS_L...\' at line 1', 'DaoLocal.alterarLocal', '2024-03-11 15:03:08', 4),
(170, 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'->TBL_LOCAIS} SET FK_EMPRESA = ?, FK_TIPO_LOCAL = ?, DESC_LOCAL = ?, STATUS_L...\' at line 1', 'DaoLocal.alterarLocal', '2024-03-11 15:03:23', 4),
(171, 'Cannot add or update a child row: a foreign key constraint fails (`echeckin`.`tbl_locais`, CONSTRAINT `FK_EMPRESA` FOREIGN KEY (`FK_EMPRESA`) REFERENCES `tbl_empresa` (`ID_EMPRESA`))', 'DaoLocal.alterarLocal', '2024-03-12 09:03:28', 4),
(172, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:00', 4),
(173, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:01', 4),
(174, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:01', 4),
(175, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:01', 4),
(176, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:11', 4),
(177, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:11', 4),
(178, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:11', 4),
(179, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:11', 4),
(180, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:12', 4),
(181, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:12', 4),
(182, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:12', 4),
(183, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:12', 4),
(184, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:12', 4),
(185, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:12', 4),
(186, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:12', 4),
(187, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:12', 4),
(188, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:18', 1),
(189, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:51', 1),
(190, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:38', 1),
(191, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:27', 1),
(192, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:27', 1),
(193, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:28', 1),
(194, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:28', 1),
(195, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:32', 1),
(196, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:45', 1),
(197, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:45', 1),
(198, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:46', 1),
(199, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:46', 1),
(200, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:46', 1),
(201, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:47', 1),
(202, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:47', 1),
(203, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 10:03:47', 1),
(204, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 11:03:18', 1),
(205, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 11:03:34', 1),
(206, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 11:03:40', 1),
(207, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 11:03:40', 1),
(208, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 11:03:40', 1),
(209, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 11:03:40', 1),
(210, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 11:03:06', 1),
(211, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 11:03:06', 1),
(212, 'Unknown column \'QUANTIDADE_USARIOS_CARGO\' in \'field list\'', 'DaoCargo.quantidadeUsuariosCargo', '2024-03-12 11:03:06', 1),
(213, 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'ORDER BY OCORRENCIA DESC\' at line 1', 'DaoCheckin.gerarListaCheckinPorEmpresa', '2024-03-12 15:03:27', 4);
*/
-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_justificativa`
--

CREATE TABLE `tbl_justificativa` (
  `ID_JUSTIFICATIVA` int(11) NOT NULL,
  `FK_USUARIO` int(11) NOT NULL,
  `FK_LOCAL` int(11) NOT NULL,
  `JUSTIFICATIVA` text NOT NULL,
  `DATA_HORA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_justificativa`
--
/*
INSERT INTO `tbl_justificativa` (`ID_JUSTIFICATIVA`, `FK_USUARIO`, `FK_LOCAL`, `JUSTIFICATIVA`, `DATA_HORA`) VALUES
(1, 1, 1, 'TESTE DE INSERÇÃO DE JUSTIFICATIVA', '2024-03-11 10:29:27');
*/
-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_locais`
--

CREATE TABLE `tbl_locais` (
  `ID_LOCAL` int(11) NOT NULL,
  `FK_EMPRESA` int(11) NOT NULL,
  `FK_TIPO_LOCAL` int(11) NOT NULL,
  `DESC_LOCAL` varchar(30) DEFAULT NULL,
  `STATUS_LOCAL` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_locais`
--
/*
INSERT INTO `tbl_locais` (`ID_LOCAL`, `FK_EMPRESA`, `FK_TIPO_LOCAL`, `DESC_LOCAL`, `STATUS_LOCAL`) VALUES
(1, 1, 1, 'RELÓGIO DE PONTO - ADM2', 1),
(2, 1, 2, 'REFEITÓRIO', 1),
(3, 1, 1, 'ARMAZÉM 1', 1),
(4, 2, 1, 'PORTARIA 0', 1),
(5, 3, 2, 'CARREGAMENTO DE GÁS', 1),
(6, 3, 1, 'ILHA BTE', 1),
(7, 3, 1, 'ILHA 22', 1),
(8, 3, 2, 'ILHA 23', 1),
(9, 2, 1, 'CAIXA D\'ÁGUA', 1),
(10, 4, 1, 'PORTARIA', 1),
(11, 4, 1, 'ADM', 1),
(12, 5, 1, 'TESTE1', 1);

--
-- Acionadores `tbl_locais`
--
DELIMITER $$
CREATE TRIGGER `after_insert_local` AFTER INSERT ON `tbl_locais` FOR EACH ROW BEGIN
    DECLARE num_locais INT;

    -- Conta a quantidade de locais para a FK_EMPRESA do novo local
    SELECT COUNT(*) INTO num_locais
    FROM TBL_LOCAIS
    WHERE FK_EMPRESA = NEW.FK_EMPRESA;

    -- Atualiza a quantidade de locais na TBL_EMPRESA
    UPDATE TBL_EMPRESA
    SET QTD_LOCAIS = num_locais
    WHERE ID_EMPRESA = NEW.FK_EMPRESA;
END
$$
DELIMITER ;
*/
-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_log`
--

CREATE TABLE `tbl_log` (
  `ID_LOG` int(11) NOT NULL,
  `REGLOG` text DEFAULT NULL,
  `DATAHORA` datetime DEFAULT NULL,
  `ID_USUARIO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_log`
--
/*
INSERT INTO `tbl_log` (`ID_LOG`, `REGLOG`, `DATAHORA`, `ID_USUARIO`) VALUES
(1, 'Teste para inserção de log no banco de dados', '2024-02-28 10:08:26', 1),
(2, 'Novo local cadatrado.\nID do novo local: 3', '2024-02-28 10:22:54', 1),
(3, 'Novo usuário cadastrado.\nID do usuário cadastrado: 3', '2024-02-28 14:22:39', 1),
(4, 'Nova empresa cadastrada.\nID da empresa cadastrada: 2', '2024-02-28 14:55:45', 1),
(5, 'Novo local cadatrado.\nID do novo local: 4', '2024-02-28 15:03:21', 1),
(6, 'Nova empresa cadastrada.\nID da empresa cadastrada: 3', '2024-02-28 15:17:14', 1),
(7, 'Empresa alterada\nID Empresa alterada: 1', '2024-02-28 16:52:26', 1),
(8, 'Empresa alterada\nID Empresa alterada: 1', '2024-02-28 16:53:13', 1),
(9, 'Empresa alterada\nID Empresa alterada: 1', '2024-02-28 16:53:30', 1),
(10, 'Empresa alterada\nID Empresa alterada: 2', '2024-02-28 16:53:37', 1),
(11, 'Novo usuário cadastrado.\nID do usuário cadastrado: 4', '2024-02-29 13:49:09', 1),
(12, 'Novo usuário cadastrado.\nID do usuário cadastrado: 9', '2024-03-04 10:57:06', 1),
(13, 'Alteração no cadastro do usuário: 2', '2024-03-04 13:53:46', 4),
(14, 'Alteração no cadastro do usuário: 2', '2024-03-04 13:56:27', 4),
(15, 'Alteração no cadastro do usuário: 9', '2024-03-04 14:01:36', 4),
(16, 'Senha do usuário resetada.\nID do usuario: 2', '2024-03-04 14:35:53', 4),
(17, 'Senha do usuário resetada.\nID do usuario: 2', '2024-03-04 14:36:02', 4),
(18, 'Senha do usuário resetada.\nID do usuario: 2', '2024-03-04 15:01:37', 4),
(19, 'Alteração no cadastro do usuário: 3', '2024-03-04 15:13:29', 4),
(20, 'Novo local cadatrado.\nID do novo local: 5', '2024-03-04 15:21:11', 1),
(21, 'Novo local cadastrado.\nID do novo local: 6', '2024-03-04 16:26:25', 4),
(22, 'Novo local cadastrado.\nID do novo local: 7', '2024-03-04 16:27:03', 4),
(23, 'Empresa alterada\nID Empresa alterada: 3', '2024-03-07 09:46:03', 1),
(24, 'Empresa alterada\nID Empresa alterada: 2', '2024-03-07 10:36:08', 1),
(25, 'Empresa alterada\nID Empresa alterada: 2', '2024-03-07 10:38:45', 1),
(26, 'Alteração no cadastro do usuário: 4', '2024-03-08 14:48:13', 4),
(27, 'Alteração no cadastro do usuário: 4', '2024-03-08 14:48:23', 4),
(28, 'Empresa alterada\nID Empresa alterada: 3', '2024-03-11 15:15:05', 1),
(29, 'Empresa alterada\nID Empresa alterada: 3', '2024-03-11 15:15:10', 1),
(30, 'Alteração de local.\nID do local alterado: 7', '2024-03-12 09:04:44', 4),
(31, 'Alteração de local.\nID do local alterado: 6', '2024-03-12 11:54:28', 4),
(32, 'Alteração de local.\nID do local alterado: 5', '2024-03-12 11:54:51', 4),
(33, 'Empresa alterada\nID Empresa alterada: 1', '2024-03-12 11:55:15', 1),
(34, 'Novo local cadastrado.\nID do novo local: 8', '2024-03-12 13:37:38', 4),
(35, 'Alteração de local.\nID do local alterado: 1', '2024-03-12 13:44:17', 4),
(36, 'Alteração de local.\nID do local alterado: 2', '2024-03-12 13:44:25', 4),
(37, 'Alteração de local.\nID do local alterado: 3', '2024-03-12 13:44:47', 4),
(38, 'Alteração de local.\nID do local alterado: 2', '2024-03-12 13:45:00', 4),
(39, 'Alteração de local.\nID do local alterado: 8', '2024-03-12 13:45:07', 4),
(40, 'Alteração de local.\nID do local alterado: 4', '2024-03-12 13:45:30', 4),
(41, 'Novo local cadastrado.\nID do novo local: 9', '2024-03-12 13:53:03', 4),
(42, 'Senha do usuário resetada.\nID do usuario: 1', '2024-03-12 17:25:38', 4),
(43, 'Senha do usuário resetada.\nID do usuario: 2', '2024-03-12 17:25:45', 4),
(44, 'Nova empresa cadastrada.\nID da empresa cadastrada: 4', '2024-03-13 16:31:05', 1),
(45, 'Novo local cadastrado.\nID do novo local: 10', '2024-03-13 16:31:31', 4),
(46, 'Novo local cadastrado.\nID do novo local: 11', '2024-03-13 16:31:53', 4),
(47, 'Novo usuário cadastrado.\nID do usuário cadastrado: 10', '2024-03-13 16:32:41', 1),
(48, 'Nova empresa cadastrada.\nID da empresa cadastrada: 5', '2024-03-14 16:46:07', 1),
(49, 'Novo local cadastrado.\nID do novo local: 12', '2024-03-14 16:46:34', 4),
(50, 'Novo usuário cadastrado.\nID do usuário cadastrado: 11', '2024-03-14 16:47:52', 1);
*/
-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_niveis_acesso`
--

CREATE TABLE `tbl_niveis_acesso` (
  `ID_NIVEL_ACESSO` int(11) NOT NULL,
  `DESC_NIVEL_ACESSO` varchar(20) DEFAULT NULL,
  `STATUS_NIVELACESSO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_niveis_acesso`
--
/*
INSERT INTO `tbl_niveis_acesso` (`ID_NIVEL_ACESSO`, `DESC_NIVEL_ACESSO`, `STATUS_NIVELACESSO`) VALUES
(1, 'ADMINISTRADOR', 0),
(2, 'DESENVOLVEDOR', 0),
(3, 'OPERADOR DE ILHA', 5),
(4, 'RONDANTE', 0),
(5, 'USUARIO', 1);
*/
-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_tipos_locais`
--

CREATE TABLE `tbl_tipos_locais` (
  `ID_TIPO_LOCAL` int(11) NOT NULL,
  `DESCRICAO_TIPOLOCAL` varchar(20) DEFAULT NULL,
  `STATUS_TIPOLOCAL` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_tipos_locais`
--
/*
INSERT INTO `tbl_tipos_locais` (`ID_TIPO_LOCAL`, `DESCRICAO_TIPOLOCAL`, `STATUS_TIPOLOCAL`) VALUES
(1, 'PONTO DE RONDA', 1),
(2, 'ILHA DE CARREGAMENTO', 1);
*/
-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `ID_USUARIO` int(11) NOT NULL,
  `NOME` varchar(30) DEFAULT NULL,
  `MATRICULA` varchar(30) DEFAULT NULL,
  `EMPRESA` int(11) DEFAULT NULL,
  `CARGO` int(11) DEFAULT NULL,
  `LOGIN` varchar(20) DEFAULT NULL,
  `SENHA` varchar(255) DEFAULT NULL,
  `STATUS_USUARIO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_usuario`
--
/*
INSERT INTO `tbl_usuario` (`ID_USUARIO`, `NOME`, `MATRICULA`, `EMPRESA`, `CARGO`, `LOGIN`, `SENHA`, `STATUS_USUARIO`) VALUES
(1, 'Danilo Franco', '354', 1, 3, 'DANILO', '$2y$10$yntrNRhrHEOxkyhj5ZcjQ.ERK/jrRUU2iyY6TcwWhloLn6fV5QfRS', 1),
(2, 'Kaio Anjos', '331', 1, 2, 'KAIO', '$2y$10$2Nyuu.JZncljJHeUyxKtm.tW18CRFCA9XkDx/wYsUGMAPwraJm4b2', 1),
(3, 'Admin', '9999', 1, 4, 'ADMINISTRADOR', '$2y$10$jer/idn32YSVuR8.usTSXOPPUUVURFWVCoQqqryaW9rsp3kXbOqyq', 1),
(4, 'Administrador', '221', 1, 3, 'ADMIN', '$2y$10$juycKdqfxLfwTl2JPP5weuUf4PvxG7yrlyaWeUePYAY5/CJL6LYsa', 1),
(9, 'Teste Colab', '555321', 3, 2, 'TESTE', '$2y$10$t0lKxxLrqyRAxlQQG73FZOKDUmwjBp2p4/rUat0xLfNaBQ6xdpI0C', 0),
(10, 'DIUARY ESRON', '335', 4, 3, 'DIU', '$2y$10$PB.OMhyhGT51FLSG2yosJ.h2oo2H17w/iHxASa21rXfvwMh1lT5Ri', 1),
(11, 'USER TESTE', '333', 5, 1, 'TESTE1', '$2y$10$oAlxqLghI7v2pPtZPKytbufR8U4kfPuGKJoE4aHbo4emis4X.k0By', 1);
*/
-- --------------------------------------------------------

--
-- Estrutura stand-in para view `usuario_cargo_acesso`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `usuario_cargo_acesso` (
`USUARIO` int(11)
,`CARGO` int(11)
,`NIVEL_ACESSO` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura para view `checkin_local_empresa_usuario`
--
DROP TABLE IF EXISTS `checkin_local_empresa_usuario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `checkin_local_empresa_usuario`  AS SELECT `c`.`ID_CHECKIN` AS `ID_CHECKIN`, `c`.`FK_LOCAL` AS `FK_LOCAL`, `l`.`FK_EMPRESA` AS `FK_EMPRESA`, `c`.`FK_USUARIO` AS `FK_USUARIO`, `c`.`DATAHORA_CHECKIN` AS `OCORRENCIA` FROM (`tbl_checkin` `c` join `tbl_locais` `l` on(`c`.`FK_LOCAL` = `l`.`ID_LOCAL`)) ORDER BY `c`.`ID_CHECKIN` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para view `empresa_local_justificativa`
--
DROP TABLE IF EXISTS `empresa_local_justificativa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `empresa_local_justificativa`  AS SELECT `just`.`ID_JUSTIFICATIVA` AS `ID_JUSTIFICATIVA`, `empresa`.`ID_EMPRESA` AS `FK_EMPRESA`, `just`.`FK_USUARIO` AS `FK_USUARIO`, `just`.`FK_LOCAL` AS `FK_LOCAL`, `just`.`JUSTIFICATIVA` AS `JUSTIFICATIVA`, `just`.`DATA_HORA` AS `DATA_HORA` FROM ((`tbl_empresa` `empresa` join `tbl_locais` `local` on(`empresa`.`ID_EMPRESA` = `local`.`ID_LOCAL`)) join `tbl_justificativa` `just` on(`just`.`FK_LOCAL` = `local`.`ID_LOCAL`)) ;

-- --------------------------------------------------------

--
-- Estrutura para view `quant_usuario_cargo`
--
DROP TABLE IF EXISTS `quant_usuario_cargo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `quant_usuario_cargo`  AS SELECT `usuario`.`CARGO` AS `ID_CARGO`, `cargo`.`DESCRICAO_CARGO` AS `DESCRICAO_CARGO`, count(`usuario`.`CARGO`) AS `QUANTIDADE_USUARIOS_CARGO` FROM (`tbl_usuario` `usuario` join `tbl_cargos` `cargo` on(`usuario`.`CARGO` = `cargo`.`ID_CARGO`)) GROUP BY `usuario`.`CARGO` ;

-- --------------------------------------------------------

--
-- Estrutura para view `usuario_cargo_acesso`
--
DROP TABLE IF EXISTS `usuario_cargo_acesso`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `usuario_cargo_acesso`  AS SELECT `usuario`.`ID_USUARIO` AS `USUARIO`, `cargo`.`ID_CARGO` AS `CARGO`, `acesso`.`ID_NIVEL_ACESSO` AS `NIVEL_ACESSO` FROM ((`tbl_usuario` `usuario` join `tbl_cargos` `cargo` on(`usuario`.`CARGO` = `cargo`.`ID_CARGO`)) join `tbl_niveis_acesso` `acesso` on(`cargo`.`FK_NIVEL_ACESSO` = `acesso`.`ID_NIVEL_ACESSO`)) ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbl_cargos`
--
ALTER TABLE `tbl_cargos`
  ADD PRIMARY KEY (`ID_CARGO`),
  ADD KEY `FK_NIVEIS_ACESSO` (`FK_NIVEL_ACESSO`);

--
-- Índices de tabela `tbl_checkin`
--
ALTER TABLE `tbl_checkin`
  ADD PRIMARY KEY (`ID_CHECKIN`),
  ADD KEY `FK_LOCAL` (`FK_LOCAL`),
  ADD KEY `FK_USUARIO` (`FK_USUARIO`);

--
-- Índices de tabela `tbl_empresa`
--
ALTER TABLE `tbl_empresa`
  ADD PRIMARY KEY (`ID_EMPRESA`);

--
-- Índices de tabela `tbl_erro`
--
ALTER TABLE `tbl_erro`
  ADD PRIMARY KEY (`ID_ERRO`),
  ADD KEY `FK_USUARIO` (`FK_USUARIO`);

--
-- Índices de tabela `tbl_justificativa`
--
ALTER TABLE `tbl_justificativa`
  ADD PRIMARY KEY (`ID_JUSTIFICATIVA`),
  ADD KEY `FK_USUARIO` (`FK_USUARIO`),
  ADD KEY `FK_LOCAL` (`FK_LOCAL`);

--
-- Índices de tabela `tbl_locais`
--
ALTER TABLE `tbl_locais`
  ADD PRIMARY KEY (`ID_LOCAL`),
  ADD KEY `FK_EMPRESA` (`FK_EMPRESA`),
  ADD KEY `FK_TIPO_LOCAL` (`FK_TIPO_LOCAL`);

--
-- Índices de tabela `tbl_log`
--
ALTER TABLE `tbl_log`
  ADD PRIMARY KEY (`ID_LOG`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`);

--
-- Índices de tabela `tbl_niveis_acesso`
--
ALTER TABLE `tbl_niveis_acesso`
  ADD PRIMARY KEY (`ID_NIVEL_ACESSO`);

--
-- Índices de tabela `tbl_tipos_locais`
--
ALTER TABLE `tbl_tipos_locais`
  ADD PRIMARY KEY (`ID_TIPO_LOCAL`);

--
-- Índices de tabela `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`ID_USUARIO`),
  ADD UNIQUE KEY `unica_matricula` (`MATRICULA`),
  ADD UNIQUE KEY `unico_login` (`LOGIN`),
  ADD KEY `fk_usuario_empresa` (`EMPRESA`),
  ADD KEY `fk_usuario_cargo` (`CARGO`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbl_cargos`
--
ALTER TABLE `tbl_cargos`
  MODIFY `ID_CARGO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tbl_checkin`
--
ALTER TABLE `tbl_checkin`
  MODIFY `ID_CHECKIN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `tbl_empresa`
--
ALTER TABLE `tbl_empresa`
  MODIFY `ID_EMPRESA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tbl_erro`
--
ALTER TABLE `tbl_erro`
  MODIFY `ID_ERRO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT de tabela `tbl_justificativa`
--
ALTER TABLE `tbl_justificativa`
  MODIFY `ID_JUSTIFICATIVA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbl_locais`
--
ALTER TABLE `tbl_locais`
  MODIFY `ID_LOCAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `tbl_log`
--
ALTER TABLE `tbl_log`
  MODIFY `ID_LOG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `tbl_niveis_acesso`
--
ALTER TABLE `tbl_niveis_acesso`
  MODIFY `ID_NIVEL_ACESSO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  MODIFY `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tbl_cargos`
--
ALTER TABLE `tbl_cargos`
  ADD CONSTRAINT `FK_NIVEIS_ACESSO` FOREIGN KEY (`FK_NIVEL_ACESSO`) REFERENCES `tbl_niveis_acesso` (`ID_NIVEL_ACESSO`);

--
-- Restrições para tabelas `tbl_checkin`
--
ALTER TABLE `tbl_checkin`
  ADD CONSTRAINT `tbl_checkin_ibfk_1` FOREIGN KEY (`FK_LOCAL`) REFERENCES `tbl_locais` (`ID_LOCAL`),
  ADD CONSTRAINT `tbl_checkin_ibfk_2` FOREIGN KEY (`FK_USUARIO`) REFERENCES `tbl_usuario` (`ID_USUARIO`);

--
-- Restrições para tabelas `tbl_erro`
--
ALTER TABLE `tbl_erro`
  ADD CONSTRAINT `tbl_erro_ibfk_1` FOREIGN KEY (`FK_USUARIO`) REFERENCES `tbl_usuario` (`ID_USUARIO`);

--
-- Restrições para tabelas `tbl_justificativa`
--
ALTER TABLE `tbl_justificativa`
  ADD CONSTRAINT `tbl_justificativa_ibfk_1` FOREIGN KEY (`FK_USUARIO`) REFERENCES `tbl_usuario` (`ID_USUARIO`),
  ADD CONSTRAINT `tbl_justificativa_ibfk_2` FOREIGN KEY (`FK_LOCAL`) REFERENCES `tbl_locais` (`ID_LOCAL`);

--
-- Restrições para tabelas `tbl_locais`
--
ALTER TABLE `tbl_locais`
  ADD CONSTRAINT `FK_EMPRESA` FOREIGN KEY (`FK_EMPRESA`) REFERENCES `tbl_empresa` (`ID_EMPRESA`),
  ADD CONSTRAINT `FK_TIPO_LOCAL` FOREIGN KEY (`FK_TIPO_LOCAL`) REFERENCES `tbl_tipos_locais` (`ID_TIPO_LOCAL`);

--
-- Restrições para tabelas `tbl_log`
--
ALTER TABLE `tbl_log`
  ADD CONSTRAINT `tbl_log_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `tbl_usuario` (`ID_USUARIO`);

--
-- Restrições para tabelas `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD CONSTRAINT `fk_usuario_cargo` FOREIGN KEY (`CARGO`) REFERENCES `tbl_cargos` (`ID_CARGO`),
  ADD CONSTRAINT `fk_usuario_empresa` FOREIGN KEY (`EMPRESA`) REFERENCES `tbl_empresa` (`ID_EMPRESA`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
