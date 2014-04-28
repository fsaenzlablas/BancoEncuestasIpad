-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 13-12-2010 a las 17:00:24
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
-- Estructura de tabla para la tabla `banco_encuesta_enc_tmp`
--

CREATE TABLE IF NOT EXISTS `banco_encuesta_enc_tmp` (
  `nro_consecutivo` varchar(11) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `cedula` varchar(12) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `estado` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `cod_bacteriologa` varchar(3) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nro_consecutivo`),
  KEY `banco_encuesta_enc_tmp_cedula` (`cedula`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
