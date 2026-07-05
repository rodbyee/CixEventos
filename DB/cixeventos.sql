-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2026 a las 22:47:57
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
-- Base de datos: `cixeventos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_evento_inmobiliario`
--

CREATE TABLE `detalle_evento_inmobiliario` (
  `id_detalle` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_apartado` datetime NOT NULL DEFAULT current_timestamp(),
  `devuelto` tinyint(4) DEFAULT 0,
  `fecha_devolucion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_evento_inmobiliario`
--

INSERT INTO `detalle_evento_inmobiliario` (`id_detalle`, `id_evento`, `id_item`, `cantidad`, `fecha_apartado`, `devuelto`, `fecha_devolucion`) VALUES
(15, 13, 4, 1, '2026-05-06 15:31:00', 0, NULL),
(16, 13, 7, 1, '2026-05-06 15:31:00', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inmobiliario`
--

CREATE TABLE `inmobiliario` (
  `id_item` int(11) NOT NULL,
  `nombre_item` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `stock_total` int(11) NOT NULL,
  `precio_renta` decimal(10,2) NOT NULL,
  `id_usuario_inv` int(11) NOT NULL,
  `stock_danado` int(11) NOT NULL,
  `stock_reparacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inmobiliario`
--

INSERT INTO `inmobiliario` (`id_item`, `nombre_item`, `descripcion`, `stock_total`, `precio_renta`, `id_usuario_inv`, `stock_danado`, `stock_reparacion`) VALUES
(1, 'Silla Thonet Cafe', 'Silla de amdera CAFE', 50, 15.00, 7, 0, 0),
(3, 'Abecedario', 'letras de colores', 70, 19.98, 7, 0, 0),
(4, 'Mesa madera abedul', 'Madera de abedul ', 199, 49.99, 6, 0, 0),
(7, 'refresco', '', 9, 67.00, 7, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `mensaje` varchar(500) NOT NULL,
  `leida` tinyint(4) DEFAULT 0,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id_notificacion`, `id_usuario`, `mensaje`, `leida`, `fecha`) VALUES
(1, 5, 'Tu evento \"XV isabrella\" ya pasó. Por favor confirma la devolución del mobiliario.', 0, '2026-05-05 16:56:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_preparado`
--

CREATE TABLE `pedido_preparado` (
  `id_pedido` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_preparado` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido_preparado`
--

INSERT INTO `pedido_preparado` (`id_pedido`, `id_evento`, `id_usuario`, `fecha_preparado`) VALUES
(1, 6, 6, '2026-05-06 10:43:41'),
(2, 14, 6, '2026-05-06 11:34:51'),
(3, 15, 12, '2026-05-06 11:47:21'),
(4, 13, 12, '2026-05-06 15:31:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registrar_evento`
--

CREATE TABLE `registrar_evento` (
  `id_evento` int(11) NOT NULL,
  `nombre_evento` varchar(500) NOT NULL,
  `fecha_evento` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT 'Pendiente',
  `notas_adicionales` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registrar_evento`
--

INSERT INTO `registrar_evento` (`id_evento`, `nombre_evento`, `fecha_evento`, `hora_inicio`, `hora_fin`, `direccion`, `id_usuario`, `estado`, `notas_adicionales`) VALUES
(3, 'XV Morales', '2026-05-15', '19:00:00', '02:00:00', 'Central Andalina', 5, 'Cancelado', NULL),
(5, 'Peda Masiva', '2026-05-19', '22:00:00', '07:00:00', 'Velamar', 5, 'Confirmado', NULL),
(6, 'Rocket hoy ', '2026-05-04', '18:00:00', '00:00:00', 'Casa SANTIAGO', 8, 'Listo para entregar', NULL),
(7, 'Festival de molletes', '2026-05-05', '00:00:00', '03:02:00', 'Sanborns', 9, 'Confirmado', NULL),
(9, 'XV isabrella', '2026-05-03', '10:00:00', '12:00:00', 'Nautico', 5, 'Confirmado', NULL),
(13, 'Clase hoy', '2026-05-06', '07:00:00', '20:00:00', 'Salon 220', 8, 'Confirmado', NULL),
(14, 'Festival de putas', '2026-05-20', '03:36:00', '05:38:00', 'Iest Anahuac', 13, 'Confirmado', NULL),
(15, 'Didifest', '2027-03-15', '13:50:00', '01:45:00', 'casa de didi', 14, 'Listo para entregar', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `tipo_de_rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `tipo_de_rol`) VALUES
(1, 'Admin'),
(2, 'Inventario'),
(3, 'Trabajador'),
(4, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id_tarea` int(11) NOT NULL,
  `id_remitente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `prioridad` enum('alta','media','baja') DEFAULT 'media',
  `fecha_limite` date DEFAULT NULL,
  `estado` enum('pendiente','completada') DEFAULT 'pendiente',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id_tarea`, `id_remitente`, `id_destinatario`, `titulo`, `descripcion`, `prioridad`, `fecha_limite`, `estado`, `fecha_creacion`) VALUES
(1, 6, 7, 'Prueba 1', 'hola', 'media', '2026-05-05', 'pendiente', '2026-05-06 03:41:37'),
(2, 6, 5, 'Prueba 2', 'Hola isa', 'media', '2026-05-05', 'completada', '2026-05-06 04:10:42'),
(3, 5, 6, 'Prueba a Admin 1', 'Hola guapeton', 'baja', '2026-05-05', 'completada', '2026-05-06 04:49:39'),
(4, 5, 7, 'Prueba dia 2', 'Hola', 'baja', '2026-05-06', 'pendiente', '2026-05-06 16:48:45'),
(5, 5, 7, 'Hola guapo', 'Hola', 'baja', '2026-05-06', 'pendiente', '2026-05-06 21:29:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `email_usuario` varchar(200) NOT NULL,
  `genero` text NOT NULL,
  `password_usuario` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `email_usuario`, `genero`, `password_usuario`, `id_rol`) VALUES
(5, 'Isabella Lopez', 'isa@lopez.com', 'Mujer', '$2y$10$BFVyKux2o0slxxriMIQKiua6k4GvcpwQJJVwG4aN1B/5T./3oeIOC', 1),
(6, 'Rodrigo Aguilar', 'rodrigo@aguilar.com', 'Hombre', '$2y$10$hacVGzDLbLyVYsgZIVWgQ.gY368UTPrBzzAJ4K5rsabsawGedIOnW', 1),
(7, 'Max Rios', 'max@rios.com', 'Hombre', '$2y$10$fd9x9a0YJVQ9ZtZkhD4xnetUpp0KNlSqYbr/nnjwF.lukOx4g9iV6', 2),
(8, 'Santiago Ramos', 'santi@ramos.com', 'Mujer', '$2y$10$A1G/8I51Mhd7dU5Q8yLcJOAWtdaJMTTjeeAPFt/rQwcAuWZFxtw8u', 4),
(9, 'Eduardo Venegas', 'verga@negra.com', 'Mujer', '$2y$10$RYNUd6P01LGDJwj0jFQnTOi26/F8slwQnfuXuhGcUn12uRtFXd7Ki', 4),
(12, 'Juan Perez', 'juan@perez.com', 'Hombre', '$2y$10$IfkaAeunc4288GQqATOdTO3RWDTXrvRUSuPl0K2QiwYgDGGH5dxoS', 3),
(13, 'Fernanda', 'fer@gmail.com', 'Mujer', '$2y$10$bgLoH0IjNuMP4pdPNJ1t4uWzGiNG/rI2zW9Xi2j1HiJR5y0Kpvh46', 4),
(14, 'eunice', 'eun@gmail.com', 'Mujer', '$2y$10$bxa0pZDwa2ga6S2HGX7YiOoCh16EXpxY/wV/L.MfkU54JP2Yj2eC2', 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_evento_inmobiliario`
--
ALTER TABLE `detalle_evento_inmobiliario`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_evento_vinculo` (`id_evento`),
  ADD KEY `fk_item_vinculo` (`id_item`);

--
-- Indices de la tabla `inmobiliario`
--
ALTER TABLE `inmobiliario`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `fk_usuario_inv` (`id_usuario_inv`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `fk_notif_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedido_preparado`
--
ALTER TABLE `pedido_preparado`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedido_evento` (`id_evento`),
  ADD KEY `fk_pedido_usuario` (`id_usuario`);

--
-- Indices de la tabla `registrar_evento`
--
ALTER TABLE `registrar_evento`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `fk_usuario_evento` (`id_usuario`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `id_remitente` (`id_remitente`),
  ADD KEY `id_destinatario` (`id_destinatario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `email_usuario` (`email_usuario`),
  ADD KEY `fk_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_evento_inmobiliario`
--
ALTER TABLE `detalle_evento_inmobiliario`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `inmobiliario`
--
ALTER TABLE `inmobiliario`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedido_preparado`
--
ALTER TABLE `pedido_preparado`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `registrar_evento`
--
ALTER TABLE `registrar_evento`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_evento_inmobiliario`
--
ALTER TABLE `detalle_evento_inmobiliario`
  ADD CONSTRAINT `fk_evento_vinculo` FOREIGN KEY (`id_evento`) REFERENCES `registrar_evento` (`id_evento`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_item_vinculo` FOREIGN KEY (`id_item`) REFERENCES `inmobiliario` (`id_item`);

--
-- Filtros para la tabla `inmobiliario`
--
ALTER TABLE `inmobiliario`
  ADD CONSTRAINT `fk_usuario_inv` FOREIGN KEY (`id_usuario_inv`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `fk_notif_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `pedido_preparado`
--
ALTER TABLE `pedido_preparado`
  ADD CONSTRAINT `fk_pedido_evento` FOREIGN KEY (`id_evento`) REFERENCES `registrar_evento` (`id_evento`),
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `registrar_evento`
--
ALTER TABLE `registrar_evento`
  ADD CONSTRAINT `fk_usuario_evento` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`id_remitente`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `tareas_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
