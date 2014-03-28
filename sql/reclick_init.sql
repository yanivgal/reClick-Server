-- phpMyAdmin SQL Dump
-- version 4.1.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2014 at 07:08 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `reclick`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
CREATE TABLE IF NOT EXISTS `games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `num_of_players` int(4) NOT NULL DEFAULT '0',
  `sequence` varchar(4096) DEFAULT NULL,
  `turn` int(4) DEFAULT NULL,
  `started` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
CREATE TABLE IF NOT EXISTS `players` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `nickname` varchar(25) NOT NULL,
  `gcm_reg_id` varchar(4096) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  FULLTEXT KEY `gcm_reg_id` (`gcm_reg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `players_in_games`
--

DROP TABLE IF EXISTS `players_in_games`;
CREATE TABLE IF NOT EXISTS `players_in_games` (
  `player_id` int(10) unsigned NOT NULL,
  `game_id` int(10) unsigned NOT NULL,
  `turn` int(4) unsigned NOT NULL,
  KEY `player_id` (`player_id`),
  KEY `game_id` (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `players_in_games`
--
ALTER TABLE `players_in_games`
ADD CONSTRAINT `fk_players_in_games_game_id` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `fk_players_in_games_player_id` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
