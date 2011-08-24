-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 23-08-2011 a las 16:31:04
-- Versión del servidor: 5.1.41
-- Versión de PHP: 5.3.2-1ubuntu4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `buscador`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adaptors`
--

CREATE TABLE IF NOT EXISTS `adaptors` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `file` varchar(200) DEFAULT NULL,
  `class_name` varchar(25) DEFAULT NULL,
  `search_engine_id` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_adaptors` (`class_name`),
  KEY `search_engine_id` (`search_engine_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `adaptors`
--

INSERT INTO `adaptors` (`id`, `name`, `description`, `file`, `class_name`, `search_engine_id`) VALUES
(1, 'Lis RSS', 'RSS Adaptor for LIS', 'general_adaptor.php', 'GeneralAdaptor', 40),
(2, 'Al Dia RSS', 'RSS Adaptor for Al Dia', 'general_adaptor.php', 'GeneralAdaptor', 28),
(3, 'Infoenlaces RSS', 'RSS Adaptor for Infoenlaces', 'general_adaptor.php', 'GeneralAdaptor', 29);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infosources`
--

CREATE TABLE IF NOT EXISTS `infosources` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `search_engine_id` smallint(6) DEFAULT NULL,
  `search_engine_params` text,
  PRIMARY KEY (`id`),
  KEY `FK_infosources` (`search_engine_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=58 ;

--
-- Volcar la base de datos para la tabla `infosources`
--

INSERT INTO `infosources` (`id`, `name`, `description`, `search_engine_id`, `search_engine_params`) VALUES
(56, 'Portal de Infomed - Solr', 'Sitios de Salud indexados por Sorl', 61, '<?xml version="1.0"?>\n<parameters>\n  <param name="sites">www.sld.cu</param>\n</parameters>\n'),
(57, 'Portal de Infomed - Solr - Sitios de Salud', 'Portal de Infomed - Solr', 61, '<?xml version="1.0"?>\n<parameters>\n  <param name="sites">sld.cu</param>\n</parameters>\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `searchengines`
--

CREATE TABLE IF NOT EXISTS `searchengines` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `params` text,
  `description` text,
  `implementation` varchar(200) DEFAULT NULL,
  `class_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=62 ;

--
-- Volcar la base de datos para la tabla `searchengines`
--

INSERT INTO `searchengines` (`id`, `name`, `params`, `description`, `implementation`, `class_name`) VALUES
(61, 'Sitios de Infomed Solr', '<?xml version="1.0"?>\r\n<parameters>\r\n  <param>\r\n    <name>sites</name>\r\n    <type>text</type>\r\n  </param>\r\n</parameters>', 'Búsqueda en los sitios de infomed a traves de Solr', 'sitiosinfomedsolr_search_engine.php', 'SitiosinfomedsolrSearchEngine');
