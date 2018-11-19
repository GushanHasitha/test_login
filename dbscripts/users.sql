

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


--
-- Database: `testlogin`
--
DROP DATABASE IF EXISTS `test_login`;
CREATE DATABASE IF NOT EXISTS `test_login`
  DEFAULT CHARACTER SET utf8;
USE `test_login`;


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`user_name`),
  UNIQUE (`email`)
) 
  ENGINE = InnoDB 
  DEFAULT CHARSET = utf8;


