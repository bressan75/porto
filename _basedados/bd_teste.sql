# MySQL-Front 5.1  (Build 3.35)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;


# Host: localhost    Database: bd_teste
# ------------------------------------------------------
# Server version 5.5.5-10.4.13-MariaDB

USE `bd_teste`;

#
# Source for table clientes
#

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(70) DEFAULT NULL,
  `doc` varchar(20) DEFAULT NULL,
  `rg_ie` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `observacao` text DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `modificado` datetime DEFAULT NULL,
  `status` enum('Ativo','Inativo','Removido') DEFAULT 'Ativo',
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table clientes
#

INSERT INTO `clientes` VALUES (1,'Prefeitura de Indaiatuba','349001030001-20','248077855','(11) 98786-7766','prefeitura@gov.br','Rua Fábio Barbabé, 123','teste','2023-03-20 20:35:42','2023-03-20 20:36:41','Ativo',1);

#
# Source for table container
#

CREATE TABLE `container` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) DEFAULT NULL,
  `numero` varchar(11) DEFAULT NULL,
  `tipo` enum('20','40') DEFAULT NULL,
  `status_container` enum('Cheio','Vazio') DEFAULT NULL,
  `categoria` enum('Importação','Exportação') DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `modificado` datetime DEFAULT NULL,
  `status` enum('Ativo','Inativo','Removido') DEFAULT 'Ativo',
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table container
#

INSERT INTO `container` VALUES (1,1,'test1234567','20','Vazio','Importação','2023-03-20 20:41:08',NULL,'Ativo',1);
INSERT INTO `container` VALUES (2,1,'abcd9876543','40','Cheio','Exportação','2023-03-20 20:41:40',NULL,'Ativo',1);

#
# Source for table movimentacoes
#

CREATE TABLE `movimentacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `container` int(11) DEFAULT NULL,
  `tipo` enum('Embarque','Descarga','Gate In','Gate Out','Reposicionamento','Pesagem','Scanner') DEFAULT NULL,
  `datainicio` datetime DEFAULT NULL,
  `datafim` datetime DEFAULT NULL,
  `status` enum('Ativo','Inativo','Removido') DEFAULT 'Ativo',
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table movimentacoes
#

INSERT INTO `movimentacoes` VALUES (1,2,'Embarque','2023-03-20 20:45:00','2023-03-24 13:35:00','Ativo',1);
INSERT INTO `movimentacoes` VALUES (2,1,'Gate Out','2023-03-20 21:45:00','2023-03-30 23:45:00','Ativo',1);

#
# Source for table usuarios
#

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(70) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `login` varchar(20) DEFAULT NULL,
  `senha` varchar(20) DEFAULT NULL,
  `nivel` enum('Administrador','Operador','Tesoureiro') DEFAULT 'Operador',
  `foto` varchar(70) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `modificado` datetime DEFAULT NULL,
  `status` enum('Ativo','Inativo','Removido') DEFAULT 'Ativo',
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table usuarios
#

INSERT INTO `usuarios` VALUES (1,'Marcelo B.','19848199844','(11) 98786-7766','marcelo@bressan.ws','root','123','Administrador','sem-foto.jpg','2023-03-20 19:48:00',NULL,'Ativo',1);
INSERT INTO `usuarios` VALUES (2,'Erica Bressan','257.975.128-90','(11) 97574-1451','adm@divlumens.com.br','erica','123','Administrador','sem-foto.jpg','2023-03-20 20:28:41','2023-03-20 20:29:57','Ativo',1);

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
