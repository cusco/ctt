-- MySQL dump 10.13  Distrib 5.5.33, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: CTT
-- ------------------------------------------------------
-- Server version	5.5.33-1-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `codigosPostais`
--

DROP TABLE IF EXISTS `codigosPostais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `codigosPostais` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Codigo_Distrito` char(2) NOT NULL,
  `Codigo_Concelho` char(2) NOT NULL,
  `Codigo_Localidade` int(11) DEFAULT NULL,
  `LOCALIDADE` varchar(96) NOT NULL,
  `ART_COD` varchar(96) NOT NULL,
  `ART_TIPO` varchar(96) NOT NULL,
  `PRI_PREP` varchar(96) NOT NULL,
  `ART_TITULO` varchar(96) NOT NULL,
  `SEG_PREP` varchar(96) NOT NULL,
  `ART_DESIG` varchar(96) NOT NULL,
  `ART_LOCAL` varchar(96) NOT NULL,
  `TROCO` varchar(96) NOT NULL,
  `PORTA` varchar(96) NOT NULL,
  `CLIENTE` varchar(96) NOT NULL,
  `CP4` mediumint(9) NOT NULL,
  `CP3` char(3) NOT NULL,
  `CPALF` varchar(96) NOT NULL,
  `LATITUDE` double NOT NULL,
  `LONGITUDE` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Codigo_Distrito` (`Codigo_Distrito`),
  KEY `Codigo_Concelho` (`Codigo_Concelho`),
  KEY `Codigo_Localidade` (`Codigo_Localidade`),
  CONSTRAINT `codigosPostais_ibfk_1` FOREIGN KEY (`Codigo_Distrito`) REFERENCES `distritos` (`Codigo_Distrito`),
  CONSTRAINT `codigosPostais_ibfk_2` FOREIGN KEY (`Codigo_Concelho`) REFERENCES `concelhos` (`Codigo_Concelho`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `concelhos`
--

DROP TABLE IF EXISTS `concelhos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `concelhos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Codigo_Distrito` char(2) NOT NULL,
  `Codigo_Concelho` char(2) NOT NULL,
  `Designacao_Concelho` varchar(96) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Codigo_Distrito` (`Codigo_Distrito`),
  KEY `Codigo_Concelho` (`Codigo_Concelho`),
  CONSTRAINT `concelhos_ibfk_1` FOREIGN KEY (`Codigo_Distrito`) REFERENCES `distritos` (`Codigo_Distrito`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `distritos`
--

DROP TABLE IF EXISTS `distritos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distritos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Codigo_Distrito` char(2) NOT NULL,
  `Designacao_Distrito` varchar(96) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Codigo_Distrito` (`Codigo_Distrito`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-24 12:15:04
