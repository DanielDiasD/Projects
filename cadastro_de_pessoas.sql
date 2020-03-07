-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Mar-2020 às 20:09
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cadastro_de_pessoas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro`
--

CREATE TABLE `cadastro` (
  `codigo` int(11) NOT NULL,
  `tipo_de_pessoa` varchar(15) NOT NULL,
  `nome_fantasia` varchar(100) NOT NULL,
  `cpf_cnpj` varchar(18) NOT NULL,
  `razao` varchar(100) NOT NULL,
  `endereco` varchar(50) NOT NULL,
  `numero` varchar(3) NOT NULL,
  `complemento` varchar(5) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `municipio` varchar(50) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `e_mail` varchar(50) NOT NULL,
  `telefone` varchar(13) NOT NULL,
  `celular` varchar(14) NOT NULL,
  `cliente` tinyint(1) NOT NULL,
  `fornecedor` tinyint(1) NOT NULL,
  `funcionario` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cadastro`
--

INSERT INTO `cadastro` (`codigo`, `tipo_de_pessoa`, `nome_fantasia`, `cpf_cnpj`, `razao`, `endereco`, `numero`, `complemento`, `cep`, `municipio`, `uf`, `e_mail`, `telefone`, `celular`, `cliente`, `fornecedor`, `funcionario`) VALUES
(14, 'Pessoa Física', 'Daniel Dias Vieira', '999.999.999-99', '', 'Rua Barros Barreto', '123', '', '21032-140', 'Rio de Janeiro', 'RJ', 'danieu_dias@hotmail.com', '(21) 2573-011', '(21) 99825-748', 1, 0, 0),
(17, 'Pessoa Jurídica', 'akajsdla', '12.312.312', 'fadasfdasfas', 'asdasdass', '', '', '', '', '', '', '', '', 0, 0, 0),
(18, 'Pessoa Jurídica', 'TV/REDE/CANAIS/G2C+GLOBO SOMLIVRE GLOBO.COM GLOBOPLAY', '27.865.757/0001-02', 'GLOBO COMUNICACAO E PARTICIPACOES S/A', 'R LOPES QUINTAS', '123', '', '22.460-901', 'RIO DE JANEIRO', 'RJ', '', '(21) 2155-455', '(12) 31231-231', 0, 1, 0),
(19, 'Pessoa Física', 'Kessy Jhones', '999.999.999-99', '', 'Rua General Izidoro Dias Lopes', '123', '', '09687-100', 'São Bernardo do Campo', 'SP', 'kessy@kessy.com.br', '(99) 9999-999', '(99) 99999-999', 1, 0, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cadastro`
--
ALTER TABLE `cadastro`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastro`
--
ALTER TABLE `cadastro`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
