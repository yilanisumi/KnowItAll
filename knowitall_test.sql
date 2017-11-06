-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2017 at 02:27 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `knowitall_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `frequent_search`
--

CREATE TABLE `frequent_search` (
  `search` varchar(45) NOT NULL,
  `freq` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `frequent_tag`
--

CREATE TABLE `frequent_tag` (
  `tag` varchar(45) NOT NULL,
  `freq` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `search_temp`
--

CREATE TABLE `search_temp` (
  `user_id` varchar(45) NOT NULL,
  `survey_id` varchar(45) NOT NULL,
  `create_time` varchar(45) NOT NULL,
  `survey_tags` varchar(1000) NOT NULL,
  `voter_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `survey_id` varchar(45) NOT NULL,
  `survey_title` varchar(1000) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `rating_average` double NOT NULL,
  `create_time` varchar(45) DEFAULT NULL,
  `survey_tags` varchar(1000) NOT NULL,
  `voter_number` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `survey`
--

INSERT INTO `survey` (`survey_id`, `survey_title`, `user_id`, `rating_average`, `create_time`, `survey_tags`, `voter_number`) VALUES
('P0000000001', 'Admin Poll 1', '9999999999', 0, '2017-11-05', ' Admin Poll 1', 0),
('P0000000002', 'Admin Poll 2', '9999999999', 0, '2017-11-05', ' Admin Poll 2', 0),
('R0000000001', 'Admin Rating 1', '9999999999', 0, '2017-11-05', ' Admin Rating 1', 0),
('R0000000002', 'Admin Rating 2', '9999999999', 0, '2017-11-05', ' Admin Rating 2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `survey_comments`
--

CREATE TABLE `survey_comments` (
  `survey_id` varchar(45) NOT NULL,
  `comment_string` varchar(1000) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `comment_time` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `survey_options`
--

CREATE TABLE `survey_options` (
  `survey_id` varchar(45) NOT NULL,
  `option_id` int(45) NOT NULL,
  `option_string` varchar(1000) NOT NULL,
  `voter_number` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `survey_options`
--

INSERT INTO `survey_options` (`survey_id`, `option_id`, `option_string`, `voter_number`) VALUES
('P0000000001', 1, '1', 0),
('P0000000001', 2, '2', 0),
('P0000000001', 3, '3', 0),
('R0000000001', 1, '', 0),
('R0000000001', 2, '', 0),
('R0000000001', 3, '', 0),
('R0000000001', 4, '', 0),
('R0000000001', 5, '', 0),
('R0000000001', 6, '', 0),
('R0000000001', 7, '', 0),
('R0000000001', 8, '', 0),
('R0000000001', 9, '', 0),
('R0000000001', 10, '', 0),
('P0000000002', 1, 'a', 0),
('P0000000002', 2, 'b', 0),
('P0000000002', 3, 'c', 0),
('R0000000002', 1, '', 0),
('R0000000002', 2, '', 0),
('R0000000002', 3, '', 0),
('R0000000002', 4, '', 0),
('R0000000002', 5, '', 0),
('R0000000002', 6, '', 0),
('R0000000002', 7, '', 0),
('R0000000002', 8, '', 0),
('R0000000002', 9, '', 0),
('R0000000002', 10, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `trending_survey`
--

CREATE TABLE `trending_survey` (
  `survey_id` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trending_survey`
--

INSERT INTO `trending_survey` (`survey_id`) VALUES
('P0000000001'),
('R0000000001'),
('P0000000002'),
('R0000000002');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(45) NOT NULL,
  `usc_email` varchar(45) NOT NULL,
  `usc_id` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `usc_email`, `usc_id`, `password`, `user_name`) VALUES
('1111111111', 'test@usc.edu', '1111111111', '$2y$10$/2zSV5Qqkzu7RkLLrlU7juvSANfP8mN9gKGTQm67mpv1rCMHq0vMS', 'test'),
('9999999999', 'admin@usc.edu', '9999999999', '$2y$10$TEuBsosxDzTFJO11b.VnCO4UJ.WfPjLgoACZpjKN9VIyb2AVGD/x6', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_survey`
--

CREATE TABLE `user_survey` (
  `user_id` varchar(45) NOT NULL,
  `survey_id` varchar(45) NOT NULL,
  `option_id` int(45) NOT NULL,
  `anonymity` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`survey_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `survey_comments`
--
ALTER TABLE `survey_comments`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `survey_id` (`survey_id`);

--
-- Indexes for table `survey_options`
--
ALTER TABLE `survey_options`
  ADD KEY `survey_id` (`survey_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_survey`
--
ALTER TABLE `user_survey`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `survey_id` (`survey_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `survey_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `survey_comments`
--
ALTER TABLE `survey_comments`
  ADD CONSTRAINT `survey_comments_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`survey_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `survey_options`
--
ALTER TABLE `survey_options`
  ADD CONSTRAINT `survey_options_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`survey_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_survey`
--
ALTER TABLE `user_survey`
  ADD CONSTRAINT `user_survey_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
