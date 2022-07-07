-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2022 at 06:11 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paimon_social_media`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `post_id`, `comment_content`, `upload_time`) VALUES
(43, 16, 156, 'Him also my brother 😋', '2022-07-07 09:16:06'),
(44, 16, 155, '♥‿♥', '2022-07-07 09:18:35'),
(45, 17, 157, '💪💪👌', '2022-07-07 09:37:46'),
(46, 17, 159, '✌️', '2022-07-07 09:38:47'),
(47, 16, 159, '>.<', '2022-07-07 09:40:04'),
(48, 19, 158, '?_?', '2022-07-07 09:46:33'),
(49, 16, 169, '😂😂😂', '2022-07-07 10:07:27'),
(50, 17, 171, '😲', '2022-07-07 10:13:26'),
(51, 29, 155, 'mew', '2022-07-07 10:54:09'),
(52, 29, 157, 'mew', '2022-07-07 10:54:23'),
(53, 17, 175, 'handsome 😘', '2022-07-07 10:56:02');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220620145615', '2022-06-20 16:56:23', 177),
('DoctrineMigrations\\Version20220620150752', '2022-06-20 17:08:13', 59),
('DoctrineMigrations\\Version20220620151123', '2022-06-20 17:11:27', 69),
('DoctrineMigrations\\Version20220621100743', '2022-06-21 12:32:16', 70),
('DoctrineMigrations\\Version20220621135713', '2022-06-21 15:57:17', 823),
('DoctrineMigrations\\Version20220622032832', '2022-06-22 05:28:42', 490),
('DoctrineMigrations\\Version20220622114046', '2022-06-22 13:40:54', 1420),
('DoctrineMigrations\\Version20220624012913', '2022-06-24 03:29:23', 884),
('DoctrineMigrations\\Version20220624111613', '2022-06-24 13:16:22', 499),
('DoctrineMigrations\\Version20220627084434', '2022-06-27 10:45:25', 268),
('DoctrineMigrations\\Version20220628025946', '2022-06-28 04:59:57', 391),
('DoctrineMigrations\\Version20220629081252', '2022-06-29 10:13:03', 413),
('DoctrineMigrations\\Version20220705112720', '2022-07-05 13:27:23', 1519);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `time`, `message`) VALUES
(5, 15, '2022-07-07 11:00:26', 'hello, I\'m admin and this is chat area, every can be chat at here'),
(6, 16, '2022-07-07 11:00:49', 'ok, I\'m get it'),
(7, 17, '2022-07-07 11:02:00', 'hello everybody 😬'),
(8, 28, '2022-07-07 11:03:36', 'concainitthoi 🤣'),
(9, 26, '2022-07-07 11:04:52', 'join Juventus with me?'),
(10, 27, '2022-07-07 11:08:30', 'If you work, you can eat'),
(11, 27, '2022-07-07 11:08:45', '🤣💩💩💩'),
(12, 29, '2022-07-07 11:09:04', 'mew mew mew');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seen` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `sender_id`, `receiver_id`, `type`, `seen`) VALUES
(84, 16, 17, 'invite', 'no'),
(85, 16, 17, 'like', 'yes'),
(86, 16, 17, 'like', 'yes'),
(87, 16, 17, 'comment', 'yes'),
(88, 16, 17, 'comment', 'yes'),
(89, 16, 18, 'invite', 'no'),
(90, 16, 18, 'like', 'no'),
(91, 16, 18, 'like', 'no'),
(92, 16, 18, 'like', 'no'),
(93, 18, 17, 'invite', 'no'),
(94, 17, 18, 'like', 'no'),
(95, 17, 18, 'like', 'no'),
(96, 17, 18, 'like', 'no'),
(97, 17, 16, 'like', 'yes'),
(98, 17, 16, 'comment', 'yes'),
(99, 17, 18, 'comment', 'no'),
(100, 16, 18, 'comment', 'no'),
(101, 18, 16, 'like', 'yes'),
(102, 18, 17, 'like', 'no'),
(103, 19, 18, 'invite', 'no'),
(104, 19, 16, 'invite', 'no'),
(105, 19, 17, 'invite', 'no'),
(106, 17, 19, 'like', 'no'),
(107, 17, 19, 'like', 'no'),
(108, 19, 16, 'like', 'yes'),
(109, 19, 16, 'comment', 'yes'),
(110, 19, 17, 'like', 'no'),
(111, 19, 16, 'like', 'yes'),
(112, 19, 17, 'like', 'no'),
(113, 20, 18, 'invite', 'no'),
(114, 20, 16, 'invite', 'no'),
(115, 20, 15, 'invite', 'no'),
(116, 20, 19, 'invite', 'no'),
(117, 20, 17, 'invite', 'no'),
(118, 18, 20, 'like', 'no'),
(119, 18, 19, 'like', 'no'),
(120, 18, 20, 'like', 'no'),
(121, 16, 20, 'like', 'no'),
(122, 16, 19, 'like', 'no'),
(123, 21, 16, 'invite', 'no'),
(124, 21, 17, 'invite', 'no'),
(125, 17, 21, 'like', 'no'),
(126, 17, 20, 'like', 'no'),
(127, 17, 21, 'like', 'no'),
(128, 17, 20, 'like', 'no'),
(130, 22, 16, 'invite', 'no'),
(131, 17, 22, 'like', 'no'),
(132, 17, 22, 'like', 'no'),
(133, 22, 17, 'invite', 'no'),
(134, 22, 17, 'like', 'no'),
(135, 22, 17, 'like', 'no'),
(136, 16, 22, 'like', 'no'),
(137, 16, 22, 'like', 'no'),
(138, 16, 22, 'comment', 'no'),
(139, 23, 17, 'invite', 'no'),
(140, 23, 16, 'invite', 'no'),
(141, 17, 23, 'like', 'no'),
(142, 17, 23, 'like', 'no'),
(143, 17, 23, 'comment', 'no'),
(144, 23, 17, 'like', 'no'),
(145, 23, 17, 'like', 'no'),
(146, 16, 23, 'like', 'no'),
(147, 16, 23, 'like', 'no'),
(148, 16, 15, 'invite', 'no'),
(149, 26, 17, 'invite', 'no'),
(150, 26, 16, 'invite', 'no'),
(151, 17, 26, 'like', 'no'),
(152, 17, 26, 'like', 'no'),
(153, 16, 26, 'like', 'no'),
(154, 16, 26, 'like', 'no'),
(155, 26, 16, 'like', 'no'),
(156, 26, 16, 'like', 'no'),
(157, 27, 26, 'invite', 'no'),
(158, 27, 16, 'invite', 'no'),
(159, 27, 17, 'invite', 'no'),
(160, 16, 27, 'like', 'no'),
(161, 16, 27, 'like', 'no'),
(162, 28, 16, 'invite', 'no'),
(163, 16, 28, 'like', 'no'),
(164, 29, 16, 'invite', 'no'),
(165, 29, 17, 'invite', 'no'),
(166, 16, 29, 'like', 'no'),
(167, 17, 29, 'like', 'no'),
(168, 29, 17, 'like', 'no'),
(169, 29, 17, 'like', 'no'),
(170, 29, 17, 'comment', 'no'),
(171, 29, 16, 'like', 'no'),
(172, 29, 16, 'like', 'no'),
(173, 29, 16, 'comment', 'no'),
(174, 17, 26, 'comment', 'no'),
(175, 29, 29, 'like', 'no'),
(176, 29, 29, 'like', 'no'),
(177, 26, 26, 'like', 'no'),
(178, 26, 26, 'like', 'no'),
(179, 26, 27, 'like', 'no'),
(180, 26, 27, 'like', 'no'),
(181, 26, 17, 'like', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `caption` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_like` int(11) DEFAULT NULL,
  `total_comment` int(11) DEFAULT NULL,
  `upload_time` datetime NOT NULL,
  `deleted` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `caption`, `image`, `total_like`, `total_comment`, `upload_time`, `deleted`) VALUES
(153, 17, '', '62c63e3d8ce54124265689_1687222054790264_5162858216794514973_n.jpg', NULL, NULL, '2022-07-07 04:00:29', 'true'),
(154, 17, '(｡◕‿‿◕｡)', '62c63f8fbd65d95772266_2705970872965236_632200472798691328_n.jpg', NULL, NULL, '2022-07-07 04:06:07', 'true'),
(155, 17, '(ᵔᴥᵔ)', '62c63fe0b1e0b51116737_2340582749504052_2203976933392252928_n.jpg', 7, 2, '2022-07-07 04:07:28', 'false'),
(156, 17, 'My brother 😊', '62c64077c18aa219722257_3072157676346552_7925643272636394562_n.jpg', 5, 1, '2022-07-07 09:09:59', 'false'),
(157, 16, 'Hello, I\'m Ryan 😅', '62c6414739768z3170885078876_0278cee3f6a8f4eb901a51dd462a741b.jpg', 4, 2, '2022-07-07 04:13:27', 'false'),
(158, 16, 'I bet you will love it,\r\nit really is a blockbuster\r\n😱😱', '62c6440157893Spider Man far form home.jpg', 4, 1, '2022-07-07 09:25:05', 'false'),
(159, 18, 'Hi! ♥️', '62c6455ec75bcFB_IMG_1614323966647.jpg', 2, 2, '2022-07-07 04:30:54', 'false'),
(160, 18, '', '62c645bf1c1bahinh-nen-dem-giang-sinh_091726376.jpg', 2, NULL, '2022-07-07 09:32:31', 'false'),
(161, 18, 'Is it useful? 👀', '62c6460f1def0131752816_3815612358555191_3155517000523454452_o.jpg', 2, NULL, '2022-07-07 09:33:51', 'false'),
(162, 19, '', '62c648383e61b134671084_1564176410447883_1172392563814571750_o.jpg', 2, NULL, '2022-07-07 04:43:04', 'false'),
(163, 19, '', '62c64851b2f41Ảnh-nền-máy-tính-cực-đẹp-Gearvn.jpg', 2, NULL, '2022-07-07 09:43:29', 'false'),
(164, 20, '', '62c649ad54818Avatar.jpg', 2, NULL, '2022-07-07 04:49:17', 'false'),
(165, 20, '', '62c649c7c8f72130764089_1608736309327560_7453165455246016133_o.jpg', 3, NULL, '2022-07-07 09:49:43', 'false'),
(166, 21, '', '62c64af1236b7Gearvn_hính nền tối giản_ (39).jpg', 1, NULL, '2022-07-07 04:54:41', 'false'),
(167, 21, '', '62c64b28b2c74268772332_323142876478998_6569563362885641001_n.jpg', 1, NULL, '2022-07-07 09:55:36', 'false'),
(168, 22, 'I\'m Fizz z z z z z z .......................🐟', '62c64c014ff02fizz-chu-cho-tinh-nghich-khung-vien.jpg', 2, NULL, '2022-07-07 04:59:13', 'false'),
(169, 22, 'Fizz and friends 🤜🤛', '62c64c689f81dfizz_14.jpg', 2, 1, '2022-07-07 10:00:56', 'false'),
(170, 23, 'I\'m Diana 🌛  not diana 👿', '62c64ea7c9ff7Diana_Splash_Centered_11.jpg', 2, NULL, '2022-07-07 05:10:31', 'false'),
(171, 23, 'Fire..fire...never die ', '62c64f136893dcach-choi-diana-mua-10-1_1577162607.jpg', 2, 1, '2022-07-07 10:12:19', 'false'),
(172, 16, 'So cute 😍', '62c64feae37dd124469819_379640346680458_7512299767944675453_n.jpg', NULL, NULL, '2022-07-07 10:15:54', 'true'),
(173, 24, '', '62c651fec8b98seraphine_3_cvdy.jpg', NULL, NULL, '2022-07-07 05:24:46', 'false'),
(174, 25, '', '62c6523f37d7dYasuo_36.jpg', NULL, NULL, '2022-07-07 05:25:51', 'false'),
(175, 26, 'Turn on levitation mode 😎😎', '62c652fe8583fVi-sao-Kha-Banh-tro-thanh-hien-tuong-dinh-dam-tren-mang-xa-hoi-khabanh-1554192528-width660height597.jpg', 3, 1, '2022-07-07 05:29:02', 'false'),
(176, 26, 'Kha\' and juventus 🤣', '62c653663ab69tải xuống.jpg', 3, NULL, '2022-07-07 10:30:46', 'false'),
(177, 27, 'hehe....', '62c65487f08c9toan-bo-loi-ran-day-cua-huan-hoa-hong-huan-rose.jpg', 2, NULL, '2022-07-07 05:35:36', 'false'),
(178, 27, 'If you work, you can eat', '62c6551db6407images.jpg', 2, NULL, '2022-07-07 10:38:05', 'false'),
(179, 28, '', '62c655f3f0fcatải xuống (1).jpg', NULL, NULL, '2022-07-07 05:41:40', 'true'),
(180, 28, '', '62c656268680fimages (1).jpg', NULL, NULL, '2022-07-07 05:42:30', 'true'),
(181, 28, 'concainit 👏', '62c656731285ctien-bip-la-ai-2.jpg', 1, NULL, '2022-07-07 05:43:47', 'false'),
(182, 29, 'mew` mew\' mew mew` mew 😽😻', '62c658884fb2c010251_100357_3.jpg', 3, NULL, '2022-07-07 05:52:40', 'false'),
(183, 29, '', '62c659a94e88d290656296_882970775955319_5469132121496318817_n.jpg', 1, NULL, '2022-07-07 10:57:29', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `reaction`
--

CREATE TABLE `reaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reaction`
--

INSERT INTO `reaction` (`id`, `user_id`, `post_id`) VALUES
(86, 16, 155),
(87, 16, 156),
(88, 16, 159),
(89, 16, 160),
(90, 16, 161),
(91, 17, 161),
(92, 17, 159),
(93, 17, 160),
(94, 17, 157),
(95, 18, 158),
(96, 18, 155),
(97, 17, 163),
(98, 17, 162),
(99, 19, 158),
(100, 19, 156),
(101, 19, 157),
(102, 19, 155),
(103, 18, 164),
(104, 18, 162),
(105, 18, 165),
(106, 16, 165),
(107, 16, 163),
(108, 17, 167),
(109, 17, 165),
(110, 17, 166),
(111, 17, 164),
(112, 17, 169),
(113, 17, 168),
(114, 22, 156),
(115, 22, 155),
(116, 16, 169),
(117, 16, 168),
(118, 17, 171),
(119, 17, 170),
(120, 23, 155),
(121, 23, 156),
(122, 16, 171),
(123, 16, 170),
(124, 17, 176),
(125, 17, 175),
(126, 16, 176),
(127, 16, 175),
(128, 26, 158),
(129, 26, 157),
(130, 16, 178),
(131, 16, 177),
(132, 16, 181),
(133, 16, 182),
(134, 17, 182),
(135, 29, 156),
(136, 29, 155),
(137, 29, 158),
(138, 29, 157),
(139, 29, 183),
(140, 29, 182),
(141, 26, 175),
(142, 26, 176),
(143, 26, 178),
(144, 26, 177),
(145, 26, 155);

-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

CREATE TABLE `relationship` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `relationship`
--

INSERT INTO `relationship` (`id`, `user_id`, `friend_id`, `status`) VALUES
(117, 16, 17, '1'),
(118, 17, 16, '1'),
(119, 16, 18, '1'),
(120, 18, 16, '1'),
(121, 18, 17, '1'),
(122, 17, 18, '1'),
(123, 19, 18, '1'),
(124, 19, 16, '1'),
(125, 19, 17, '1'),
(126, 17, 19, '1'),
(127, 16, 19, '1'),
(128, 20, 18, '1'),
(129, 20, 16, '1'),
(130, 20, 15, '1'),
(131, 20, 19, '0'),
(132, 20, 17, '1'),
(133, 16, 20, '1'),
(134, 17, 20, '1'),
(135, 18, 20, '1'),
(136, 18, 19, '1'),
(137, 21, 16, '1'),
(138, 21, 17, '1'),
(139, 16, 21, '1'),
(140, 17, 21, '1'),
(142, 22, 16, '1'),
(145, 22, 17, '1'),
(146, 17, 22, '1'),
(147, 16, 22, '1'),
(148, 23, 17, '1'),
(149, 23, 16, '1'),
(150, 17, 23, '1'),
(151, 16, 23, '1'),
(152, 16, 15, '1'),
(153, 15, 16, '1'),
(154, 15, 20, '1'),
(155, 26, 17, '1'),
(156, 26, 16, '1'),
(157, 17, 26, '1'),
(158, 16, 26, '1'),
(159, 27, 26, '1'),
(160, 27, 16, '1'),
(161, 27, 17, '1'),
(162, 17, 27, '1'),
(163, 16, 27, '1'),
(164, 28, 16, '1'),
(165, 16, 28, '1'),
(166, 29, 16, '1'),
(167, 29, 17, '1'),
(168, 17, 29, '1'),
(169, 16, 29, '1'),
(170, 26, 27, '1');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `user_send_report_id` int(11) NOT NULL,
  `user_reported_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `reason` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `user_send_report_id`, `user_reported_id`, `post_id`, `reason`, `report_time`) VALUES
(11, 16, 29, 182, 'hmmm', '2022-07-07 10:55:09'),
(12, 17, 29, 182, 'wtf', '2022-07-07 10:55:28'),
(13, 17, 18, 161, 'vv', '2022-07-07 10:56:41');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `gender`, `fullname`, `avatar`, `login_status`, `email`, `phone`, `address`, `new_password`) VALUES
(15, 'administrator', '[\"ROLE_ADMIN\"]', '$2y$13$L9J0NLyBUuV.VvPMszSHA.8RfFgJoZ7EdTK26pRohG0tyIqui0CQy', 'male', 'admin', 'avatar.png', 'offline', NULL, NULL, NULL, NULL),
(16, 'ryan123456', '[\"ROLE_USER\"]', '$2y$13$9NLPbYITiBa0QjlYvvbso.wpXZtrh15tRzrZLvpIKNTsLERSanjVy', 'male', '_Ryan_', '62c6414739768z3170885078876_0278cee3f6a8f4eb901a51dd462a741b.jpg', 'offline', 'ryan@gmail.com', '0374463592', NULL, NULL),
(17, 'rom1234567', '[\"ROLE_USER\"]', '$2y$13$6qq5mWQgP6zT8bSgCK63mO3bDLrxbhcn0iLCVsOcQ6o1Jc.PSJQL.', 'female', '_Rom_', '62c63fe0b1e0b51116737_2340582749504052_2203976933392252928_n.jpg', 'offline', NULL, NULL, NULL, NULL),
(18, 'ten1234567', '[\"ROLE_USER\"]', '$2y$13$CytF8hxTzeaBYGQwT2Ar6ODWuk5erFGDvOE1YLKhVcN8waONtqrT2', 'female', '_Ten_', '62c6455ec75bcFB_IMG_1614323966647.jpg', 'offline', NULL, NULL, NULL, NULL),
(19, 'vuongkhailam', '[\"ROLE_USER\"]', '$2y$13$.ouHBq3eiG1tiF0URP5dNuiNU06kogF4ObIVuZelSvhmKYdPbh.16', 'male', 'Otiss', '62c648383e61b134671084_1564176410447883_1172392563814571750_o.jpg', 'offline', NULL, NULL, NULL, NULL),
(20, 'cappp123', '[\"ROLE_USER\"]', '$2y$13$Eqj6QS53sF.Ps6Ddr7fZCuuFInaoRCl9fx7/oC7qEtpkrmAQ.5Tv2', 'male', 'Capppp', '62c649ad54818Avatar.jpg', 'offline', NULL, NULL, NULL, NULL),
(21, 'kennen1234', '[\"ROLE_USER\"]', '$2y$13$KAV/nQtHWqkpLKkjKDJvseEKgyx4hwU8CJ2F4yMma/wHvmL0Mp4.2', 'male', 'Ken', '62c64af1236b7Gearvn_hính nền tối giản_ (39).jpg', 'offline', NULL, NULL, NULL, NULL),
(22, 'fizzzz1234', '[\"ROLE_USER\"]', '$2y$13$2T50at3B/CjArE1nCwliAu5rKzWwosGN7.hxXvfX7TJHGUChSYlmm', 'male', 'Fizz', '62c64c014ff02fizz-chu-cho-tinh-nghich-khung-vien.jpg', 'offline', NULL, NULL, NULL, NULL),
(23, 'diana123456', '[\"ROLE_USER\"]', '$2y$13$8jEHpoT8e3OTVMg18c9.pOEeVSSbBEihXY8tzMa9hVcFUWHtwbhci', 'male', 'Diana', '62c64ea7c9ff7Diana_Splash_Centered_11.jpg', 'offline', NULL, NULL, NULL, NULL),
(24, 'seraphine123', '[\"ROLE_USER\"]', '$2y$13$oiW1eaFfY9Bp9DJphIChrOb5kfkiQvxCEl1iBzYDuYgXLCKGZHZk6', 'female', 'Sera', '62c651fec8b98seraphine_3_cvdy.jpg', 'offline', NULL, NULL, NULL, NULL),
(25, 'yasuo12345', '[\"ROLE_USER\"]', '$2y$13$NbXq20WD7GANd3El/qTlteHGhUd3Fw9Uxs68jjopMZ0brQWrZBDfi', 'male', 'Yasuo', '62c6523f37d7dYasuo_36.jpg', 'offline', NULL, NULL, NULL, NULL),
(26, 'ngobakha123', '[\"ROLE_USER\"]', '$2y$13$48vemVvIRD5EwzFA9QPJu.d2lphRCIwrls4URxGGHdSf/L/iTM4ZK', 'male', 'Kha\'Banh', '62c652fe8583fVi-sao-Kha-Banh-tro-thanh-hien-tuong-dinh-dam-tren-mang-xa-hoi-khabanh-1554192528-width660height597.jpg', 'offline', NULL, NULL, NULL, NULL),
(27, 'huanhoahong123', '[\"ROLE_USER\"]', '$2y$13$35mky6tykpYwPGtefP.TTuoCJnM3oZ7.ayC8HZxLG/W5EhwAElrmG', 'male', 'Rose Teacher', '62c65487f08c9toan-bo-loi-ran-day-cua-huan-hoa-hong-huan-rose.jpg', 'offline', NULL, NULL, NULL, NULL),
(28, 'tienbip12345', '[\"ROLE_USER\"]', '$2y$13$R94VHblbNtkvHfAQqutAvONHcOZAyJGf4BliG.An.ssmMZWMxCJKG', 'male', 'Tien _BIP_', '62c656731285ctien-bip-la-ai-2.jpg', 'offline', NULL, NULL, NULL, NULL),
(29, 'tranducbo1234', '[\"ROLE_USER\"]', '$2y$13$KdJVSw2NWT.wLbRLbiVnfevf7PNeRb1vltyFNfETuND0kJCfksvTq', 'female', 'Mew', '62c658884fb2c010251_100357_3.jpg', 'offline', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526CA76ED395` (`user_id`),
  ADD KEY `IDX_9474526C4B89032C` (`post_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DB021E96A76ED395` (`user_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BF5476CAF624B39D` (`sender_id`),
  ADD KEY `IDX_BF5476CACD53EDB6` (`receiver_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5A8A6C8DA76ED395` (`user_id`);

--
-- Indexes for table `reaction`
--
ALTER TABLE `reaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A4D707F7A76ED395` (`user_id`),
  ADD KEY `IDX_A4D707F74B89032C` (`post_id`);

--
-- Indexes for table `relationship`
--
ALTER TABLE `relationship`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_200444A0A76ED395` (`user_id`),
  ADD KEY `IDX_200444A06A5458E8` (`friend_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C42F7784FB466E4A` (`user_send_report_id`),
  ADD KEY `IDX_C42F77843DA62723` (`user_reported_id`),
  ADD KEY `IDX_C42F77844B89032C` (`post_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `reaction`
--
ALTER TABLE `reaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `relationship`
--
ALTER TABLE `relationship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C4B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `FK_DB021E96A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `FK_BF5476CACD53EDB6` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_BF5476CAF624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `reaction`
--
ALTER TABLE `reaction`
  ADD CONSTRAINT `FK_A4D707F74B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_A4D707F7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `relationship`
--
ALTER TABLE `relationship`
  ADD CONSTRAINT `FK_200444A06A5458E8` FOREIGN KEY (`friend_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_200444A0A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `FK_C42F77843DA62723` FOREIGN KEY (`user_reported_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_C42F77844B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_C42F7784FB466E4A` FOREIGN KEY (`user_send_report_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
