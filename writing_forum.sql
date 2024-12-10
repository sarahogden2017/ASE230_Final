-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 10, 2024 at 05:52 AM
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
-- Database: `writing_forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`post_id`, `user_id`) VALUES
(6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `date_joined` date NOT NULL DEFAULT current_timestamp(),
  `stories_contributed` int(11) NOT NULL DEFAULT 0,
  `password_hash` tinytext NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `date_joined`, `stories_contributed`, `password_hash`, `is_admin`) VALUES
(1, 'bob', 'bob@gmail.com', '2024-12-05', 0, '123', 1),
(2, 'bob2', '4@gmial.com', '2024-12-08', 0, 'pas', 0),
(3, 'bob3', 'bob@gmail.comcom', '2024-12-09', 0, '123', -10);

-- --------------------------------------------------------

--
-- Table structure for table `writing_posts`
--

CREATE TABLE `writing_posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prompt_id` int(11) NOT NULL,
  `text` mediumtext NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `writing_posts`
--

INSERT INTO `writing_posts` (`post_id`, `user_id`, `prompt_id`, `text`, `likes`, `date_created`) VALUES
(6, 1, 7, 'hi bob', 1, '2024-12-09 23:23:03'),
(7, 1, 7, 'hello', 0, '2024-12-09 23:43:54');

-- --------------------------------------------------------

--
-- Table structure for table `writing_prompts`
--

CREATE TABLE `writing_prompts` (
  `prompt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prompt_text` mediumtext NOT NULL,
  `responses` int(11) NOT NULL DEFAULT 0,
  `visibility` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `writing_prompts`
--

INSERT INTO `writing_prompts` (`prompt_id`, `user_id`, `prompt_text`, `responses`, `visibility`, `date_created`, `date_updated`) VALUES
(7, 3, 'hello world', 2, 0, '2024-12-09 20:48:51', '2024-12-09 23:43:54'),
(8, 3, 'hi', 0, 0, '2024-12-09 20:49:07', '2024-12-09 20:49:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `writing_posts`
--
ALTER TABLE `writing_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `prompt_id` (`prompt_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `writing_prompts`
--
ALTER TABLE `writing_prompts`
  ADD PRIMARY KEY (`prompt_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `writing_posts`
--
ALTER TABLE `writing_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `writing_prompts`
--
ALTER TABLE `writing_prompts`
  MODIFY `prompt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `writing_posts`
--
ALTER TABLE `writing_posts`
  ADD CONSTRAINT `writing_posts_ibfk_1` FOREIGN KEY (`prompt_id`) REFERENCES `writing_prompts` (`prompt_id`),
  ADD CONSTRAINT `writing_posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `writing_prompts`
--
ALTER TABLE `writing_prompts`
  ADD CONSTRAINT `writing_prompts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
