-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 29, 2019 at 02:35 AM
-- Server version: 10.2.23-MariaDB
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `registroContable`
--

-- --------------------------------------------------------

--
-- Table structure for table `tablaGastos`
--

CREATE TABLE `tablaGastos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `costo` varchar(30) DEFAULT NULL,
  `modificado` datetime DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- Table structure for table `tablaIngresos`
--

CREATE TABLE `tablaIngresos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `costo` varchar(30) DEFAULT NULL,
  `modificado` datetime DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- Table structure for table `tablaUsuarios`
--

CREATE TABLE `tablaUsuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `contrasena` varchar(50) DEFAULT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `token` varchar(40) NOT NULL,
  `sesion` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tablaGastos`
--
ALTER TABLE `tablaGastos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tablaIngresos`
--
ALTER TABLE `tablaIngresos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tablaUsuarios`
--
ALTER TABLE `tablaUsuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tablaGastos`
--
ALTER TABLE `tablaGastos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tablaIngresos`
--
ALTER TABLE `tablaIngresos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tablaUsuarios`
--
ALTER TABLE `tablaUsuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
