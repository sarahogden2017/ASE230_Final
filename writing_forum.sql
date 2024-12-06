-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 06, 2024 at 06:56 PM
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
(1, 'bob', 'bob@gmail.com', '2024-12-05', 0, '123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `writing_posts`
--

CREATE TABLE `writing_posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prompt_id` int(11) NOT NULL,
  `text` mediumint(9) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `writing_posts`
--
ALTER TABLE `writing_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `writing_prompts`
--
ALTER TABLE `writing_prompts`
  MODIFY `prompt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
