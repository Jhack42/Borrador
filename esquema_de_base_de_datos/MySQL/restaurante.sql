Create database restaurante;
use  restaurante;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-02-2024 a las 03:14:32
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_banners`
--

CREATE TABLE `tbl_banners` (
  `ID` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_banners`
--

INSERT INTO `tbl_banners` (`ID`, `titulo`, `descripcion`, `link`) VALUES
(30, 'Soy Juan Carlos Pinto Cruz ', 'La mejor reseta del Peru ', '#ver '),
(31, '123', 'asd', '#ver Menu');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_colaboradores`
--

CREATE TABLE `tbl_colaboradores` (
  `ID` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `linkfacebook` varchar(255) NOT NULL,
  `linkinstagram` varchar(255) NOT NULL,
  `linkinlinkedin` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_colaboradores`
--

INSERT INTO `tbl_colaboradores` (`ID`, `titulo`, `descripcion`, `linkfacebook`, `linkinstagram`, `linkinlinkedin`, `foto`) VALUES
(56, 'El paraiso2', 'Restaurante del mesjor sabor casero', 'El paraiso2', '//Instagram', '//LINKENID', '1708274326_Captura1.JPG'),
(59, 'EL MIRADOR DE SANTA CLARA ', 'Restaurante del mesjor sabor casero', '//facebook xd ', '//Instagram', 'asd', '1708278798_Captura1.JPG'),
(60, 'EL MIRADOR DE SANTA CLARA ', 'asd', 'El paraiso2', 'sad', '//LINKENID', '1708278959_Captura1.JPG'),
(61, 'asd', 'asd', 'asd', 'asd', 'asd', '1708279223_Captura1.JPG'),
(62, 'EL MIRADOR DE SANTA CLARA ', 'asd', 'El paraiso2', 'sad', 'ASD', '1708280200_JUAN.jpg'),
(63, '123', '213', '321', '123', '123', '1708281618_JUAN.jpg'),
(64, '132', '213', '213', '21', '213', '1708281738_'),
(65, '123', '123', '123', '323', '321', '1708281762_JUAN.jpg'),
(66, '12', '23', '213', '231', '213', '1708282436_index.html'),
(67, 'EL MIRADOR DE SANTA CLARA ', 'wqe', 'wqe', 'wqe', 'weq', '1708299966_CUADERNO DE INFORMES1.pdf'),
(68, '12', '12', '123', '132', '132', '1708300854_JUAN.jpg'),
(69, 'EL MIRADOR DE SANTA CLARA ', 'asd', 'asd', 'asd', 'asd', '1708302197_JUAN.jpg'),
(70, '1232', '132', '132', '123', '123', '1708303345_JUAN.jpg'),
(71, '132', '123', '123', '123', '213', '1708303361_JUAN.jpg'),
(72, '123', '31', '13', '31', '31', '1708303404_JUAN.jpg'),
(73, '1232', '213', '123', '213', '123', '1708305270_JUAN.jpg'),
(74, 'asd', 'asd', 'asd', 'asd', 'sad', '1708307053_JUAN.jpg'),
(75, 'asd', 'sad', 'asd', 'asd', 'sad', '1708307987_JUAN.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_comentarios`
--

CREATE TABLE `tbl_comentarios` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `mensaje` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ingredientes` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `precio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_testimonios`
--

CREATE TABLE `tbl_testimonios` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `opinion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `paswoord` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_banners`
--
ALTER TABLE `tbl_banners`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tbl_colaboradores`
--
ALTER TABLE `tbl_colaboradores`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tbl_comentarios`
--
ALTER TABLE `tbl_comentarios`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tbl_testimonios`
--
ALTER TABLE `tbl_testimonios`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_banners`
--
ALTER TABLE `tbl_banners`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `tbl_colaboradores`
--
ALTER TABLE `tbl_colaboradores`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `tbl_comentarios`
--
ALTER TABLE `tbl_comentarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_testimonios`
--
ALTER TABLE `tbl_testimonios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
