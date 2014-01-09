-- MySQL dump 10.10
--
-- Host: localhost    Database: stability_platform
-- ------------------------------------------------------
-- Server version	5.0.22-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `data_playback`
--

DROP TABLE IF EXISTS `data_playback`;
CREATE TABLE `data_playback` (
  `id` int(20) NOT NULL auto_increment,
  `type` varchar(128) collate utf8_unicode_ci NOT NULL,
  `module_server` varchar(128) collate utf8_unicode_ci NOT NULL,
  `press_server` varchar(128) collate utf8_unicode_ci NOT NULL,
  `press_mode` varchar(64) collate utf8_unicode_ci NOT NULL,
  `press_args` varchar(512) collate utf8_unicode_ci NOT NULL,
  `tool_name` varchar(64) collate utf8_unicode_ci NOT NULL,
  `tool_args` varchar(4096) collate utf8_unicode_ci NOT NULL,
  `last_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `descinfo` varchar(256) collate utf8_unicode_ci NOT NULL,
  `running` tinyint(1) NOT NULL default '1' COMMENT '是否在运行',
  `reserve2` varchar(64) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `history_record`
--

DROP TABLE IF EXISTS `history_record`;
CREATE TABLE `history_record` (
  `id` int(20) NOT NULL auto_increment,
  `data_id` int(20) NOT NULL,
  `desc_info` varchar(256) collate utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `stop_time` timestamp NOT NULL default '0000-00-00 00:00:00',
  `max_time` varchar(64) collate utf8_unicode_ci default NULL,
  `pid` varchar(20) collate utf8_unicode_ci default NULL,
  `reserve2` varchar(64) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `data_id` (`data_id`),
  CONSTRAINT `history_record_ibfk_1` FOREIGN KEY (`data_id`) REFERENCES `data_playback` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

