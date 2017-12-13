-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Servidor: concretospiura.com.mysql:3306
-- Tiempo de generación: 17-04-2016 a las 14:29:46
-- Versión del servidor: 5.5.47-MariaDB-1~wheezy
-- Versión de PHP: 5.4.45-0+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `concretospiura_`
--
CREATE DATABASE `concretospiura_` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `concretospiura_`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigos_usuario`
--

DROP TABLE IF EXISTS `amigos_usuario`;
CREATE TABLE IF NOT EXISTS `amigos_usuario` (
  `idUsuario` int(11) NOT NULL,
  `idAmigo` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`,`idAmigo`),
  KEY `fk_Amigos_usuario_Usuario1_idx` (`idAmigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `amigos_usuario`
--

INSERT INTO `amigos_usuario` (`idUsuario`, `idAmigo`) VALUES
(46, 47),
(47, 46);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_usuarios`
--

DROP TABLE IF EXISTS `bitacora_usuarios`;
CREATE TABLE IF NOT EXISTS `bitacora_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_mysql` varchar(45) DEFAULT NULL,
  `fecha_movimiento` datetime DEFAULT NULL,
  `accion_sistema` varchar(45) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `bitacora_usuarios`
--

INSERT INTO `bitacora_usuarios` (`id`, `usuario_mysql`, `fecha_movimiento`, `accion_sistema`, `id_usuario`) VALUES
(1, 'concretospiura_@10.24.3.10', '2016-04-17 14:25:48', 'INSERT', 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `key_generator`
--

DROP TABLE IF EXISTS `key_generator`;
CREATE TABLE IF NOT EXISTS `key_generator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codeGenerator` varchar(128) CHARACTER SET utf8 NOT NULL,
  `codeState` int(1) DEFAULT NULL,
  `dataInit` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `dataExpired` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `key_generator`
--

INSERT INTO `key_generator` (`id`, `codeGenerator`, `codeState`, `dataInit`, `dataExpired`) VALUES
(5, 'abcde', 1, 'hoy', 'mañana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tienda`
--

DROP TABLE IF EXISTS `tienda`;
CREATE TABLE IF NOT EXISTS `tienda` (
  `owner` int(11) DEFAULT NULL,
  `titulo` varchar(45) CHARACTER SET ucs2 NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `owner_UNIQUE` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tienda`
--

INSERT INTO `tienda` (`owner`, `titulo`, `id`) VALUES
(46, 'TIENDA ONLINE', 2),
(NULL, 'tienda UNE PRODUCTOS MOVILES', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `login_user` varchar(45) CHARACTER SET utf8 NOT NULL,
  `password_user` varchar(60) CHARACTER SET utf8 NOT NULL,
  `mail_user` varchar(100) CHARACTER SET utf8 NOT NULL,
  `nivel_acceso` int(11) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `hora_creacion` time DEFAULT NULL,
  `nombre_user` varchar(75) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) CHARACTER SET utf8 NOT NULL,
  `password` varchar(128) CHARACTER SET utf8 NOT NULL,
  `email` varchar(150) CHARACTER SET utf8 NOT NULL,
  `fechaCreacion` date DEFAULT NULL,
  `estadoRegistro` int(1) DEFAULT NULL,
  `keyGenerator` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `nivelAcceso` int(1) DEFAULT NULL,
  `idKeyGenerator` int(11) DEFAULT NULL,
  `horaCreacion` time NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_usuario_key_generator1_idx` (`idKeyGenerator`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla usuarios' AUTO_INCREMENT=51 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `password`, `email`, `fechaCreacion`, `estadoRegistro`, `keyGenerator`, `nivelAcceso`, `idKeyGenerator`, `horaCreacion`) VALUES
(46, 'jdiaz01', 'UECdutoEjXpaaev0rQk7ZwaIUwyOmKuFqC2ja733C2A=', '12345', '2016-04-16', 0, 'keyGen', 1, 5, '14:08:50'),
(47, 'jdiaz02', 'UECdutoEjXpaaev0rQk7ZwaIUwyOmKuFqC2ja733C2A=', 'jdiaz02@jdiaz.com', '2016-04-16', 0, 'keyGen', 1, NULL, '15:42:28'),
(50, 'jdiaz03', 'UECdutoEjXpaaev0rQk7ZwaIUwyOmKuFqC2ja733C2A=', 'jdiaz03@jdiaz.com', '2016-04-17', 0, 'keyGen', 1, NULL, '09:25:48');

--
-- Disparadores `usuario`
--
DROP TRIGGER IF EXISTS `tgr_Insert_usuariosBitacora`;
DELIMITER //
CREATE TRIGGER `tgr_Insert_usuariosBitacora` AFTER INSERT ON `usuario`
 FOR EACH ROW insert INTO bitacora_usuarios (usuario_mysql, fecha_movimiento, accion_sistema, id_usuario)
 values (USER(), NOW(), 'INSERT', NEW.id)
//
DELIMITER ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amigos_usuario`
--
ALTER TABLE `amigos_usuario`
  ADD CONSTRAINT `fk_Amigos_usuario_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Amigos_usuario_Usuario1` FOREIGN KEY (`idAmigo`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD CONSTRAINT `fk_Tienda_Usuario1` FOREIGN KEY (`owner`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_key_generator1` FOREIGN KEY (`idKeyGenerator`) REFERENCES `key_generator` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
