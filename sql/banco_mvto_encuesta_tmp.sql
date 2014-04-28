-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 13-12-2010 a las 17:01:46
-- Versión del servidor: 5.1.44
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `4dlab_dllo`
--

-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `banco_mvto_encuesta_tmp`
--

CREATE TABLE IF NOT EXISTS `banco_mvto_encuesta_tmp` (
  `nro_consecutivo` varchar(11) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `codigo` smallint(6) NOT NULL DEFAULT '0',
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `valor` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(9) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `orden` int(11) NOT NULL DEFAULT '0',
  `criticidad` tinyint(11) NOT NULL,
  `resperada` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `secuencia` int(11) NOT NULL,
  `carita` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  KEY `banco_mvto_encuesta_nro_consecutivo` (`nro_consecutivo`),
  KEY `banco_mvto_encuesta_codigo` (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;