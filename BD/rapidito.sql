
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: rapidito
-- ------------------------------------------------------
-- Server version	5.6.16

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
-- Table structure for table `aperturas`
--

DROP TABLE IF EXISTS `aperturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aperturas` (
  `idapertura` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_apertura` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `monto_apertura` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `monto_cierre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cajas_idcaja` int(11) NOT NULL,
  `usuarios_idusuario` int(11) NOT NULL,
  `billetaje_hist_idbilletaje` int(11) DEFAULT NULL,
  PRIMARY KEY (`idapertura`),
  KEY `fk_aperturas_cajas1_idx` (`cajas_idcaja`),
  KEY `fk_aperturas_usuarios1_idx` (`usuarios_idusuario`),
  KEY `fk_aperturas_billetaje_hist1_idx` (`billetaje_hist_idbilletaje`),
  CONSTRAINT `fk_aperturas_billetaje_hist1` FOREIGN KEY (`billetaje_hist_idbilletaje`) REFERENCES `billetaje_hist` (`idbilletaje`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_aperturas_cajas1` FOREIGN KEY (`cajas_idcaja`) REFERENCES `cajas` (`idcaja`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_aperturas_usuarios1` FOREIGN KEY (`usuarios_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `aprobaciones`
--

DROP TABLE IF EXISTS `aprobaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aprobaciones` (
  `idaprobacion` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_reg` datetime NOT NULL,
  `fecha_mod` datetime DEFAULT NULL,
  `fecha_aprob` datetime DEFAULT NULL,
  `creditos_idcredito` int(11) NOT NULL,
  `usuarios_idusuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idaprobacion`),
  KEY `fk_aprobaciones_creditos1_idx` (`creditos_idcredito`),
  KEY `fk_aprobaciones_usuarios1_idx` (`usuarios_idusuario`),
  CONSTRAINT `fk_aprobaciones_creditos1` FOREIGN KEY (`creditos_idcredito`) REFERENCES `creditos` (`idcredito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_aprobaciones_usuarios1` FOREIGN KEY (`usuarios_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `aval`
--

DROP TABLE IF EXISTS `aval`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aval` (
  `idconyugue` int(11) NOT NULL AUTO_INCREMENT,
  `apellido_pat` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_mat` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `dni` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `sexo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nacimiento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `referencia` varchar(85) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ocupacion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `dir_trabajo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `parentesco` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `habilitado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `clientes_idcliente` int(11) NOT NULL,
  PRIMARY KEY (`idconyugue`),
  KEY `fk_aval_clientes1_idx` (`clientes_idcliente`),
  CONSTRAINT `fk_aval_clientes1` FOREIGN KEY (`clientes_idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `billetaje`
--

DROP TABLE IF EXISTS `billetaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `billetaje` (
  `idbilletaje` int(11) NOT NULL AUTO_INCREMENT,
  `cant_200` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_100` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_50` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_20` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_10` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_5` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_2` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_1` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_0_5` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_0_2` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_0_1` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idbilletaje`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `billetaje_hist`
--

DROP TABLE IF EXISTS `billetaje_hist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `billetaje_hist` (
  `idbilletaje` int(11) NOT NULL AUTO_INCREMENT,
  `cant_200` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_100` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_50` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_20` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_10` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_5` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_2` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_1` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_0_5` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_0_2` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_0_1` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idbilletaje`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cajas`
--

DROP TABLE IF EXISTS `cajas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cajas` (
  `idcaja` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `capital` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `billetaje_reg` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `usuarios_idusuario` int(11) NOT NULL,
  `billetaje_idbilletaje` int(11) DEFAULT NULL,
  PRIMARY KEY (`idcaja`),
  KEY `fk_cajas_usuarios1_idx` (`usuarios_idusuario`),
  KEY `fk_cajas_billetaje1_idx` (`billetaje_idbilletaje`),
  CONSTRAINT `fk_cajas_billetaje1` FOREIGN KEY (`billetaje_idbilletaje`) REFERENCES `billetaje` (`idbilletaje`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cajas_usuarios1` FOREIGN KEY (`usuarios_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_pat` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_mat` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nacimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `hijos` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `grado_ins` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado_civ` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lugar_nac` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `referencia` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_viv` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `distrito` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `provincia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `tiempo_viv` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `comentario` text COLLATE utf8_spanish_ci,
  `url_foto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `url_domicilio` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `inscripcion` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `calificacion` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ocupacion_tipo` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `ocupacion_des` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
  `habilitado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `observaciones` text COLLATE utf8_spanish_ci,
  PRIMARY KEY (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `consumo`
--

DROP TABLE IF EXISTS `consumo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consumo` (
  `idconsumo` int(11) NOT NULL AUTO_INCREMENT,
  `dedicacion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `tiempo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ingreso` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `lugar_trabajo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `profesion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `clientes_idcliente` int(11) NOT NULL,
  PRIMARY KEY (`idconsumo`),
  KEY `fk_consumo_clientes1_idx` (`clientes_idcliente`),
  CONSTRAINT `fk_consumo_clientes1` FOREIGN KEY (`clientes_idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conyugue`
--

DROP TABLE IF EXISTS `conyugue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conyugue` (
  `idconyugue` int(11) NOT NULL AUTO_INCREMENT,
  `apellido_pat` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_mat` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `dni` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `sexo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nacimiento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `referencia` varchar(85) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ocupacion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `dir_trabajo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `parentesco` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `habilitado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `clientes_idcliente` int(11) NOT NULL,
  PRIMARY KEY (`idconyugue`),
  KEY `fk_conyugue_clientes1_idx` (`clientes_idcliente`),
  CONSTRAINT `fk_conyugue_clientes1` FOREIGN KEY (`clientes_idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `creditos`
--

DROP TABLE IF EXISTS `creditos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `creditos` (
  `idcredito` int(11) NOT NULL AUTO_INCREMENT,
  `nro_credito` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `monto_prop` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `monto_aprob` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `n_cuotas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `n_cuotas_aprob` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `interes` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `interes_aprob` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `frecuencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `m_cuotas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `m_cuotas_aprob` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `m_interes` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `m_interes_aprob` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `m_total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `m_total_aprob` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_reg` datetime NOT NULL,
  `estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `clientes_idcliente` int(11) NOT NULL,
  `conyugue_id` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `aval_id` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idcredito`),
  KEY `fk_creditos_clientes1_idx` (`clientes_idcliente`),
  CONSTRAINT `fk_creditos_clientes1` FOREIGN KEY (`clientes_idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cuenta_pf`
--

DROP TABLE IF EXISTS `cuenta_pf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuenta_pf` (
  `idcuenta` int(11) NOT NULL AUTO_INCREMENT,
  `monto_inicio` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `monto_fin` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `fecha_retiro` datetime DEFAULT NULL,
  `interes` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `clientes_idcliente` int(11) NOT NULL,
  `usuarios_idusuario` int(11) NOT NULL,
  PRIMARY KEY (`idcuenta`),
  KEY `fk_cuenta_corriente_clientes1_idx` (`clientes_idcliente`),
  KEY `fk_cuenta_corriente_usuarios1_idx` (`usuarios_idusuario`),
  CONSTRAINT `fk_cuenta_corriente_clientes1` FOREIGN KEY (`clientes_idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuenta_corriente_usuarios1` FOREIGN KEY (`usuarios_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `desembolso`
--

DROP TABLE IF EXISTS `desembolso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `desembolso` (
  `iddesembolso` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_reg` datetime NOT NULL,
  `fecha_desem` datetime DEFAULT NULL,
  `creditos_idcredito` int(11) NOT NULL,
  `usuarios_idusuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`iddesembolso`),
  KEY `fk_desembolso_creditos1_idx` (`creditos_idcredito`),
  KEY `fk_desembolso_usuarios1_idx` (`usuarios_idusuario`),
  CONSTRAINT `fk_desembolso_creditos1` FOREIGN KEY (`creditos_idcredito`) REFERENCES `creditos` (`idcredito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_desembolso_usuarios1` FOREIGN KEY (`usuarios_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `movimientos`
--

DROP TABLE IF EXISTS `movimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movimientos` (
  `idmovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `monto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `concepto` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_mov` datetime NOT NULL,
  `autoriza` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_comprobante` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nro_comprobante` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `detalle` text COLLATE utf8_spanish_ci,
  `cajas_idcaja` int(11) NOT NULL,
  `usuarios_idusuario` int(11) NOT NULL,
  `creditos_idcredito` int(11) DEFAULT NULL,
  PRIMARY KEY (`idmovimiento`),
  KEY `fk_movimientos_cajas1_idx` (`cajas_idcaja`),
  KEY `fk_movimientos_usuarios1_idx` (`usuarios_idusuario`),
  KEY `fk_movimientos_creditos1_idx` (`creditos_idcredito`),
  CONSTRAINT `fk_movimientos_cajas1` FOREIGN KEY (`cajas_idcaja`) REFERENCES `cajas` (`idcaja`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimientos_creditos1` FOREIGN KEY (`creditos_idcredito`) REFERENCES `creditos` (`idcredito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimientos_usuarios1` FOREIGN KEY (`usuarios_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `negocio`
--

DROP TABLE IF EXISTS `negocio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `negocio` (
  `idnegocio` int(11) NOT NULL AUTO_INCREMENT,
  `norm_tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `norm_tipo_local` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `norm_tipo_negocio` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `tiempo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `trans_tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `trans_placa` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `trans_empresa` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `trans_direccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `trans_soat` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `trans_soat_cad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `trans_tarjeta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `trans_tarjeta_cad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `url_croquis` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `clientes_idcliente` int(11) NOT NULL,
  PRIMARY KEY (`idnegocio`),
  KEY `fk_negocio_clientes1_idx` (`clientes_idcliente`),
  CONSTRAINT `fk_negocio_clientes1` FOREIGN KEY (`clientes_idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagos` (
  `idpago` int(11) NOT NULL AUTO_INCREMENT,
  `n_cuota_programada` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_programada` date NOT NULL,
  `cuota_programada` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `monto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `mora` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `creditos_idcredito` int(11) NOT NULL,
  `usuarios_idusuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpago`),
  KEY `fk_pagos_creditos1_idx` (`creditos_idcredito`),
  KEY `fk_pagos_usuarios1_idx` (`usuarios_idusuario`),
  CONSTRAINT `fk_pagos_creditos1` FOREIGN KEY (`creditos_idcredito`) REFERENCES `creditos` (`idcredito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pagos_usuarios1` FOREIGN KEY (`usuarios_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `solicitudes`
--

DROP TABLE IF EXISTS `solicitudes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitudes` (
  `idsolicitud` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_reg` datetime NOT NULL,
  `fecha_mod` datetime DEFAULT NULL,
  `fecha_pre` datetime DEFAULT NULL,
  `negocio_des` text COLLATE utf8_spanish_ci,
  `creditos_idcredito` int(11) NOT NULL,
  `usuarios_idusuario` int(11) NOT NULL,
  PRIMARY KEY (`idsolicitud`),
  KEY `fk_solicitudes_creditos1_idx` (`creditos_idcredito`),
  KEY `fk_solicitudes_usuarios1_idx` (`usuarios_idusuario`),
  CONSTRAINT `fk_solicitudes_creditos1` FOREIGN KEY (`creditos_idcredito`) REFERENCES `creditos` (`idcredito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitudes_usuarios1` FOREIGN KEY (`usuarios_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `transferencias`
--

DROP TABLE IF EXISTS `transferencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transferencias` (
  `idtransferencia` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `monto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `concepto` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_mov` datetime NOT NULL,
  `autoriza` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `detalle` text COLLATE utf8_spanish_ci,
  `usuarios_idusuario` int(11) NOT NULL,
  `cajas_idcaja` int(11) NOT NULL,
  `cajas_idcaja1` int(11) NOT NULL,
  `usuarios_idusuario1` int(11) NOT NULL,
  PRIMARY KEY (`idtransferencia`),
  KEY `fk_transferencias_usuarios1_idx` (`usuarios_idusuario`),
  KEY `fk_transferencias_cajas1_idx` (`cajas_idcaja`),
  KEY `fk_transferencias_cajas2_idx` (`cajas_idcaja1`),
  KEY `fk_transferencias_usuarios2_idx` (`usuarios_idusuario1`),
  CONSTRAINT `fk_transferencias_cajas1` FOREIGN KEY (`cajas_idcaja`) REFERENCES `cajas` (`idcaja`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transferencias_cajas2` FOREIGN KEY (`cajas_idcaja1`) REFERENCES `cajas` (`idcaja`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transferencias_usuarios1` FOREIGN KEY (`usuarios_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transferencias_usuarios2` FOREIGN KEY (`usuarios_idusuario1`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `privilegios` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_pat` varchar(55) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_mat` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(55) COLLATE utf8_spanish_ci NOT NULL,
  `doc_nro` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nacimiento` date DEFAULT NULL,
  `grado` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado_civil` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lugar_nacimiento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `comentarios` text COLLATE utf8_spanish_ci,
  `telefono` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(55) COLLATE utf8_spanish_ci NOT NULL,
  `referencia` varchar(55) COLLATE utf8_spanish_ci DEFAULT NULL,
  `distrito` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `provincia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(55) COLLATE utf8_spanish_ci DEFAULT NULL,
  `url_foto` varchar(55) COLLATE utf8_spanish_ci DEFAULT NULL,
  `habilitado` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `voucher_pago`
--

DROP TABLE IF EXISTS `voucher_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voucher_pago` (
  `idvoucher` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_vp` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `monto_pago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_pago` datetime NOT NULL,
  `creditos_idcredito` int(11) NOT NULL,
  `usuarios_idusuario` int(11) NOT NULL,
  PRIMARY KEY (`idvoucher`),
  KEY `fk_voucher_pago_creditos1_idx` (`creditos_idcredito`),
  KEY `fk_voucher_pago_usuarios1_idx` (`usuarios_idusuario`),
  CONSTRAINT `fk_voucher_pago_creditos1` FOREIGN KEY (`creditos_idcredito`) REFERENCES `creditos` (`idcredito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_voucher_pago_usuarios1` FOREIGN KEY (`usuarios_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-01  4:52:49
