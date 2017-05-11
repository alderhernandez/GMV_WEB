-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 25-04-2017 a las 14:31:57
-- Versión del servidor: 5.1.36
-- Versión de PHP: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `gmv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE IF NOT EXISTS `actividad` (
  `IDACTIVIDAD` text,
  `ACTIVIDAD` text,
  `IDCATEGORIA` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`IDACTIVIDAD`, `ACTIVIDAD`, `IDCATEGORIA`) VALUES
('1', 'IMPULSAR PRODUCTO UMK', '1'),
('2', 'IMPULSAR PRODUCTO NO UMK', '1'),
('3', 'MOSTRAR CATALOGO DE PRODUCTOS', '1'),
('4', 'PROMOVER PRODUCTO QUE HO HA VENDIDO ANTES', '1'),
('5', 'OFRECER SERVICIOS DE VALOR AGREGADO', '1'),
('6', 'VERIFICAR RECEPCION DE PEDIDO', '2'),
('7', 'VALIDAR COMPLETITUD DE PEDIDO RECIBIBO', '2'),
('8', 'LLENAR FORMATO FALTANTE', '3'),
('9', 'SOLICITUD DE DOCUMENTACION', '3'),
('10', 'PROMOVER PROGRAMA DE PUNTOS', '4'),
('11', 'MOSTRAR CATALOGO DE CANJES', '4'),
('12', 'LLENAR FORMATO DE CANJE', '4'),
('13', 'RECOPILAR BOUCHERS', '4'),
('14', 'RETIRAR PRODUCTO VENCIDO', '5'),
('15', 'RETIRAR PRODUCTO NO VENCIDO', '5'),
('16', 'CIERRE DE CAMPAÑA', '6'),
('17', 'PROMOVER CAMPAÑA', '6'),
('18', 'FIESTA DE ANIVERSARIO', '7'),
('19', 'LLENAR ENCUESTA', '8');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `actividades`
--
CREATE TABLE IF NOT EXISTS `actividades` (
`IDACTIVIDAD` text
,`ACTIVIDAD` text
,`IDCATEGORIA` text
,`CATEGORIA` text
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda`
--

CREATE TABLE IF NOT EXISTS `agenda` (
  `IdPlan` int(10) NOT NULL AUTO_INCREMENT,
  `Vendedor` varchar(10) DEFAULT NULL,
  `Ruta` varchar(10) DEFAULT NULL,
  `Inicia` date DEFAULT NULL,
  `Termina` date DEFAULT NULL,
  `Zona` varchar(10) DEFAULT NULL,
  `Comentario` varchar(1500) DEFAULT NULL,
  `Estado` bit(1) DEFAULT NULL COMMENT 'Campo que indica si la agenda es la vigente',
  PRIMARY KEY (`IdPlan`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `agenda`
--

INSERT INTO `agenda` (`IdPlan`, `Vendedor`, `Ruta`, `Inicia`, `Termina`, `Zona`, `Comentario`, `Estado`) VALUES
(3, 'TANIA MARQ', 'F09', '2017-04-17', '2017-04-21', 'F09', NULL, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `IDCATEGORIA` text,
  `CATEGORIA` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`IDCATEGORIA`, `CATEGORIA`) VALUES
('1', 'GESTION DE VENTAS'),
('2', 'SEGUIMIENTO A PEDIDOS'),
('3', 'ACTUALIZACION DE DATOS'),
('4', 'PROGRAMA DE PUNTOS'),
('5', 'PRODUCTO'),
('6', 'CAMPAÑA'),
('7', 'INVITACION'),
('8', 'ENCUESTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobros`
--

CREATE TABLE IF NOT EXISTS `cobros` (
  `IDCOBRO` varchar(16) DEFAULT NULL,
  `CLIENTE` varchar(10) DEFAULT NULL,
  `RUTA` varchar(5) DEFAULT NULL,
  `IMPORTE` varchar(200) DEFAULT NULL,
  `TIPO` varchar(10) DEFAULT NULL,
  `OBSERVACION` varchar(400) DEFAULT NULL,
  `FECHA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `cobros`
--

INSERT INTO `cobros` (`IDCOBRO`, `CLIENTE`, `RUTA`, `IMPORTE`, `TIPO`, `OBSERVACION`, `FECHA`) VALUES
('13-C190417206', '03078', '13', '500', 'EFECTIVO', 'PRUEBA DE CP', '2017-04-19 10:50:55'),
('13-C190417207', '00619', '13', '1312312', 'EFECTIVO', 'PRUEBA DE PROTONES', '2017-04-19 10:51:12'),
('13-C190417201', '00623', '13', '1200', 'EFECTIVO', 'sdafdada', '2017-04-19 11:35:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
  `IdGrupo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'llave principal del grupo',
  `NombreGrupo` varchar(50) DEFAULT NULL COMMENT 'nombre del grupo',
  `IdResponsable` int(11) DEFAULT NULL COMMENT 'id del usuario que es dueño del grupo',
  `Estado` int(11) DEFAULT NULL COMMENT 'estado 0= inactivo 1= activo',
  `FechaCreada` datetime DEFAULT NULL,
  PRIMARY KEY (`IdGrupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`IdGrupo`, `NombreGrupo`, `IdResponsable`, `Estado`, `FechaCreada`) VALUES
(1, 'GRUPO SAC1', 4, 0, '2017-03-31 17:00:40'),
(2, 'GRUPO SAC1', 4, 1, '2017-04-25 00:43:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_asignacion`
--

CREATE TABLE IF NOT EXISTS `grupo_asignacion` (
  `IdGrupo` int(11) DEFAULT NULL,
  `IdVendedor` varchar(10) DEFAULT NULL,
  `Estado` bit(1) DEFAULT NULL,
  `FechaCreada` datetime DEFAULT NULL,
  `FechaBaja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `grupo_asignacion`
--

INSERT INTO `grupo_asignacion` (`IdGrupo`, `IdVendedor`, `Estado`, `FechaCreada`, `FechaBaja`) VALUES
(1, '3', b'1', '2017-04-25 00:00:00', NULL),
(1, '6', b'1', '2017-04-25 00:00:00', NULL),
(1, '2', b'0', '2017-04-24 00:00:00', NULL),
(1, '7', b'1', '2017-04-25 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `IDPEDIDO` varchar(255) DEFAULT NULL,
  `VENDEDOR` varchar(255) DEFAULT NULL,
  `CLIENTE` varchar(255) DEFAULT NULL,
  `NOMBRE` varchar(255) DEFAULT NULL,
  `MONTO` varchar(255) DEFAULT NULL,
  `ESTADO` int(1) DEFAULT NULL,
  `FECHA_CREADA` datetime DEFAULT NULL,
  `FECHA_GRABADA` datetime DEFAULT NULL,
  `FECHA_ULTIMA_ACTUALIZACION` datetime DEFAULT NULL,
  `NOTA` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `pedido`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalle`
--

CREATE TABLE IF NOT EXISTS `pedido_detalle` (
  `IDPEDIDO` varchar(255) DEFAULT NULL,
  `ARTICULO` varchar(255) DEFAULT NULL,
  `DESCRIPCION` varchar(255) DEFAULT NULL,
  `CANTIDAD` varchar(255) DEFAULT NULL,
  `TOTAL` varchar(255) DEFAULT NULL,
  `BONIFICADO` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `pedido_detalle`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `razon`
--

CREATE TABLE IF NOT EXISTS `razon` (
  `IdRazon` longtext,
  `Vendedor` longtext,
  `Cliente` longtext,
  `Nombre` longtext,
  `Fecha` datetime DEFAULT NULL,
  `Observacion` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `razon`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `razon_detalle`
--

CREATE TABLE IF NOT EXISTS `razon_detalle` (
  `IdRazon` longtext,
  `IdAE` longtext,
  `Actividad` longtext,
  `Categoria` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `razon_detalle`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `IdUser` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(20) DEFAULT NULL,
  `Nombre` varchar(30) DEFAULT NULL,
  `Password` varchar(35) DEFAULT NULL,
  `Rol` int(1) DEFAULT NULL,
  `Activo` bit(1) DEFAULT NULL,
  PRIMARY KEY (`IdUser`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Volcar la base de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IdUser`, `Usuario`, `Nombre`, `Password`, `Rol`, `Activo`) VALUES
(2, 'Alder', 'Alder Hernandez', '123', 4, b'1'),
(3, 'F09', 'NEYLING RAMIREZ', '123', 1, b'1'),
(4, 'SAC1', 'SARA', '123', 2, b'1'),
(5, 'SAC3', 'REYNA', '123', 2, b'1'),
(6, 'F01', 'VENDEDOR 1 ', '123', 1, b'1'),
(7, 'F02', 'VENDEDOR 2', '123', 1, b'1'),
(8, 'F03', 'VENDEDOR 3 ', '123', 1, b'1'),
(9, 'F04', 'VENDEDOR 4', '123', 1, b'1'),
(10, 'F05', 'VENDEDOR 5', '123', 1, b'1'),
(11, 'F07', 'VENDEDOR 7', '123', 1, b'1'),
(12, 'F08', 'VENDEDOR 8', '123', 1, b'1'),
(13, 'F09', 'VENDEDOR 9', '123', 1, b'1'),
(14, 'F10', 'VENDEDOR 10', '123', 1, b'1'),
(15, 'F11', 'VENDEDOR 11', '123', 1, b'1'),
(16, 'F13', 'VENDEDOR 13', '123', 1, b'1'),
(17, 'SUP01', 'VERONICA', '123', 3, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vclientes`
--

CREATE TABLE IF NOT EXISTS `vclientes` (
  `IdPlan` varchar(10) DEFAULT NULL,
  `Lunes` varchar(500) DEFAULT NULL,
  `Martes` varchar(500) DEFAULT NULL,
  `Miercoles` varchar(500) DEFAULT NULL,
  `Jueves` varchar(500) DEFAULT NULL,
  `Viernes` varchar(500) DEFAULT NULL,
  `Obervaciones` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `vclientes`
--

INSERT INTO `vclientes` (`IdPlan`, `Lunes`, `Martes`, `Miercoles`, `Jueves`, `Viernes`, `Obervaciones`) VALUES
('3', '00001-00535-00536-00538-00617-00619-00620-00622-00623', '00751-00752-00753-00754-00755-00756-00757-00758-00759-00760-00761-00762', '00890-00891-00892-00893-00894-00896-00987-00988-00989', '01007-01008-01011-01018-01019-01020-01109-01118-01119-01786-01882-01906-01907-01908-01910-01928', '02111-02123-02148-02197-02200-02247-02256-02295-02297-02316', 'COMENTARIO VISITA 1|-|COMENTARIO VISITA 2|-|COMENTARIO VISITA 3|-|COMENTARIO VISITA 4|-|COMENTARIO VISITA 5|-|COMENTARIO VISITA 6|-|COMENTARIO VISITA 7|-|COMENTARIO VISITA 8|-|COMENTARIO VISITA 9|-|COMENTARIO VISITA 10|-|COMENTARIO VISITA 11|-|COMENTARIO VISITA 12|-|COMENTARIO VISITA 13|-|COMENTARIO VISITA 14|-|COMENTARIO VISITA 15|-|COMENTARIO VISITA 16|-|');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_grupoasignacion`
--
CREATE TABLE IF NOT EXISTS `view_grupoasignacion` (
`IdGrupo` int(11)
,`NombreGrupo` varchar(50)
,`IdResponsable` int(11)
,`ResponsableUsuario` varchar(20)
,`ResponsableNombre` varchar(30)
,`Estado` int(11)
,`IdVendedor` varchar(10)
,`Ruta` varchar(20)
,`NombreRuta` varchar(30)
,`EstadoVendedor` bit(1)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas`
--

CREATE TABLE IF NOT EXISTS `visitas` (
  `IdPlan` varchar(15) DEFAULT NULL,
  `IdCliente` varchar(10) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Lati` varchar(10) DEFAULT NULL,
  `Logi` varchar(10) DEFAULT NULL,
  `Local` varchar(5) DEFAULT NULL,
  `Observacion` varchar(500) DEFAULT NULL,
  `Accion` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `visitas`
--


-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtsplanes`
--
CREATE TABLE IF NOT EXISTS `vtsplanes` (
`IdPlan` int(10)
,`Vendedor` varchar(10)
,`Ruta` varchar(10)
,`Inicia` date
,`Termina` date
,`Zona` varchar(10)
,`Estado` bit(1)
,`Lunes` varchar(500)
,`Martes` varchar(500)
,`Miercoles` varchar(500)
,`Jueves` varchar(500)
,`Viernes` varchar(500)
,`Obervaciones` varchar(500)
);
-- --------------------------------------------------------

--
-- Estructura para la vista `actividades`
--
DROP TABLE IF EXISTS `actividades`;

CREATE ALGORITHM=UNDEFINED DEFINER=`Dios`@`%` SQL SECURITY DEFINER VIEW `actividades` AS select `a`.`IDACTIVIDAD` AS `IDACTIVIDAD`,`a`.`ACTIVIDAD` AS `ACTIVIDAD`,`a`.`IDCATEGORIA` AS `IDCATEGORIA`,`c`.`CATEGORIA` AS `CATEGORIA` from (`actividad` `a` join `categoria` `c` on((`a`.`IDCATEGORIA` = `c`.`IDCATEGORIA`))) order by `c`.`CATEGORIA`,`a`.`ACTIVIDAD`;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_grupoasignacion`
--
DROP TABLE IF EXISTS `view_grupoasignacion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`Dios`@`%` SQL SECURITY DEFINER VIEW `view_grupoasignacion` AS select `grupos`.`IdGrupo` AS `IdGrupo`,`grupos`.`NombreGrupo` AS `NombreGrupo`,`grupos`.`IdResponsable` AS `IdResponsable`,`usuario`.`Usuario` AS `ResponsableUsuario`,`usuario`.`Nombre` AS `ResponsableNombre`,`grupos`.`Estado` AS `Estado`,`grupo_asignacion`.`IdVendedor` AS `IdVendedor`,`t1`.`Usuario` AS `Ruta`,`t1`.`Nombre` AS `NombreRuta`,`grupo_asignacion`.`Estado` AS `EstadoVendedor` from (((`grupos` join `grupo_asignacion` on((`grupo_asignacion`.`IdGrupo` = `grupos`.`IdGrupo`))) join `usuario` `t1` on((`t1`.`IdUser` = `grupo_asignacion`.`IdVendedor`))) join `usuario` on((`usuario`.`IdUser` = `grupos`.`IdResponsable`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `vtsplanes`
--
DROP TABLE IF EXISTS `vtsplanes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`Dios`@`%` SQL SECURITY DEFINER VIEW `vtsplanes` AS select `t0`.`IdPlan` AS `IdPlan`,`t0`.`Vendedor` AS `Vendedor`,`t0`.`Ruta` AS `Ruta`,`t0`.`Inicia` AS `Inicia`,`t0`.`Termina` AS `Termina`,`t0`.`Zona` AS `Zona`,`t0`.`Estado` AS `Estado`,`t1`.`Lunes` AS `Lunes`,`t1`.`Martes` AS `Martes`,`t1`.`Miercoles` AS `Miercoles`,`t1`.`Jueves` AS `Jueves`,`t1`.`Viernes` AS `Viernes`,`t1`.`Obervaciones` AS `Obervaciones` from (`agenda` `t0` join `vclientes` `t1` on((`t0`.`IdPlan` = `t1`.`IdPlan`)));
