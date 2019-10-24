-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
-- Servidor: localhost
-- Versión del servidor: 5.5.38-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `datacenter_access`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accedostaff`
--

CREATE TABLE IF NOT EXISTS `accedostaff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `accemail` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `cedula` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `userpass1` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `userpass2` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `admin` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `accedostaff`
--

INSERT INTO `accedostaff` (`id`, `name`, `accemail`, `cedula`, `username`, `userpass1`, `userpass2`, `admin`) VALUES
(1, 'admin', 'itdistro@company.com', '000-000000-0000', 'admin', 'b/Nfh8F4.9BPpF53qJP0VWR6cMQluXG1vef4jLpxqBJEsRsMwE3CjEAYj8miWZhXMXgv5I5FVRLFuLt4Qz4u30', '$6$rounds=5000$abcd1234$', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `authstaff`
--

CREATE TABLE IF NOT EXISTS `authstaff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `compdid` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `fullcompany` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `authemail` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `visitortype` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'auth',
  `personalid` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `signature` text COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `userpass1` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `userpass2` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `compdid` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `fullcompany` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ip_add` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `log_in` timestamp NULL DEFAULT NULL,
  `log_out` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registry`
--

CREATE TABLE IF NOT EXISTS `registry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `visitcode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `visitstatus` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `personalid` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `visitortype` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'guest',
  `fullcompany` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `purpose` text COLLATE utf8_unicode_ci NOT NULL,
  `signature` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `accedoescort` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `savedvisits`
--

CREATE TABLE IF NOT EXISTS `savedvisits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `visitcode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `visitstatus` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `submitter` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `assigned` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedvisits`
--

CREATE TABLE IF NOT EXISTS `schedvisits` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `visitcode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `visitortype` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `personalid` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `fullcompany` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
