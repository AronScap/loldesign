-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04-Mar-2022 às 00:03
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `aron_loldesign`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `destiny`
--

CREATE TABLE `destiny` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `destiny`
--

INSERT INTO `destiny` (`id`, `code`) VALUES
(1, '011'),
(2, '016'),
(3, '017'),
(4, '018');

-- --------------------------------------------------------

--
-- Estrutura da tabela `origin`
--

CREATE TABLE `origin` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `origin`
--

INSERT INTO `origin` (`id`, `code`) VALUES
(1, '011'),
(2, '016'),
(3, '017'),
(4, '018');

-- --------------------------------------------------------

--
-- Estrutura da tabela `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `minutes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `plans`
--

INSERT INTO `plans` (`id`, `name`, `minutes`) VALUES
(1, 'FaleMais 30', 30),
(2, 'FaleMais 60', 60),
(3, 'FaleMais 120', 120);

-- --------------------------------------------------------

--
-- Estrutura da tabela `prices`
--

CREATE TABLE `prices` (
  `id` int(11) NOT NULL,
  `originID` int(11) NOT NULL,
  `destinyID` int(11) NOT NULL,
  `priceperminute` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `prices`
--

INSERT INTO `prices` (`id`, `originID`, `destinyID`, `priceperminute`) VALUES
(1, 1, 2, 1.9),
(2, 2, 1, 2.9),
(3, 1, 3, 1.7),
(4, 3, 1, 2.7),
(5, 1, 4, 0.9),
(6, 4, 1, 1.9);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `destiny`
--
ALTER TABLE `destiny`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `origin`
--
ALTER TABLE `origin`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prices_origin` (`originID`),
  ADD KEY `prices_destiny` (`destinyID`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `destiny`
--
ALTER TABLE `destiny`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `origin`
--
ALTER TABLE `origin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `prices`
--
ALTER TABLE `prices`
  ADD CONSTRAINT `prices_destiny` FOREIGN KEY (`destinyID`) REFERENCES `destiny` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prices_origin` FOREIGN KEY (`originID`) REFERENCES `origin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
