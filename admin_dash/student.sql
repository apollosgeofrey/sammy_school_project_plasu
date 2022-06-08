-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 07, 2021 at 08:44 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student`
--

-- --------------------------------------------------------

--
-- Table structure for table `auto_id_generate`
--

CREATE TABLE `auto_id_generate` (
  `id` int(11) NOT NULL,
  `jame_reg_no` varchar(250) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `sex` varchar(100) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `faculty` varchar(100) DEFAULT NULL,
  `faculty_id` varchar(100) DEFAULT 'NULL',
  `department` varchar(100) DEFAULT NULL,
  `mat_number` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auto_id_generate`
--

INSERT INTO `auto_id_generate` (`id`, `jame_reg_no`, `name`, `sex`, `uid`, `faculty`, `faculty_id`, `department`, `mat_number`) VALUES
(1, '56645262BA', 'Abebe Sharew', ' M', 3, 'Natural Science', 'FNS', 'CS', 'PLASU/2016/FNS/0001'),
(2, '32939883ND', 'Bereket Alayu', ' F', 3, 'Natural Science', 'FNS', 'CS', 'PLASU/2016/FNS/0002'),
(3, '38292844BF', 'Dejene Techane', ' M', 3, 'Natural Science', 'FNS', 'CS', 'PLASU/2016/FNS/0003'),
(4, '61617878BG', 'Geteye Zigale', ' M', 3, 'Natural Science', 'FNS', 'CS', 'PLASU/2016/FNS/0004'),
(5, '90889896NF', 'Girma Elias', ' M', 3, 'Natural Science', 'FNS', 'CS', 'PLASU/2016/FNS/0005'),
(6, '45562726MA', 'Girmachew Gulint', ' M', 3, 'Natural Science', 'FNS', 'CS', 'PLASU/2016/FNS/0006'),
(7, '41524255AN', 'Misrak Abebe', ' F', 3, 'Natural Science', 'FNS', 'CS', 'PLASU/2016/FNS/0007'),
(8, '35617615JY', 'Tizita Taye', ' F', 3, 'Natural Science', 'FNS', 'CS', 'PLASU/2016/FNS/0008'),
(9, '37827889US', 'Yichalewale Tessema', ' M', 3, 'Natural Science', 'FNS', 'CS', 'PLASU/2016/FNS/0009'),
(10, '78383737NG', 'Yigezu Agonafer', ' M', 3, 'Natural Science', 'FNS', 'CS', 'PLASU/2016/FNS/0010'),
(11, '56782374FS', 'Apollos Geofrey', ' ', 3, 'Natural Science', 'FNS', 'Math', 'PLASU/2017/FNS/0011');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `faculty_name` varchar(250) DEFAULT NULL,
  `faculty_id` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `rank_level` varchar(50) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `username`, `faculty_name`, `faculty_id`, `password`, `role`, `rank_level`) VALUES
(1, 'admin', 'Plasu Registrar', 'Registrar', 'b59c67bf196a4758191e42f76670ceba', 'Administrator', '2'),
(2, 'apollosgeofrey', 'Coding', 'cod', 'b59c67bf196a4758191e42f76670ceba', 'Administrator', '1'),
(3, 'science', 'Faculty Of Natural And Applied Science', 'FNS', '4a7d1ed414474e4033ac29ccb8653d9b', 'Administrator', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auto_id_generate`
--
ALTER TABLE `auto_id_generate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auto_id_generate`
--
ALTER TABLE `auto_id_generate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
