-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql304.byetcluster.com
-- Tempo de geração: 27-Abr-2025 às 17:23
-- Versão do servidor: 10.6.19-MariaDB
-- versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ljmn_38667775_ticketsystem`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text NOT NULL,
  `prioridade` enum('Baixa','Média','Alta') NOT NULL DEFAULT 'Média',
  `estado` enum('Aberto','Em Andamento','Fechado') NOT NULL DEFAULT 'Aberto',
  `area` enum('TI','3D','COMUNICAÇÃO','PROGRAMAÇÃO','MANUTENÇÃO') NOT NULL,
  `nome_usuario` int(11) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Extraindo dados da tabela `tickets`
--

INSERT INTO `tickets` (`id`, `titulo`, `descricao`, `prioridade`, `estado`, `area`, `nome_usuario`, `criado_em`, `atualizado_em`) VALUES
(1, 'teste 1', 'ticket para testes', 'Baixa', 'Aberto', '', 1, '2025-04-04 14:35:29', '2025-04-04 14:35:46'),
(37, 'teste', 'teste', 'Média', 'Aberto', 'TI', 25, '2025-04-27 18:40:18', '2025-04-27 18:40:18'),
(28, 'teste', 'teste', 'Baixa', 'Aberto', 'TI', 20, '2025-04-17 20:34:59', '2025-04-17 20:34:59'),
(24, 'erro windows', 'erro', 'Alta', 'Em Andamento', 'TI', 25, '2025-04-14 21:54:25', '2025-04-27 10:41:15'),
(35, 'Computador 2', 'Erro no acesso ao terminal', 'Alta', 'Aberto', 'MANUTENÇÃO', 22, '2025-04-22 11:45:10', '2025-04-22 11:48:33'),
(34, '2134', '5', 'Média', 'Aberto', '3D', 22, '2025-04-22 11:23:47', '2025-04-22 11:23:47'),
(36, 'erro VScode', 'erro ao abrir o VSCODE', 'Baixa', 'Fechado', 'PROGRAMAÇÃO', 22, '2025-04-27 10:54:54', '2025-04-27 10:55:08'),
(39, 'Erro windows10', 'Aparece BSOD', 'Alta', 'Fechado', 'PROGRAMAÇÃO', 25, '2025-04-27 20:11:26', '2025-04-27 20:13:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cargo` enum('user','admin') NOT NULL,
  `area` enum('TI','3D','COMUNICAÇÃO','PROGRAMAÇÃO','MANUTENÇÃO') DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `cargo`, `area`, `criado_em`) VALUES
(5, 'alberto', 'alberto@oficina.pt', '$2y$10$xNKvZ2AAFqOJ/zV64oUgT.phj7GX/Q.s7J6wBmIJYZy6eBezScbcm', 'admin', '', '2025-04-10 13:25:12'),
(17, 'Francisco', '1234@oficina.pt', '$2y$10$6K0TL8mXHDwpyrimhJy6Eu2w5LYiwQEe4dnbqhn1uUzPL6w6ZPCYO', 'admin', 'TI', '2025-04-14 16:38:52'),
(21, 'Francisco', 'kiko.martins122@gmail.com', '$2y$10$tKFuda0pprWuh2qe8vm25eBTPB/wo7iwfp3XW6V1yxboCnv1VTLsm', 'admin', 'PROGRAMAÇÃO', '2025-04-14 16:48:22'),
(20, 'Francisco', 'a14568@oficina.pt', '$2y$10$vO7liVqHtXK0dtWQOHdHI.8sXN4sGMzl2a5rjfJGE8owL19EXM.za', 'user', NULL, '2025-04-14 16:47:56'),
(22, 'admin', 'admin@gmail.com', '$2y$10$m/w/Z9X5jm/v0gybofwoceQoKh3M1GEX8NX8aviJzX8zc7FHkFg1i', 'admin', 'PROGRAMAÇÃO', '2025-04-14 16:55:53'),
(24, 'dinis', 'kkozen777@gmail.con', '$2y$10$aa2ISuW6cnkFhtLqnRC9NeRo8IUfSSuUR0xQ8Z4tQBaRl08Ky2waO', 'user', NULL, '2025-04-14 20:46:49'),
(25, 'joao', 'a14486@oficina.pt', '$2y$10$vS/RDqMCo9E0binGHPLdm.aRuuQA.vmAW/I6NciKGUoI/uqs.rdWO', 'user', NULL, '2025-04-14 21:53:43'),
(26, 'Rosas', 'rosas@gmail.com', '$2y$10$PWkzj5TF2dPzOIuT7WEznOZjpzIAYV1WfOH6yVfdvRi.2nHqaj2yC', 'admin', '3D', '2025-04-14 22:00:42'),
(27, 'francisco', 'francisco@gmail.com', '$2y$10$f88LT7FfMF5MwmUguaEur.kZTW8JPFN/W9Nvbdr.dqQotLsF4yQW6', 'user', NULL, '2025-04-15 11:36:32'),
(31, 'Francisco', 'francisco@ofiacna.pt', '$2y$10$WdfERmGZwkfCUnHcxvA08.tpobKMX1ZDaf/oDWJ5o8MBqHWe4XH2y', 'user', NULL, '2025-04-15 14:02:44');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`nome_usuario`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
