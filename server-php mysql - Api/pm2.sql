-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2023 at 05:07 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pm2`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id` int(10) NOT NULL,
  `super_users_id` int(10) DEFAULT NULL,
  `business_id` int(10) DEFAULT NULL,
  `location_id` int(10) DEFAULT NULL,
  `area_name` varchar(64) DEFAULT NULL,
  `color_code` varchar(64) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `super_users_id`, `business_id`, `location_id`, `area_name`, `color_code`, `created_at`, `updated_at`) VALUES
(28, 1, 9, 8, 'a', NULL, NULL, NULL),
(29, 1, 9, 8, 'b', '', NULL, NULL),
(30, 1, 9, 9, 'c', NULL, NULL, NULL),
(31, 1, 9, 9, 'd', '', NULL, NULL),
(32, 79, 10, 11, 'aa', '#74c93b', NULL, NULL),
(33, 79, 10, 11, 'asss', '#692121', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `id` int(10) NOT NULL,
  `super_users_id` int(10) DEFAULT NULL,
  `business_name` varchar(64) DEFAULT NULL,
  `time_zone` varchar(64) DEFAULT NULL,
  `address` varchar(127) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`id`, `super_users_id`, `business_name`, `time_zone`, `address`, `created_at`, `updated_at`) VALUES
(8, 1, 'ABC', 'Europe/Andorra', 'ABC', '2023-02-28 09:38:21', NULL),
(9, 1, 'ABC2', 'Asia/Kabul', 'ABC2', '2023-02-28 09:38:33', NULL),
(10, 79, 'B1', 'Europe/Andorra', 'Adr1', '2023-03-10 04:27:32', '2023-03-10 04:35:00'),
(11, 79, 'B2', 'Europe/Tirane', 'Adr2', '2023-03-10 04:27:48', NULL),
(12, 79, 'B3', 'Asia/Kabul', 'Adr3', '2023-03-10 04:28:20', NULL),
(13, 6, 'ddddddd', 'Asia/Kabul', 'C-20,JAkir Hossain Road,Block-E, Md-pur', '2023-04-01 08:16:12', NULL),
(14, 79, 'abc', 'Asia/Dubai', 'test', '2023-04-03 08:20:12', NULL),
(15, 81, '6566', 'Asia/Dubai', '6565', '2023-04-17 22:35:07', NULL),
(16, 84, 'ddddddd', 'Europe/Andorra', 'C-20,JAkir Hossain Road,Block-E, Md-pur', '2023-04-28 19:57:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(127) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `country` varchar(127) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `state` varchar(64) DEFAULT NULL,
  `zip` varchar(64) DEFAULT NULL,
  `file_company_logo` varchar(256) DEFAULT NULL,
  `file_report_logo` varchar(256) DEFAULT NULL,
  `file_report_background` varchar(256) DEFAULT NULL,
  `report_footer` varchar(256) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `address`, `country`, `city`, `state`, `zip`, `file_company_logo`, `file_report_logo`, `file_report_background`, `report_footer`) VALUES
(1, 'Pata Corporation', 'C-20,JAkir Hossain Road,Block-E, Md-pur', 'US', 'PArk', 'NY', '1212', NULL, NULL, NULL, 'footer content XXXXXXXXX XXXXXXX');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `country` varchar(200) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `country`) VALUES
(1, 'Afghanistan'),
(2, 'Åland Islands'),
(3, 'Albania'),
(4, 'Algeria'),
(5, 'American Samoa'),
(6, 'Andorra'),
(7, 'Angola'),
(8, 'Anguilla'),
(9, 'Antarctica'),
(10, 'Antigua and Barbuda'),
(11, 'Argentina'),
(12, 'Armenia'),
(13, 'Aruba'),
(14, 'Australia'),
(15, 'Austria'),
(16, 'Azerbaijan'),
(17, 'Bahamas'),
(18, 'Bahrain'),
(19, 'Bangladesh'),
(20, 'Barbados'),
(21, 'Belarus'),
(22, 'Belgium'),
(23, 'Belize'),
(24, 'Benin'),
(25, 'Bermuda'),
(26, 'Bhutan'),
(27, 'Bolivia'),
(28, 'Bosnia and Herzegovina'),
(29, 'Botswana'),
(30, 'Bouvet Island'),
(31, 'Brazil'),
(32, 'British Indian Ocean Territory'),
(33, 'Brunei Darussalam'),
(34, 'Bulgaria'),
(35, 'Burkina Faso'),
(36, 'Burundi'),
(37, 'Cambodia'),
(38, 'Cameroon'),
(39, 'Canada'),
(40, 'Cape Verde'),
(41, 'Cayman Islands'),
(42, 'Central African Republic'),
(43, 'Chad'),
(44, 'Chile'),
(45, 'China'),
(46, 'Christmas Island'),
(47, 'Cocos (Keeling) Islands'),
(48, 'Colombia'),
(49, 'Comoros'),
(50, 'Congo'),
(51, 'Congo, The Democratic Republic of the'),
(52, 'Cook Islands'),
(53, 'Costa Rica'),
(54, 'Côte D\'Ivoire'),
(55, 'Croatia'),
(56, 'Cuba'),
(57, 'Cyprus'),
(58, 'Czech Republic'),
(59, 'Denmark'),
(60, 'Djibouti'),
(61, 'Dominica'),
(62, 'Dominican Republic'),
(63, 'Ecuador'),
(64, 'Egypt'),
(65, 'El Salvador'),
(66, 'Equatorial Guinea'),
(67, 'Eritrea'),
(68, 'Estonia'),
(69, 'Ethiopia'),
(70, 'Falkland Islands (Malvinas)'),
(71, 'Faroe Islands'),
(72, 'Fiji'),
(73, 'Finland'),
(74, 'France'),
(75, 'French Guiana'),
(76, 'French Polynesia'),
(77, 'French Southern Territories'),
(78, 'Gabon'),
(79, 'Gambia'),
(80, 'Georgia'),
(81, 'Germany'),
(82, 'Ghana'),
(83, 'Gibraltar'),
(84, 'Greece'),
(85, 'Greenland'),
(86, 'Grenada'),
(87, 'Guadeloupe'),
(88, 'Guam'),
(89, 'Guatemala'),
(90, 'Guernsey'),
(91, 'Guinea'),
(92, 'Guinea-Bissau'),
(93, 'Guyana'),
(94, 'Haiti'),
(95, 'Heard Island and McDonald Islands'),
(96, 'Holy See (Vatican City State)'),
(97, 'Honduras'),
(98, 'Hong Kong'),
(99, 'Hungary'),
(100, 'Iceland'),
(101, 'India'),
(102, 'Indonesia'),
(103, 'Iran, Islamic Republic of'),
(104, 'Iraq'),
(105, 'Ireland'),
(106, 'Isle of Man'),
(107, 'Israel'),
(108, 'Italy'),
(109, 'Jamaica'),
(110, 'Japan'),
(111, 'Jersey'),
(112, 'Jordan'),
(113, 'Kazakhstan'),
(114, 'Kenya'),
(115, 'Kiribati'),
(116, 'Korea, Democratic People\'s Republic of'),
(117, 'Korea, Republic of'),
(118, 'Kuwait'),
(119, 'Kyrgyzstan'),
(120, 'Lao People\'s Democratic Republic'),
(121, 'Latvia'),
(122, 'Lebanon'),
(123, 'Lesotho'),
(124, 'Liberia'),
(125, 'Libyan Arab Jamahiriya'),
(126, 'Liechtenstein'),
(127, 'Lithuania'),
(128, 'Luxembourg'),
(129, 'Macao'),
(130, 'Macedonia, The Former Yugoslav Republic of'),
(131, 'Madagascar'),
(132, 'Malawi'),
(133, 'Malaysia'),
(134, 'Maldives'),
(135, 'Mali'),
(136, 'Malta'),
(137, 'Marshall Islands'),
(138, 'Martinique'),
(139, 'Mauritania'),
(140, 'Mauritius'),
(141, 'Mayotte'),
(142, 'Mexico'),
(143, 'Micronesia, Federated States of'),
(144, 'Moldova, Republic of'),
(145, 'Monaco'),
(146, 'Mongolia'),
(147, 'Montenegro'),
(148, 'Montserrat'),
(149, 'Morocco'),
(150, 'Mozambique'),
(151, 'Myanmar'),
(152, 'Namibia'),
(153, 'Nauru'),
(154, 'Nepal'),
(155, 'Netherlands'),
(156, 'Netherlands Antilles'),
(157, 'New Caledonia'),
(158, 'New Zealand'),
(159, 'Nicaragua'),
(160, 'Niger'),
(161, 'Nigeria'),
(162, 'Niue'),
(163, 'Norfolk Island'),
(164, 'Northern Mariana Islands'),
(165, 'Norway'),
(166, 'Oman'),
(167, 'Pakistan'),
(168, 'Palau'),
(169, 'Palestinian Territory, Occupied'),
(170, 'Panama'),
(171, 'Papua New Guinea'),
(172, 'Paraguay'),
(173, 'Peru'),
(174, 'Philippines'),
(175, 'Pitcairn'),
(176, 'Poland'),
(177, 'Portugal'),
(178, 'Puerto Rico'),
(179, 'Qatar'),
(180, 'Reunion'),
(181, 'Romania'),
(182, 'Russian Federation'),
(183, 'Rwanda'),
(184, 'Saint Barthélemy'),
(185, 'Saint Helena'),
(186, 'Saint Kitts and Nevis'),
(187, 'Saint Lucia'),
(188, 'Saint Martin'),
(189, 'Saint Pierre and Miquelon'),
(190, 'Saint Vincent and the Grenadines'),
(191, 'Samoa'),
(192, 'San Marino'),
(193, 'Sao Tome and Principe'),
(194, 'Saudi Arabia'),
(195, 'Senegal'),
(196, 'Serbia'),
(197, 'Seychelles'),
(198, 'Sierra Leone'),
(199, 'Singapore'),
(200, 'Slovakia'),
(201, 'Slovenia'),
(202, 'Solomon Islands'),
(203, 'Somalia'),
(204, 'South Africa'),
(205, 'South Georgia and the South Sandwich Islands'),
(206, 'Spain'),
(207, 'Sri Lanka'),
(208, 'Sudan'),
(209, 'Suriname'),
(210, 'Svalbard and Jan Mayen'),
(211, 'Swaziland'),
(212, 'Sweden'),
(213, 'Switzerland'),
(214, 'Syrian Arab Republic'),
(215, 'Taiwan, Province Of China'),
(216, 'Tajikistan'),
(217, 'Tanzania, United Republic of'),
(218, 'Thailand'),
(219, 'Timor-Leste'),
(220, 'Togo'),
(221, 'Tokelau'),
(222, 'Tonga'),
(223, 'Trinidad and Tobago'),
(224, 'Tunisia'),
(225, 'Turkey'),
(226, 'Turkmenistan'),
(227, 'Turks and Caicos Islands'),
(228, 'Tuvalu'),
(229, 'Uganda'),
(230, 'Ukraine'),
(231, 'United Arab Emirates'),
(232, 'United Kingdom'),
(233, 'United States'),
(234, 'United States Minor Outlying Islands'),
(235, 'Uruguay'),
(236, 'Uzbekistan'),
(237, 'Vanuatu'),
(238, 'Venezuela'),
(239, 'Viet Nam'),
(240, 'Virgin Islands, British'),
(241, 'Virgin Islands, U.S.'),
(242, 'Wallis And Futuna'),
(243, 'Western Sahara'),
(244, 'Yemen'),
(245, 'Zambia'),
(246, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `super_users_id` int(10) DEFAULT NULL,
  `business_id` int(10) DEFAULT NULL,
  `location_name` varchar(127) DEFAULT NULL,
  `location_code` varchar(64) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `timezone` varchar(64) DEFAULT NULL,
  `week_start` varchar(64) DEFAULT NULL,
  `ROSTER_DEFAULT_SHIFT_LEN` varchar(64) DEFAULT NULL,
  `DEFAULT_MEALBREAK_DURATION` varchar(64) DEFAULT NULL,
  `monday` varchar(64) DEFAULT NULL,
  `monday_from` varchar(64) DEFAULT NULL,
  `monday_to` varchar(64) DEFAULT NULL,
  `tuesday` varchar(64) DEFAULT NULL,
  `tuesday_from` varchar(64) DEFAULT NULL,
  `tuesday_to` varchar(64) DEFAULT NULL,
  `wednesday` varchar(64) DEFAULT NULL,
  `wednesday_from` varchar(64) DEFAULT NULL,
  `wednesday_to` varchar(64) DEFAULT NULL,
  `thursday` varchar(64) DEFAULT NULL,
  `thursday_from` varchar(64) DEFAULT NULL,
  `thursday_to` varchar(64) DEFAULT NULL,
  `friday` varchar(64) DEFAULT NULL,
  `friday_from` varchar(64) DEFAULT NULL,
  `friday_to` varchar(64) DEFAULT NULL,
  `saturday` varchar(64) DEFAULT NULL,
  `saturday_from` varchar(64) DEFAULT NULL,
  `saturday_to` varchar(64) DEFAULT NULL,
  `sunday` varchar(64) DEFAULT NULL,
  `sunday_from` varchar(64) DEFAULT NULL,
  `sunday_to` varchar(64) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `super_users_id`, `business_id`, `location_name`, `location_code`, `address`, `timezone`, `week_start`, `ROSTER_DEFAULT_SHIFT_LEN`, `DEFAULT_MEALBREAK_DURATION`, `monday`, `monday_from`, `monday_to`, `tuesday`, `tuesday_from`, `tuesday_to`, `wednesday`, `wednesday_from`, `wednesday_to`, `thursday`, `thursday_from`, `thursday_to`, `friday`, `friday_from`, `friday_to`, `saturday`, `saturday_from`, `saturday_to`, `sunday`, `sunday_from`, `sunday_to`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'abc', '100', 'C-20,JAkir Hossain Road,Block-E, Md-pur', 'Europe/Andorra', 'Tue', '8', '30', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(2, 1, 2, '5656', '65656', '6565', 'Asia/Dubai', 'Wed', '6', '45', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(3, 6, 3, 'abc', '100', 'C-20,JAkir Hossain Road,Block-E, Md-pur', 'Asia/Kabul', 'Tue', '8', '75', '', '12:30', '12:30', '', '12:00', '12:15', '', '12:15', '12:30', '', '12:15', '', '', '12:15', '12:15', '', '1:15', '', '', '', '', '', NULL, NULL),
(4, 6, 4, 'abc', '100', 'C-20,JAkir Hossain Road,Block-E, Md-pur', 'Europe/Andorra', 'Tue', '8', '60', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(5, 8, 6, '555', '55', '55', 'Asia/Kabul', NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(6, 6, 5, 'Fisheries', '100', '52 Strode Road', 'Europe/London', 'Mon', '8', '15', '1', '', '', '1', '', '', '1', '', '', '1', '', '', '1', '', '', '1', '', '', '1', '', '', '', NULL, NULL),
(7, 6, 5, 'Paper Tite Ltd', '034', '32 Peel Avenue, N1 5TH', 'Europe/Andorra', 'Mon', '8', '30', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Operating Hours can not be set up because times are \"12am to 2pm\"  only, please fix', NULL, NULL),
(8, 1, 9, 'abc', 'abc', 'C-20,JAkir Hossain Road,Block-E, Md-pur', 'Europe/Andorra', NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(9, 1, 9, 'def', '100', 'C-20,JAkir Hossain Road,Block-E, Md-pur', 'Asia/Kabul', NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(10, 1, 8, 'AbcLoc', '100', '100', 'Europe/Andorra', NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(11, 79, 10, 'abc', '100', 'C-20,JAkir Hossain Road,Block-E, Md-pur', 'Europe/Andorra', 'Mon', '44', '45', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(10) NOT NULL,
  `creator_users_id` int(10) DEFAULT NULL,
  `business_id` int(10) DEFAULT NULL,
  `contents` text DEFAULT NULL,
  `file_news` varchar(256) DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `user_type` varchar(64) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `creator_users_id`, `business_id`, `contents`, `file_news`, `keywords`, `user_type`, `created_at`, `updated_at`) VALUES
(10, 79, 10, 'dfdf  sdsdsd', NULL, 'All,vv,B1,abc', '', '2023-03-25 06:35:05', NULL),
(11, 79, 10, 'dfdfdf', 'http://localhost/pm/public/uploads/images/news/1679726206Untitled.png', 'All,vv,B2', '', '2023-03-25 06:36:46', NULL),
(12, 79, 10, 'dd ttt tttt', '', 'All,vv,abc,B1', 'System Administrator', '2023-03-25 08:51:06', NULL),
(13, 80, 10, 'ere reererer', 'http://localhost/pm/public/uploads/images/news/1679726206Untitled.png', 'vv', 'Employee', '2023-03-25 10:31:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(10) NOT NULL,
  `business_id` int(10) DEFAULT NULL,
  `super_users_id` int(10) DEFAULT NULL,
  `assign_to_users_id` int(10) DEFAULT NULL,
  `location_id` int(10) DEFAULT NULL,
  `project_title` varchar(127) DEFAULT NULL,
  `project_description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `priority` enum('Low','High','Medium') DEFAULT NULL,
  `project_status` enum('incomplete','completed','canceled','paused','In-Progress','Not Started') DEFAULT NULL,
  `file_project` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `business_id`, `super_users_id`, `assign_to_users_id`, `location_id`, `project_title`, `project_description`, `due_date`, `notes`, `priority`, `project_status`, `file_project`, `created_at`, `updated_at`) VALUES
(13, 5, 6, 19, 12, 'ghggh', 'ghghg', '2022-08-26', NULL, 'High', 'completed', NULL, '2022-08-20 15:01:26', NULL),
(14, 5, 6, 20, 12, 'Prepare the Exit List for leavers', '5 leavers at end of September prepare documents', '2022-08-19', NULL, 'Medium', 'incomplete', NULL, '2022-08-21 09:34:31', NULL),
(17, 5, 6, 21, 13, 'A', 'jhj', '2022-08-18', NULL, 'High', 'canceled', 'https://kinstaff.com/pms/public/uploads/images/projects/1661534806tin.jpg', '2022-08-26 18:26:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(10) NOT NULL,
  `super_users_id` int(10) DEFAULT NULL,
  `worker_users_id` int(10) DEFAULT NULL,
  `business_id` int(10) DEFAULT NULL,
  `location_id` int(10) DEFAULT NULL,
  `area_id` int(10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start` varchar(127) DEFAULT NULL,
  `finish` varchar(127) DEFAULT NULL,
  `meal_break` varchar(127) DEFAULT NULL,
  `rest_break` varchar(127) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `publish_type` varchar(20) DEFAULT NULL,
  `status` enum('incomplete','completed','canceled','paused') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `super_users_id`, `worker_users_id`, `business_id`, `location_id`, `area_id`, `start_date`, `end_date`, `start`, `finish`, `meal_break`, `rest_break`, `notes`, `publish_type`, `status`, `created_at`, `updated_at`) VALUES
(17, 1, 69, 9, 8, 30, '2023-03-08', '2023-03-08', '09:00', '17:00', '15', '15', NULL, '1', NULL, '2023-03-08 07:33:52', NULL),
(18, 1, 70, 9, 8, 29, '2023-03-09', '2023-03-09', '09:00', '17:00', '15', '15', NULL, '1', NULL, '2023-03-08 07:33:59', NULL),
(19, 1, 76, 9, 8, 29, '2023-03-10', '2023-03-10', '09:00', '17:00', '15', '15', NULL, '1', NULL, '2023-03-08 08:09:01', NULL),
(20, 79, 79, 10, 11, 32, '2023-03-21', '2023-03-21', '09:00', '17:00', '15', '15', '5656', '1', NULL, '2023-03-21 05:13:11', NULL),
(21, 79, 79, 10, 11, 33, '2023-03-22', '2023-03-22', '09:00', '17:00', '15', '15', '5656', '1', NULL, '2023-03-21 05:13:18', NULL),
(22, 79, 80, 10, 11, 33, '2023-04-03', '2023-04-03', '09:00', '17:00', '15', '15', NULL, '1', NULL, '2023-04-03 08:21:53', NULL),
(23, 79, 80, 10, 11, 32, '2023-04-05', '2023-04-05', '09:00', '17:00', '15', '15', NULL, '1', NULL, '2023-04-03 08:22:06', NULL),
(24, 79, 80, 10, 11, 32, '2023-04-06', '2023-04-06', '09:00', '17:00', '15', '15', NULL, '1', NULL, '2023-04-03 08:22:13', NULL),
(25, 79, 80, 10, 11, 32, '2023-04-07', '2023-04-07', '09:00', '17:00', '15', '15', NULL, '1', NULL, '2023-04-03 08:22:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_break_details`
--

CREATE TABLE `schedule_break_details` (
  `id` int(10) NOT NULL,
  `schedule_id` int(10) DEFAULT NULL,
  `type` varchar(127) DEFAULT NULL,
  `duration` varchar(127) DEFAULT NULL,
  `start` varchar(127) DEFAULT NULL,
  `finish` varchar(127) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(10) NOT NULL,
  `assign_by_users_id` int(10) DEFAULT NULL,
  `assign_to_users_id` int(10) DEFAULT NULL,
  `task_title` varchar(127) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('incomplete','completed','canceled','paused') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `email` varchar(127) NOT NULL,
  `password` varchar(127) NOT NULL,
  `title` varchar(127) DEFAULT NULL,
  `first_name` varchar(127) DEFAULT NULL,
  `last_name` varchar(127) DEFAULT NULL,
  `file_picture` varchar(256) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `Payroll_ID` varchar(64) DEFAULT NULL,
  `main_location_id` int(10) DEFAULT NULL,
  `main_location` varchar(127) DEFAULT NULL,
  `address` varchar(127) DEFAULT NULL,
  `city` varchar(127) DEFAULT NULL,
  `state` varchar(127) DEFAULT NULL,
  `zip` varchar(127) DEFAULT NULL,
  `gender` varchar(64) DEFAULT NULL,
  `country_id` varchar(127) DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_type` enum('System Administrator','Supervisor','Employee','Location Manager') NOT NULL,
  `inventory_status` enum('live','archive') DEFAULT 'live',
  `visiblity` int(10) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `title`, `first_name`, `last_name`, `file_picture`, `phone_no`, `dob`, `Payroll_ID`, `main_location_id`, `main_location`, `address`, `city`, `state`, `zip`, `gender`, `country_id`, `country`, `created_at`, `updated_at`, `user_type`, `inventory_status`, `visiblity`, `status`) VALUES
(75, 'amir66rucst@gmail.com', '74986', '', '55656', '56565', NULL, '655', NULL, NULL, 8, 'abc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-08 08:06:51', NULL, 'Employee', 'live', NULL, 'active'),
(76, 'ggfgg@dfdf.com', '99726', '', 'ggg', 'gg', NULL, '666', NULL, NULL, 8, 'abc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-08 08:08:19', NULL, 'Employee', 'live', NULL, 'active'),
(77, 'ggfgg@dggfdf.com', '59510', '', 'gg', 'gg', NULL, '666', NULL, NULL, 8, 'abc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-08 08:08:28', NULL, 'Employee', 'live', NULL, 'active'),
(78, 'ggfgg@dggggfdf.com', '87106', '', 'gg', 'gg', NULL, '666', NULL, NULL, 8, 'abc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-08 08:08:28', NULL, 'Employee', 'live', NULL, 'active'),
(79, 'amirrucst@gmail.com', '123', '', 'vv', 'vv', 'http://localhost/pm/public/uploads/images/users/1679375574Untitled.png', '', '2023-04-22', NULL, NULL, NULL, '', '', NULL, '', '', NULL, '', NULL, '2023-04-28 12:51:58', 'System Administrator', 'live', NULL, ''),
(80, 'amirrucst11@gmail.com', '49908', '', 'abc', 'abc', 'http://localhost/pm/public/uploads/images/users/1679375834Untitled.png', '123', '2023-04-14', NULL, 11, 'abc', '', '', NULL, '', '', NULL, '', '2023-03-21 05:15:49', '2023-04-28 19:15:41', 'Employee', 'live', NULL, 'active'),
(81, 'gfgfg@gfgfg.com', '545454', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-17 22:32:10', NULL, 'System Administrator', 'live', NULL, 'active'),
(82, '', '', NULL, 'OpenShift', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Employee', 'live', -1, 'active'),
(83, '', '', NULL, 'EmptyShift', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Employee', 'live', -1, 'active'),
(84, 'trrrt@erere.com', '5656565', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-17 22:36:28', NULL, 'System Administrator', 'live', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users_leave`
--

CREATE TABLE `users_leave` (
  `id` int(10) NOT NULL,
  `users_pay_details_id` int(10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `leave_type` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_leave`
--

INSERT INTO `users_leave` (`id`, `users_pay_details_id`, `start_date`, `end_date`, `leave_type`) VALUES
(1, 4, '2023-03-24', '2023-03-25', 'Annual Leave (Vacation)'),
(9, 5, '2023-05-04', '2023-05-11', 'Sick (Personal/Carer\'s) Leave'),
(16, 0, '0000-00-00', '0000-00-00', ''),
(17, 0, '0000-00-00', '0000-00-00', ''),
(18, 0, '0000-00-00', '0000-00-00', ''),
(19, 0, '0000-00-00', '0000-00-00', ''),
(20, 0, '0000-00-00', '0000-00-00', ''),
(21, 5, '2023-05-10', '2023-05-11', 'Sick (Personal/Carer\'s) Leave'),
(22, 5, '2023-05-04', '2023-05-11', 'Sick (Personal/Carer\'s) Leave');

-- --------------------------------------------------------

--
-- Table structure for table `users_leave_apply`
--

CREATE TABLE `users_leave_apply` (
  `id` int(10) NOT NULL,
  `users_id` int(10) DEFAULT NULL,
  `users_pay_details_id` int(10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `leave_type` varchar(64) DEFAULT NULL,
  `status` enum('accept','reject','pending') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_leave_apply`
--

INSERT INTO `users_leave_apply` (`id`, `users_id`, `users_pay_details_id`, `start_date`, `end_date`, `leave_type`, `status`) VALUES
(10, 80, 5, '2023-05-04', '2023-05-11', 'Sick (Personal/Carer\'s) Leave', 'accept'),
(11, 80, 5, '2023-05-10', '2023-05-11', 'Sick (Personal/Carer\'s) Leave', 'reject');

-- --------------------------------------------------------

--
-- Table structure for table `users_location`
--

CREATE TABLE `users_location` (
  `id` int(10) NOT NULL,
  `users_id` int(10) DEFAULT NULL,
  `business_id` int(10) DEFAULT NULL,
  `location_id` int(10) DEFAULT NULL,
  `location_name` varchar(64) DEFAULT NULL,
  `main` enum('yes','no') DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_location`
--

INSERT INTO `users_location` (`id`, `users_id`, `business_id`, `location_id`, `location_name`, `main`, `status`, `created_at`, `updated_at`) VALUES
(31, 73, 9, 8, 'abc', 'yes', 'active', NULL, '2023-03-08 08:06:51'),
(32, 74, 9, 8, 'abc', 'yes', 'active', NULL, '2023-03-08 08:06:51'),
(33, 75, 9, 8, 'abc', 'yes', 'active', '2023-03-08 08:06:59', NULL),
(34, 76, 9, 8, 'abc', 'yes', 'active', '2023-03-08 08:08:27', NULL),
(35, 77, 9, 8, 'abc', 'yes', 'active', '2023-03-08 08:08:28', NULL),
(36, 78, 9, 8, 'abc', 'yes', 'active', '2023-03-08 08:08:28', NULL),
(37, 73, 10, 11, 'abc', 'yes', 'active', NULL, '2023-03-10 04:32:46'),
(38, 74, 10, 11, 'abc', 'yes', 'active', NULL, '2023-03-10 04:32:46'),
(39, 79, 10, 11, 'abc', 'yes', 'active', '2023-03-10 04:32:46', NULL),
(40, 80, 10, 11, 'abc', 'yes', 'active', '2023-03-21 05:15:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_pay_details`
--

CREATE TABLE `users_pay_details` (
  `id` int(10) NOT NULL,
  `super_users_id` int(10) DEFAULT NULL,
  `users_id` int(10) DEFAULT NULL,
  `business_id` int(10) DEFAULT NULL,
  `Payroll_ID` int(10) DEFAULT NULL,
  `access_level` varchar(64) DEFAULT NULL,
  `employee_start_date` date DEFAULT NULL,
  `stress_profile` varchar(127) DEFAULT NULL,
  `employeement_type` varchar(64) DEFAULT NULL,
  `pay_rate_type` varchar(64) DEFAULT NULL,
  `salary_type` varchar(64) DEFAULT NULL,
  `salary_amount` decimal(10,2) DEFAULT NULL,
  `weekday_rate` decimal(10,2) DEFAULT NULL,
  `public_holiday_rate` decimal(10,2) DEFAULT NULL,
  `saterday_rate` decimal(10,2) DEFAULT NULL,
  `sunday_rate` decimal(10,2) DEFAULT NULL,
  `monday_rate` decimal(10,2) DEFAULT NULL,
  `tuesday_rate` decimal(10,2) DEFAULT NULL,
  `wednesday_rate` decimal(10,2) DEFAULT NULL,
  `thrusday_rate` decimal(10,2) DEFAULT NULL,
  `friday_rate` decimal(10,2) DEFAULT NULL,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `overtime_rate` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_pay_details`
--

INSERT INTO `users_pay_details` (`id`, `super_users_id`, `users_id`, `business_id`, `Payroll_ID`, `access_level`, `employee_start_date`, `stress_profile`, `employeement_type`, `pay_rate_type`, `salary_type`, `salary_amount`, `weekday_rate`, `public_holiday_rate`, `saterday_rate`, `sunday_rate`, `monday_rate`, `tuesday_rate`, `wednesday_rate`, `thrusday_rate`, `friday_rate`, `hourly_rate`, `overtime_rate`) VALUES
(4, 79, 79, 10, 65656, 'Supervisor', '2023-03-16', 'CA overtime  40hrs per week,8 hrs per days,max 6 days per week', 'Full time', 'Salary', 'Monthly', '66.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '66.00'),
(5, 79, 80, 10, 11, 'Employee', '2023-03-17', 'CA overtime  40hrs per week,8 hrs per days,max 6 days per week', 'Full time', 'Hourly', '', '0.00', '11.00', '11.00', '11.00', '11.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '11.00');

-- --------------------------------------------------------

--
-- Table structure for table `users_training`
--

CREATE TABLE `users_training` (
  `id` int(10) NOT NULL,
  `users_pay_details_id` int(10) DEFAULT NULL,
  `training_type` varchar(64) DEFAULT NULL,
  `renewal_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_training`
--

INSERT INTO `users_training` (`id`, `users_pay_details_id`, `training_type`, `renewal_date`, `notes`) VALUES
(1, 4, 'Employee Training', '2023-03-25', '5656');

-- --------------------------------------------------------

--
-- Table structure for table `users_unavailability`
--

CREATE TABLE `users_unavailability` (
  `id` int(10) NOT NULL,
  `users_pay_details_id` int(10) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `start_time` varchar(64) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` varchar(64) DEFAULT NULL,
  `repeat_type` varchar(64) DEFAULT NULL,
  `Mon` varchar(64) DEFAULT NULL,
  `Tue` varchar(64) DEFAULT NULL,
  `Wed` varchar(64) DEFAULT NULL,
  `Thu` varchar(64) DEFAULT NULL,
  `Fri` varchar(64) DEFAULT NULL,
  `Sat` varchar(64) DEFAULT NULL,
  `Sun` varchar(64) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_unavailability`
--

INSERT INTO `users_unavailability` (`id`, `users_pay_details_id`, `start_date`, `start_time`, `end_date`, `end_time`, `repeat_type`, `Mon`, `Tue`, `Wed`, `Thu`, `Fri`, `Sat`, `Sun`, `notes`) VALUES
(1, 4, '2023-03-25', '12:00', '2023-03-26', '12:45', 'Do not repeat', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_works_at_location`
--

CREATE TABLE `users_works_at_location` (
  `id` int(10) NOT NULL,
  `users_pay_details_id` int(10) DEFAULT NULL,
  `super_users_id` int(10) DEFAULT NULL,
  `worker_users_id` int(10) DEFAULT NULL,
  `business_id` int(10) DEFAULT NULL,
  `location_id` int(10) DEFAULT NULL,
  `location_name` varchar(64) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_works_at_location`
--

INSERT INTO `users_works_at_location` (`id`, `users_pay_details_id`, `super_users_id`, `worker_users_id`, `business_id`, `location_id`, `location_name`, `created_at`, `updated_at`) VALUES
(10, 4, 79, 79, 10, 33, 'asss', '2023-03-21 05:11:57', NULL),
(11, 4, 79, 79, 10, 32, 'aa', '2023-03-21 05:11:57', NULL),
(12, 5, 79, 80, 10, 32, 'aa', '2023-03-21 05:16:25', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_break_details`
--
ALTER TABLE `schedule_break_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_leave`
--
ALTER TABLE `users_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_leave_apply`
--
ALTER TABLE `users_leave_apply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_location`
--
ALTER TABLE `users_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_pay_details`
--
ALTER TABLE `users_pay_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_training`
--
ALTER TABLE `users_training`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_unavailability`
--
ALTER TABLE `users_unavailability`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_works_at_location`
--
ALTER TABLE `users_works_at_location`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `schedule_break_details`
--
ALTER TABLE `schedule_break_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `users_leave`
--
ALTER TABLE `users_leave`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users_leave_apply`
--
ALTER TABLE `users_leave_apply`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users_location`
--
ALTER TABLE `users_location`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users_pay_details`
--
ALTER TABLE `users_pay_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_training`
--
ALTER TABLE `users_training`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_unavailability`
--
ALTER TABLE `users_unavailability`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_works_at_location`
--
ALTER TABLE `users_works_at_location`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
