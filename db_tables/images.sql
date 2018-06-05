-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2018-05-25 06:03:37
-- 服务器版本: 5.5.57-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `fruit`
--

-- --------------------------------------------------------

--
-- 表的结构 `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_file_name` varchar(256) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `caption` varchar(128) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`image_id`),
  UNIQUE KEY `image_file_name` (`image_file_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `images`
--

INSERT INTO `images` (`image_id`, `image_file_name`, `date_added`, `caption`, `active`) VALUES
(1, '1.jpg', '2017-12-06 23:24:05', '', 1),
(2, '2.jpg', '2017-12-06 23:24:05', '', 1),
(3, '3Bananas.jpg', '2017-12-06 23:24:58', '', 1),
(4, '4. Blackberry.jpg', '2017-12-06 23:24:58', '', 1),
(5, '5. Durian.jpg', '2017-12-06 23:25:38', '', 1),
(6, '6. Figs.jpg', '2017-12-06 23:25:38', '', 1),
(7, '7.Grapefruit.jpg', '2017-12-06 23:26:00', '', 1),
(8, '8.Guava.jpg', '2017-12-06 23:26:00', '', 1),
(9, '9.Grapes.jpg', '2017-12-06 23:26:29', '', 1),
(10, '10.Kiwifruit.jpg', '2017-12-06 23:26:29', '', 1),
(11, '11.Lemon.jpg', '2017-12-06 23:26:52', '', 1),
(12, '12_Mango.jpg', '2017-12-06 23:26:52', '', 1),
(13, '13.Oranges.jpg', '2017-12-06 23:29:15', '', 1),
(14, '14.Passionfruit.jpg', '2017-12-06 23:29:15', '', 1),
(15, '15.Peaches.jpg', '2017-12-06 23:29:37', '', 1),
(16, '16.Pineapple.jpg', '2017-12-06 23:29:37', '', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
