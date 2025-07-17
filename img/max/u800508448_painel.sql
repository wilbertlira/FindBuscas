-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 03/02/2025 às 07:13
-- Versão do servidor: 5.7.36
-- Versão do PHP: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u800508448_painel`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `data_criada` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_expiracao` datetime DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `nivel` enum('cliente','revendedor','admin') DEFAULT 'cliente',
  `registrador` varchar(50) DEFAULT NULL,
  `creditos` int(11) DEFAULT '0',
  `verificado` tinyint(1) DEFAULT '0',
  `plano` varchar(50) DEFAULT NULL,
  `trocar` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `senha`, `email`, `token`, `data_criada`, `data_expiracao`, `status`, `nivel`, `registrador`, `creditos`, `verificado`, `plano`, `trocar`) VALUES
(1, 'usuario_teste', '1234', 'teste@skysearch.com', 'dd1155e76bfb71ecd4cdee2c63dddf8c', '2024-12-23 23:44:00', '2026-01-22 23:44:00', 'ativo', 'cliente', 'sistema', 100, 1, 'basico', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_usuario_login` (`usuario`,`senha`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
