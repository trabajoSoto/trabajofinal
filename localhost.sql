-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-03-2021 a las 14:42:31
-- Versión del servidor: 5.7.31-0ubuntu0.16.04.1
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sebas_db`
--
CREATE DATABASE IF NOT EXISTS `sebas_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sebas_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instalaciones`
--

CREATE TABLE `instalaciones` (
  `Id_Instalacion` int(2) NOT NULL,
  `Nombre_Instalacion` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `instalaciones`
--

INSERT INTO `instalaciones` (`Id_Instalacion`, `Nombre_Instalacion`) VALUES
(1, 'Fisio'),
(2, 'Gym'),
(3, 'Pisci'),
(4, 'Sala');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `idMaterial` int(5) NOT NULL,
  `nomMaterial` varchar(22) NOT NULL,
  `unidades` int(5) NOT NULL,
  `Id_Instalacion` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`idMaterial`, `nomMaterial`, `unidades`, `Id_Instalacion`) VALUES
(1, 'Esterillas', 100, 4),
(2, 'Balones', 10, 4),
(3, 'Esterillas', 50, 2),
(8, 'Flotadores', 50, 3),
(9, 'Toallas', 25, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `idPago` int(3) NOT NULL,
  `tipoPago` varchar(15) NOT NULL,
  `deudor` int(6) NOT NULL,
  `IdUser` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`idPago`, `tipoPago`, `deudor`, `IdUser`) VALUES
(2, 'Efectivo', 10, 3),
(3, 'Tarjeta', 50, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `Id_Reservas` int(4) NOT NULL,
  `Id_Instalacion` int(2) NOT NULL,
  `start` datetime NOT NULL,
  `IdUser` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`Id_Reservas`, `Id_Instalacion`, `start`, `IdUser`) VALUES
(2, 4, '2021-03-15 13:20:17', 3),
(3, 4, '2021-03-18 17:30:00', 3),
(6, 1, '2021-03-23 17:00:00', 3),
(26, 1, '2021-03-23 20:00:00', 4),
(27, 1, '2021-03-24 20:00:00', 4),
(29, 2, '2021-03-25 10:00:00', 3),
(49, 3, '2021-03-27 14:00:00', 2),
(50, 2, '2021-03-20 16:00:00', 2),
(51, 3, '2021-03-21 18:00:00', 2),
(52, 2, '2021-03-20 10:00:00', 2),
(53, 1, '2021-03-29 10:00:00', 2),
(54, 4, '2021-04-01 13:00:00', 2),
(55, 2, '2021-03-21 14:00:00', 2),
(56, 3, '2021-03-13 13:00:00', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `IdUser` int(5) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `password` varchar(22) NOT NULL,
  `tipo` varchar(5) NOT NULL,
  `DNI` varchar(9) NOT NULL,
  `Nombre` varchar(22) NOT NULL,
  `Caso` text,
  `Cuota` int(6) DEFAULT NULL,
  `Promo` tinyint(1) DEFAULT NULL,
  `Sueldo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IdUser`, `usuario`, `password`, `tipo`, `DNI`, `Nombre`, `Caso`, `Cuota`, `Promo`, `Sueldo`) VALUES
(1, 'u1', 'a', 'S', '11S', 'S1', NULL, 111, NULL, NULL),
(2, 'u2', 'b', 'E', '22E', 'E2', NULL, NULL, NULL, 2222),
(3, 'u3', 'c', 'S', '33S', 'S3', 'Hiperlordosis', 33, 1, NULL),
(4, 'u4', 'd', 'S', '22S', 'S2', 'Hipercifosis, hernia', 22, 1, NULL),
(6, 'u6', 'f', 'E', '66E', 'E3', NULL, NULL, NULL, 666),
(7, 'u7', 'g', 'E', '77E', 'E11', NULL, NULL, NULL, 777),
(9, 'u9', 'i', 'E', 'E99', 'E4', NULL, NULL, NULL, 1411),
(10, 'u10', 'j', 'S', '10101010S', 'Arturo Fernández', NULL, 1000, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `instalaciones`
--
ALTER TABLE `instalaciones`
  ADD PRIMARY KEY (`Id_Instalacion`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`idMaterial`),
  ADD KEY `materiales_ibfk_1` (`Id_Instalacion`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`idPago`),
  ADD KEY `pago_ibfk_1` (`IdUser`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`Id_Reservas`),
  ADD KEY `reservas_ibfk_2` (`Id_Instalacion`),
  ADD KEY `reservas_ibfk_3` (`IdUser`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUser`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `instalaciones`
--
ALTER TABLE `instalaciones`
  MODIFY `Id_Instalacion` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `idMaterial` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `idPago` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `Id_Reservas` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUser` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD CONSTRAINT `materiales_ibfk_1` FOREIGN KEY (`Id_Instalacion`) REFERENCES `instalaciones` (`Id_Instalacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`IdUser`) REFERENCES `usuario` (`IdUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`Id_Instalacion`) REFERENCES `instalaciones` (`Id_Instalacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_3` FOREIGN KEY (`IdUser`) REFERENCES `usuario` (`IdUser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
