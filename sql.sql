
-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 21, 2012 at 12:59 PM
-- Server version: 5.1.57
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `alpha_agora`
--

CREATE TABLE `alpha_agora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) COLLATE latin1_general_ci NOT NULL,
  `subject` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `message` varchar(1000) COLLATE latin1_general_ci NOT NULL,
  `island_id` int(11) NOT NULL,
  `post_date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (author) REFERENCES alpha_users(id),
  FOREIGN KEY (island_id) REFERENCES alpha_islands(id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alpha_alliance`
--

CREATE TABLE `alpha_alliance` (
  `ally_id` int(11) NOT NULL AUTO_INCREMENT,
  `ally_name` text COLLATE latin1_general_ci NOT NULL,
  `ally_tag` text COLLATE latin1_general_ci NOT NULL,
  `ally_description` text COLLATE latin1_general_ci NOT NULL,
  `ally_ext_page` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `ally_int_page` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `ally_leader` text COLLATE latin1_general_ci NOT NULL,
  `ally_general` text COLLATE latin1_general_ci NOT NULL,
  `ally_minister` text COLLATE latin1_general_ci NOT NULL,
  `ally_diplo` text COLLATE latin1_general_ci NOT NULL,
  `ally_created` int(11) NOT NULL,
  `ally_founder` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`ally_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alpha_alliance_users`
--

CREATE TABLE `alpha_alliance_users` (
  `user_id` varchar(11) COLLATE latin1_general_ci NOT NULL,
  `ally_id` varchar(11) COLLATE latin1_general_ci NOT NULL,
  `user_rank` varchar(11) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;



--
-- Table structure for table `alpha_army`
--

CREATE TABLE `alpha_army` (
  `city` int(11) NOT NULL,
  `army_line` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `army_start` int(11) NOT NULL DEFAULT '0',
  `ships_line` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `ships_start` int(11) NOT NULL DEFAULT '0',
  `phalanx` int(11) NOT NULL DEFAULT '0',
  `steamgiant` int(11) NOT NULL DEFAULT '0',
  `spearman` int(11) NOT NULL DEFAULT '0',
  `swordsman` int(11) NOT NULL DEFAULT '0',
  `slinger` int(11) NOT NULL DEFAULT '0',
  `archer` int(11) NOT NULL DEFAULT '0',
  `marksman` int(11) NOT NULL DEFAULT '0',
  `ram` int(11) NOT NULL DEFAULT '0',
  `catapult` int(11) NOT NULL DEFAULT '0',
  `mortar` int(11) NOT NULL DEFAULT '0',
  `gyrocopter` int(11) NOT NULL DEFAULT '0',
  `bombardier` int(11) NOT NULL DEFAULT '0',
  `cook` int(11) NOT NULL DEFAULT '0',
  `medic` int(11) NOT NULL DEFAULT '0',
  `barbarian` int(11) NOT NULL DEFAULT '0',
  `ship_ram` int(11) NOT NULL DEFAULT '0',
  `ship_flamethrower` int(11) NOT NULL DEFAULT '0',
  `ship_steamboat` int(11) NOT NULL DEFAULT '0',
  `ship_ballista` int(11) NOT NULL DEFAULT '0',
  `ship_catapult` int(11) NOT NULL DEFAULT '0',
  `ship_mortar` int(11) NOT NULL DEFAULT '0',
  `ship_submarine` int(11) NOT NULL DEFAULT '0',
  `ship_transport` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`city`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `alpha_banners`
--

CREATE TABLE `alpha_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame` text CHARACTER SET utf8 NOT NULL,
  `image` text CHARACTER SET utf8 NOT NULL,
  `link` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `alpha_banners`
--


-- --------------------------------------------------------

--
-- Table structure for table `alpha_banners_right`
--

CREATE TABLE `alpha_banners_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame` text CHARACTER SET utf8 NOT NULL,
  `image` text CHARACTER SET utf8 NOT NULL,
  `link` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `alpha_banners_right`
--


-- --------------------------------------------------------

--
-- Table structure for table `alpha_config`
--

CREATE TABLE `alpha_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_name` text CHARACTER SET utf8 NOT NULL,
  `game_version` varchar(20) NOT NULL,
  `style_version` varchar(20) NOT NULL,
  `script_version` varchar(20) NOT NULL,
  `admin_email` text CHARACTER SET utf8 NOT NULL,
  `board_link` varchar(30) NOT NULL,
  `head_news` varchar(30) NOT NULL,
  `game_speed` int(11) NOT NULL DEFAULT '1',
  `easter_design` enum('0', '1') NOT NULL,
  `double_login` enum('0', '1') NOT NULL,
  `standard_capacity` int(11) NOT NULL,
  `transport_capacity` int(11) NOT NULL,
  `town_queue_size` int(11) NOT NULL,
  `army_queue_size` int(11) NOT NULL,
  `notes_default` int(11) NOT NULL,
  `notes_premium` int(11) NOT NULL,
  `trade_route_time` int(11) NOT NULL,
  `research_rate` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `alpha_config`
--

INSERT INTO `alpha_config` VALUES(1, 'MyIkariam', '0.0.1 Alpha 2', '0.0.1', '0.0.1', 'test@test.com', 'http://boardforum01.zz.mu/forum/', 'Welcome to MyIkariam', 50, '0', '0', 3000, 500, 5, 5, 200, 7000, 604800, 250);

-- --------------------------------------------------------

--
-- Table structure for table `alpha_double_login`
--

CREATE TABLE `alpha_double_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_from` int(11) NOT NULL,
  `account_to` int(11) NOT NULL,
  `login_time` int(11) NOT NULL,
  `ip_address` varchar(15) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`,`account_from`,`account_to`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `alpha_double_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `alpha_islands`
--

CREATE TABLE `alpha_islands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'Island',
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `trade_resource` int(11) NOT NULL DEFAULT '3',
  `wonder` int(11) NOT NULL DEFAULT '0',
  `wood_level` int(11) NOT NULL DEFAULT '1',
  `trade_level` int(11) NOT NULL DEFAULT '1',
  `wood_count` int(11) NOT NULL DEFAULT '0',
  `trade_count` int(11) NOT NULL DEFAULT '0',
  `wood_start` int(11) NOT NULL DEFAULT '0',
  `trade_start` int(11) NOT NULL DEFAULT '0',
  `city0` int(11) NOT NULL DEFAULT '0',
  `city1` int(11) NOT NULL DEFAULT '0',
  `city2` int(11) NOT NULL DEFAULT '0',
  `city3` int(11) NOT NULL DEFAULT '0',
  `city4` int(11) NOT NULL DEFAULT '0',
  `city5` int(11) NOT NULL DEFAULT '0',
  `city6` int(11) NOT NULL DEFAULT '0',
  `city7` int(11) NOT NULL DEFAULT '0',
  `city8` int(11) NOT NULL DEFAULT '0',
  `city9` int(11) NOT NULL DEFAULT '0',
  `city10` int(11) NOT NULL DEFAULT '0',
  `city11` int(11) NOT NULL DEFAULT '0',
  `city12` int(11) NOT NULL DEFAULT '0',
  `city13` int(11) NOT NULL DEFAULT '0',
  `city14` int(11) NOT NULL DEFAULT '0',
  `city15` int(11) NOT NULL DEFAULT '0',
  `barbarian_village` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`,`name`,`x`,`y`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `alpha_islands`
--

INSERT INTO `alpha_islands` VALUES(1, 'Buvios', 1, 1, 2, 4, 6, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(2, 'Angaios', 1, 4, 1, 4, 7, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(3, 'Queoos', 1, 8, 1, 3, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(4, 'Kelatia', 1, 10, 5, 3, 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(5, 'Buratia', 1, 17, 4, 3, 8, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(6, 'Whoriios', 1, 18, 3, 4, 8, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(7, 'Taiuios', 1, 19, 2, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(8, 'Horios', 1, 20, 2, 2, 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(9, 'Ageitia', 1, 21, 1, 1, 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(10, 'Verotia', 2, 2, 4, 4, 6, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(11, 'Sepaios', 2, 3, 5, 4, 5, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(12, 'Croicios', 2, 5, 5, 4, 5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(13, 'Revios', 2, 7, 2, 4, 8, 9, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(14, 'Rikios', 2, 9, 1, 1, 7, 12, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(15, 'Onaios', 2, 17, 5, 4, 6, 14, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(16, 'Iaaos', 2, 25, 2, 1, 7, 11, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(17, 'Burytia', 3, 2, 2, 2, 5, 2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(18, 'Blinaios', 3, 5, 3, 1, 2, 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(19, 'Llaynios', 3, 8, 5, 1, 4, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(20, 'Foyeos', 3, 13, 5, 1, 1, 12, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(21, 'Urneitia', 3, 17, 1, 4, 6, 19, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(22, 'Striwoios', 3, 23, 5, 2, 5, 11, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(23, 'Ineitia', 4, 7, 4, 2, 1, 23, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(24, 'Rouyios', 4, 8, 5, 1, 7, 11, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(25, 'Nysetia', 4, 13, 1, 3, 5, 28, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(26, 'Likoios', 4, 14, 3, 2, 6, 38, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(27, 'Wubios', 4, 16, 1, 3, 4, 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(28, 'Mosautia', 4, 20, 1, 3, 5, 5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(29, 'Zenios', 4, 24, 1, 2, 8, 11, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(30, 'Haunios', 5, 1, 5, 2, 6, 14, 7, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(31, 'Threcios', 5, 2, 1, 4, 5, 3, 3, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(32, 'Janios', 5, 3, 4, 4, 1, 2, 2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(33, 'Voigios', 5, 4, 4, 3, 8, 2, 2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(34, 'Vohios', 5, 5, 1, 4, 6, 6, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(35, 'Whoocios', 5, 9, 3, 4, 5, 13, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(36, 'Daetios', 5, 16, 3, 1, 8, 3, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(37, 'Miluos', 5, 18, 5, 2, 3, 9, 3, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(38, 'Urnoitia', 5, 23, 3, 1, 1, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(39, 'Adaytia', 5, 25, 4, 1, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(40, 'Swoyuos', 6, 1, 1, 4, 8, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(41, 'Doruios', 6, 2, 5, 3, 7, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(42, 'Urneos', 6, 7, 5, 3, 8, 15, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(43, 'Zhaisios', 6, 8, 1, 3, 5, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(44, 'Emuios', 6, 11, 2, 2, 3, 9, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(45, 'Reerios', 6, 14, 3, 3, 4, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(46, 'Lauroos', 6, 17, 5, 2, 3, 3, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(47, 'Kimayos', 6, 19, 1, 3, 6, 2, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(48, 'Gyrios', 6, 22, 3, 4, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(49, 'Delytia', 6, 23, 4, 4, 2, 8, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(50, 'Vymios', 6, 24, 1, 4, 2, 5, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(51, 'Ducaios', 7, 3, 3, 2, 7, 31, 19, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(52, 'Wybios', 7, 5, 4, 1, 6, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(53, 'Oughatia', 7, 10, 5, 1, 3, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(54, 'Hatieos', 7, 12, 5, 2, 2, 19, 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(55, 'Shyiaos', 7, 18, 4, 4, 1, 4, 5, 615, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(56, 'Duneios', 7, 20, 3, 4, 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(57, 'Entheetia', 7, 23, 4, 4, 5, 8, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(58, 'Sholios', 8, 3, 4, 4, 8, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(59, 'Tantuios', 8, 7, 5, 4, 8, 5, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(60, 'Ageoutia', 8, 9, 1, 1, 6, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(61, 'Clauzaios', 8, 12, 4, 1, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(62, 'Taioos', 8, 14, 3, 4, 1, 4, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(63, 'Syfios', 8, 17, 4, 4, 1, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(64, 'Veuweos', 8, 20, 5, 4, 1, 19, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(65, 'Schuirios', 8, 21, 5, 4, 2, 12, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(66, 'Atetia', 9, 1, 2, 1, 4, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(67, 'Rovios', 9, 2, 2, 3, 5, 6, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(68, 'Chroweios', 9, 3, 1, 1, 3, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(69, 'Quaylios', 9, 6, 5, 2, 4, 12, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(70, 'Sninios', 9, 7, 1, 3, 7, 12, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(71, 'Dakoos', 9, 9, 5, 4, 8, 2, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(72, 'Honitia', 9, 10, 1, 3, 5, 4, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(73, 'Tehyios', 9, 14, 5, 4, 7, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(74, 'Rahios', 9, 19, 2, 4, 4, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(75, 'Uskeuos', 9, 22, 1, 3, 6, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(76, 'Straidios', 9, 25, 3, 1, 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(77, 'Sackyos', 10, 3, 5, 3, 8, 14, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(78, 'Peroeos', 10, 4, 2, 3, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(79, 'Untutia', 10, 6, 2, 2, 4, 36, 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(80, 'Smakios', 10, 8, 3, 1, 2, 4, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(81, 'Takios', 10, 9, 5, 1, 1, 19, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(82, 'Mosuos', 10, 10, 4, 2, 5, 8, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(83, 'Swauxuos', 10, 17, 2, 1, 6, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(84, 'Tysoios', 10, 22, 5, 3, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(85, 'Wotios', 11, 9, 4, 1, 5, 8, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(86, 'Lihios', 11, 11, 3, 3, 5, 2, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(87, 'Samootia', 11, 13, 4, 4, 2, 6, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(88, 'Ildetia', 11, 14, 3, 4, 5, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(89, 'Yeritia', 11, 15, 3, 3, 6, 2, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(90, 'Soixios', 11, 16, 1, 3, 8, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(91, 'Aleeos', 11, 18, 4, 4, 4, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(92, 'Silios', 11, 23, 5, 3, 5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(93, 'Royios', 11, 25, 5, 3, 3, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(94, 'Engoios', 12, 1, 5, 2, 1, 38, 26, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(95, 'Skeloos', 12, 2, 1, 3, 1, 19, 18, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(96, 'Fuyyos', 12, 8, 4, 1, 6, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(97, 'Cedios', 12, 14, 2, 2, 1, 18, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(98, 'Snoduos', 12, 18, 3, 3, 6, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(99, 'Cosios', 12, 19, 3, 4, 8, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(100, 'Untyos', 12, 20, 4, 3, 8, 11, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(101, 'Threkios', 12, 22, 1, 2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(102, 'Josios', 12, 23, 1, 4, 2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(103, 'Lleuhuos', 12, 25, 3, 4, 7, 31, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(104, 'Seyckoos', 13, 3, 2, 2, 1, 259, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(105, 'Bloenios', 13, 7, 2, 4, 7, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(106, 'Nusiios', 13, 8, 5, 2, 2, 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(107, 'Kuchiios', 13, 11, 5, 4, 4, 9, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(108, 'Shyitia', 13, 12, 5, 4, 2, 22, 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(109, 'Layiios', 13, 13, 5, 4, 4, 9, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(110, 'Angouos', 13, 18, 5, 2, 8, 3, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(111, 'Dagios', 13, 19, 5, 3, 1, 25, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(112, 'Nauyios', 13, 20, 1, 3, 8, 22, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(113, 'Dagios', 13, 21, 4, 2, 1, 13, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(114, 'Sluzios', 13, 22, 5, 3, 5, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(115, 'Nautoos', 13, 25, 2, 2, 7, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(116, 'Echotia', 14, 1, 1, 2, 1, 8, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(117, 'Athytia', 14, 2, 3, 3, 4, 26, 19, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(118, 'Cukios', 14, 3, 1, 1, 4, 24, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(119, 'Zukyos', 14, 5, 5, 1, 7, 25, 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(120, 'Aruos', 14, 6, 4, 2, 5, 23, 17, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(121, 'Staltaos', 14, 10, 4, 2, 5, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(122, 'Kaisios', 14, 17, 4, 3, 1, 6, 2, 97, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(123, 'Deleios', 14, 20, 2, 1, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(124, 'Bluldios', 14, 22, 2, 4, 5, 7, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(125, 'Enoitia', 14, 24, 5, 3, 4, 7, 5, 0, 0, 0, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(126, 'Umyos', 14, 25, 4, 2, 4, 17, 17, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(127, 'Brivios', 15, 4, 4, 4, 8, 22, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(128, 'Gerios', 15, 6, 4, 4, 4, 11, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(129, 'Dynatia', 15, 8, 4, 4, 6, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(130, 'Aughatia', 15, 9, 1, 1, 7, 11, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(131, 'Gepios', 15, 11, 5, 2, 5, 4, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(132, 'Staugios', 15, 12, 2, 1, 6, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(133, 'Llisyios', 15, 13, 2, 2, 4, 4, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(134, 'Killoos', 15, 14, 2, 1, 5, 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(135, 'Slijios', 15, 17, 4, 3, 8, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(136, 'Smounaos', 15, 19, 1, 3, 1, 2, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(137, 'Lluisaos', 15, 20, 4, 1, 7, 15, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(138, 'Yerytia', 15, 21, 2, 4, 4, 14, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(139, 'Toneaos', 15, 23, 5, 4, 5, 18, 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(140, 'Ritaos', 15, 24, 3, 1, 7, 5, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(141, 'Zhecios', 16, 1, 4, 3, 2, 34, 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(142, 'Echuitia', 16, 3, 1, 4, 4, 7, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(143, 'Yimios', 16, 4, 4, 2, 2, 5, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(144, 'Ageotia', 16, 6, 1, 2, 5, 9, 9, 6540, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(145, 'Nysaeos', 16, 8, 4, 2, 7, 29, 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(146, 'Phojios', 16, 9, 3, 3, 6, 3, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(147, 'Oldooos', 16, 13, 3, 1, 1, 24, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(148, 'Nedios', 16, 17, 4, 3, 7, 5, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(149, 'Issaos', 16, 19, 4, 1, 1, 7, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(150, 'Aughuos', 16, 21, 2, 3, 8, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(151, 'Rabios', 16, 22, 1, 2, 8, 16, 19, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(152, 'Esteutia', 16, 23, 5, 1, 1, 34, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(153, 'Imaytia', 16, 24, 2, 2, 2, 26, 17, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(154, 'Wavios', 17, 2, 4, 4, 7, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(155, 'Trodyos', 17, 5, 1, 2, 7, 34, 25, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(156, 'Enieos', 17, 7, 1, 2, 4, 20, 19, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(157, 'Layrios', 17, 8, 5, 4, 3, 13, 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(158, 'Voofios', 17, 9, 1, 1, 3, 29, 18, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(159, 'Oriaos', 17, 11, 5, 2, 7, 14, 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(160, 'Swaishoios', 17, 12, 1, 4, 2, 4, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(161, 'Beyreios', 17, 14, 3, 4, 4, 20, 17, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(162, 'Burauos', 17, 17, 5, 1, 5, 31, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(163, 'Zyhiios', 17, 18, 4, 3, 8, 25, 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(164, 'Llafios', 17, 23, 2, 2, 2, 14, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(165, 'Smaeghiios', 17, 25, 3, 3, 5, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(166, 'Ashaos', 18, 2, 3, 4, 5, 24, 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(167, 'Drorios', 18, 11, 1, 2, 5, 14, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(168, 'Wutios', 18, 12, 5, 1, 8, 8, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(169, 'Nysytia', 18, 13, 2, 2, 4, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(170, 'Solios', 18, 14, 1, 2, 5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(171, 'Caniios', 18, 16, 4, 3, 6, 13, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(172, 'Chaeitia', 18, 17, 2, 2, 7, 37, 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(173, 'Llocoios', 18, 18, 4, 2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(174, 'Wareatia', 18, 21, 3, 3, 1, 11, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(175, 'Woretia', 18, 24, 2, 3, 2, 14, 17, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(176, 'Lliaruios', 18, 25, 5, 2, 4, 19, 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(177, 'Enaeos', 19, 1, 3, 4, 8, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(178, 'Phynaos', 19, 2, 3, 1, 3, 15, 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(179, 'Clizios', 19, 3, 4, 2, 7, 20, 18, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(180, 'Leiboios', 19, 4, 3, 2, 5, 2, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(181, 'Newios', 19, 6, 2, 3, 6, 6, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(182, 'Dopyios', 19, 10, 3, 1, 8, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(183, 'Fusios', 19, 12, 5, 2, 3, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(184, 'Zaujios', 19, 16, 5, 2, 7, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(185, 'Aduos', 19, 20, 2, 2, 3, 17, 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(186, 'Rhoesios', 19, 25, 2, 1, 5, 23, 17, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(187, 'Oreos', 20, 2, 3, 4, 1, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(188, 'Taweios', 20, 5, 2, 1, 1, 6, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(189, 'Oughyos', 20, 9, 3, 1, 1, 8, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(190, 'Recios', 20, 13, 1, 1, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(191, 'Rookios', 20, 17, 5, 1, 4, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(192, 'Sossyos', 20, 18, 1, 2, 6, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(193, 'Drichuos', 20, 22, 1, 1, 4, 25, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `alpha_islands` VALUES(194, 'Neyduos', 20, 25, 2, 1, 8, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `alpha_missions`
--

CREATE TABLE `alpha_missions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL,
  `to` int(30) NOT NULL,
  `state` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `prev_stage_time` BIGINT NOT NULL,
  `next_stage_time` BIGINT NOT NULL,
  `wood` int(11) unsigned NOT NULL DEFAULT '0',
  `wine` int(11) unsigned NOT NULL DEFAULT '0',
  `marble` int(11) unsigned NOT NULL DEFAULT '0',
  `crystal` int(11) unsigned NOT NULL DEFAULT '0',
  `sulfur` int(11) unsigned NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `peoples` int(11) NOT NULL DEFAULT '0',
  `ships` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`from`) REFERENCES alpha_towns(id),
  FOREIGN KEY (`to`) REFERENCES alpha_towns(id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alpha_notes`
--

CREATE TABLE `alpha_notes` (
  `user` int(11) NOT NULL DEFAULT '0',
  `text` text CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `alpha_notes`
--

-- --------------------------------------------------------


--
-- Table structure for table `alpha_reports`
--

CREATE TABLE `alpha_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attacker` int(11) NOT NULL DEFAULT '0',
  `defender` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `text` text CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `alpha_reports`
--

-- --------------------------------------------------------


--
-- Table structure for table `alpha_research`
--

CREATE TABLE `alpha_research` (
  `user` int(11) NOT NULL,
  `points` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `res1_1` int(11) NOT NULL DEFAULT '0',
  `res1_2` int(11) NOT NULL DEFAULT '0',
  `res1_3` int(11) NOT NULL DEFAULT '0',
  `res1_4` int(11) NOT NULL DEFAULT '0',
  `res1_5` int(11) NOT NULL DEFAULT '0',
  `res1_6` int(11) NOT NULL DEFAULT '0',
  `res1_7` int(11) NOT NULL DEFAULT '0',
  `res1_8` int(11) NOT NULL DEFAULT '0',
  `res1_9` int(11) NOT NULL DEFAULT '0',
  `res1_10` int(11) NOT NULL DEFAULT '0',
  `res1_11` int(11) NOT NULL DEFAULT '0',
  `res1_12` int(11) NOT NULL DEFAULT '0',
  `res1_13` int(11) NOT NULL DEFAULT '0',
  `res1_14` int(11) NOT NULL DEFAULT '0',
  `res2_1` int(11) NOT NULL DEFAULT '0',
  `res2_2` int(11) NOT NULL DEFAULT '0',
  `res2_3` int(11) NOT NULL DEFAULT '0',
  `res2_4` int(11) NOT NULL DEFAULT '0',
  `res2_5` int(11) NOT NULL DEFAULT '0',
  `res2_6` int(11) NOT NULL DEFAULT '0',
  `res2_7` int(11) NOT NULL DEFAULT '0',
  `res2_8` int(11) NOT NULL DEFAULT '0',
  `res2_9` int(11) NOT NULL DEFAULT '0',
  `res2_10` int(11) NOT NULL DEFAULT '0',
  `res2_11` int(11) NOT NULL DEFAULT '0',
  `res2_12` int(11) NOT NULL DEFAULT '0',
  `res2_13` int(11) NOT NULL DEFAULT '0',
  `res2_14` int(11) NOT NULL DEFAULT '0',
  `res2_15` int(11) NOT NULL DEFAULT '0',
  `res3_1` int(11) NOT NULL DEFAULT '0',
  `res3_2` int(11) NOT NULL DEFAULT '0',
  `res3_3` int(11) NOT NULL DEFAULT '0',
  `res3_4` int(11) NOT NULL DEFAULT '0',
  `res3_5` int(11) NOT NULL DEFAULT '0',
  `res3_6` int(11) NOT NULL DEFAULT '0',
  `res3_7` int(11) NOT NULL DEFAULT '0',
  `res3_8` int(11) NOT NULL DEFAULT '0',
  `res3_9` int(11) NOT NULL DEFAULT '0',
  `res3_10` int(11) NOT NULL DEFAULT '0',
  `res3_11` int(11) NOT NULL DEFAULT '0',
  `res3_12` int(11) NOT NULL DEFAULT '0',
  `res3_13` int(11) NOT NULL DEFAULT '0',
  `res3_14` int(11) NOT NULL DEFAULT '0',
  `res3_15` int(11) NOT NULL DEFAULT '0',
  `res3_16` int(11) NOT NULL DEFAULT '0',
  `res4_1` int(11) NOT NULL DEFAULT '0',
  `res4_2` int(11) NOT NULL DEFAULT '0',
  `res4_3` int(11) NOT NULL DEFAULT '0',
  `res4_4` int(11) NOT NULL DEFAULT '0',
  `res4_5` int(11) NOT NULL DEFAULT '0',
  `res4_6` int(11) NOT NULL DEFAULT '0',
  `res4_7` int(11) NOT NULL DEFAULT '0',
  `res4_8` int(11) NOT NULL DEFAULT '0',
  `res4_9` int(11) NOT NULL DEFAULT '0',
  `res4_10` int(11) NOT NULL DEFAULT '0',
  `res4_11` int(11) NOT NULL DEFAULT '0',
  `res4_12` int(11) NOT NULL DEFAULT '0',
  `res4_13` int(11) NOT NULL DEFAULT '0',
  `res4_14` int(11) NOT NULL DEFAULT '0',
  `way1_checked` int(11) NOT NULL DEFAULT '0',
  `way2_checked` int(11) NOT NULL DEFAULT '0',
  `way3_checked` int(11) NOT NULL DEFAULT '0',
  `way4_checked` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alpha_spyes`
--

CREATE TABLE `alpha_spyes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `risk` int(11) NOT NULL,
  `last_update` int(11) NOT NULL,
  `mission_type` int(11) NOT NULL,
  `mission_start` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user`,`from`,`to`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `alpha_spy_messages`
--

CREATE TABLE `alpha_spy_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL DEFAULT '0',
  `spy` int(11) NOT NULL DEFAULT '0',
  `from` int(11) NOT NULL DEFAULT '0',
  `to` int(11) NOT NULL DEFAULT '0',
  `mission` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `desc` text CHARACTER SET utf8 NOT NULL DEFAULT '',
  `text` text CHARACTER SET utf8 NOT NULL DEFAULT '',
  `checked` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user`,`spy`,`from`,`to`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `alpha_towns`
--

CREATE TABLE `alpha_towns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `island` int(11) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `last_update` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'Polis',
  `wood` int(11) unsigned NOT NULL DEFAULT '500',
  `wine` int(11) unsigned NOT NULL DEFAULT '0',
  `marble` int(11) unsigned NOT NULL DEFAULT '0',
  `crystal` int(11) unsigned NOT NULL DEFAULT '0',
  `sulfur` int(11) unsigned NOT NULL DEFAULT '0',
  `pos0_type` int(11) NOT NULL DEFAULT '1',
  `pos0_level` int(11) NOT NULL DEFAULT '1',
  `pos1_type` int(11) NOT NULL DEFAULT '0',
  `pos1_level` int(11) NOT NULL DEFAULT '0',
  `pos2_type` int(11) NOT NULL DEFAULT '0',
  `pos2_level` int(11) NOT NULL DEFAULT '0',
  `pos3_type` int(11) NOT NULL DEFAULT '0',
  `pos3_level` int(11) NOT NULL DEFAULT '0',
  `pos4_type` int(11) NOT NULL DEFAULT '0',
  `pos4_level` int(11) NOT NULL DEFAULT '0',
  `pos5_type` int(11) NOT NULL DEFAULT '0',
  `pos5_level` int(11) NOT NULL DEFAULT '0',
  `pos6_type` int(11) NOT NULL DEFAULT '0',
  `pos6_level` int(11) NOT NULL DEFAULT '0',
  `pos7_type` int(11) NOT NULL DEFAULT '0',
  `pos7_level` int(11) NOT NULL DEFAULT '0',
  `pos8_type` int(11) NOT NULL DEFAULT '0',
  `pos8_level` int(11) NOT NULL DEFAULT '0',
  `pos9_type` int(11) NOT NULL DEFAULT '0',
  `pos9_level` int(11) NOT NULL DEFAULT '0',
  `pos10_type` int(11) NOT NULL DEFAULT '0',
  `pos10_level` int(11) NOT NULL DEFAULT '0',
  `pos11_type` int(11) NOT NULL DEFAULT '0',
  `pos11_level` int(11) NOT NULL DEFAULT '0',
  `pos12_type` int(11) NOT NULL DEFAULT '0',
  `pos12_level` int(11) NOT NULL DEFAULT '0',
  `pos13_type` int(11) NOT NULL DEFAULT '0',
  `pos13_level` int(11) NOT NULL DEFAULT '0',
  `pos14_type` int(11) NOT NULL DEFAULT '0',
  `pos14_level` int(11) NOT NULL DEFAULT '0',
  `build_line` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `build_start` int(11) NOT NULL DEFAULT '0',
  `peoples` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '40',
  `workers` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `tradegood` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `scientists` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `templer` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `spyes` int(11) NOT NULL DEFAULT '0',
  `spyes_start` int(11) NOT NULL DEFAULT '0',
  `workers_wood` int(11) NOT NULL DEFAULT '0',
  `tradegood_wood` int(11) NOT NULL DEFAULT '0',
  `tavern_wine` int(11) NOT NULL DEFAULT '0',
  `branch_search_type` int(11) NOT NULL DEFAULT '0',
  `branch_search_resource` int(11) NOT NULL DEFAULT '0',
  `branch_search_radius` int(11) NOT NULL DEFAULT '1',
  `branch_trade_wood_type` int(11) NOT NULL DEFAULT '1',
  `branch_trade_wine_type` int(11) NOT NULL DEFAULT '1',
  `branch_trade_marble_type` int(11) NOT NULL DEFAULT '1',
  `branch_trade_crystal_type` int(11) NOT NULL DEFAULT '1',
  `branch_trade_sulfur_type` int(11) NOT NULL DEFAULT '1',
  `branch_trade_wood_count` int(11) NOT NULL DEFAULT '0',
  `branch_trade_wine_count` int(11) NOT NULL DEFAULT '0',
  `branch_trade_marble_count` int(11) NOT NULL DEFAULT '0',
  `branch_trade_crystal_count` int(11) NOT NULL DEFAULT '0',
  `branch_trade_sulfur_count` int(11) NOT NULL DEFAULT '0',
  `branch_trade_wood_cost` int(11) NOT NULL DEFAULT '0',
  `branch_trade_wine_cost` int(11) NOT NULL DEFAULT '0',
  `branch_trade_marble_cost` int(11) NOT NULL DEFAULT '0',
  `branch_trade_crystal_cost` int(11) NOT NULL DEFAULT '0',
  `branch_trade_sulfur_cost` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`user`,`island`,`position`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `alpha_town_messages`
--

CREATE TABLE `alpha_town_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL DEFAULT '0',
  `town` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `text` text CHARACTER SET utf8 NOT NULL DEFAULT '',
  `checked` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`user`,`town`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `alpha_town_messages_new` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `town_id` int(11) NOT NULL,
    `viewed` BOOLEAN NOT NULL DEFAULT FALSE,
    `date` int(11) NOT NULL,
    `type` int(11) NOT NULL,
    `data` JSON NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES alpha_users(id),
    FOREIGN KEY (`town_id`) REFERENCES alpha_towns(id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `alpha_colonies` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `town_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`town_id`) REFERENCES alpha_towns(id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `alpha_trade_routes`
--

CREATE TABLE `alpha_trade_routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `start_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `send_resource` int(11) NOT NULL,
  `send_time` int(11) NOT NULL,
  `send_count` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user`,`from`,`to`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `alpha_users`
--

CREATE TABLE `alpha_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `register_key` varchar(255) CHARACTER SET utf8 NOT NULL,
  `register_complete` int(11) NOT NULL DEFAULT '0',
  `rank` int(11) NOT NULL DEFAULT '0',
  `last_visit` int(11) NOT NULL,
  `double_login` int(11) NOT NULL DEFAULT '0',
  `blocked_time` int(11) NOT NULL DEFAULT '0',
  `blocked_why` text CHARACTER SET utf8 NOT NULL DEFAULT '',
  `town` int(11) NOT NULL DEFAULT '0',
  `capital` int(11) NOT NULL DEFAULT '0',
  `gold` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '100',
  `ambrosy` int(11) NOT NULL DEFAULT '50',
  `transports` int(11) NOT NULL DEFAULT '0',
  `tutorial` int(11) NOT NULL DEFAULT '0',
  `premium_account` int(11) NOT NULL DEFAULT '0',
  `premium_wood` int(11) NOT NULL DEFAULT '0',
  `premium_marble` int(11) NOT NULL DEFAULT '0',
  `premium_sulfur` int(11) NOT NULL DEFAULT '0',
  `premium_crystal` int(11) NOT NULL DEFAULT '0',
  `premium_wine` int(11) NOT NULL DEFAULT '0',
  `premium_capacity` int(11) NOT NULL DEFAULT '0',
  `options_select` int(11) NOT NULL DEFAULT '1',
  `points` float(11,0) NOT NULL DEFAULT '0',
  `points_buildings` float(11,0) NOT NULL DEFAULT '0',
  `points_levels` float(11,0) NOT NULL DEFAULT '0',
  `points_peoples` float(11,0) NOT NULL DEFAULT '0',
  `points_research` float(11,0) NOT NULL DEFAULT '0',
  `points_complete` float(11,0) NOT NULL DEFAULT '0',
  `points_army` float(11,0) NOT NULL DEFAULT '0',
  `points_gold` float(11,0) NOT NULL DEFAULT '0',
  `points_transports` float(11,0) NOT NULL DEFAULT '0',
  `punti_diplo` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Table structure for table `alpha_user_messages`
--

CREATE TABLE `alpha_user_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL DEFAULT '0',
  `to` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL DEFAULT '0',
  `text` text CHARACTER SET utf8 NOT NULL DEFAULT '',
  `checked_from` int(11) NOT NULL DEFAULT '0',
  `checked_to` int(11) NOT NULL DEFAULT '0',
  `deleted_from` int(11) NOT NULL DEFAULT '0',
  `deleted_to` int(11) NOT NULL DEFAULT '0',
  `archived_from` int(11) NOT NULL DEFAULT '0',
  `archived_to` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`from`,`to`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
