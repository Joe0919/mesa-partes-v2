-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;--
-- Create schema db_mesapartes
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ db_mesapartes;
USE db_mesapartes;

--
-- Table structure for table `db_mesapartes`.`area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `idarea` int(11) NOT NULL AUTO_INCREMENT,
  `cod_area` varchar(15) NOT NULL,
  `area` varchar(200) NOT NULL DEFAULT '',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`idarea`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_mesapartes`.`area`
--

/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` (`idarea`,`cod_area`,`area`,`deleted`) VALUES 
 (1,'A0001','DIRECCION GRAL',0),
 (2,'A0002','SECRETARIA GRAL',0),
 (3,'A0003','TECNOLOGIA DE LA INFORMACION (TI)',0);
/*!40000 ALTER TABLE `area` ENABLE KEYS */;--
-- Table structure for table `db_mesapartes`.`areainstitu`
--

DROP TABLE IF EXISTS `areainstitu`;
CREATE TABLE `areainstitu` (
  `idareainstitu` int(11) NOT NULL AUTO_INCREMENT,
  `idinstitucion` int(11) NOT NULL,
  `idarea` int(11) NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`idareainstitu`),
  KEY `idinstitucion` (`idinstitucion`),
  KEY `idarea` (`idarea`),
  CONSTRAINT `areainstitu_ibfk_1` FOREIGN KEY (`idinstitucion`) REFERENCES `institucion` (`idinstitucion`),
  CONSTRAINT `areainstitu_ibfk_2` FOREIGN KEY (`idarea`) REFERENCES `area` (`idarea`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_mesapartes`.`areainstitu`
--

/*!40000 ALTER TABLE `areainstitu` DISABLE KEYS */;
INSERT INTO `areainstitu` (`idareainstitu`,`idinstitucion`,`idarea`,`deleted`) VALUES 
 (1,1,1,0),
 (2,1,2,0),
 (3,1,3,0);
/*!40000 ALTER TABLE `areainstitu` ENABLE KEYS */;--
-- Table structure for table `db_mesapartes`.`derivacion`
--

DROP TABLE IF EXISTS `derivacion`;
CREATE TABLE `derivacion` (
  `idderivacion` int(11) NOT NULL AUTO_INCREMENT,
  `fechad` datetime NOT NULL,
  `origen` varchar(100) NOT NULL,
  `idareainstitu` int(11) NOT NULL,
  `iddocumento` int(11) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`idderivacion`),
  KEY `idareainstitu` (`idareainstitu`),
  KEY `iddocumento` (`iddocumento`),
  CONSTRAINT `derivacion_ibfk_1` FOREIGN KEY (`idareainstitu`) REFERENCES `areainstitu` (`idareainstitu`),
  CONSTRAINT `derivacion_ibfk_2` FOREIGN KEY (`iddocumento`) REFERENCES `documento` (`iddocumento`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Table structure for table `db_mesapartes`.`documento`
--

DROP TABLE IF EXISTS `documento`;
CREATE TABLE `documento` (
  `iddocumento` int(11) NOT NULL AUTO_INCREMENT,
  `nro_expediente` varchar(10) NOT NULL,
  `nro_doc` varchar(10) NOT NULL,
  `folios` int(11) NOT NULL DEFAULT 0,
  `asunto` varchar(500) NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT '',
  `archivo` text NOT NULL,
  `idpersona` int(11) NOT NULL,
  `idtipodoc` int(11) NOT NULL,
  `idubicacion` int(11) NOT NULL DEFAULT 0,
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `fecha_registro` datetime DEFAULT NULL,
  PRIMARY KEY (`iddocumento`),
  KEY `idpersona` (`idpersona`),
  KEY `idtipodoc` (`idtipodoc`),
  CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`),
  CONSTRAINT `documento_ibfk_2` FOREIGN KEY (`idtipodoc`) REFERENCES `tipodoc` (`idtipodoc`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;--
-- Table structure for table `db_mesapartes`.`empleado`
--

DROP TABLE IF EXISTS `empleado`;
CREATE TABLE `empleado` (
  `idempleado` int(11) NOT NULL AUTO_INCREMENT,
  `cod_empleado` varchar(15) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `idareainstitu` int(11) NOT NULL DEFAULT 0,
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`idempleado`),
  KEY `idpersona` (`idpersona`),
  KEY `idareainstitu` (`idareainstitu`),
  CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`),
  CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`idareainstitu`) REFERENCES `areainstitu` (`idareainstitu`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_mesapartes`.`empleado`
--

/*!40000 ALTER TABLE `empleado` DISABLE KEYS */;
INSERT INTO `empleado` (`idempleado`,`cod_empleado`,`idpersona`,`idareainstitu`,`deleted`) VALUES 
 (1,'E00001',1,3,0);
/*!40000 ALTER TABLE `empleado` ENABLE KEYS */;--
-- Table structure for table `db_mesapartes`.`historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE `historial` (
  `idhistorial` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `expediente` varchar(6) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `accion` varchar(100) NOT NULL DEFAULT '',
  `area` varchar(200) NOT NULL,
  `descrip` varchar(500) DEFAULT NULL,
  `idusuario` int(11) NOT NULL,
  `dni_usuario` varchar(8) DEFAULT NULL,
  `usuario` varchar(200) DEFAULT NULL,
  `rol` varchar(100) DEFAULT NULL,
  `area_usuario` varchar(200) DEFAULT NULL,
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`idhistorial`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `db_mesapartes`.`institucion`
--

DROP TABLE IF EXISTS `institucion`;
CREATE TABLE `institucion` (
  `idinstitucion` int(11) NOT NULL AUTO_INCREMENT,
  `ruc` varchar(15) NOT NULL,
  `razon` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL DEFAULT '',
  `telefono` varchar(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `web` varchar(50) DEFAULT NULL,
  `sector` varchar(100) DEFAULT NULL,
  `logo` text NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`idinstitucion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_mesapartes`.`institucion`
--

/*!40000 ALTER TABLE `institucion` DISABLE KEYS */;
INSERT INTO `institucion` (`idinstitucion`,`ruc`,`razon`,`direccion`,`telefono`,`email`,`web`,`sector`,`logo`,`deleted`) VALUES 
 (1,'20987654321','TRAMITADOC','AV. LOS ALISOS MZ13 LT4 - ANCASH','999999999','virtualiza@gmail.com','virtualiza.com','DOCUMENTARIO','files/logo/logo1_20987654321_20241029.png',0);
/*!40000 ALTER TABLE `institucion` ENABLE KEYS */;--
-- Table structure for table `db_mesapartes`.`modulo`
--

DROP TABLE IF EXISTS `modulo`;
CREATE TABLE `modulo` (
  `idmodulo` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`idmodulo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_mesapartes`.`modulo`
--

/*!40000 ALTER TABLE `modulo` DISABLE KEYS */;
INSERT INTO `modulo` (`idmodulo`,`titulo`,`descripcion`,`estado`) VALUES 
 (1,'Dashboard','Dashboard Principal del sistema',1),
 (2,'Usuarios','Gestion de Usuarios del sistema',1),
 (3,'Roles','Gestion de Roles del sistema',1),
 (4,'Áreas','Gestion de Areas del sistema',1),
 (5,'Empleados','Gestión de Empleados del sistema',1),
 (6,'Trámites','Vista de Tramites del sistema',1),
 (7,'Nuevo Trámite','Registro de nuevo Tramite al sistema',1),
 (8,'Trámites Recibidos','Gestion trámites recibidos del área perteneciente',1),
 (9,'Trámites Enviados','Vista de trámites enviados desde el área perteneciente',1),
 (10,'Búsqueda','Busqueda de tramite en el sistema',1),
 (11,'Informes','Generar Informes del sistema',1);
/*!40000 ALTER TABLE `modulo` ENABLE KEYS */;--
-- Table structure for table `db_mesapartes`.`permiso`
--

DROP TABLE IF EXISTS `permiso`;
CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL AUTO_INCREMENT,
  `idroles` int(11) NOT NULL,
  `idmodulo` int(11) NOT NULL,
  `cre` tinyint(1) NOT NULL DEFAULT 0,
  `rea` tinyint(1) NOT NULL DEFAULT 0,
  `upd` tinyint(1) NOT NULL DEFAULT 0,
  `del` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idpermiso`),
  KEY `FK_permiso_1` (`idroles`),
  KEY `FK_permiso_2` (`idmodulo`),
  CONSTRAINT `FK_permiso_1` FOREIGN KEY (`idroles`) REFERENCES `roles` (`idroles`),
  CONSTRAINT `FK_permiso_2` FOREIGN KEY (`idmodulo`) REFERENCES `modulo` (`idmodulo`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_mesapartes`.`permiso`
--

/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
INSERT INTO `permiso` (`idpermiso`,`idroles`,`idmodulo`,`cre`,`rea`,`upd`,`del`) VALUES 
 (1,1,1,1,1,1,1),
 (2,1,2,1,1,1,1),
 (3,1,3,1,1,1,1),
 (4,1,4,1,1,1,1),
 (5,1,5,1,1,1,1),
 (6,1,6,1,1,1,1),
 (7,1,7,1,1,1,1),
 (8,1,8,1,1,1,1),
 (9,1,9,1,1,1,1),
 (10,1,10,1,1,1,1),
 (11,1,11,1,1,1,1),
 (12,2,1,1,1,1,1),
 (13,2,2,0,1,0,0),
 (14,2,3,0,1,0,0),
 (15,2,4,0,1,0,0),
 (16,2,5,0,1,0,0),
 (17,2,6,0,1,0,0),
 (18,2,7,0,1,0,0),
 (19,2,8,0,1,0,0),
 (20,2,9,0,1,0,0),
 (21,2,10,0,1,0,0),
 (22,2,11,0,1,0,0),
 (23,3,1,1,1,1,1),
 (24,3,2,0,0,0,0),
 (25,3,3,0,0,0,0),
 (26,3,4,0,0,0,0),
 (27,3,5,0,0,0,0),
 (28,3,6,0,0,0,0),
 (29,3,7,1,1,1,1),
 (30,3,8,1,1,1,1),
 (31,3,9,1,1,1,1),
 (32,3,10,1,1,1,1),
 (33,3,11,0,0,0,0),
 (34,4,1,0,1,0,0),
 (35,4,2,0,1,0,0),
 (36,4,3,0,0,0,0),
 (37,4,4,0,1,0,0),
 (38,4,5,0,1,0,0),
 (39,4,6,0,1,0,0),
 (40,4,7,0,1,0,0),
 (41,4,8,0,0,0,0),
 (42,4,9,0,0,0,0),
 (43,4,10,0,1,0,0),
 (44,4,11,0,1,0,0),
 (45,5,1,0,1,0,0),
 (46,5,2,0,1,0,0),
 (47,5,3,0,0,0,0),
 (48,5,4,0,1,0,0),
 (49,5,5,0,1,0,0);
INSERT INTO `permiso` (`idpermiso`,`idroles`,`idmodulo`,`cre`,`rea`,`upd`,`del`) VALUES 
 (50,5,6,0,1,0,0),
 (51,5,7,0,0,0,0),
 (52,5,8,0,0,0,0),
 (53,5,9,0,0,0,0),
 (54,5,10,0,1,0,0),
 (55,5,11,0,1,0,0),
 (56,6,1,1,1,1,1),
 (57,6,2,0,0,0,0),
 (58,6,3,0,0,0,0),
 (59,6,4,0,0,0,0),
 (60,6,5,0,0,0,0),
 (61,6,6,1,1,1,1),
 (62,6,7,0,0,0,0),
 (63,6,8,0,0,0,0),
 (64,6,9,0,0,0,0),
 (65,6,10,0,0,0,0),
 (66,6,11,0,0,0,0);
/*!40000 ALTER TABLE `permiso` ENABLE KEYS */;--
-- Table structure for table `db_mesapartes`.`persona`
--

DROP TABLE IF EXISTS `persona`;
CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(8) NOT NULL,
  `ap_paterno` varchar(100) NOT NULL,
  `ap_materno` varchar(100) NOT NULL,
  `nombres` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `telefono` int(9) unsigned NOT NULL DEFAULT 0,
  `direccion` varchar(100) NOT NULL,
  `ruc_institu` varchar(15) DEFAULT NULL,
  `institucion` varchar(200) DEFAULT NULL,
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`idpersona`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_mesapartes`.`persona`
--

/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` (`idpersona`,`dni`,`ap_paterno`,`ap_materno`,`nombres`,`email`,`telefono`,`direccion`,`ruc_institu`,`institucion`,`deleted`) VALUES 
 (1,'12345678','GONZALES','PRADA','JAVIER','admin@gmail.com',999999900,'PERU',NULL,NULL,0);
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;--
-- Table structure for table `db_mesapartes`.`roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `idroles` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `estado` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`idroles`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_mesapartes`.`roles`
--

/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`idroles`,`rol`,`descripcion`,`estado`,`deleted`) VALUES 
 (1,'ADMINISTRADOR','TODOS LOS MODULOS',1,0),
 (2,'ASISTENTE','RECEPCIONA Y DERIVA',1,0),
 (3,'AUXILIAR','GESTION DE DOCUMENTOS',1,0),
 (4,'SUPERVISOR','SUPERVISAR PROCESOS',1,0),
 (5,'INVITADO','VER INFORMACION DEL SISTEMA',1,0),
 (6,'COORDINADOR','ANALIZAR LOS INFORMES',1,0);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;--
-- Table structure for table `db_mesapartes`.`tipodoc`
--

DROP TABLE IF EXISTS `tipodoc`;
CREATE TABLE `tipodoc` (
  `idtipodoc` int(11) NOT NULL AUTO_INCREMENT,
  `tipodoc` varchar(50) NOT NULL,
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`idtipodoc`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_mesapartes`.`tipodoc`
--

/*!40000 ALTER TABLE `tipodoc` DISABLE KEYS */;
INSERT INTO `tipodoc` (`idtipodoc`,`tipodoc`,`deleted`) VALUES 
 (1,'OFICIO',0),
 (2,'OFICIO MULTIPLE',0),
 (3,'MEMORANDUM',0),
 (4,'SOLICITUD',0),
 (5,'INFORME',0);
/*!40000 ALTER TABLE `tipodoc` ENABLE KEYS */;--
-- Table structure for table `db_mesapartes`.`usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idusuarios` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `dni` varchar(8) NOT NULL DEFAULT '',
  `contrasena` varchar(100) NOT NULL DEFAULT '',
  `fecharegistro` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `ultacceso` datetime DEFAULT NULL,
  `fechaedicion` datetime NOT NULL,
  `estado` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `foto` text DEFAULT NULL,
  `idroles` int(11) NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`idusuarios`),
  KEY `idroles` (`idroles`),
  CONSTRAINT `FK_usuarios_1` FOREIGN KEY (`idroles`) REFERENCES `roles` (`idroles`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_mesapartes`.`usuarios`
--

/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`idusuarios`,`nombre`,`dni`,`contrasena`,`fecharegistro`,`ultacceso`,`fechaedicion`,`estado`,`foto`,`idroles`,`deleted`) VALUES 
 (1,'JavierGP78','12345678','$2y$10$7c2.tsXblMuxNHK8T5vT0.yjdpE5koySOvcetpl7Egt3hZJ7J3H5.','2024-12-02 19:36:46','2024-12-02 20:28:01','2024-12-02 19:36:58',1,'files/images/0/user.png',1,0);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;--
-- View structure for view `db_mesapartes`.`docs_procesados_fecha`
--

DROP VIEW IF EXISTS `docs_procesados_fecha`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `db_mesapartes`.`docs_procesados_fecha` AS select date_format(`h`.`fecha`,'%d/%m/%Y') AS `fecha`,count(distinct `h`.`expediente`) AS `cantidad` from `db_mesapartes`.`historial` `h` where `h`.`idhistorial` > (select min(`h2`.`idhistorial`) from `db_mesapartes`.`historial` `h2` where `h2`.`expediente` = `h`.`expediente`) group by cast(`h`.`fecha` as date) order by cast(`h`.`fecha` as date);--
-- View structure for view `db_mesapartes`.`ingreso_docs_fecha`
--

DROP VIEW IF EXISTS `ingreso_docs_fecha`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `db_mesapartes`.`ingreso_docs_fecha` AS select date_format(`db_mesapartes`.`documento`.`fecha_registro`,'%d/%m/%Y') AS `fecha`,count(0) AS `cantidad` from `db_mesapartes`.`documento` group by cast(`db_mesapartes`.`documento`.`fecha_registro` as date) order by cast(`db_mesapartes`.`documento`.`fecha_registro` as date);--
-- View structure for view `db_mesapartes`.`ranking_docs_area`
--

DROP VIEW IF EXISTS `ranking_docs_area`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `db_mesapartes`.`ranking_docs_area` AS select `a`.`area` AS `area`,count(`d`.`idubicacion`) AS `total_documentos` from ((`db_mesapartes`.`documento` `d` join `db_mesapartes`.`areainstitu` `ae` on(`ae`.`idareainstitu` = `d`.`idubicacion`)) join `db_mesapartes`.`area` `a` on(`a`.`idarea` = `ae`.`idarea`)) group by `ae`.`idareainstitu` order by count(`d`.`idubicacion`) desc;--
-- Function `db_mesapartes`.`gen_cod_area`
--

DROP FUNCTION IF EXISTS `gen_cod_area`;
DELIMITER $$

CREATE FUNCTION `gen_cod_area`(caracter varchar(3), longitud int) RETURNS varchar(10) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
Begin

  declare con int default 0;

  declare cadena varchar(6) default '';

	set con=(select max(idarea) from area);

  if(con is null) then
    set cadena=CONCAT(caracter, RIGHT(CONCAT('000001'),longitud));
  else
    SET cadena = CONCAT(caracter, RIGHT(CONCAT('00000', (con + 1)),longitud));
  end if;
Return cadena;

End $$

DELIMITER ;

--
-- Function `db_mesapartes`.`gen_cod_empleado`
--

DROP FUNCTION IF EXISTS `gen_cod_empleado`;
DELIMITER $$

CREATE FUNCTION `gen_cod_empleado`(caracter varchar(3), longitud int) RETURNS varchar(10) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
Begin
  declare con int default 0;
  declare cadena varchar(6) default '';
	set con=(select max(idempleado) from empleado);
  if(con is null) then
    set cadena= CONCAT(caracter, RIGHT(CONCAT('000001'),longitud));
  else
    SET cadena = CONCAT(caracter, RIGHT(CONCAT('00000', (con + 1)),longitud));
  end if;
Return cadena;

End $$

DELIMITER ;

--
-- Function `db_mesapartes`.`gen_nroexpediente`
--

DROP FUNCTION IF EXISTS `gen_nroexpediente`;
DELIMITER $$

CREATE FUNCTION `gen_nroexpediente`() RETURNS varchar(6) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
Begin
  declare con int default 0;
  declare cadena varchar(6) default '';
	set con=(select max(iddocumento) from documento);
  if(con is null) then
    set cadena='000001';
  else
    SET cadena = RIGHT(CONCAT('00000', (con + 1)),6);
  end if;
Return cadena;

End $$

DELIMITER ;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
