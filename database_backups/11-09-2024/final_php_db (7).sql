-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-09-2024 a las 00:10:44
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
-- Base de datos: `final_php_db`
--
CREATE DATABASE IF NOT EXISTS `final_php_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `final_php_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `fecha_cita` date NOT NULL,
  `motivo_cita` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id_noticia` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `imagen` text NOT NULL,
  `texto` longtext NOT NULL,
  `fecha` date NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id_noticia`, `titulo`, `imagen`, `texto`, `fecha`, `id_user`) VALUES
(9, 'Noticia 01', 'noticia1.jpg', 'Este es el texto de la primera noticia.', '2024-09-01', 1),
(10, 'Noticia 02', 'noticia2.jpg', 'Este es el texto de la segunda noticia.', '2024-09-02', 2),
(11, 'Noticia 03', 'noticia3.jpg', 'Este es el texto de la tercera noticia.', '2024-09-03', 3),
(12, 'Noticia 04', 'noticia4.jpg', 'Este es el texto de la cuarta noticia.', '2024-09-04', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_data`
--

CREATE TABLE `users_data` (
  `id_user` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `sexo` enum('masculino','femenino','otro') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users_data`
--

INSERT INTO `users_data` (`id_user`, `nombre`, `apellidos`, `email`, `telefono`, `fecha_nacimiento`, `direccion`, `sexo`) VALUES
(1, 'Larry', 'Yoffre', 'user1@gmail.com', '76543344444', '1988-09-22', 'Lavalleja1428', 'masculino'),
(2, 'Larry', 'Yoffre', 'user2@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(3, 'Larry', 'Yoffre', 'user3@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(4, 'Larry', 'Yoffre', 'user4@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(5, 'Larry', 'Yoffre', 'user5@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(6, 'Larry', 'Yoffre', 'user6@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(7, 'Larry', 'Yoffre', 'user7@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(8, 'Larry', 'Yoffre', 'user8@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(9, 'Larry', 'Yoffre', 'user9@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(10, 'Larry', 'Yoffre', 'user10@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(11, 'Larry', 'Yoffre', 'user11@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(13, 'Larry', 'Yoffre', 'user12@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(14, 'Larry', 'Yoffre', 'user14@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(15, 'Larry', 'Yoffre', 'user16@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(16, 'Larry', 'Yoffre', 'user17@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(18, 'Larry', 'Yoffre', 'user18@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(19, 'Larry', 'Yoffre', 'user19@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(20, 'Larry', 'Yoffre', 'user20@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(21, 'Larry', 'Yoffre', 'user21@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(22, 'Larry', 'Yoffre', 'user22@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(23, 'Larry', 'Yoffre', 'user23@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(25, 'Larry', 'Yoffre', 'user24@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(26, 'Larry', 'Yoffre', 'user26@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(27, 'Larry', 'Yoffre', 'user27@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino'),
(29, 'Larry', 'Yoffre', 'user28@gmail.com', '76543344444', '1988-09-22', 'Lavalleja 1428', 'masculino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_login`
--

CREATE TABLE `users_login` (
  `id_login` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users_login`
--

INSERT INTO `users_login` (`id_login`, `id_user`, `contrasena`, `rol`) VALUES
(1, 1, '$2y$10$iauLgNTiOM8.0.c4b6hGGegji3.zCNGyAaS85Mtlwg3UDGduva4/O', 'user'),
(3, 2, '$2y$10$XYuMMjYpdiu0BTvh0aCWUecc3hwyiPdvuyixA65imLQD7en7DVv9e', 'user'),
(5, 3, '$2y$10$8P0FS05fL1rWhNdbt.29eub.exD4w8DuYmBRWL.SVTZdUOIDkZsjy', 'user'),
(7, 4, '$2y$10$WHxKAa0m6C8g4UuSi8sq/u.CMktYTTj7am3dPo2qM3WswYXsjVl.u', 'user'),
(8, 5, '$2y$10$GCKO6XDlBzliGDC4U1aNPO8EqKYEged0w67bZLke64CQA18bChhmi', 'user'),
(9, 6, '$2y$10$IzTOHBww2KTFe80N.Ek/pe06kQLwEltSV4kvPkZXLoB1gauZhq2yy', 'user'),
(10, 7, '$2y$10$pvVEhrvF6TFLb8kBwoZMJOgJS6GE3W0DWo4gnUIoPieHTyxSolmwC', 'user'),
(11, 8, '$2y$10$maoOdDpCj6Wuno6nVbw.cu3h0J6S.q4daXvLgjJ6jUA/PWfwpN3aC', 'user'),
(12, 9, '$2y$10$5EpTfTIY.tQUu7R6RltQBetXUJTJaUqHTZkxQqqoZgjHkOpeDOdP.', 'user'),
(13, 10, '$2y$10$3GCPhgU9QA1HEioCrgGOSOY5kz6Pqv2CoK50zUeVrW0mRwhwM.7Jm', 'user'),
(14, 11, '$2y$10$OcfAqIQeTBTzZ.T2bqnBzOm11ORX7F6JMd1WXqou.A91W4hJYJynC', 'user'),
(15, 13, '$2y$10$0piTi9SqRhSdX.pws7QeEuIt41HolHD9QkcrG4fc.Lbwp6RGWkJv6', 'user'),
(16, 14, '$2y$10$ghyfA2PujKAIegYJ3X166u7eqGZHqFSDiFBa7SQtLhIdT7eqQMgzm', 'user'),
(17, 15, '$2y$10$951haoqShZWHwA/t9PvONOU82TlQJHqeoftvN1gppr5axMoum2b/W', 'user'),
(18, 16, '$2y$10$R9x4z8fSKU4RsN55xdqbzego9UlQg713B2k3X9gBTnB5nGNqqmuGy', 'user'),
(19, 18, '$2y$10$LvAXPldgTWEs23L9K7Jie..LUpsZqhqvik/rxFsBTjsc1FvdlmGci', 'user'),
(20, 19, '$2y$10$4JC3LENhejXHMKhhGNqruO61g36aS44f080zR8f3tg1jJO5yiRo9u', 'user'),
(21, 20, '$2y$10$1mUjOve84bBXCd3KScvjv.dgzcL0rY43gIlrOqm8Vx5DbVZ89ZJYa', 'user'),
(22, 21, '$2y$12$BM.aCJTfT2F1s6j3LN3vWeGKYnTUSmhMgKNTbLooje8FMeYCJVUBu', 'user'),
(23, 22, '$2y$12$Or.QiUfxWVY1GVCvcGdaUODX9XY8UwxJmxb07rQYSqs9GIQ41ydUW', 'user'),
(24, 23, '$2y$12$QIlGpQTuK/OuXl6w/B9t2.ZahTYIaKF7Q5t1SY.FrrKxZ.VIApDRy', 'user'),
(25, 25, '$2y$12$n.Hhav64td1Cmt8Jh2TsSePp6ahE28SumupzgCsMzOzGYvdCSCSHy', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `fecha_cita` (`fecha_cita`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id_noticia`),
  ADD UNIQUE KEY `titulo` (`titulo`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `fecha` (`fecha`);

--
-- Indices de la tabla `users_data`
--
ALTER TABLE `users_data`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `users_login`
--
ALTER TABLE `users_login`
  ADD PRIMARY KEY (`id_login`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id_noticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `users_data`
--
ALTER TABLE `users_data`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `users_login`
--
ALTER TABLE `users_login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_data` (`id_user`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_data` (`id_user`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `users_login`
--
ALTER TABLE `users_login`
  ADD CONSTRAINT `users_login_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users_data` (`id_user`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
