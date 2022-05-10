-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Servidor: us-cdbr-east-05.cleardb.net
-- Tiempo de generación: 10-05-2022 a las 04:29:49
-- Versión del servidor: 5.6.50-log
-- Versión de PHP: 7.0.33-0ubuntu0.16.04.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `heroku_ebee224f7f955f7`
--
CREATE DATABASE IF NOT EXISTS `heroku_ebee224f7f955f7` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `heroku_ebee224f7f955f7`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidatos`
--

CREATE TABLE `candidatos` (
  `IDCandidatos` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `NumeroDocumento` varchar(50) NOT NULL,
  `TipoDocumento` varchar(10) NOT NULL,
  `Correo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `candidatos`
--

INSERT INTO `candidatos` (`IDCandidatos`, `Nombre`, `NumeroDocumento`, `TipoDocumento`, `Correo`) VALUES
(34, 'Juan Diego Villa', '1053863042', 'CC', 'juandvillamontoya@gmail.com'),
(44, 'Maria Fernanda', '10538630', 'CC', 'mafevimon@gmail.com'),
(54, 'Maria Camila Betancur', '1053870754', 'CC', 'mmartinezbe@gmail.com'),
(64, 'Maria del Carmen', '43093328', 'CE', 'macamonbel@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidatosofertas`
--

CREATE TABLE `candidatosofertas` (
  `IDCandidatosOfertas` int(11) NOT NULL,
  `IDOfertas` int(11) NOT NULL,
  `IDCandidatos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `candidatosofertas`
--

INSERT INTO `candidatosofertas` (`IDCandidatosOfertas`, `IDOfertas`, `IDCandidatos`) VALUES
(94, 234, 34),
(104, 244, 44),
(114, 254, 54),
(124, 254, 64),
(134, 264, 64),
(144, 274, 64),
(154, 274, 54),
(164, 274, 44),
(174, 274, 34),
(184, 284, 64),
(194, 284, 54),
(204, 284, 44),
(214, 284, 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `IDOfertas` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`IDOfertas`, `Nombre`, `Estado`) VALUES
(234, 'Desarrollador PHP', 'Activo'),
(244, 'Ingeniero Civil', 'Activo'),
(254, 'Administrador y servicio al cliente', 'Activo'),
(264, 'Mestro Personalizado', 'Activo'),
(274, 'Oferta general', 'Activo'),
(284, 'Oferta general 2', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosws`
--

CREATE TABLE `usuariosws` (
  `IDUsuariosWs` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Clave` varchar(100) NOT NULL,
  `Activo` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuariosws`
--

INSERT INTO `usuariosws` (`IDUsuariosWs`, `Nombre`, `Usuario`, `Clave`, `Activo`) VALUES
(4, 'Bolsa', 'BolsaApi', '5f639f0522f18b1c0217373473fd7011a38743c4', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `candidatos`
--
ALTER TABLE `candidatos`
  ADD PRIMARY KEY (`IDCandidatos`);

--
-- Indices de la tabla `candidatosofertas`
--
ALTER TABLE `candidatosofertas`
  ADD PRIMARY KEY (`IDCandidatosOfertas`);

--
-- Indices de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`IDOfertas`);

--
-- Indices de la tabla `usuariosws`
--
ALTER TABLE `usuariosws`
  ADD PRIMARY KEY (`IDUsuariosWs`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `candidatos`
--
ALTER TABLE `candidatos`
  MODIFY `IDCandidatos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT de la tabla `candidatosofertas`
--
ALTER TABLE `candidatosofertas`
  MODIFY `IDCandidatosOfertas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;
--
-- AUTO_INCREMENT de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `IDOfertas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;
--
-- AUTO_INCREMENT de la tabla `usuariosws`
--
ALTER TABLE `usuariosws`
  MODIFY `IDUsuariosWs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
