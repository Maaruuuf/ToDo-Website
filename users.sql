-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2024 at 01:56 PM
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
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `deadline` date NOT NULL,
  `progress` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `uid`, `title`, `author`, `description`, `deadline`, `progress`, `created_at`) VALUES
(7, 7, 'Rich Dad Poor Dad', 'Robert Kiyosaki and Sharon Lechter', 'Inspirational and Motivational', '2024-09-30', 10, '2024-09-18 06:44:22'),
(8, 7, 'Gitanjali', 'Rabindranath Tagore', 'Poems', '2024-10-10', 80, '2024-09-18 06:45:39'),
(10, 5, 'A Song of Ice and fire', 'George R. R. Martin', 'Fantasy Novel', '2024-12-31', 50, '2024-09-21 11:18:01'),
(11, 5, 'The Alchemist', 'Paulo Coelho', 'This book is a modern classic that inspires readers to chase their dreams', '2025-01-31', 20, '2024-09-21 11:19:20'),
(12, 5, 'The Da Vinci Code', 'Dan Brown', 'This Novels griping mix of art, history and mystery', '2025-03-31', 80, '2024-09-21 11:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `financial_overview`
--

CREATE TABLE `financial_overview` (
  `id` int(11) NOT NULL,
  `current_balance` decimal(10,2) NOT NULL,
  `monthly_income` decimal(10,2) NOT NULL,
  `monthly_expenses` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `financial_overview`
--

INSERT INTO `financial_overview` (`id`, `current_balance`, `monthly_income`, `monthly_expenses`, `created_at`) VALUES
(1, 5000.00, 5000.00, 0.00, '2024-07-16 06:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `financial_records`
--

CREATE TABLE `financial_records` (
  `id` int(11) NOT NULL,
  `type` enum('cost','saving') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `financial_records`
--

INSERT INTO `financial_records` (`id`, `type`, `amount`, `description`, `date`, `created_at`) VALUES
(18, 'saving', 5000.00, 'Tutions', '2024-09-01', '2024-09-21 11:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `sno` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `tstamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`sno`, `uid`, `title`, `description`, `tstamp`) VALUES
(7, 5, 'Update ', 'Check all the apps and update them today', '2024-09-21 17:08:15'),
(8, 5, 'Personal Goals', 'Exercise for 30 minutes today', '2024-09-21 17:08:48'),
(9, 5, 'social', 'Call a friend to catch up', '2024-09-21 17:09:10'),
(10, 5, 'Work', 'Reply client mails today', '2024-09-21 17:09:39'),
(11, 7, 'Grocery', 'Buy apple and oranges', '2024-09-21 17:51:30'),
(12, 7, 'Technical maintenance', 'Backup important files', '2024-09-21 17:52:16'),
(13, 7, 'Social', 'plan a dinner with friends\r\n', '2024-09-21 17:52:43');

-- --------------------------------------------------------

--
-- Table structure for table `project_budgets`
--

CREATE TABLE `project_budgets` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `budget` decimal(10,2) NOT NULL,
  `spent` decimal(10,2) DEFAULT 0.00,
  `deadline` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_budgets`
--

INSERT INTO `project_budgets` (`id`, `uid`, `project_name`, `description`, `budget`, `spent`, `deadline`, `created_at`) VALUES
(8, 7, 'SmartBIn', 'A automated dust bin', 5000.00, 2000.00, '2024-09-24', '2024-09-18 06:46:54'),
(10, 5, 'Booth', '3.1 Dsd Lab Project', 2000.00, 1990.00, '2024-07-29', '2024-09-21 11:12:14'),
(11, 5, 'Waste Bin', '3.1 Micro lab project', 3000.00, 3010.00, '2024-09-24', '2024-09-21 11:12:53'),
(13, 7, 'SAP', 'This is a dsd project', 3000.00, 3500.00, '2024-06-27', '2024-09-21 11:54:08');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `sno` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tstamp` datetime NOT NULL DEFAULT current_timestamp(),
  `start_date` date NOT NULL,
  `deadline_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`sno`, `uid`, `title`, `description`, `tstamp`, `start_date`, `deadline_date`) VALUES
(7, 7, 'vaccine', 'Taking covid vaccine', '2024-09-18 12:49:25', '2024-09-21', '2026-02-24'),
(9, 7, 'Project', 'Database project submission', '2024-09-18 14:17:54', '2024-09-16', '2024-09-18'),
(11, 5, 'Project Deadlines', 'Submit project report by following day', '2024-09-21 17:04:03', '2024-09-10', '2024-10-30'),
(12, 5, 'Financial Tasks', 'Pay utility bills by end of the month', '2024-09-21 17:04:54', '2024-09-01', '2024-09-30'),
(13, 5, 'Appoinment', 'Doctors appoinment', '2024-09-21 17:05:23', '2024-09-21', '2024-10-02'),
(14, 5, 'Project Deadline', 'Submit DB project', '2024-09-21 17:05:57', '2024-09-15', '2024-09-18'),
(15, 5, 'personal Goal', 'Finish a book before deadline', '2024-09-21 17:06:50', '2024-09-21', '2024-09-23'),
(16, 7, 'Skill', 'acquire a skill ', '2024-09-21 17:53:18', '2024-09-21', '2024-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `sid` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`sid`, `email`, `username`, `password`, `date`) VALUES
(5, 'maruf@gmail.com', 'maruf', '1234', '2024-07-16 16:07:06'),
(7, 'sowmikvadro@gmail.com', 'sowmik', '1234', '2024-09-17 16:51:00');

-- --------------------------------------------------------

--
-- Table structure for table `watch_links`
--

CREATE TABLE `watch_links` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `deadline` date NOT NULL,
  `progress` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `watch_links`
--

INSERT INTO `watch_links` (`id`, `uid`, `title`, `url`, `deadline`, `progress`, `created_at`) VALUES
(7, 7, 'Scholarship in USA', 'https://www.youtube.com/watch?v=vXjLnZSW1Co', '2024-09-20', 80, '2024-09-18 06:40:52'),
(8, 7, 'Data Blog', 'https://dataniyekotha.gitbook.io/undefined', '2024-09-20', 40, '2024-09-18 06:42:10'),
(10, 5, 'JavaScript Tutorial', 'https://www.youtube.com/watch?v=PkZNo7MFNFg', '2024-12-30', 20, '2024-09-21 11:25:44'),
(11, 5, 'Python Tutorial', 'https://www.youtube.com/watch?v=_uQrJ0TkZlc', '2024-12-31', 70, '2024-09-21 11:26:45'),
(12, 5, 'Resources for Web development', 'https://www.w3schools.com/html/', '2024-09-30', 90, '2024-09-21 11:27:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `financial_overview`
--
ALTER TABLE `financial_overview`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financial_records`
--
ALTER TABLE `financial_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`sno`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `project_budgets`
--
ALTER TABLE `project_budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`sno`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `watch_links`
--
ALTER TABLE `watch_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `financial_overview`
--
ALTER TABLE `financial_overview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `financial_records`
--
ALTER TABLE `financial_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `project_budgets`
--
ALTER TABLE `project_budgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `watch_links`
--
ALTER TABLE `watch_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`sid`);

--
-- Constraints for table `project_budgets`
--
ALTER TABLE `project_budgets`
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`sid`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`sid`),
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`uid`) REFERENCES `users` (`sid`);

--
-- Constraints for table `watch_links`
--
ALTER TABLE `watch_links`
  ADD CONSTRAINT `tasks_ibfk_4` FOREIGN KEY (`uid`) REFERENCES `users` (`sid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
