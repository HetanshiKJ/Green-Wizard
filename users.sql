-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 08:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fName`, `lName`, `email`, `password`, `reset_token`) VALUES
(2, 'Lily', 'Adams', 'lilyadams@email.com', '$2y$10$Wp/LrRwBbyqiLufus1AxvO5CqdonUx0HTofUf8nHv14K/jCnrn5wu', 'bcf48854e1c1e8a8c26ee9bca3b9b8498ddd8955a39b4bf39640e33f296b277aea0b530c63101b1f114d72bbea9edf71c237'),
(3, 'Claire', 'Dunphy', 'clairedunphy@email.com', '$2y$10$ykMB8TXl4u80q9JpvYqwHeIDeNypGC0UWExMxEnp0DMfsBpOxkc..', NULL),
(4, 'Daisy', 'Michelle', 'jadhavhetanshi@gmail.com', '$2y$10$62ziz4jC6j8Tzw6K23nuU.0T5GCn3z3iV/3g2qmMSt35btvMXJgGO', '4f8676bdb4b2df734b16ef68e5d3a3e9a5cd532f836e0744bcae7a00a6f14e29c08e76e9f4890fa3276139341e86f1d3fd80'),
(5, 'kavita ', 'jadhav', 'kavita.jadhav.0211@gmail.com', '$2y$10$QcEIg/WQJIizK3za4QvVtOSG19pfMbC5wDLOm4okolYUoCBqwJuZu', NULL),
(6, 'hetanshi', 'Jadhav', 'jadahvhetanshi@gmail.com', '$2y$10$9lQnovysDhNCzBdJxz4u7Oc51pIdbom7kD9twE0dyrfrIY5m/oCX6', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
