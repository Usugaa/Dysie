-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-05-2024 a las 08:43:45
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dysie`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarRecordatorio` (IN `nuevo_nom_recordatorio` VARCHAR(255), IN `id_tarjeta` INT)   BEGIN
    DECLARE contador INT;
    
    SELECT COUNT(*) INTO contador
    FROM recordatorio
    WHERE nom_recordatorio = nuevo_nom_recordatorio;
    
    IF contador = 0 THEN
        INSERT INTO recordatorio (nom_recordatorio, tiempo_restante, fecha_creacion, id_tarjetas)
        VALUES (nuevo_nom_recordatorio, NOW(), NOW(), id_tarjeta);
        SELECT 'Recordatorio agregado exitosamente.' AS mensaje;
    ELSE
        SELECT 'Ya existe un recordatorio con el mismo nombre.' AS mensaje;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarTarjeta` (IN `nuevo_nom_tarjeta` VARCHAR(255), IN `nuevo_plazo` INT, IN `nuevo_color` VARCHAR(50), IN `nuevo_id_tablero` INT)   BEGIN
    DECLARE contador INT;

    -- Validar si el nombre de la tarjeta ya existe
    SELECT COUNT(*) INTO contador
    FROM tarjeta
    WHERE nom_tarjeta = nuevo_nom_tarjeta;
    
    IF contador = 0 THEN
        -- Validar que el plazo sea positivo
        IF nuevo_plazo > 0 THEN
            -- Validar que el color no esté vacío
            IF nuevo_color != '' THEN
                -- Validar que el ID de tablero exista
                IF EXISTS (SELECT 1 FROM tablero WHERE id_tablero = nuevo_id_tablero) THEN
                    -- Insertar la nueva tarjeta
                    INSERT INTO tarjeta (id_tarjetas,nom_tarjeta, plazo, color, fecha_creacion, id_tablero, fecha_modi)
                    VALUES (nuevo_nom_tarjeta, nuevo_plazo, nuevo_color, NOW(), nuevo_id_tablero, NOW());
                    SELECT 'Tarjeta insertada exitosamente.' AS mensaje;
                ELSE
                    SELECT 'El ID de tablero no existe.' AS mensaje;
                END IF;
            ELSE
                SELECT 'El campo de color no puede estar vacío.' AS mensaje;
            END IF;
        ELSE
            SELECT 'El plazo debe ser mayor que 0.' AS mensaje;
        END IF;
    ELSE
        SELECT 'Ya existe una tarjeta con el mismo nombre.' AS mensaje;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarUsuario` (IN `nombre_usuario` VARCHAR(255), IN `apellidos_usuario` VARCHAR(255), IN `email_usuario` VARCHAR(255), IN `contra_encriptada` VARCHAR(255), IN `fecha_nacimiento_usuario` DATE)   BEGIN
    DECLARE contador INT;

    -- Verificar si el email ya existe
    SELECT COUNT(*) INTO contador
    FROM usuario
    WHERE email = email_usuario;

    IF contador > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El email ya está en uso.';
    ELSE
        -- Insertar el nuevo usuario si el email no existe
        INSERT INTO usuario (nombre_usu, apellidos_usu, email, contra_encrip, fecha_nacimiento, fecha_registro)
        VALUES (nombre_usuario, apellidos_usuario, email_usuario, contra_encriptada, fecha_nacimiento_usuario, NOW());
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ValidarEInsertarTablero` (IN `nuevo_nom_tablero` VARCHAR(255), IN `nueva_descripcion` TEXT, IN `nuevo_email` VARCHAR(255), IN `nuevo_color` VARCHAR(50))   BEGIN
    DECLARE contador INT;

    -- Validar que el nombre de tablero no esté en uso
    SELECT COUNT(*) INTO contador
    FROM tablero
    WHERE nom_tablero = nuevo_nom_tablero;

    IF contador = 0 THEN
        -- Insertar el nuevo tablero
        INSERT INTO tablero (nom_tablero, descripcion, email, color, fecha_creacion, fecha_modi)
        VALUES (nuevo_nom_tablero, nueva_descripcion, nuevo_email, nuevo_color, NOW(), NOW());
        SELECT 'Tablero insertado exitosamente.' AS mensaje;
    ELSE
        SELECT 'Ya existe un tablero con el mismo nombre.' AS mensaje;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `usuario` varchar(10) NOT NULL,
  `contra` varchar(101) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`usuario`, `contra`) VALUES
('admin', 'dysieadmin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id_config` smallint(16) UNSIGNED NOT NULL,
  `idioma` varchar(50) NOT NULL,
  `moneda` decimal(10,3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `delete_tarjeta`
--

CREATE TABLE `delete_tarjeta` (
  `id_tarjetas` smallint(16) UNSIGNED NOT NULL,
  `nom_tarjeta` varchar(25) NOT NULL,
  `plazo` datetime NOT NULL,
  `color` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_delete` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_update` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_tablero` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci KEY_BLOCK_SIZE=8 ROW_FORMAT=COMPRESSED;

--
-- Volcado de datos para la tabla `delete_tarjeta`
--

INSERT INTO `delete_tarjeta` (`id_tarjetas`, `nom_tarjeta`, `plazo`, `color`, `fecha_creacion`, `fecha_delete`, `fecha_update`, `id_tablero`) VALUES
(57, 'sad', '0000-00-00 00:00:00', '', '2023-11-22 04:23:17', '2023-11-22 04:34:50', '2023-11-22 04:34:50', 70),
(56, 'fdsfsd', '0000-00-00 00:00:00', '', '2023-11-22 04:12:05', '2023-11-22 04:12:14', '2023-11-22 04:12:14', 70),
(60, 'asd', '0000-00-00 00:00:00', '', '2023-11-22 05:01:51', '2023-11-22 05:02:26', '2023-11-22 05:02:26', 70),
(59, 'asd', '0000-00-00 00:00:00', '', '2023-11-22 05:01:24', '2023-11-22 05:02:27', '2023-11-22 05:02:27', 70),
(62, 'OAnichdip', '0000-00-00 00:00:00', '', '2024-04-02 18:34:29', '2024-04-02 18:34:37', '2024-04-02 18:34:37', 75),
(64, 'GOku', '0000-00-00 00:00:00', '', '2024-04-29 21:38:19', '2024-04-29 21:38:24', '2024-04-29 21:38:24', 71);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `delete_usu`
--

CREATE TABLE `delete_usu` (
  `id_usuario` smallint(16) NOT NULL,
  `nombre_usu` varchar(50) NOT NULL,
  `apellidos_usu` varchar(50) NOT NULL,
  `email` varchar(20) NOT NULL,
  `contra` varchar(101) NOT NULL,
  `foto` blob DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_delete` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `delete_usu`
--

INSERT INTO `delete_usu` (`id_usuario`, `nombre_usu`, `apellidos_usu`, `email`, `contra`, `foto`, `fecha_nacimiento`, `fecha_registro`, `fecha_delete`) VALUES
(146, 'sebastian', 'pareja ', 'sebas200420@gmail.co', '$2y$10$rRxZs.JIw304QZAAaz/8/emF7BvtElqqvDcG81GyqhyO.BZjIft/W', NULL, '2004-10-20', '2023-11-21 19:03:25', '2023-11-21'),
(147, 'sebastian', 'pareja ', 'sebas200420@gmail.co', '$2y$10$Bu/dO2QmvG2TqAKsWAogpOH8ioEJ88URWtTL1nAxuMspMmtpGmUJi', NULL, '2004-10-20', '2023-11-21 19:04:45', '2023-11-21'),
(148, 'sebastian', 'pareja ', 'sebas200420@gmail.co', '$2y$10$Yc0Igu4bbKuHIOZuZExOlOf7WPj55uDuAS6J72S8PiohHpzFGWnzG', NULL, '2004-10-20', '2023-11-21 19:06:41', '2023-11-21'),
(156, 'Brayan1', 'zapata', 'brayan@gmail.com', '$2y$10$5oQ7MJ412tjxHPiJAbH1HOAEFpOt4RW/6sGCwaXY0.20kIWjiOtvy', NULL, '2007-02-13', '2024-04-02 17:39:19', '2024-04-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recordatorio`
--

CREATE TABLE `recordatorio` (
  `id_recordatorio` smallint(16) UNSIGNED NOT NULL,
  `nom_recordatorio` varchar(50) NOT NULL,
  `tiempo_restante` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_tarjetas` smallint(16) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablero`
--

CREATE TABLE `tablero` (
  `id_tablero` smallint(16) UNSIGNED NOT NULL,
  `nom_tablero` varchar(50) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `color` varchar(100) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_modi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tablero`
--

INSERT INTO `tablero` (`id_tablero`, `nom_tablero`, `descripcion`, `email`, `color`, `fecha_creacion`, `fecha_modi`) VALUES
(70, 'viernes ', '', 'sebas200420@gmail.com', 'linear-gradient(125deg, #ff5f60, #f9d423);', '2024-04-29 21:38:01', '2023-11-21 23:54:19'),
(68, 'hola', '', 'sebas200420@gmail.com', '#B0C4DE', '2023-11-21 23:54:15', '2023-11-21 23:54:15'),
(69, 'viernes', '', 'sebas200420@gmail.com', '#B0C4DE', '2023-11-21 23:54:18', '2023-11-21 23:54:18'),
(71, 'lol', '', 'sebas200420@gmail.com', '#28bf2e', '2024-04-17 18:58:55', '2023-11-21 23:54:21'),
(74, 'Buenas', '', 'restrepoc08@gmail.com', 'linear-gradient(125d', '2024-04-02 18:33:23', '2024-04-02 18:33:23'),
(73, 'Asereje aja eje', '', 'estivenmoto6@gmail.com', '#4496ff', '2024-04-02 18:29:06', '2024-04-02 18:29:06'),
(76, 'Marleny', '', 'brayan@gmail.com', 'linear-gradient(125deg, #ff5f60, #f9d423);', '2024-04-02 22:42:27', '2024-04-02 22:41:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE `tarjeta` (
  `id_tarjetas` smallint(16) NOT NULL,
  `nom_tarjeta` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `plazo` datetime NOT NULL,
  `color` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_update` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_tablero` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tarjeta`
--

INSERT INTO `tarjeta` (`id_tarjetas`, `nom_tarjeta`, `email`, `plazo`, `color`, `fecha_creacion`, `fecha_modi`, `fecha_update`, `id_tablero`) VALUES
(58, 'vacaciones', '', '0000-00-00 00:00:00', '', '2023-11-22 04:34:52', '2023-11-22 04:34:52', '2023-11-22 04:34:52', 70),
(61, 'Malparido', '', '0000-00-00 00:00:00', '', '2024-04-02 18:33:37', '2024-04-02 18:33:37', '2024-04-02 18:33:37', 74),
(63, 'informe', '', '0000-00-00 00:00:00', '', '2024-04-02 22:42:39', '2024-04-02 22:42:39', '2024-04-02 22:42:39', 76);

--
-- Disparadores `tarjeta`
--
DELIMITER $$
CREATE TRIGGER `before_update_tarjeta` BEFORE UPDATE ON `tarjeta` FOR EACH ROW BEGIN
    -- Declara la variable antes de asignarle un valor
    DECLARE fecha_actualizacion DATETIME;

    -- Utiliza SET para asignar el valor a la variable
    SET fecha_actualizacion = NOW();

    -- Inserta en update_tarjeta solo si hay cambios
    IF NEW.nom_tarjeta <> OLD.nom_tarjeta  THEN
        INSERT INTO update_tarjeta (id_tarjetas, nom_tarjeta, plazo, color, fecha_creacion, id_tablero, fecha_update)
        VALUES (id_tarjetas, OLD.nom_tarjeta, OLD.plazo, OLD.color, OLD.fecha_creacion, OLD.id_tablero, fecha_actualizacion);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_tarjeta` AFTER DELETE ON `tarjeta` FOR EACH ROW BEGIN
INSERT INTO delete_tarjeta(id_tarjetas,nom_tarjeta,plazo,color,fecha_creacion,fecha_delete,id_tablero)
VALUES (old.id_tarjetas, old.nom_tarjeta,old.plazo,old.color,old.fecha_creacion,now(),old.id_tablero);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `update_tarjeta`
--

CREATE TABLE `update_tarjeta` (
  `id_tarjetas` smallint(16) UNSIGNED NOT NULL,
  `nom_tarjeta` varchar(25) NOT NULL,
  `plazo` datetime NOT NULL,
  `color` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_update` date NOT NULL,
  `id_tablero` smallint(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `update_tarjeta`
--

INSERT INTO `update_tarjeta` (`id_tarjetas`, `nom_tarjeta`, `plazo`, `color`, `fecha_creacion`, `fecha_update`, `id_tablero`) VALUES
(1, 'sevas', '0000-00-00 00:00:00', '', '2023-11-22 04:34:52', '2023-11-22', 70),
(2, 'segasd', '0000-00-00 00:00:00', '', '2023-11-22 04:34:52', '2023-11-22', 70),
(3, 'sevas', '0000-00-00 00:00:00', '', '2023-11-22 04:34:52', '2023-11-22', 70),
(4, 'ssvas', '0000-00-00 00:00:00', '', '2023-11-22 04:34:52', '2023-11-22', 70),
(5, 'sebastian', '0000-00-00 00:00:00', '', '2023-11-22 04:34:52', '2023-11-22', 70),
(6, 'asd', '0000-00-00 00:00:00', '', '2023-11-22 04:34:52', '2023-11-22', 70);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `update_usu`
--

CREATE TABLE `update_usu` (
  `id_usuario` int(16) NOT NULL,
  `nombre_usu` varchar(50) NOT NULL,
  `apellido_usu` varchar(50) NOT NULL,
  `email` varchar(20) NOT NULL,
  `contra` varchar(101) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_update` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `update_usu`
--

INSERT INTO `update_usu` (`id_usuario`, `nombre_usu`, `apellido_usu`, `email`, `contra`, `fecha_nacimiento`, `fecha_registro`, `fecha_update`) VALUES
(135, 'sebastian', 'pareja', 'sebas200420@gmail.co', '$2y$10$Vin9OnpbAyQvjul5hSLFd.dFJNWDm.mqYdNeX6u9egjb8zbJ6kyZW', '2004-10-20', '2023-10-29 00:10:08', '2023-11-12 23:35:41'),
(153, 'Valentina', 'Muñoz', 'vmf21112005@gmail.co', '$2y$10$tOPVXiGo/408H7MvA5slSuLG9dlqC2D5qxj8morGzMQSizhw58Uha', '2005-11-21', '2024-04-02 18:37:47', '2024-04-02 18:38:46'),
(156, 'Brayan', 'zapata', 'brayan@gmail.com', '$2y$10$0bidWt5p0R.3Cm59l.JYO.MQLbe1jTBtzwGiuFbKH1.hLg1GTlcTi', '2007-02-13', '2024-04-02 22:38:04', '2024-04-02 22:39:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` smallint(16) UNSIGNED NOT NULL,
  `nombre_usu` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `apellidos_usu` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `contra` varchar(101) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_update` timestamp NOT NULL DEFAULT current_timestamp(),
  `roles` varchar(30) NOT NULL,
  `grado` int(2) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `nombre_membresia` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usu`, `apellidos_usu`, `email`, `contra`, `fecha_nacimiento`, `fecha_registro`, `fecha_update`, `roles`, `grado`, `foto`, `nombre_membresia`) VALUES
(149, 'sebastian', 'pareja ', 'sebas200420@gmail.com', '$2y$10$7WwflDipwn75iK0Sq1Vsr.4MvUwyalyDajqkvr9gJ.Q7ZdCkyd7qC', '2004-10-20', '2024-05-08 06:29:44', '0000-00-00 00:00:00', 'estudiante', 0, '', 'free'),
(145, 'sebastian', 'pareja ', 'sebas2004@gmail.com', '$2y$10$NdJ7y6IqHHF/uihQcK1etOF1HGcJc.nm3lablAfpJDrE3PdYjcYB.', '2004-10-20', '2023-11-12 23:05:26', '2023-11-12 23:05:26', '', 0, '', ''),
(150, 'Estiven', 'Montoya Torres', 'estivenmoto6@gmail.com', '$2y$10$kj/dJFrJLXzAMpk8u/a3Fu8.P1d/dsZr6kKSqd.IGKmd.gO9vuwjy', '2005-05-04', '2024-04-02 18:21:18', '2024-04-02 18:21:18', '', 0, '', ''),
(151, 'Carlos ', 'Restrepo', 'restrepoc08@gmail.com', '$2y$10$B.7fOesCduY2e0M1ZPOCHeHJ3o3p1hjy2jKnKVcFlU9hif8gvicTW', '2005-06-19', '2024-04-02 18:32:12', '2024-04-02 18:32:12', '', 0, '', ''),
(152, 'Isabela ', 'Rubio', 'isatejada@gmail.com', '$2y$10$P/xXtDampU6Igm/K0ac32.eu9bl26vVGyK6H3Xk46CK6oXZ9G64lG', '2006-03-06', '2024-04-02 18:33:11', '2024-04-02 18:33:11', '', 0, '', ''),
(153, 'Vale', 'Muñoz', 'vmf21112005@gmail.com', '$2y$10$sldjn2XDQ.k2dJesLLfFZ.Hi5BN7kZiSvFodndureYrr.famyQSP2', '2005-11-21', '2024-04-02 18:38:46', '0000-00-00 00:00:00', '', 0, '', ''),
(154, 'kevin', 'monsalve', 'kmonsalve004@gmail.com', '$2y$10$.XWEpxVp1lr8WzO6l5iUseLjpxL0vuNC98pt90oIeX4/Kmc3Olnnm', '2005-09-12', '2024-04-02 19:41:39', '2024-04-02 19:41:39', '', 0, '', ''),
(155, 'ppp', 'ppp', 'ppp@com', '$2y$10$VdtVm5jsbhTStOd1aj0pZu.uIlJcK/C4XMrZ0kV09ZlzTy5GquhqK', '2004-06-09', '2024-04-02 22:01:30', '2024-04-02 22:01:30', '', 0, '', ''),
(157, 'Carlos', 'Restrepo', 'sebas@ma', '$2y$10$Jyy9NM5t//ULxfeY2DLDyeCkYQe5Prism1BSk/BeHUyuRWK7S8zT.', '2004-10-20', '2024-04-24 22:32:36', '2024-04-24 22:32:36', 'estudiante', 0, '', '');

--
-- Disparadores `usuario`
--
DELIMITER $$
CREATE TRIGGER `delete_usu` AFTER DELETE ON `usuario` FOR EACH ROW BEGIN
INSERT INTO delete_usu(id_usuario, nombre_usu, apellidos_usu, email, contra, foto, fecha_nacimiento, fecha_registro, fecha_delete)
VALUES (old.id_usuario, old.nombre_usu, old.apellidos_usu, old.email, old.contra, old.foto, old.fecha_nacimiento, old.fecha_registro, now());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_usu` AFTER UPDATE ON `usuario` FOR EACH ROW BEGIN
INSERT INTO update_usu(id_usuario, nombre_usu, apellido_usu, email, contra, foto, fecha_nacimiento, fecha_registro, fecha_update)
VALUES (old.id_usuario, old.nombre_usu, old.apellidos_usu, old.email, old.contra, old.foto, old.fecha_nacimiento, old.fecha_registro, now());
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id_config`);

--
-- Indices de la tabla `delete_tarjeta`
--
ALTER TABLE `delete_tarjeta`
  ADD PRIMARY KEY (`id_tarjetas`) KEY_BLOCK_SIZE=1024,
  ADD KEY `fk_eliminar_tarjeta_tablero` (`id_tablero`) KEY_BLOCK_SIZE=1024;

--
-- Indices de la tabla `delete_usu`
--
ALTER TABLE `delete_usu`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `recordatorio`
--
ALTER TABLE `recordatorio`
  ADD PRIMARY KEY (`id_recordatorio`),
  ADD UNIQUE KEY `FK` (`id_tarjetas`);

--
-- Indices de la tabla `tablero`
--
ALTER TABLE `tablero`
  ADD PRIMARY KEY (`id_tablero`);

--
-- Indices de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD PRIMARY KEY (`id_tarjetas`),
  ADD KEY `id_tablero` (`id_tablero`);

--
-- Indices de la tabla `update_tarjeta`
--
ALTER TABLE `update_tarjeta`
  ADD PRIMARY KEY (`id_tarjetas`),
  ADD KEY `fk_update_tarjeta` (`id_tablero`);

--
-- Indices de la tabla `update_usu`
--
ALTER TABLE `update_usu`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id_config` smallint(16) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `delete_tarjeta`
--
ALTER TABLE `delete_tarjeta`
  MODIFY `id_tarjetas` smallint(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `delete_usu`
--
ALTER TABLE `delete_usu`
  MODIFY `id_usuario` smallint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT de la tabla `recordatorio`
--
ALTER TABLE `recordatorio`
  MODIFY `id_recordatorio` smallint(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tablero`
--
ALTER TABLE `tablero`
  MODIFY `id_tablero` smallint(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  MODIFY `id_tarjetas` smallint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `update_tarjeta`
--
ALTER TABLE `update_tarjeta`
  MODIFY `id_tarjetas` smallint(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `update_usu`
--
ALTER TABLE `update_usu`
  MODIFY `id_usuario` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` smallint(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
