-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 09-Dez-2019 às 13:50
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ferramenta`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluguel`
--

CREATE TABLE `aluguel` (
  `idAluguel` int(11) NOT NULL,
  `dataDevEfetiva` date DEFAULT NULL,
  `dataRetEfetiva` date DEFAULT NULL,
  `temSeguro` bit(1) DEFAULT NULL,
  `valorTotal` double DEFAULT NULL,
  `taxa` double DEFAULT NULL,
  `idMaquina` int(11) DEFAULT NULL,
  `idReserva` int(11) DEFAULT NULL,
  `idManutencao` int(11) DEFAULT NULL,
  `idOperador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) DEFAULT NULL,
  `telefone` char(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `idEndereco` int(11) NOT NULL,
  `CEP` char(8) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `bairro` varchar(200) DEFAULT NULL,
  `rua` varchar(200) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(200) DEFAULT NULL,
  `ehPrincipal` bit(1) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `filial`
--

CREATE TABLE `filial` (
  `idFilial` int(11) NOT NULL,
  `Telefone` char(11) DEFAULT NULL,
  `idEndereco` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `manutencao`
--

CREATE TABLE `manutencao` (
  `idManutencao` int(11) NOT NULL,
  `dataEntrada` date DEFAULT NULL,
  `dataSaida` date DEFAULT NULL,
  `custo` double DEFAULT NULL,
  `idMaquina` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `maquina`
--

CREATE TABLE `maquina` (
  `idMaquina` int(11) NOT NULL,
  `numeroSerie` varchar(10) DEFAULT NULL,
  `modelo` varchar(30) DEFAULT NULL,
  `fabricante` varchar(50) DEFAULT NULL,
  `idFilial` int(11) DEFAULT NULL,
  `idTipo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `operador`
--

CREATE TABLE `operador` (
  `idOperador` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `celular` char(11) DEFAULT NULL,
  `valorHora` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `operatipo`
--

CREATE TABLE `operatipo` (
  `idTipo` int(11) NOT NULL,
  `idOperador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `pessoafisica`
--

CREATE TABLE `pessoafisica` (
  `idCliente` int(11) NOT NULL,
  `CPF` char(11) DEFAULT NULL,
  `dataNascimento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `pessoajuridica`
--

CREATE TABLE `pessoajuridica` (
  `idCliente` int(11) NOT NULL,
  `CNPJ` char(15) DEFAULT NULL,
  `razaoSocial` varchar(100) DEFAULT NULL,
  `representante` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `reserva`
--

CREATE TABLE `reserva` (
  `idReserva` int(11) NOT NULL,
  `hora` time DEFAULT NULL,
  `dataRetirada` date DEFAULT NULL,
  `dataDevolucao` date DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idEndereco` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `reservatipo`
--

CREATE TABLE `reservatipo` (
  `idReserva` int(11) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `tipomaquina`
--

CREATE TABLE `tipomaquina` (
  `idTipo` int(11) NOT NULL,
  `valorAluguel` double DEFAULT NULL,
  `descricao` varchar(200) NOT NULL,
  `ramo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `aluguel`
--
ALTER TABLE `aluguel`
  ADD PRIMARY KEY (`idAluguel`),
  ADD KEY `idMaquina` (`idMaquina`),
  ADD KEY `idReserva` (`idReserva`),
  ADD KEY `idManutencao` (`idManutencao`),
  ADD KEY `idOperador` (`idOperador`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`idEndereco`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Indexes for table `filial`
--
ALTER TABLE `filial`
  ADD PRIMARY KEY (`idFilial`),
  ADD KEY `idEndereco` (`idEndereco`);

--
-- Indexes for table `manutencao`
--
ALTER TABLE `manutencao`
  ADD PRIMARY KEY (`idManutencao`),
  ADD KEY `idMaquina` (`idMaquina`);

--
-- Indexes for table `maquina`
--
ALTER TABLE `maquina`
  ADD PRIMARY KEY (`idMaquina`),
  ADD KEY `idFilial` (`idFilial`),
  ADD KEY `idTipo` (`idTipo`);

--
-- Indexes for table `operador`
--
ALTER TABLE `operador`
  ADD PRIMARY KEY (`idOperador`);

--
-- Indexes for table `operatipo`
--
ALTER TABLE `operatipo`
  ADD KEY `idOperador` (`idOperador`),
  ADD KEY `idTipo` (`idTipo`);

--
-- Indexes for table `pessoafisica`
--
ALTER TABLE `pessoafisica`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indexes for table `pessoajuridica`
--
ALTER TABLE `pessoajuridica`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indexes for table `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`idReserva`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idEndereco` (`idEndereco`);

--
-- Indexes for table `reservatipo`
--
ALTER TABLE `reservatipo`
  ADD PRIMARY KEY (`idReserva`,`idTipo`),
  ADD KEY `idTipo` (`idTipo`);

--
-- Indexes for table `tipomaquina`
--
ALTER TABLE `tipomaquina`
  ADD PRIMARY KEY (`idTipo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aluguel`
--
ALTER TABLE `aluguel`
  MODIFY `idAluguel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `idEndereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `filial`
--
ALTER TABLE `filial`
  MODIFY `idFilial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `manutencao`
--
ALTER TABLE `manutencao`
  MODIFY `idManutencao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `maquina`
--
ALTER TABLE `maquina`
  MODIFY `idMaquina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `operador`
--
ALTER TABLE `operador`
  MODIFY `idOperador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `reserva`
--
ALTER TABLE `reserva`
  MODIFY `idReserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `tipomaquina`
--
ALTER TABLE `tipomaquina`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `aluguel`
--
ALTER TABLE `aluguel`
  ADD CONSTRAINT `ALUGUEL_ibfk_1` FOREIGN KEY (`idMaquina`) REFERENCES `maquina` (`idMaquina`),
  ADD CONSTRAINT `ALUGUEL_ibfk_2` FOREIGN KEY (`idReserva`) REFERENCES `reserva` (`idReserva`),
  ADD CONSTRAINT `ALUGUEL_ibfk_3` FOREIGN KEY (`idManutencao`) REFERENCES `manutencao` (`idManutencao`),
  ADD CONSTRAINT `ALUGUEL_ibfk_4` FOREIGN KEY (`idOperador`) REFERENCES `operador` (`idOperador`);

--
-- Limitadores para a tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `ENDERECOS_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`id`);

--
-- Limitadores para a tabela `filial`
--
ALTER TABLE `filial`
  ADD CONSTRAINT `FILIAL_ibfk_1` FOREIGN KEY (`idEndereco`) REFERENCES `enderecos` (`idEndereco`);

--
-- Limitadores para a tabela `manutencao`
--
ALTER TABLE `manutencao`
  ADD CONSTRAINT `MANUTENCAO_ibfk_1` FOREIGN KEY (`idMaquina`) REFERENCES `maquina` (`idMaquina`);

--
-- Limitadores para a tabela `maquina`
--
ALTER TABLE `maquina`
  ADD CONSTRAINT `MAQUINA_ibfk_1` FOREIGN KEY (`idFilial`) REFERENCES `filial` (`idFilial`),
  ADD CONSTRAINT `MAQUINA_ibfk_2` FOREIGN KEY (`idTipo`) REFERENCES `tipomaquina` (`idTipo`);

--
-- Limitadores para a tabela `operatipo`
--
ALTER TABLE `operatipo`
  ADD CONSTRAINT `OPERATIPO_ibfk_1` FOREIGN KEY (`idTipo`) REFERENCES `tipomaquina` (`idTipo`),
  ADD CONSTRAINT `OPERATIPO_ibfk_2` FOREIGN KEY (`idOperador`) REFERENCES `operador` (`idOperador`),
  ADD CONSTRAINT `OPERATIPO_ibfk_3` FOREIGN KEY (`idTipo`) REFERENCES `tipomaquina` (`idTipo`),
  ADD CONSTRAINT `OPERATIPO_ibfk_4` FOREIGN KEY (`idOperador`) REFERENCES `operador` (`idOperador`);

--
-- Limitadores para a tabela `pessoafisica`
--
ALTER TABLE `pessoafisica`
  ADD CONSTRAINT `PESSOAFISICA_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`id`);

--
-- Limitadores para a tabela `pessoajuridica`
--
ALTER TABLE `pessoajuridica`
  ADD CONSTRAINT `PESSOAJURIDICA_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`id`);

--
-- Limitadores para a tabela `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `RESERVA_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `RESERVA_ibfk_2` FOREIGN KEY (`idEndereco`) REFERENCES `enderecos` (`idEndereco`);

--
-- Limitadores para a tabela `reservatipo`
--
ALTER TABLE `reservatipo`
  ADD CONSTRAINT `RESERVATIPO_ibfk_1` FOREIGN KEY (`idReserva`) REFERENCES `reserva` (`idReserva`),
  ADD CONSTRAINT `RESERVATIPO_ibfk_2` FOREIGN KEY (`idTipo`) REFERENCES `tipomaquina` (`idTipo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
