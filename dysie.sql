-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2024 at 07:55 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dysie`
--

DELIMITER $$
--
-- Procedures
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
-- Table structure for table `administrador`
--

CREATE TABLE `administrador` (
  `usuario` varchar(10) NOT NULL,
  `contra` varchar(101) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `administrador`
--

INSERT INTO `administrador` (`usuario`, `contra`) VALUES
('admin', 'dysieadmin');

-- --------------------------------------------------------

--
-- Table structure for table `configuracion`
--

CREATE TABLE `configuracion` (
  `id_config` smallint(16) UNSIGNED NOT NULL,
  `idioma` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `moneda` decimal(10,3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delete_tarjeta`
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 KEY_BLOCK_SIZE=8 ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `delete_tarjeta`
--

INSERT INTO `delete_tarjeta` (`id_tarjetas`, `nom_tarjeta`, `plazo`, `color`, `fecha_creacion`, `fecha_delete`, `fecha_update`, `id_tablero`) VALUES
(57, 'sad', '0000-00-00 00:00:00', '', '2023-11-22 04:23:17', '2023-11-22 04:34:50', '2023-11-22 04:34:50', 70),
(56, 'fdsfsd', '0000-00-00 00:00:00', '', '2023-11-22 04:12:05', '2023-11-22 04:12:14', '2023-11-22 04:12:14', 70),
(60, 'asd', '0000-00-00 00:00:00', '', '2023-11-22 05:01:51', '2023-11-22 05:02:26', '2023-11-22 05:02:26', 70),
(59, 'asd', '0000-00-00 00:00:00', '', '2023-11-22 05:01:24', '2023-11-22 05:02:27', '2023-11-22 05:02:27', 70),
(62, 'OAnichdip', '0000-00-00 00:00:00', '', '2024-04-02 18:34:29', '2024-04-02 18:34:37', '2024-04-02 18:34:37', 75),
(64, 'GOku', '0000-00-00 00:00:00', '', '2024-04-29 21:38:19', '2024-04-29 21:38:24', '2024-04-29 21:38:24', 71),
(67, '1', '0000-00-00 00:00:00', '', '2024-06-23 02:13:32', '2024-06-23 03:14:17', '2024-06-23 03:14:17', 112),
(68, '2', '0000-00-00 00:00:00', '', '2024-06-23 02:13:36', '2024-06-23 03:14:19', '2024-06-23 03:14:19', 112),
(72, '6', '0000-00-00 00:00:00', '', '2024-06-23 02:13:50', '2024-06-23 03:14:21', '2024-06-23 03:14:21', 112),
(69, '3', '0000-00-00 00:00:00', '', '2024-06-23 02:13:40', '2024-06-23 03:14:23', '2024-06-23 03:14:23', 112),
(73, '7', '0000-00-00 00:00:00', '', '2024-06-23 02:13:54', '2024-06-23 03:14:24', '2024-06-23 03:14:24', 112),
(74, '8', '0000-00-00 00:00:00', '', '2024-06-23 02:13:57', '2024-06-23 03:14:25', '2024-06-23 03:14:25', 112),
(70, '4', '0000-00-00 00:00:00', '', '2024-06-23 02:13:43', '2024-06-23 03:14:27', '2024-06-23 03:14:27', 112),
(76, '10', '0000-00-00 00:00:00', '', '2024-06-23 02:14:05', '2024-06-23 03:14:28', '2024-06-23 03:14:28', 112),
(71, '5', '0000-00-00 00:00:00', '', '2024-06-23 02:13:47', '2024-06-23 03:14:29', '2024-06-23 03:14:29', 112),
(75, '9', '0000-00-00 00:00:00', '', '2024-06-23 02:14:01', '2024-06-23 03:14:31', '2024-06-23 03:14:31', 112),
(77, '1', '0000-00-00 00:00:00', '', '2024-06-23 02:14:12', '2024-06-23 03:14:34', '2024-06-23 03:14:34', 113),
(78, '2', '0000-00-00 00:00:00', '', '2024-06-23 02:14:15', '2024-06-23 03:14:36', '2024-06-23 03:14:36', 113),
(79, '3', '0000-00-00 00:00:00', '', '2024-06-23 02:14:17', '2024-06-23 03:14:37', '2024-06-23 03:14:37', 113),
(81, '5', '0000-00-00 00:00:00', '', '2024-06-23 02:14:25', '2024-06-23 03:14:39', '2024-06-23 03:14:39', 113),
(80, '4', '0000-00-00 00:00:00', '', '2024-06-23 02:14:21', '2024-06-23 03:14:41', '2024-06-23 03:14:41', 113),
(82, '6', '0000-00-00 00:00:00', '', '2024-06-23 02:14:30', '2024-06-23 03:14:43', '2024-06-23 03:14:43', 113),
(83, '7', '0000-00-00 00:00:00', '', '2024-06-23 02:15:18', '2024-06-23 03:14:45', '2024-06-23 03:14:45', 113),
(84, '8', '0000-00-00 00:00:00', '', '2024-06-23 02:15:22', '2024-06-23 03:14:46', '2024-06-23 03:14:46', 113),
(85, '9', '0000-00-00 00:00:00', '', '2024-06-23 02:15:25', '2024-06-23 03:14:48', '2024-06-23 03:14:48', 113),
(86, '10', '0000-00-00 00:00:00', '', '2024-06-23 02:15:29', '2024-06-23 03:14:50', '2024-06-23 03:14:50', 113),
(87, '1', '0000-00-00 00:00:00', '', '2024-06-23 02:15:42', '2024-06-23 03:16:17', '2024-06-23 03:16:17', 109),
(90, '4', '0000-00-00 00:00:00', '', '2024-06-23 02:15:52', '2024-06-23 03:16:18', '2024-06-23 03:16:18', 109),
(95, '9', '0000-00-00 00:00:00', '', '2024-06-23 02:16:06', '2024-06-23 03:16:19', '2024-06-23 03:16:19', 109),
(93, '7', '0000-00-00 00:00:00', '', '2024-06-23 02:16:00', '2024-06-23 03:16:21', '2024-06-23 03:16:21', 109),
(92, '6', '0000-00-00 00:00:00', '', '2024-06-23 02:15:58', '2024-06-23 03:16:22', '2024-06-23 03:16:22', 109),
(89, '3', '0000-00-00 00:00:00', '', '2024-06-23 02:15:48', '2024-06-23 03:16:23', '2024-06-23 03:16:23', 109),
(91, '5', '0000-00-00 00:00:00', '', '2024-06-23 02:15:55', '2024-06-23 03:16:24', '2024-06-23 03:16:24', 109),
(88, '2', '0000-00-00 00:00:00', '', '2024-06-23 02:15:45', '2024-06-23 03:16:26', '2024-06-23 03:16:26', 109),
(96, '10', '0000-00-00 00:00:00', '', '2024-06-23 02:16:11', '2024-06-23 03:16:28', '2024-06-23 03:16:28', 109),
(94, '8', '0000-00-00 00:00:00', '', '2024-06-23 02:16:03', '2024-06-23 03:16:34', '2024-06-23 03:16:34', 109);

-- --------------------------------------------------------

--
-- Table structure for table `delete_usu`
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `delete_usu`
--

INSERT INTO `delete_usu` (`id_usuario`, `nombre_usu`, `apellidos_usu`, `email`, `contra`, `foto`, `fecha_nacimiento`, `fecha_registro`, `fecha_delete`) VALUES
(146, 'sebastian', 'pareja ', 'sebas200420@gmail.co', '$2y$10$rRxZs.JIw304QZAAaz/8/emF7BvtElqqvDcG81GyqhyO.BZjIft/W', NULL, '2004-10-20', '2023-11-21 19:03:25', '2023-11-21'),
(147, 'sebastian', 'pareja ', 'sebas200420@gmail.co', '$2y$10$Bu/dO2QmvG2TqAKsWAogpOH8ioEJ88URWtTL1nAxuMspMmtpGmUJi', NULL, '2004-10-20', '2023-11-21 19:04:45', '2023-11-21'),
(148, 'sebastian', 'pareja ', 'sebas200420@gmail.co', '$2y$10$Yc0Igu4bbKuHIOZuZExOlOf7WPj55uDuAS6J72S8PiohHpzFGWnzG', NULL, '2004-10-20', '2023-11-21 19:06:41', '2023-11-21'),
(156, 'Brayan1', 'zapata', 'brayan@gmail.com', '$2y$10$5oQ7MJ412tjxHPiJAbH1HOAEFpOt4RW/6sGCwaXY0.20kIWjiOtvy', NULL, '2007-02-13', '2024-04-02 17:39:19', '2024-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `recordatorio`
--

CREATE TABLE `recordatorio` (
  `id_recordatorio` smallint(16) UNSIGNED NOT NULL,
  `nom_recordatorio` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tiempo_restante` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_tarjetas` smallint(16) NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tablero`
--

CREATE TABLE `tablero` (
  `id_tablero` smallint(16) UNSIGNED NOT NULL,
  `nom_tablero` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `color` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_modi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `tablero`
--

INSERT INTO `tablero` (`id_tablero`, `nom_tablero`, `descripcion`, `email`, `color`, `fecha_creacion`, `fecha_modi`) VALUES
(70, 'viernes ', '', 'sebas200420@gmail.com', 'linear-gradient(125deg, #ff5f60, #f9d423);', '2024-04-29 21:38:01', '2023-11-21 23:54:19'),
(68, 'hola', '', 'sebas200420@gmail.com', '#B0C4DE', '2023-11-21 23:54:15', '2023-11-21 23:54:15'),
(69, 'viernes', '', 'sebas200420@gmail.com', '#B0C4DE', '2023-11-21 23:54:18', '2023-11-21 23:54:18'),
(71, 'lol', '', 'sebas200420@gmail.com', '#28bf2e', '2024-04-17 18:58:55', '2023-11-21 23:54:21'),
(74, 'Buenas', '', 'restrepoc08@gmail.com', 'linear-gradient(125d', '2024-04-02 18:33:23', '2024-04-02 18:33:23'),
(73, 'Asereje aja eje', '', 'estivenmoto6@gmail.com', '#4496ff', '2024-04-02 18:29:06', '2024-04-02 18:29:06'),
(76, 'Marleny', '', 'brayan@gmail.com', 'linear-gradient(125deg, #ff5f60, #f9d423);', '2024-04-02 22:42:27', '2024-04-02 22:41:28'),
(112, '12345', '', 'morales2006sm@gmail.com', '#4496ff', '2024-06-23 02:11:52', '2024-06-23 02:11:52'),
(113, 'morales', '', 'morales2006sm@gmail.com', '#4496ff', '2024-06-23 02:13:10', '2024-06-23 02:13:10'),
(121, 'omg', '', 'morales2006sm@gmail.com', '#4496ff', '2024-06-24 01:44:44', '2024-06-24 01:44:44'),
(111, '1234', '', 'morales2006sm@gmail.com', '#4496ff', '2024-06-23 02:11:50', '2024-06-23 02:11:50'),
(110, '123', '', 'morales2006sm@gmail.com', '#4496ff', '2024-06-23 02:11:47', '2024-06-23 02:11:47'),
(115, '2', '', 'morales2006sm@gmail.com', '#4496ff', '2024-06-23 03:20:50', '2024-06-23 03:20:50'),
(114, '1', '', 'morales2006sm@gmail.com', '#4496ff', '2024-06-23 03:20:48', '2024-06-23 03:20:48'),
(117, '333', '', 'morales2006sm@gmail.com', '#4496ff', '2024-06-24 01:35:03', '2024-06-24 01:35:03'),
(118, '33333', '', 'morales2006sm@gmail.com', '#4496ff', '2024-06-24 01:35:17', '2024-06-24 01:35:17'),
(119, '20', '', 'morales2006sm@gmail.com', '#4496ff', '2024-06-24 01:41:28', '2024-06-24 01:41:28'),
(120, '21', '', 'morales2006sm@gmail.com', '#4496ff', '2024-06-24 01:41:40', '2024-06-24 01:41:40'),
(116, '3', '', 'morales2006sm@gmail.com', '#4496ff', '2024-06-23 03:20:51', '2024-06-23 03:20:51');

-- --------------------------------------------------------

--
-- Table structure for table `tarjeta`
--

CREATE TABLE `tarjeta` (
  `id_tarjetas` smallint(16) NOT NULL,
  `nom_tarjeta` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `plazo` datetime NOT NULL,
  `color` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modi` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_update` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_tablero` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `tarjeta`
--

INSERT INTO `tarjeta` (`id_tarjetas`, `nom_tarjeta`, `email`, `plazo`, `color`, `fecha_creacion`, `fecha_modi`, `fecha_update`, `id_tablero`) VALUES
(58, 'vacaciones', '', '0000-00-00 00:00:00', '', '2023-11-22 04:34:52', '2023-11-22 04:34:52', '2023-11-22 04:34:52', 70),
(61, 'Malparido', '', '0000-00-00 00:00:00', '', '2024-04-02 18:33:37', '2024-04-02 18:33:37', '2024-04-02 18:33:37', 74),
(63, 'informe', '', '0000-00-00 00:00:00', '', '2024-04-02 22:42:39', '2024-04-02 22:42:39', '2024-04-02 22:42:39', 76),
(65, '1', '', '0000-00-00 00:00:00', '', '2024-06-22 01:19:44', '2024-06-22 01:19:44', '2024-06-22 01:19:44', 77),
(66, '2', '', '0000-00-00 00:00:00', '', '2024-06-22 18:00:20', '2024-06-22 18:00:20', '2024-06-22 18:00:20', 77),
(99, '1', '', '0000-00-00 00:00:00', '', '2024-06-23 03:21:45', '2024-06-23 03:21:45', '2024-06-23 03:21:45', 114),
(100, '1', '', '0000-00-00 00:00:00', '', '2024-06-23 03:22:40', '2024-06-23 03:22:40', '2024-06-23 03:22:40', 110),
(101, '1', '', '0000-00-00 00:00:00', '', '2024-06-24 01:44:56', '2024-06-24 01:44:56', '2024-06-24 01:44:56', 121),
(97, '1', '', '0000-00-00 00:00:00', '', '2024-06-23 03:21:31', '2024-06-23 03:21:31', '2024-06-23 03:21:31', 116),
(98, '1', '', '0000-00-00 00:00:00', '', '2024-06-23 03:21:38', '2024-06-23 03:21:38', '2024-06-23 03:21:38', 103);

--
-- Triggers `tarjeta`
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
-- Table structure for table `update_tarjeta`
--

CREATE TABLE `update_tarjeta` (
  `id_tarjetas` smallint(16) UNSIGNED NOT NULL,
  `nom_tarjeta` varchar(25) NOT NULL,
  `plazo` datetime NOT NULL,
  `color` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_update` date NOT NULL,
  `id_tablero` smallint(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `update_tarjeta`
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
-- Table structure for table `update_usu`
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `update_usu`
--

INSERT INTO `update_usu` (`id_usuario`, `nombre_usu`, `apellido_usu`, `email`, `contra`, `fecha_nacimiento`, `fecha_registro`, `fecha_update`) VALUES
(135, 'sebastian', 'pareja', 'sebas200420@gmail.co', '$2y$10$Vin9OnpbAyQvjul5hSLFd.dFJNWDm.mqYdNeX6u9egjb8zbJ6kyZW', '2004-10-20', '2023-10-29 00:10:08', '2023-11-12 23:35:41'),
(153, 'Valentina', 'Muñoz', 'vmf21112005@gmail.co', '$2y$10$tOPVXiGo/408H7MvA5slSuLG9dlqC2D5qxj8morGzMQSizhw58Uha', '2005-11-21', '2024-04-02 18:37:47', '2024-04-02 18:38:46'),
(156, 'Brayan', 'zapata', 'brayan@gmail.com', '$2y$10$0bidWt5p0R.3Cm59l.JYO.MQLbe1jTBtzwGiuFbKH1.hLg1GTlcTi', '2007-02-13', '2024-04-02 22:38:04', '2024-04-02 22:39:19'),
(158, 'sebastian', 'morales', 'morales2006sm@gmail.', '$2y$10$b03yG1/H0wzpElMd1sxapuV4VWpCsFloD/gs7Cz64ZzaW2EwN4MGS', '2006-04-06', '2024-06-22 23:18:18', '2024-06-22 23:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
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
  `roles` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `grado` int(2) NOT NULL,
  `nombre_membresia` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usu`, `apellidos_usu`, `email`, `contra`, `fecha_nacimiento`, `fecha_registro`, `fecha_update`, `roles`, `grado`, `nombre_membresia`) VALUES
(149, 'sebastian', 'pareja ', 'sebas200420@gmail.com', '$2y$10$7WwflDipwn75iK0Sq1Vsr.4MvUwyalyDajqkvr9gJ.Q7ZdCkyd7qC', '2004-10-20', '2024-06-22 17:45:09', '0000-00-00 00:00:00', 'estudiante', 0, 0),
(145, 'sebastian', 'pareja ', 'sebas2004@gmail.com', '$2y$10$NdJ7y6IqHHF/uihQcK1etOF1HGcJc.nm3lablAfpJDrE3PdYjcYB.', '2004-10-20', '2024-06-22 01:52:47', '2023-11-12 23:05:26', '', 0, 1),
(150, 'Estiven', 'Montoya Torres', 'estivenmoto6@gmail.com', '$2y$10$kj/dJFrJLXzAMpk8u/a3Fu8.P1d/dsZr6kKSqd.IGKmd.gO9vuwjy', '2005-05-04', '2024-04-02 18:21:18', '2024-04-02 18:21:18', '', 0, 0),
(151, 'Carlos ', 'Restrepo', 'restrepoc08@gmail.com', '$2y$10$B.7fOesCduY2e0M1ZPOCHeHJ3o3p1hjy2jKnKVcFlU9hif8gvicTW', '2005-06-19', '2024-04-02 18:32:12', '2024-04-02 18:32:12', '', 0, 0),
(152, 'Isabela ', 'Rubio', 'isatejada@gmail.com', '$2y$10$P/xXtDampU6Igm/K0ac32.eu9bl26vVGyK6H3Xk46CK6oXZ9G64lG', '2006-03-06', '2024-04-02 18:33:11', '2024-04-02 18:33:11', '', 0, 0),
(153, 'Vale', 'Muñoz', 'vmf21112005@gmail.com', '$2y$10$sldjn2XDQ.k2dJesLLfFZ.Hi5BN7kZiSvFodndureYrr.famyQSP2', '2005-11-21', '2024-06-22 18:52:09', '0000-00-00 00:00:00', '', 0, 0),
(154, 'kevin', 'monsalve', 'kmonsalve004@gmail.com', '$2y$10$.XWEpxVp1lr8WzO6l5iUseLjpxL0vuNC98pt90oIeX4/Kmc3Olnnm', '2005-09-12', '2024-06-22 18:26:51', '2024-04-02 19:41:39', '', 0, 0),
(155, 'ppp', 'ppp', 'ppp@com', '$2y$10$VdtVm5jsbhTStOd1aj0pZu.uIlJcK/C4XMrZ0kV09ZlzTy5GquhqK', '2004-06-09', '2024-06-22 18:26:48', '2024-04-02 22:01:30', '', 0, 0),
(157, 'Carlos', 'Restrepo', 'sebas@ma', '$2y$10$Jyy9NM5t//ULxfeY2DLDyeCkYQe5Prism1BSk/BeHUyuRWK7S8zT.', '2004-10-20', '2024-06-22 18:29:50', '2024-04-24 22:32:36', 'estudiante', 0, 1),
(158, 'sebastian', 'morales', 'morales2006sm@gmail.com', '$2y$10$b03yG1/H0wzpElMd1sxapuV4VWpCsFloD/gs7Cz64ZzaW2EwN4MGS', '2006-04-06', '2024-06-24 01:44:34', '2024-06-22 01:09:32', 'estudiante', 0, 0);

--
-- Triggers `usuario`
--
DELIMITER $$
CREATE TRIGGER `delete_usu` AFTER DELETE ON `usuario` FOR EACH ROW BEGIN
INSERT INTO delete_usu(id_usuario, nombre_usu, apellidos_usu, email, contra, fecha_nacimiento, fecha_registro, fecha_delete)
VALUES (old.id_usuario, old.nombre_usu, old.apellidos_usu, old.email, old.contra, old.fecha_nacimiento, old.fecha_registro, now());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_usu` AFTER UPDATE ON `usuario` FOR EACH ROW BEGIN
INSERT INTO update_usu(id_usuario, nombre_usu, apellido_usu, email, contra, fecha_nacimiento, fecha_registro, fecha_update)
VALUES (old.id_usuario, old.nombre_usu, old.apellidos_usu, old.email, old.contra, old.fecha_nacimiento, old.fecha_registro, now());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `vista_usuarios_sin_foto`
-- (See below for the actual view)
--
CREATE TABLE `vista_usuarios_sin_foto` (
`id_usuario` smallint(16) unsigned
,`nombre_usu` varchar(50)
,`apellidos_usu` varchar(50)
,`email` varchar(100)
,`contra` varchar(101)
,`fecha_nacimiento` date
,`fecha_registro` timestamp
,`fecha_update` timestamp
,`roles` varchar(30)
,`grado` int(2)
,`nombre_membresia` tinyint(1)
);

-- --------------------------------------------------------

--
-- Structure for view `vista_usuarios_sin_foto`
--
DROP TABLE IF EXISTS `vista_usuarios_sin_foto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_usuarios_sin_foto`  AS SELECT `usuario`.`id_usuario` AS `id_usuario`, `usuario`.`nombre_usu` AS `nombre_usu`, `usuario`.`apellidos_usu` AS `apellidos_usu`, `usuario`.`email` AS `email`, `usuario`.`contra` AS `contra`, `usuario`.`fecha_nacimiento` AS `fecha_nacimiento`, `usuario`.`fecha_registro` AS `fecha_registro`, `usuario`.`fecha_update` AS `fecha_update`, `usuario`.`roles` AS `roles`, `usuario`.`grado` AS `grado`, `usuario`.`nombre_membresia` AS `nombre_membresia` FROM `usuario``usuario`  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id_config`);

--
-- Indexes for table `delete_tarjeta`
--
ALTER TABLE `delete_tarjeta`
  ADD PRIMARY KEY (`id_tarjetas`) KEY_BLOCK_SIZE=1024,
  ADD KEY `fk_eliminar_tarjeta_tablero` (`id_tablero`) KEY_BLOCK_SIZE=1024;

--
-- Indexes for table `delete_usu`
--
ALTER TABLE `delete_usu`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indexes for table `recordatorio`
--
ALTER TABLE `recordatorio`
  ADD PRIMARY KEY (`id_recordatorio`),
  ADD UNIQUE KEY `FK` (`id_tarjetas`);

--
-- Indexes for table `tablero`
--
ALTER TABLE `tablero`
  ADD PRIMARY KEY (`id_tablero`);

--
-- Indexes for table `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD PRIMARY KEY (`id_tarjetas`),
  ADD KEY `id_tablero` (`id_tablero`);

--
-- Indexes for table `update_tarjeta`
--
ALTER TABLE `update_tarjeta`
  ADD PRIMARY KEY (`id_tarjetas`),
  ADD KEY `fk_update_tarjeta` (`id_tablero`);

--
-- Indexes for table `update_usu`
--
ALTER TABLE `update_usu`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id_config` smallint(16) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delete_tarjeta`
--
ALTER TABLE `delete_tarjeta`
  MODIFY `id_tarjetas` smallint(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `delete_usu`
--
ALTER TABLE `delete_usu`
  MODIFY `id_usuario` smallint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `recordatorio`
--
ALTER TABLE `recordatorio`
  MODIFY `id_recordatorio` smallint(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tablero`
--
ALTER TABLE `tablero`
  MODIFY `id_tablero` smallint(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `tarjeta`
--
ALTER TABLE `tarjeta`
  MODIFY `id_tarjetas` smallint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `update_tarjeta`
--
ALTER TABLE `update_tarjeta`
  MODIFY `id_tarjetas` smallint(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `update_usu`
--
ALTER TABLE `update_usu`
  MODIFY `id_usuario` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` smallint(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
