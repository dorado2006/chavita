/*
Navicat MySQL Data Transfer

Source Server         : sisacreditacion
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : negocio_cultural

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2014-07-21 19:35:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `acuerdos`
-- ----------------------------
DROP TABLE IF EXISTS `acuerdos`;
CREATE TABLE `acuerdos` (
  `idacuerdos` int(11) NOT NULL,
  `idproceso_cobro` int(11) NOT NULL,
  `acuerdos` varchar(100) DEFAULT NULL,
  `fecha_recordatorio` date DEFAULT NULL,
  `fecha_final` date DEFAULT NULL,
  PRIMARY KEY (`idacuerdos`,`idproceso_cobro`),
  KEY `acuerdos_fk1` (`idproceso_cobro`),
  CONSTRAINT `acuerdos_fk1` FOREIGN KEY (`idproceso_cobro`) REFERENCES `proceso_cobro` (`idproceso_cobro`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of acuerdos
-- ----------------------------

-- ----------------------------
-- Table structure for `categoria`
-- ----------------------------
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `categoria` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of categoria
-- ----------------------------
INSERT INTO `categoria` VALUES ('1', 'computo');
INSERT INTO `categoria` VALUES ('2', 'electronomestico');

-- ----------------------------
-- Table structure for `cliente`
-- ----------------------------
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `dir_actual` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `iddistrito` int(11) DEFAULT NULL,
  `idperfil_cliente` int(11) DEFAULT NULL,
  `primer_nombre` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `segundo_nombre` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido_p` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `apellido_m` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dni` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_hijos` decimal(2,0) DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado_civil` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sexo` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idconvenio` int(11) NOT NULL,
  PRIMARY KEY (`idcliente`,`idconvenio`),
  KEY `cliente_fk1` (`idperfil_cliente`),
  KEY `cliente_fk2` (`idconvenio`) USING BTREE,
  CONSTRAINT `cliente_fk1` FOREIGN KEY (`idperfil_cliente`) REFERENCES `perfil_cliente` (`idperfil_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of cliente
-- ----------------------------
INSERT INTO `cliente` VALUES ('1', 'jr:las lomas', '1', '1', 'juliana', 'tirsa', 'sandoval', '2014-07-10', '2014-03-20', 'zoto', '44319644', '4', 'dosil@gmail.com', 'c', 'f', '1');
INSERT INTO `cliente` VALUES ('2', 'jr:las tunas', '1', '1', 'pedro', 'corta', 'tuesta', '2014-07-10', '2014-07-09', 'mandarin', '7867888', '6', 'sot@hh', 'c', 'm', '2');

-- ----------------------------
-- Table structure for `codigos_cliente`
-- ----------------------------
DROP TABLE IF EXISTS `codigos_cliente`;
CREATE TABLE `codigos_cliente` (
  `idcliente` int(11) NOT NULL,
  `idnombres_codigos` int(11) NOT NULL,
  `codigo` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idcliente`,`idnombres_codigos`),
  KEY `codigo_clientes_fk2` (`idnombres_codigos`),
  CONSTRAINT `codigos_cliente_fk1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`),
  CONSTRAINT `codigo_clientes_fk2` FOREIGN KEY (`idnombres_codigos`) REFERENCES `nombre_codigos` (`idnombre_codigos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of codigos_cliente
-- ----------------------------

-- ----------------------------
-- Table structure for `comprob_pago`
-- ----------------------------
DROP TABLE IF EXISTS `comprob_pago`;
CREATE TABLE `comprob_pago` (
  `idcomprob_pago` int(11) NOT NULL,
  `descrip_comprob_pago` varchar(20) DEFAULT NULL,
  `simbolo` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`idcomprob_pago`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of comprob_pago
-- ----------------------------
INSERT INTO `comprob_pago` VALUES ('1', 'boleta', 'B');
INSERT INTO `comprob_pago` VALUES ('2', 'factura', 'F');
INSERT INTO `comprob_pago` VALUES ('3', 'vaucher', 'V');

-- ----------------------------
-- Table structure for `convenio`
-- ----------------------------
DROP TABLE IF EXISTS `convenio`;
CREATE TABLE `convenio` (
  `idconvenio` int(11) NOT NULL,
  `descripcion` varchar(40) DEFAULT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  `direccion` varchar(40) DEFAULT NULL,
  `telefono1` varchar(12) DEFAULT NULL,
  `telefono2` varchar(12) DEFAULT NULL,
  `iddistrito` int(11) DEFAULT NULL,
  `idpersonal` int(11) DEFAULT NULL,
  PRIMARY KEY (`idconvenio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of convenio
-- ----------------------------
INSERT INTO `convenio` VALUES ('1', 'ugel-tarapoto', '2014-07-11', 'jr:ramires hurtado 565', '3454', '766', '1', '1');
INSERT INTO `convenio` VALUES ('2', 'policia-tarapoto', '2014-07-10', 'jr:rioja 453', '5644390', '433', '1', '1');

-- ----------------------------
-- Table structure for `departamento`
-- ----------------------------
DROP TABLE IF EXISTS `departamento`;
CREATE TABLE `departamento` (
  `iddepartamento` int(11) NOT NULL,
  `departamento` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`iddepartamento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of departamento
-- ----------------------------

-- ----------------------------
-- Table structure for `descripcion_venta`
-- ----------------------------
DROP TABLE IF EXISTS `descripcion_venta`;
CREATE TABLE `descripcion_venta` (
  `idventa` int(11) NOT NULL,
  `idproductos` int(11) NOT NULL,
  `cantidad` decimal(10,0) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`idventa`,`idproductos`),
  KEY `descripcion_vanta_fk2` (`idproductos`),
  CONSTRAINT `descripcion_venta_fk1` FOREIGN KEY (`idproductos`) REFERENCES `productos` (`idproductos`),
  CONSTRAINT `descripcion_venta_fk2` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of descripcion_venta
-- ----------------------------
INSERT INTO `descripcion_venta` VALUES ('1', '1', '2', '3000.00');

-- ----------------------------
-- Table structure for `det_producto_entrada`
-- ----------------------------
DROP TABLE IF EXISTS `det_producto_entrada`;
CREATE TABLE `det_producto_entrada` (
  `identrada` int(11) NOT NULL,
  `idproductos` int(11) NOT NULL,
  `cantidad` decimal(10,0) DEFAULT NULL,
  `precio_compra` decimal(10,2) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`identrada`,`idproductos`),
  KEY `det_producto_entrada_fk2` (`idproductos`),
  CONSTRAINT `det_producto_entrada_fk1` FOREIGN KEY (`identrada`) REFERENCES `entrada` (`identrada`),
  CONSTRAINT `det_producto_entrada_fk2` FOREIGN KEY (`idproductos`) REFERENCES `productos` (`idproductos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of det_producto_entrada
-- ----------------------------

-- ----------------------------
-- Table structure for `det_producto_salida`
-- ----------------------------
DROP TABLE IF EXISTS `det_producto_salida`;
CREATE TABLE `det_producto_salida` (
  `idsalida` int(11) NOT NULL,
  `idproductos` int(11) NOT NULL,
  `cantidad` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`idsalida`,`idproductos`),
  KEY `det_roducto_salida` (`idproductos`),
  CONSTRAINT `det_producto_salida` FOREIGN KEY (`idsalida`) REFERENCES `salida` (`insalida`),
  CONSTRAINT `det_roducto_salida` FOREIGN KEY (`idproductos`) REFERENCES `productos` (`idproductos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of det_producto_salida
-- ----------------------------

-- ----------------------------
-- Table structure for `distrito`
-- ----------------------------
DROP TABLE IF EXISTS `distrito`;
CREATE TABLE `distrito` (
  `iddistrito` int(11) NOT NULL,
  `idprovincia` int(11) NOT NULL,
  `distrito` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`iddistrito`,`idprovincia`),
  KEY `distrito_fk1` (`idprovincia`),
  CONSTRAINT `distrito_fk1` FOREIGN KEY (`idprovincia`) REFERENCES `proviencia` (`idproviencia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of distrito
-- ----------------------------

-- ----------------------------
-- Table structure for `entrada`
-- ----------------------------
DROP TABLE IF EXISTS `entrada`;
CREATE TABLE `entrada` (
  `identrada` int(11) NOT NULL,
  `idproveedores` int(11) NOT NULL,
  `idpersonal` int(11) NOT NULL DEFAULT '0',
  `fecha_entrada` date DEFAULT NULL,
  PRIMARY KEY (`identrada`,`idproveedores`,`idpersonal`),
  KEY `entrada_fk1` (`idproveedores`),
  KEY `entrada_fk2` (`idpersonal`),
  CONSTRAINT `entrada_fk1` FOREIGN KEY (`idproveedores`) REFERENCES `proveedores` (`idproveedores`),
  CONSTRAINT `entrada_fk2` FOREIGN KEY (`idpersonal`) REFERENCES `personal` (`idpersonal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of entrada
-- ----------------------------

-- ----------------------------
-- Table structure for `institucion`
-- ----------------------------
DROP TABLE IF EXISTS `institucion`;
CREATE TABLE `institucion` (
  `idinstitucion` int(11) NOT NULL,
  `descripcion` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idinstitucion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of institucion
-- ----------------------------
INSERT INTO `institucion` VALUES ('1', 'publica');
INSERT INTO `institucion` VALUES ('2', 'privada');

-- ----------------------------
-- Table structure for `lugar_trabajo`
-- ----------------------------
DROP TABLE IF EXISTS `lugar_trabajo`;
CREATE TABLE `lugar_trabajo` (
  `idlugar_trabajo` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idinstitucion` int(11) NOT NULL,
  `iddistrito` int(11) DEFAULT NULL,
  `codigo` varchar(9) DEFAULT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `direccion` varchar(40) DEFAULT NULL,
  `url` varchar(30) DEFAULT NULL,
  `telefono1` varchar(12) DEFAULT NULL,
  `telefono3` varchar(12) DEFAULT NULL,
  `telefono2` varchar(12) DEFAULT NULL,
  `obs` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idlugar_trabajo`,`idinstitucion`),
  KEY `trabajo_fk3` (`idinstitucion`),
  CONSTRAINT `trabajo_fk3` FOREIGN KEY (`idinstitucion`) REFERENCES `institucion` (`idinstitucion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lugar_trabajo
-- ----------------------------
INSERT INTO `lugar_trabajo` VALUES ('1', '1', '1', '1', '032', 'I:E angel custodio', 'Jr:progreso', null, '343', '565', '988', '');

-- ----------------------------
-- Table structure for `modulo`
-- ----------------------------
DROP TABLE IF EXISTS `modulo`;
CREATE TABLE `modulo` (
  `idmodulo` int(11) NOT NULL,
  `idpadre` int(11) DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `url` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  PRIMARY KEY (`idmodulo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 11264 kB';

-- ----------------------------
-- Records of modulo
-- ----------------------------
INSERT INTO `modulo` VALUES ('1', '1', 'cobranzas', 'ww.ff', '1', '3');

-- ----------------------------
-- Table structure for `moneda`
-- ----------------------------
DROP TABLE IF EXISTS `moneda`;
CREATE TABLE `moneda` (
  `idmoneda` int(11) NOT NULL,
  `descripcion_tipo_moneda` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cambio_compra` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cambio_venta` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `simbolo` varchar(5) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idmoneda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of moneda
-- ----------------------------
INSERT INTO `moneda` VALUES ('1', 'soles', null, null, 'S/.');
INSERT INTO `moneda` VALUES ('2', 'dolares', null, null, '$.');

-- ----------------------------
-- Table structure for `nombre_codigos`
-- ----------------------------
DROP TABLE IF EXISTS `nombre_codigos`;
CREATE TABLE `nombre_codigos` (
  `idnombre_codigos` int(11) NOT NULL,
  `descripcion` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `abreviatura` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idnombre_codigos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of nombre_codigos
-- ----------------------------

-- ----------------------------
-- Table structure for `oficina`
-- ----------------------------
DROP TABLE IF EXISTS `oficina`;
CREATE TABLE `oficina` (
  `idoficina` int(11) NOT NULL,
  `idsucursal` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `direccion` varchar(60) DEFAULT NULL,
  `telefono` varchar(8) DEFAULT NULL,
  `fax` varchar(10) DEFAULT NULL,
  `celular` varchar(10) DEFAULT NULL,
  `rpm` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idoficina`,`idsucursal`),
  KEY `fk_oficina_sucursal1` (`idsucursal`),
  CONSTRAINT `oficina_fk1` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 11264 kB; (`idsucursal`) REFER `bdgilmer/sucursal`(`idsucursal`) ON';

-- ----------------------------
-- Records of oficina
-- ----------------------------
INSERT INTO `oficina` VALUES ('1', '1', null, 'jr:ramires huratdo 466', '222222', '4444', '3333', '43343');

-- ----------------------------
-- Table structure for `perfil`
-- ----------------------------
DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil` (
  `idperfil` int(11) NOT NULL,
  `descripcion` varchar(40) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idperfil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of perfil
-- ----------------------------
INSERT INTO `perfil` VALUES ('1', 'Administrador', '1');
INSERT INTO `perfil` VALUES ('2', 'Vendedor', '1');
INSERT INTO `perfil` VALUES ('3', 'Cobrador', '1');

-- ----------------------------
-- Table structure for `perfil_cliente`
-- ----------------------------
DROP TABLE IF EXISTS `perfil_cliente`;
CREATE TABLE `perfil_cliente` (
  `idperfil_cliente` int(11) NOT NULL,
  `descripcion` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`idperfil_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of perfil_cliente
-- ----------------------------
INSERT INTO `perfil_cliente` VALUES ('1', 'contrado');
INSERT INTO `perfil_cliente` VALUES ('2', 'cesante');

-- ----------------------------
-- Table structure for `permiso`
-- ----------------------------
DROP TABLE IF EXISTS `permiso`;
CREATE TABLE `permiso` (
  `idmodulo` int(11) NOT NULL,
  `idperfil` int(11) NOT NULL,
  `acceder` varchar(255) DEFAULT '0',
  `anadir` varchar(255) DEFAULT '0',
  `editar` varchar(255) DEFAULT '0',
  `eliminar` varchar(255) DEFAULT '0',
  `imprimir` varchar(255) DEFAULT '0',
  PRIMARY KEY (`idmodulo`,`idperfil`),
  KEY `Ref_permiso_to_perfil` (`idperfil`),
  CONSTRAINT `permiso_fk1` FOREIGN KEY (`idmodulo`) REFERENCES `modulo` (`idmodulo`),
  CONSTRAINT `permiso_fk2` FOREIGN KEY (`idperfil`) REFERENCES `perfil` (`idperfil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 11264 kB; (`idmodulo`) REFER `bdgilmer/modulo`(`idmodulo`); (`idper';

-- ----------------------------
-- Records of permiso
-- ----------------------------

-- ----------------------------
-- Table structure for `personal`
-- ----------------------------
DROP TABLE IF EXISTS `personal`;
CREATE TABLE `personal` (
  `idpersonal` int(11) NOT NULL,
  `idperfil` int(11) NOT NULL,
  `idoficina` int(11) NOT NULL,
  `primer_nombre` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `segundo_nombre` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido_p` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido_m` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sueldo_basico` decimal(10,2) DEFAULT NULL,
  `a_familiar` char(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `pasword` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `observacion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telf2` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telf1` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `num_hijos` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado_civil` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dir_actual` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idpersonal`,`idoficina`,`idperfil`),
  KEY `personal_fk1` (`idoficina`),
  KEY `personal_fk2` (`idperfil`),
  CONSTRAINT `personal_fk1` FOREIGN KEY (`idoficina`) REFERENCES `oficina` (`idoficina`),
  CONSTRAINT `personal_fk2` FOREIGN KEY (`idperfil`) REFERENCES `perfil` (`idperfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of personal
-- ----------------------------
INSERT INTO `personal` VALUES ('1', '1', '1', 'clemente', null, 'ordoñez', 'tocto', '750.00', 'si', '123', 'dorado', 'are informatica', '942743106', null, null, '1', 'c', 'urb: san alejandro', '');
INSERT INTO `personal` VALUES ('2', '1', '1', 'Ronel', null, 'drty', 'tr', '5000.00', 'si', '321', 'ronel', 'www', '121123', null, null, '3', 'c', null, '');
INSERT INTO `personal` VALUES ('3', '1', '1', 'frankli', null, 'gabino', 'santacruz', null, null, '890', 'gabino', null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `planilla`
-- ----------------------------
DROP TABLE IF EXISTS `planilla`;
CREATE TABLE `planilla` (
  `idplanilla` int(11) NOT NULL,
  `idpersonal` int(11) NOT NULL,
  `pagos_comisiones` decimal(10,2) DEFAULT NULL,
  `descuentos` decimal(10,2) DEFAULT NULL,
  `sueldo_neto` decimal(10,2) DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  PRIMARY KEY (`idplanilla`,`idpersonal`),
  KEY `planilla` (`idpersonal`),
  CONSTRAINT `planilla` FOREIGN KEY (`idpersonal`) REFERENCES `personal` (`idpersonal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of planilla
-- ----------------------------

-- ----------------------------
-- Table structure for `proceso_cobro`
-- ----------------------------
DROP TABLE IF EXISTS `proceso_cobro`;
CREATE TABLE `proceso_cobro` (
  `idproceso_cobro` int(11) NOT NULL,
  `idventa` int(11) NOT NULL,
  `idpersonal` int(11) DEFAULT NULL,
  `fecha_recuerdo` date DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `dias_atrasados` int(5) DEFAULT NULL,
  `letra` decimal(10,2) DEFAULT NULL,
  `deuda_anterior` decimal(10,2) DEFAULT NULL,
  `abono` decimal(10,2) DEFAULT NULL,
  `resto` decimal(10,2) DEFAULT NULL,
  `fecha_abono` date DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  `nro_cuota` int(1) DEFAULT NULL,
  `tipo_cobro` varchar(10) DEFAULT NULL COMMENT 'aca va dos palabras(planilla o directo)',
  PRIMARY KEY (`idproceso_cobro`,`idventa`),
  KEY `proceso_cobro_fk1` (`idventa`),
  KEY `proceso_cobro_fk2` (`idpersonal`),
  CONSTRAINT `proceso_cobro_fk1` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of proceso_cobro
-- ----------------------------
INSERT INTO `proceso_cobro` VALUES ('1', '1', '1', '2014-07-25', '2014-07-02', '2014-07-30', null, '300.00', '300.00', '0.00', '0.00', null, '', '1', null);
INSERT INTO `proceso_cobro` VALUES ('2', '1', null, '2014-08-25', '2014-07-30', '2014-08-30', null, '300.00', '0.00', '0.00', '0.00', null, '', '2', null);
INSERT INTO `proceso_cobro` VALUES ('3', '1', null, '2014-09-25', '2014-08-30', '2014-09-30', null, '300.00', '0.00', '0.00', '0.00', null, '', '3', null);
INSERT INTO `proceso_cobro` VALUES ('4', '1', null, null, null, null, null, '300.00', '0.00', '0.00', '0.00', null, '', '4', null);
INSERT INTO `proceso_cobro` VALUES ('5', '1', null, null, null, null, null, '300.00', '0.00', '0.00', '0.00', null, '', '5', null);
INSERT INTO `proceso_cobro` VALUES ('6', '1', null, null, null, null, null, '300.00', '0.00', '0.00', '0.00', null, '', '6', null);
INSERT INTO `proceso_cobro` VALUES ('7', '1', null, null, null, null, null, '300.00', '0.00', '0.00', '0.00', null, '', '7', null);
INSERT INTO `proceso_cobro` VALUES ('8', '1', null, null, null, null, null, '300.00', '0.00', '0.00', '0.00', null, '', '8', null);
INSERT INTO `proceso_cobro` VALUES ('9', '1', null, null, null, null, null, '300.00', '0.00', '0.00', '0.00', null, '', '9', null);
INSERT INTO `proceso_cobro` VALUES ('10', '1', null, null, null, null, null, '300.00', '0.00', '0.00', '0.00', null, '', '10', null);

-- ----------------------------
-- Table structure for `productos`
-- ----------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `idproductos` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `stock` double(11,0) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `precio_venta` decimal(10,2) DEFAULT NULL,
  `comision_venta` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`idproductos`,`idcategoria`),
  KEY `productos_fk1` (`idcategoria`),
  CONSTRAINT `productos_fk1` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of productos
-- ----------------------------
INSERT INTO `productos` VALUES ('1', '1', '30', 'laptos hp', '1500.00', '10');
INSERT INTO `productos` VALUES ('2', '2', '50', 'camara-3g', '500.00', '15');

-- ----------------------------
-- Table structure for `proveedores`
-- ----------------------------
DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores` (
  `idproveedores` int(11) NOT NULL DEFAULT '0',
  `primer_nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `segundo_nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_p` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_m` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `telefono_p` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `telefono_p1` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `dni` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `empresa_labora` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `telefono_e` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `direccion_empresa` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idproveedores`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of proveedores
-- ----------------------------

-- ----------------------------
-- Table structure for `proviencia`
-- ----------------------------
DROP TABLE IF EXISTS `proviencia`;
CREATE TABLE `proviencia` (
  `idproviencia` int(11) NOT NULL,
  `iddepartamento` int(11) NOT NULL,
  `provincia` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`idproviencia`,`iddepartamento`),
  KEY `provincia_fk1` (`iddepartamento`),
  CONSTRAINT `provincia_fk1` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`iddepartamento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of proviencia
-- ----------------------------

-- ----------------------------
-- Table structure for `salida`
-- ----------------------------
DROP TABLE IF EXISTS `salida`;
CREATE TABLE `salida` (
  `insalida` int(11) NOT NULL,
  `idpersonal` int(11) NOT NULL,
  `fecha_salida` date DEFAULT NULL,
  PRIMARY KEY (`insalida`,`idpersonal`),
  KEY `salida_fk1` (`idpersonal`),
  CONSTRAINT `salida_fk1` FOREIGN KEY (`idpersonal`) REFERENCES `personal` (`idpersonal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of salida
-- ----------------------------

-- ----------------------------
-- Table structure for `sucursal`
-- ----------------------------
DROP TABLE IF EXISTS `sucursal`;
CREATE TABLE `sucursal` (
  `idsucursal` int(11) NOT NULL,
  `descripcion` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`idsucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sucursal
-- ----------------------------
INSERT INTO `sucursal` VALUES ('1', 'tarapoto');
INSERT INTO `sucursal` VALUES ('2', 'pucalpa');

-- ----------------------------
-- Table structure for `telefonos`
-- ----------------------------
DROP TABLE IF EXISTS `telefonos`;
CREATE TABLE `telefonos` (
  `idtelefonos` int(11) NOT NULL,
  `idtipo_operador` int(11) NOT NULL,
  `num_telefono` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idcliente` int(11) NOT NULL,
  PRIMARY KEY (`idtelefonos`,`idtipo_operador`,`idcliente`),
  KEY `telefonos_fk1` (`idtipo_operador`),
  KEY `telefonos_fk2` (`idcliente`),
  CONSTRAINT `telefonos_fk1` FOREIGN KEY (`idtipo_operador`) REFERENCES `tipo_operador` (`idtipo_operador`),
  CONSTRAINT `telefonos_fk2` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of telefonos
-- ----------------------------
INSERT INTO `telefonos` VALUES ('1', '1', '4343', '1');
INSERT INTO `telefonos` VALUES ('2', '2', '6543', '1');

-- ----------------------------
-- Table structure for `tipo_operador`
-- ----------------------------
DROP TABLE IF EXISTS `tipo_operador`;
CREATE TABLE `tipo_operador` (
  `idtipo_operador` int(11) NOT NULL DEFAULT '0',
  `descripcion` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idtipo_operador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of tipo_operador
-- ----------------------------
INSERT INTO `tipo_operador` VALUES ('1', 'movistar');
INSERT INTO `tipo_operador` VALUES ('2', 'claro');
INSERT INTO `tipo_operador` VALUES ('3', 'rpm');
INSERT INTO `tipo_operador` VALUES ('4', 'rpc');
INSERT INTO `tipo_operador` VALUES ('5', 'nextel');

-- ----------------------------
-- Table structure for `tipo_pago`
-- ----------------------------
DROP TABLE IF EXISTS `tipo_pago`;
CREATE TABLE `tipo_pago` (
  `idtipo_pago` int(11) NOT NULL,
  `descripcion` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idtipo_pago`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tipo_pago
-- ----------------------------
INSERT INTO `tipo_pago` VALUES ('1', 'contado');
INSERT INTO `tipo_pago` VALUES ('2', 'credito');

-- ----------------------------
-- Table structure for `unidad_medida`
-- ----------------------------
DROP TABLE IF EXISTS `unidad_medida`;
CREATE TABLE `unidad_medida` (
  `int` int(11) NOT NULL,
  `descripcion` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `simbolo` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`int`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of unidad_medida
-- ----------------------------

-- ----------------------------
-- Table structure for `venta`
-- ----------------------------
DROP TABLE IF EXISTS `venta`;
CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `idpersonal` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idtipo_pago` int(11) NOT NULL,
  `idcombrob_pago` int(11) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `igv` decimal(10,2) DEFAULT NULL,
  `monto_cuota` decimal(10,2) DEFAULT NULL,
  `fecha_venta` date DEFAULT NULL,
  `num_cuota` decimal(2,0) DEFAULT NULL,
  `acuerdo1` varchar(100) DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idventa`,`idpersonal`,`idtipo_pago`,`idcombrob_pago`,`idcliente`),
  KEY `venta_fk1` (`idpersonal`),
  KEY `venta_fk3` (`idtipo_pago`),
  KEY `venta_fk4` (`idcombrob_pago`),
  CONSTRAINT `venta_fk1` FOREIGN KEY (`idpersonal`) REFERENCES `personal` (`idpersonal`),
  CONSTRAINT `venta_fk3` FOREIGN KEY (`idtipo_pago`) REFERENCES `tipo_pago` (`idtipo_pago`),
  CONSTRAINT `venta_fk4` FOREIGN KEY (`idcombrob_pago`) REFERENCES `comprob_pago` (`idcomprob_pago`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of venta
-- ----------------------------
INSERT INTO `venta` VALUES ('1', '1', '1', '2', '1', '3000.00', '150.00', '300.00', '2014-07-10', '10', 'en mi casa', '');
