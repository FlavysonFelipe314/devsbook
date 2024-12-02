-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/12/2024 às 23:04
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
-- Banco de dados: `devsbook`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `postcomments`
--

CREATE TABLE `postcomments` (
  `id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `postcomments`
--

INSERT INTO `postcomments` (`id`, `id_post`, `id_user`, `created_at`, `body`) VALUES
(14, 14, 3, '2024-11-13 00:37:03', 'carlos '),
(15, 13, 3, '2024-11-13 00:37:18', 'JHGVFJHCFVGHJ'),
(16, 16, 12, '2024-11-13 08:20:11', 'olá '),
(17, 12, 12, '2024-11-13 08:21:14', 'opa'),
(18, 16, 3, '2024-11-13 08:21:58', 'salve'),
(19, 17, 13, '2024-11-13 08:30:22', 'teste'),
(20, 17, 3, '2024-11-13 08:31:40', 'teste');

-- --------------------------------------------------------

--
-- Estrutura para tabela `postlikes`
--

CREATE TABLE `postlikes` (
  `id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `postlikes`
--

INSERT INTO `postlikes` (`id`, `id_post`, `id_user`, `created_at`) VALUES
(23, 8, 3, '2024-11-12 02:09:53'),
(24, 14, 3, '2024-11-12 18:33:18'),
(25, 12, 8, '2024-11-12 19:06:34'),
(26, 13, 3, '2024-11-12 20:37:16'),
(27, 16, 12, '2024-11-13 04:20:12'),
(28, 12, 12, '2024-11-13 04:21:12'),
(29, 16, 3, '2024-11-13 04:21:54'),
(30, 17, 13, '2024-11-13 04:30:15'),
(31, 17, 3, '2024-11-13 04:31:35');

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `posts`
--

INSERT INTO `posts` (`id`, `id_user`, `type`, `created_at`, `body`) VALUES
(1, 3, 'text', '2024-10-29 23:18:45', 'asdasdad'),
(2, 5, 'text', '2024-10-29 23:19:44', 'oi\r\n'),
(3, 3, 'text', '2024-10-30 03:10:27', 'asdasdasdasdasdad'),
(4, 5, 'text', '2024-10-30 22:46:40', 'asdasdasdsadaa'),
(5, 5, 'text', '2024-10-30 22:46:44', 'asdasdasd'),
(6, 7, 'text', '2024-10-30 22:49:09', 'alguma coisa\r\n'),
(7, 3, 'text', '2024-10-30 22:52:53', 'oi amigos'),
(8, 8, 'text', '2024-10-30 23:34:42', 'olá mundo'),
(9, 3, 'text', '2024-10-30 23:39:58', 'olá povo'),
(10, 3, 'text', '2024-10-30 23:41:54', 'o\r\n\r\nla \r\n\r\nmundo'),
(11, 7, 'text', '2024-11-03 19:53:47', 'olá mundo \r\n'),
(12, 3, 'text', '2024-11-03 20:40:56', 'teste novo\r\n'),
(13, 7, 'text', '2024-11-04 07:00:59', 'oi\r\n'),
(14, 7, 'text', '2024-11-09 03:15:22', 'olá\r\n'),
(15, 3, 'text', '2024-11-13 04:18:08', 'boa tarde\r\n'),
(16, 12, 'text', '2024-11-13 08:20:03', 'olá mundo'),
(17, 13, 'text', '2024-11-13 08:30:14', 'olá mundo'),
(18, 3, 'text', '2024-11-16 20:26:42', 'fgsdfgh'),
(19, 3, 'text', '2024-11-16 20:26:46', 'sdfgsdfgsdfgdfcvgbd'),
(20, 3, 'text', '2024-11-16 20:26:48', 'sdfgsdfgsdfgds');

-- --------------------------------------------------------

--
-- Estrutura para tabela `userrelations`
--

CREATE TABLE `userrelations` (
  `id` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `userrelations`
--

INSERT INTO `userrelations` (`id`, `user_from`, `user_to`) VALUES
(2, 5, 4),
(3, 5, 3),
(4, 7, 3),
(22, 3, 7),
(23, 3, 8),
(24, 12, 3),
(25, 3, 12),
(26, 13, 3),
(27, 3, 13);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `work` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `birthdate`, `city`, `work`, `avatar`, `cover`, `token`) VALUES
(2, 'asdad@gmail.com', '$2y$10$MSlSUzwVinp7AOSE7ErsS./Dt9Byez0H0eeeRo5Jyr/1Xl3qBbCKO', 'flavyson felipe', '2003-10-13', NULL, NULL, 'default.png', 'cover.jpg', '0d4cec9a682e5c05da8ab9664dbd5b4e'),
(3, 'flavyson@gmail.com', '$2y$10$5aAkRsILTqUcvtNdeDsCDuXKhvr/3cY2QjOxOTpOE9FJAQsV7mTRe', 'Flavyson Felipe', '2003-10-13', 'Recife, Pernambuco', 'engenheiro de software', '78b21c6e1c9bba05b8240baad22fac90', '6342379ae48098ceb43c1f37f8ca8bbc', 'fb8667a734950a70076818eff93e9eea'),
(4, 'carlos@gmail.com', '$2y$10$VEQCvSOVDd59pnaa5ZurfueNwsC8vofmk3q1ZFVp1pFFoG9mUdmBe', 'carlos vieira', '2000-02-12', NULL, NULL, 'default.png', 'cover.jpg', 'bda272925d94014ad1b77bd944d53724'),
(5, 'erick@gmail.com', '$2y$10$XxRCQAK/.PUB3lS4oCiuheRMGer2NfTyI67tYRj3CpnIXyXfnc5GG', 'Erick', '2003-10-13', NULL, NULL, 'default.png', 'cover.jpg', '5fb63f387cb2dfd312ae0f7a75a5c8ab'),
(6, '123123@gmail.com', '$2y$10$p94FcwXaOWc91dQzW3KQQe163Kmaz1S5NQptz8nlcQRolcfRYknjK', 'Pdfan', '2000-02-12', NULL, NULL, 'default.png', 'cover.jpg', 'd13e24b2177f90f6acaf4ff33a5ad69e'),
(7, 'guitarra@gmail.com', '$2y$10$ixKSQYJlTQvMtsZp96.04u2N5WNiQLd1x3n7WWYcTpUj7eCY6n3MS', 'Michael Guitarrista', '2003-10-13', 'Recife', 'Freelancer', '6ccba62d66ba6ac4dcd1a980e972a507', '2d535196a79ffcf651397c89efc55d8a', '1e9bee7511ec2d1001fb749b5b4ab5a5'),
(8, 'maryana@gmail.com', '$2y$10$LOYMt3Dh0WFzUKybDrYdi.z9arFrJCZvioCHyD097vK/EAufVco0K', 'Maryana', '2003-10-13', 'salgado de São felix', '', '76b1bb9247360a320613343a44cd28e9', '9f90bedc2b19d0e0b6bd2e3037500d16', 'be7e8f3c921a24c9c13f35b0f5bca000'),
(9, 'teste@gmail.com', '$2y$10$dm7489D0klPYawpB19d0Y.SOICMywdBEqFHz2Go8RzIxXRdOOid/e', 'teste', '2003-10-13', NULL, NULL, 'default.png', 'cover.jpg', '6fb5f6b217e1d102ac917dd3b4e0c47e'),
(10, 'teste22@gmail.com', '$2y$10$xpw5BSSnwtE734HTjLjzRuVJokPbcA95kviIKeWBs3kvtc8Xj5j0G', 'Teste Da Silva', '2012-12-12', 'São Paulo - SP', 'engenheiro de software', '9405096276245a07ca450192987b8394', '4cd1e85848d4d1f814fa33a74b58f874', 'eb23e358bb9f31fd3be4d050b73983ef'),
(11, 'flavysonFelipe314@gmail.com', '$2y$10$WISMCzU3f9Cz46j/iT4qzuhjqV8fcpioE1hcPhTOVzJp9ccXikwO2', 'Flavyson Felipe ', '2003-10-13', NULL, NULL, 'default.png', 'cover.jpg', '399186cbf69a954055f1093c4dfb3db3'),
(12, 'usuario@gmail.com', '$2y$10$92lWqJaWwipp8meT7Fun2ea4UaEdTfMynAJlUVrN5gQoeMfsenl8G', 'Usuario1', '2004-10-13', 'recife', 'programador', 'a2e269ef8cb9096dff405edaf4282324', 'f5ceebab6428f1c939fdeb96bd406f4e', '6ab0342429320d6d77218ad56b6c97c6'),
(13, 'userteste@gmail.com', '$2y$10$YOoKtRSNtrAjDFD2WZeTHuu1/hs8IjRAYj.6X.izxhU2Wrw2Vm9Ci', 'Usuario Teste', '2003-10-13', 'recife', 'programador', 'dbabc82e1846d47be4bb7f1d426a4d0e', 'f06732eccc3548b65f05e34412fbf1f1', '3503b3bcf0f49974a348fcf3f97f1ce9');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `postcomments`
--
ALTER TABLE `postcomments`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `postlikes`
--
ALTER TABLE `postlikes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `userrelations`
--
ALTER TABLE `userrelations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `postlikes`
--
ALTER TABLE `postlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `userrelations`
--
ALTER TABLE `userrelations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
