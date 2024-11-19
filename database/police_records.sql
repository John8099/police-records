-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 01:22 AM
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
-- Database: `police_records`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `appointment_type` varchar(32) NOT NULL,
  `assignment_station` varchar(55) NOT NULL,
  `tenure` varchar(32) NOT NULL,
  `status` varchar(32) NOT NULL,
  `salary` varchar(32) NOT NULL,
  `gsis` varchar(55) NOT NULL,
  `phil_health` varchar(55) NOT NULL,
  `pag_ibig` varchar(55) NOT NULL,
  `appointment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `user_id`, `appointment_type`, `assignment_station`, `tenure`, `status`, `salary`, `gsis`, `phil_health`, `pag_ibig`, `appointment_date`) VALUES
(1, 3, 'Original', 'Janiuay Municipal Police Station', '2 months', 'Leave', '123', 'awda123', 'ad123', '123daw', '2024-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `eligibility`
--

CREATE TABLE `eligibility` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` text NOT NULL,
  `rating` text NOT NULL,
  `place` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eligibility`
--

INSERT INTO `eligibility` (`id`, `user_id`, `title`, `rating`, `place`, `date`) VALUES
(1, 1, 'test', '123', 'test', '2024-10-02');

-- --------------------------------------------------------

--
-- Table structure for table `iper`
--

CREATE TABLE `iper` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `evaluation_period` varchar(55) NOT NULL,
  `responsibilities` text NOT NULL,
  `performance_ratings` text NOT NULL,
  `strengths` text NOT NULL,
  `weakness` text NOT NULL,
  `areas_of_improvement` text NOT NULL,
  `recommendations` text NOT NULL,
  `supervisor_comment` text NOT NULL,
  `employee_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `iper`
--

INSERT INTO `iper` (`id`, `user_id`, `evaluation_period`, `responsibilities`, `performance_ratings`, `strengths`, `weakness`, `areas_of_improvement`, `recommendations`, `supervisor_comment`, `employee_comment`) VALUES
(1, 3, '2024-11-20 - 2024-11-29', '[\"awd\",\"awd\",\"awd\"]', '{\"leadership\":\"2\",\"job_knowledge\":\"2\",\"communication\":\"3\",\"teamwork\":\"4\",\"integrity\":\"5\"}', 'teadw', 'awdawd', 'awdawd', 'awd', 'awd', 'awd');

-- --------------------------------------------------------

--
-- Table structure for table `pft`
--

CREATE TABLE `pft` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `score` varchar(32) NOT NULL,
  `event` text NOT NULL,
  `bmi` varchar(32) NOT NULL,
  `bp` varchar(32) NOT NULL,
  `pulse_rate` varchar(32) NOT NULL,
  `test_date` date NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pft`
--

INSERT INTO `pft` (`id`, `user_id`, `score`, `event`, `bmi`, `bp`, `pulse_rate`, `test_date`, `date_created`) VALUES
(1, 1, '1552', '{\"meter_run\":\"test\",\"sit_up\":\"test\",\"push_up\":\"test\",\"swim\":\"test\"}', '1231', '123d', '123a', '2024-11-19', '2024-11-18 15:39:16');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rank` text NOT NULL,
  `authority` text NOT NULL,
  `effective_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `user_id`, `rank`, `authority`, `effective_date`) VALUES
(1, 1, 'Police Officer I (PO1)', 'Test', '2024-10-01'),
(2, 1, 'Police Officer II (PO2)', 'test1', '2024-10-05');

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE `trainings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_title` text NOT NULL,
  `authority` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainings`
--

INSERT INTO `trainings` (`id`, `user_id`, `course_title`, `authority`, `start_date`, `end_date`) VALUES
(1, 1, 'Information Technology', 'test', '2024-10-01', '2024-10-31'),
(2, 1, 'test', 'test', '2024-10-01', '2024-10-10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_number` varchar(55) NOT NULL,
  `rank_position` text DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` text DEFAULT NULL,
  `role` varchar(55) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_number`, `rank_position`, `first_name`, `middle_name`, `last_name`, `address`, `email`, `password`, `role`, `avatar`, `date_created`) VALUES
(1, '1231', 'Police Officer II (PO2)', 'john', 'tet2', 'doe', 'Acao Cabatuan Iloilo', 'john@gmail.com', '$2y$10$VwyoMpnAmp6WZJZqxTrm4OVL/yTqxCpduDIbf..ME5xmMSHTupQhW', 'admin', '673bd59f91509_avatar-5.jpg', '2024-09-29 16:23:47'),
(3, '143121', 'Police Officer II (PO2)1', 'awd1', 'awd1', 'awd1', 'awd1', 'montemar@gmail.com1', NULL, 'user', '673bd4a75a001_avatar-2.jpg', '2024-11-18 18:14:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `eligibility`
--
ALTER TABLE `eligibility`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `iper`
--
ALTER TABLE `iper`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pft`
--
ALTER TABLE `pft`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `eligibility`
--
ALTER TABLE `eligibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `iper`
--
ALTER TABLE `iper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pft`
--
ALTER TABLE `pft`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `eligibility`
--
ALTER TABLE `eligibility`
  ADD CONSTRAINT `eligibility_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `pft`
--
ALTER TABLE `pft`
  ADD CONSTRAINT `pft_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `promotions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `trainings`
--
ALTER TABLE `trainings`
  ADD CONSTRAINT `trainings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
