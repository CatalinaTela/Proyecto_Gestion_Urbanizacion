-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 16-12-2024 a las 13:09:08
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `desarrollo_urbanistico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inmobiliarias`
--

DROP TABLE IF EXISTS `inmobiliarias`;
CREATE TABLE IF NOT EXISTS `inmobiliarias` (
  `id_agency` int NOT NULL AUTO_INCREMENT,
  `name_agency` varchar(20) NOT NULL,
  `mail_agency` varchar(50) NOT NULL,
  `phone_agency` varchar(15) NOT NULL,
  `website` varchar(50) NOT NULL,
  PRIMARY KEY (`id_agency`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `inmobiliarias`
--

INSERT INTO `inmobiliarias` (`id_agency`, `name_agency`, `mail_agency`, `phone_agency`, `website`) VALUES
(2, 'REMAX', 'remax@inmobiliaria.com', '+54968754656', 'https://www.remax.com.ar/'),
(3, 'Ferrara SA', 'ferrara@inmobiliaria.com', '+54968754693', 'https://www.ferrarapropiedades.com/');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operacion_inmobiliaria`
--

DROP TABLE IF EXISTS `operacion_inmobiliaria`;
CREATE TABLE IF NOT EXISTS `operacion_inmobiliaria` (
  `id_operation` int NOT NULL AUTO_INCREMENT,
  `operation_name` varchar(25) NOT NULL,
  PRIMARY KEY (`id_operation`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `operacion_inmobiliaria`
--

INSERT INTO `operacion_inmobiliaria` (`id_operation`, `operation_name`) VALUES
(13, 'alquiler turistico'),
(15, 'venta'),
(16, 'alquiler');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedades`
--

DROP TABLE IF EXISTS `propiedades`;
CREATE TABLE IF NOT EXISTS `propiedades` (
  `id_property` int NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `observations` varchar(200) NOT NULL,
  `ubication` varchar(50) NOT NULL,
  `value` int NOT NULL,
  `picture` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_type` int NOT NULL,
  `id_operation` int NOT NULL,
  PRIMARY KEY (`id_property`),
  KEY `id_type` (`id_type`),
  KEY `id_operation` (`id_operation`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `propiedades`
--

INSERT INTO `propiedades` (`id_property`, `title`, `description`, `observations`, `ubication`, `value`, `picture`, `id_type`, `id_operation`) VALUES
(25, 'casa', 'casa en venta', '...', 'bariloche', 5468135, '[\"assets\\/img\\/propiedad\\/675760ce5630c_casa.png\"]', 16, 15),
(26, 'dpto', 'se alquila dpto', '...', 'bariloche', 5468135, '[\"assets\\/img\\/propiedad\\/675c5eb3cb21c_casa.png\",\"assets\\/img\\/propiedad\\/675c5f0cbb23f_casa3.png\",\"assets\\/img\\/propiedad\\/675c5f0cbb5bc_casa4.png\",\"assets\\/img\\/propiedad\\/675c5f0cbb86c_casa5.png\",\"assets\\/img\\/propiedad\\/675c5f84e5151_casa5.png\",\"assets\\/img\\/propiedad\\/675c5fbcd346e_casa5.png\",\"assets\\/img\\/propiedad\\/675c5fc62b1ed_casa.png\"]', 17, 16),
(27, 'casa', 'se alquila casa', '.....', 'bariloche', 5468135, '[\"assets\\/img\\/propiedad\\/675760fa595d9_casa.png\",\"assets\\/img\\/propiedad\\/675c643d1f1ff_casa3.png\",\"assets\\/img\\/propiedad\\/675c643d202af_casa4.png\",\"assets\\/img\\/propiedad\\/675c643d207d1_casa5.png\"]', 16, 13),
(28, 'lote', 'lote en venta', '...', 'bariloche', 5468135, '[\"assets\\/img\\/propiedad\\/675c607d09790_casa.png\",\"assets\\/img\\/propiedad\\/675c607d1211c_casa3.png\",\"assets\\/img\\/propiedad\\/675c607d125b6_casa4.png\"]', 6, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_propiedad`
--

DROP TABLE IF EXISTS `tipo_propiedad`;
CREATE TABLE IF NOT EXISTS `tipo_propiedad` (
  `id_type` int NOT NULL AUTO_INCREMENT,
  `type_name` varchar(25) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tipo_propiedad`
--

INSERT INTO `tipo_propiedad` (`id_type`, `type_name`) VALUES
(6, 'Lote'),
(16, 'casa'),
(17, 'departamento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone` varchar(15) NOT NULL,
  `role` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `name`, `lastname`, `mail`, `password`, `phone`, `role`) VALUES
(11, 'Catalina', 'Tela', 'catatela@gmail.com', '$2y$10$FH3W9llstuRUXL4891n3dOJ29ecyAEkE5oQkWhjyUlC17/AAqSxoy', '+5492944568432', 'admin'),
(13, 'Hermes', 'Tela', 'hermes@gmail.com', '$2y$10$0xM0VQnm.zykDSs0LnsfUeguXKKE0KNwhrhdXbIAMDcjE4uEzfgK.', '+5492944568432', 'user'),
(14, 'cata', 'tela', 'tela.cata@gmail.com', '$2y$10$WGVL0JiR5fw9LAFiSVhMbeNYYhn2ZbotQaEoDe3gjbkkvARDamave', '+5497563214568', 'user'),
(15, 'admi', 'nistrador', 'admin@gmail.com', '$2y$10$KHc/Xyq0JuKskbpguZLCbesfUIztlEeBhDH/ozqm/HYBDONWXl1Qu', '+54687921354', 'admin'),
(16, 'user', 'usuario', 'user@gmail.com', '$2y$10$n.LkaD0TdU/u7/CneAmoneTqIQlYlQXfpx2skrVd2sm2xh9eLf3cy', '+54687921356', 'user');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `propiedades`
--
ALTER TABLE `propiedades`
  ADD CONSTRAINT `propiedades_ibfk_1` FOREIGN KEY (`id_operation`) REFERENCES `operacion_inmobiliaria` (`id_operation`),
  ADD CONSTRAINT `propiedades_ibfk_2` FOREIGN KEY (`id_type`) REFERENCES `tipo_propiedad` (`id_type`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
