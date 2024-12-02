-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-12-2024 a las 04:09:58
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
-- Base de datos: `app_store`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apps`
--

CREATE TABLE `apps` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `app_link` varchar(255) NOT NULL,
  `app_description` text NOT NULL,
  `app_icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `apps`
--

INSERT INTO `apps` (`id`, `user_id`, `app_name`, `app_link`, `app_description`, `app_icon`, `created_at`) VALUES
(1, 2, 'OpenTune', 'https://github.com/Arturo254/OpenTune/releases/download/1.9.0/app-foss-release.apk', 'Un cliente de YouTube Music con Material Design 3, para Android', 'icons/380010563-44f9d391-2615-4c43-87e6-59702586e0fd.png', '2024-12-02 00:21:19'),
(3, 2, 'YTDLnis', 'https://github.com/deniscerri/ytdlnis/releases/download/v1.8.1.1/YTDLnis-1.8.1.1-arm64-v8a-release.apk', 'Aplicación Android de Video/Audio Downloader usando yt-dlp', 'icons/ytdlnis.png', '2024-12-02 00:57:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT 'default-avatar.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `avatar`, `created_at`) VALUES
(2, 'Arturo254', 'cervantesarturo254@gmail.com', '$2y$10$hgKXnYCLAv31DcO6nIANEueuvW6pI/6qzCrj3rSvfUXi0aT99z1mu', 'avatar/avatar_674cfc5f9128d.jpeg', '2024-12-02 00:16:31');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apps`
--
ALTER TABLE `apps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `apps`
--
ALTER TABLE `apps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `apps`
--
ALTER TABLE `apps`
  ADD CONSTRAINT `apps_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
