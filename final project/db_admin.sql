-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 09:21 AM
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
-- Database: `db_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` int(11) NOT NULL COMMENT 'role_id',
  `role` varchar(255) DEFAULT NULL COMMENT 'role_text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Editor'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `img_profile` varchar(255) NOT NULL,
  `user_id` varchar(6) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `religion` varchar(255) NOT NULL,
  `birthdate` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `university` varchar(255) NOT NULL,
  `faculty` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `guardian_name` varchar(255) NOT NULL,
  `guardian_mobile` varchar(255) NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `room_status` varchar(255) NOT NULL,
  `roleid` tinyint(4) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `img_profile`, `user_id`, `name`, `username`, `religion`, `birthdate`, `age`, `university`, `faculty`, `branch`, `year`, `email`, `password`, `mobile`, `address`, `guardian_name`, `guardian_mobile`, `room_number`, `room_status`, `roleid`, `isActive`, `created_at`, `updated_at`) VALUES
(7, 'Logocpu.png', '660064', 'นายฐากร เจริญสุข', 'ริว', 'คริส', '2002-12-12', '22', 'มหาวิทยาลัยเจ้าพระยา', 'บริหารและการจัดการ', 'การจัดการ', 'ปีที่ 1', 'nababurbd@gmail.com', '188000e1f0fb4075ae1c659697b96296f982cdc4', '0639945449', 'หอพักพิมพันธ์', 'วิ', '0639945449', '212', 'อยู่กับเพื่อน', 1, 0, '2020-03-12 16:23:01', '2020-03-12 16:23:01'),
(51, 'shopee-pay.jpg', '444444', 'Millon 8', 'asdfa', 'คริส', '2024-11-20', '11', 'มหาวิทยาลัยเจ้าพระยา', 'บริหารและการจัดการ', 'การจัดการ', 'ปีที่ 1', 'ptha555@gmail.com', '3ab20dca13e081212cd765ea3437ecc27fb91538', '0639945448', 'asdfasdf', 'เมียพี่ฐา', '0639945449', '2', 'อยู่กับเพื่อน', 1, 0, '2024-11-29 17:36:28', '2024-11-29 17:36:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'role_id', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
