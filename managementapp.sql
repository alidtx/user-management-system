-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 02, 2024 at 05:42 AM
-- Server version: 8.3.0
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `managementapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` enum('active','pending','deleted','') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `email`, `password`, `type`, `status`) VALUES
(1, 'Ali Rimon', 'alirimon10@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'administrator', 'active'),
(5, 'ali', 'alirimon3@gmail.com', '202cb962ac59075b964b07152d234b70', 'general', 'active'),
(6, 'alirimon12', 'alirimon500@gmail.com', '202cb962ac59075b964b07152d234b70', 'general', 'active'),
(7, 'And12111111111111', 'alirimon4@gmail.com', '202cb962ac59075b964b07152d234b70', 'administrator', 'active'),
(8, 'Ali Abu', 'alirimon5ffffff@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'general', 'active'),
(9, 'dfdfdfd', 'alirimon5@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'general', 'active'),
(10, 'dddddddddddddddddddd', 'alirimon100@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'general', 'active'),
(11, 'sss', 'alirimon5000000000000@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'general', 'active');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
