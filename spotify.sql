-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 02:19 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spotify`
--

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `ID` int(11) NOT NULL,
  `ArtistName` varchar(255) NOT NULL,
  `SongName` varchar(255) NOT NULL,
  `Genre` varchar(100) NOT NULL,
  `ReleaseDate` varchar(50) NOT NULL,
  `Streams` varchar(50) NOT NULL,
  `Duration` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`ID`, `ArtistName`, `SongName`, `Genre`, `ReleaseDate`, `Streams`, `Duration`) VALUES
(1, 'Bruno Mars', 'Just the Way You Are', 'Pop • R&B', '2010', '2.5B', '3:40 mins'),
(2, 'Yung Kai', 'Blue', 'indie song', '2024', '277M', '3:14 mins'),
(3, 'David Kushner\r\n', 'Daylight', 'Pop Ballad', '2023', '1.4B', '3:32 mins'),
(26, 'Passenger', 'Simple Song', 'folk pop • soft rock', '2017', '133M', '3:48 mins'),
(27, 'Bruno Mars', 'The Lazy Song', 'reggae-pop', '2010', '1.1B', '3:40 mins'),
(28, 'Bruno Mars1', 'The Lazy Song', 'reggae-pop', '2010', '1.1B', '3:40 mins'),
(29, 'Bruno Mars2', 'The Lazy Song', 'reggae-pop', '2010', '1.1B', '3:40 mins'),
(30, 'Bruno Mars3', 'The Lazy Song', 'reggae-pop', '2010', '1.1B', '3:40 mins'),
(31, 'Bruno Mars4', 'The Lazy Song', 'reggae-pop', '2010', '1.1B', '3:40 mins'),
(32, 'Bruno Mars5', 'The Lazy Song', 'reggae-pop', '2010', '1.1B', '3:40 mins');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `created_at`) VALUES
(1, 'Test', 'test123', '$2y$10$MteMS1.N6uKR4piLLKkYyeJx/qvu/LEGE.wpwiDVSBOXR57ylC8PW', '2025-03-06 23:35:46'),
(3, 'Test2@gmail.com', 'test22', '$2y$10$knqMuwFy9g1A/H/GOsY90OekNWL9h2bdqszbitzREd7ga2bys1YdW', '2025-03-06 23:42:49'),
(4, 'Test3@gmail.com', 'test33', '$2y$10$p.Uf3Vxy7m4UL34MTVHEjugIkKs1NdKAhmKI2W5hJGjKBmjcE.9t6', '2025-03-06 23:49:51'),
(5, 'Test4@gmail.com', 'test44', '$2y$10$CTKnTfDX992Knh9Cu61vPOJPtNDYH2YxntGMX2/XENin15NlB0Uhe', '2025-03-07 00:11:21'),
(7, 'test12@gmail.com', 'test12', '$2y$10$KJgzEEfcQgco0YkuC8WYp.dmdGlQlu6iYFtlwOr4VdxpHUolffmm6', '2025-03-07 00:45:48'),
(8, '', '', '$2y$10$JBRtfCGIyHshVmD7ACaZmelJ/GSYO9tv8JQd2cydgD7v0FnU/bse6', '2025-03-07 00:47:07'),
(12, 'Test5@gmail.com', 'test5', '$2y$10$hP/2KqcaCBfZoUrU4QRmsuMAGFRdrtcMippBSQh5Ua3PIhuss.rxa', '2025-03-07 02:10:32'),
(13, 'test@gmail.com', 'test6', '$2y$10$BrhGLxQoLChj6hfopLrBt.LTZd9gDiFDKLMhzTIVeahNzDzOHp/oi', '2025-03-07 14:50:22'),
(14, 'test7@gmail.com', 'test7', '$2y$10$ADK.Br6ppQ65GRVgpCpVIOjh7OifO9lzjsOAXyIiRQ8qLg2iReOSW', '2025-03-07 22:28:43'),
(15, 'test8@gmail.com', 'test8', '$2y$10$.Bxkbc/L5dZOYtETtUds.OgMIvxUdFIDHOP1LF8vpxlja5wKr/Z6S', '2025-03-07 22:29:44'),
(16, 'test9@gmail.com', 'test9', '$2y$10$Q6Z7Lpaxhh8f61DFn7yhxO4tXMoa2Q4Oc7VAeyv/UgHVGJlCRHCMy', '2025-03-12 16:22:52'),
(17, 'test99@gmail.com', 'test99', '$2y$10$tlciErpU2ea81wnRwg2W9uynSaL87nNuK3Ypl54gyaeiQ1NHAQXgu', '2025-03-12 23:35:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
