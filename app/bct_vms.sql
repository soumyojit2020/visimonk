-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 06, 2018 at 06:10 AM
-- Server version: 5.6.39-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bct_vms`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` varchar(512) NOT NULL,
  `account_name` varchar(512) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `area_id` int(11) NOT NULL,
  `area_description` varchar(255) NOT NULL,
  `campus_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `floor_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `building_id` int(11) NOT NULL,
  `building_description` varchar(255) NOT NULL,
  `campus_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

CREATE TABLE `campus` (
  `campus_id` int(11) NOT NULL,
  `campus_description` varchar(255) NOT NULL,
  `account_id` varchar(512) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `floor`
--

CREATE TABLE `floor` (
  `floor_id` int(11) NOT NULL,
  `floor_description` varchar(255) NOT NULL,
  `building_id` int(11) NOT NULL,
  `campus_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_area`
--

CREATE TABLE `form_area` (
  `form_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_building`
--

CREATE TABLE `form_building` (
  `form_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_campus`
--

CREATE TABLE `form_campus` (
  `form_id` int(11) NOT NULL,
  `campus_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_floor`
--

CREATE TABLE `form_floor` (
  `form_id` int(11) NOT NULL,
  `floor_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_port`
--

CREATE TABLE `form_port` (
  `form_id` int(11) NOT NULL,
  `port_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_structure`
--

CREATE TABLE `form_structure` (
  `form_id` int(11) NOT NULL,
  `form_name` varchar(255) NOT NULL,
  `visitor_name` tinyint(1) NOT NULL DEFAULT '1',
  `gender` tinyint(1) NOT NULL DEFAULT '1',
  `visitor_type` tinyint(1) NOT NULL DEFAULT '1',
  `email` tinyint(1) NOT NULL DEFAULT '0',
  `phone` tinyint(1) NOT NULL DEFAULT '0',
  `id` tinyint(1) NOT NULL DEFAULT '0',
  `id_photo` tinyint(1) NOT NULL DEFAULT '0',
  `date` tinyint(1) NOT NULL DEFAULT '0',
  `time` tinyint(1) NOT NULL DEFAULT '0',
  `host_name` tinyint(1) NOT NULL DEFAULT '0',
  `host_email` tinyint(1) NOT NULL DEFAULT '0',
  `host_phone` tinyint(1) NOT NULL DEFAULT '0',
  `notes` tinyint(1) NOT NULL DEFAULT '0',
  `camera` tinyint(1) NOT NULL DEFAULT '0',
  `email_notification` varchar(255) NOT NULL,
  `sms_notification` varchar(255) NOT NULL,
  `account_id` varchar(512) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hq`
--

CREATE TABLE `hq` (
  `address_line_1` varchar(1024) DEFAULT NULL,
  `address_line_2` varchar(1024) DEFAULT NULL,
  `city` varchar(512) DEFAULT NULL,
  `state` varchar(512) DEFAULT NULL,
  `country` varchar(512) DEFAULT NULL,
  `pin_code` int(11) DEFAULT NULL,
  `email` varchar(512) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `account_id` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logo`
--

CREATE TABLE `logo` (
  `logo_path` varchar(1024) DEFAULT NULL,
  `account_id` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `permission_id` int(11) NOT NULL,
  `permission_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `port`
--

CREATE TABLE `port` (
  `port_id` int(11) NOT NULL,
  `port_description` varchar(255) NOT NULL,
  `campus_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `floor_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profile_image`
--

CREATE TABLE `profile_image` (
  `profile_image_path` varchar(1024) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_description` varchar(255) NOT NULL,
  `account_id` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `snapshot`
--

CREATE TABLE `snapshot` (
  `Id` int(11) NOT NULL,
  `Image` varchar(20000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(512) NOT NULL,
  `account_id` varchar(512) NOT NULL,
  `phone_number` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_status` enum('confirmed','pending') NOT NULL DEFAULT 'pending',
  `token_code` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_area`
--

CREATE TABLE `user_area` (
  `user_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_building`
--

CREATE TABLE `user_building` (
  `user_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_campus`
--

CREATE TABLE `user_campus` (
  `user_id` int(11) NOT NULL,
  `campus_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_floor`
--

CREATE TABLE `user_floor` (
  `user_id` int(11) NOT NULL,
  `floor_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_port`
--

CREATE TABLE `user_port` (
  `user_id` int(11) NOT NULL,
  `port_id` int(11) NOT NULL,
  `account_id` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `visitor_id` varchar(512) NOT NULL,
  `visitor_name` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `visitor_type` varchar(255) NOT NULL,
  `visitor_email` varchar(255) DEFAULT NULL,
  `visitor_phone` varchar(512) DEFAULT NULL,
  `id` varchar(255) DEFAULT NULL,
  `photo_id_path` varchar(512) DEFAULT NULL,
  `host_name` varchar(255) DEFAULT NULL,
  `host_email` varchar(255) DEFAULT NULL,
  `host_phone` varchar(255) DEFAULT NULL,
  `notes` varchar(512) DEFAULT NULL,
  `date_time_in` datetime DEFAULT NULL,
  `date_time_out` datetime DEFAULT NULL,
  `image_path` varchar(512) DEFAULT NULL,
  `visitor_otp` int(11) DEFAULT NULL,
  `visitor_otp_created` datetime DEFAULT NULL,
  `visitor_otp_expired` tinyint(1) DEFAULT NULL,
  `host_otp` int(11) DEFAULT NULL,
  `host_otp_created` datetime DEFAULT NULL,
  `host_otp_expired` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `form_id` int(11) DEFAULT NULL,
  `account_id` varchar(512) DEFAULT NULL,
  `location_level` varchar(128) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `account_id` (`account_id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`area_id`),
  ADD KEY `campus_id` (`campus_id`),
  ADD KEY `building_id` (`building_id`),
  ADD KEY `floor_id` (`floor_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`building_id`),
  ADD KEY `campus_id` (`campus_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `campus`
--
ALTER TABLE `campus`
  ADD PRIMARY KEY (`campus_id`),
  ADD KEY `campus_ibfk_1` (`account_id`);

--
-- Indexes for table `floor`
--
ALTER TABLE `floor`
  ADD PRIMARY KEY (`floor_id`),
  ADD KEY `building_id` (`building_id`),
  ADD KEY `campus_id` (`campus_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `form_area`
--
ALTER TABLE `form_area`
  ADD UNIQUE KEY `form_id` (`form_id`,`area_id`,`account_id`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `form_building`
--
ALTER TABLE `form_building`
  ADD UNIQUE KEY `form_id` (`form_id`,`building_id`,`account_id`),
  ADD KEY `building_id` (`building_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `form_campus`
--
ALTER TABLE `form_campus`
  ADD UNIQUE KEY `form_id` (`form_id`,`campus_id`,`account_id`),
  ADD KEY `campus_id` (`campus_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `form_floor`
--
ALTER TABLE `form_floor`
  ADD UNIQUE KEY `form_id` (`form_id`,`floor_id`,`account_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `form_floor_ibfk_2` (`floor_id`);

--
-- Indexes for table `form_port`
--
ALTER TABLE `form_port`
  ADD UNIQUE KEY `form_id` (`form_id`,`port_id`,`account_id`),
  ADD KEY `port_id` (`port_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `form_structure`
--
ALTER TABLE `form_structure`
  ADD PRIMARY KEY (`form_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `hq`
--
ALTER TABLE `hq`
  ADD UNIQUE KEY `account_id` (`account_id`);

--
-- Indexes for table `logo`
--
ALTER TABLE `logo`
  ADD UNIQUE KEY `account_id` (`account_id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `port`
--
ALTER TABLE `port`
  ADD PRIMARY KEY (`port_id`);

--
-- Indexes for table `profile_image`
--
ALTER TABLE `profile_image`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD UNIQUE KEY `role_id` (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `role-user_ibfk_1` (`user_id`),
  ADD KEY `role-user_ibfk_2` (`role_id`);

--
-- Indexes for table `snapshot`
--
ALTER TABLE `snapshot`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_ibfk_1` (`account_id`);

--
-- Indexes for table `user_area`
--
ALTER TABLE `user_area`
  ADD UNIQUE KEY `user_id` (`user_id`,`area_id`,`account_id`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `user_building`
--
ALTER TABLE `user_building`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `building_id` (`building_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `user_campus`
--
ALTER TABLE `user_campus`
  ADD UNIQUE KEY `user_id` (`user_id`,`campus_id`,`account_id`),
  ADD KEY `campus_id` (`campus_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `user_floor`
--
ALTER TABLE `user_floor`
  ADD UNIQUE KEY `user_id` (`user_id`,`floor_id`,`account_id`),
  ADD KEY `floor_id` (`floor_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `user_port`
--
ALTER TABLE `user_port`
  ADD UNIQUE KEY `user_id` (`user_id`,`port_id`,`account_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `port_id` (`port_id`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`visitor_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `form_id` (`form_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `building_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `campus`
--
ALTER TABLE `campus`
  MODIFY `campus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `floor`
--
ALTER TABLE `floor`
  MODIFY `floor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `form_structure`
--
ALTER TABLE `form_structure`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `port`
--
ALTER TABLE `port`
  MODIFY `port_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `snapshot`
--
ALTER TABLE `snapshot`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_ibfk_1` FOREIGN KEY (`campus_id`) REFERENCES `campus` (`campus_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `area_ibfk_2` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `area_ibfk_3` FOREIGN KEY (`floor_id`) REFERENCES `floor` (`floor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `area_ibfk_4` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `building`
--
ALTER TABLE `building`
  ADD CONSTRAINT `building_ibfk_1` FOREIGN KEY (`campus_id`) REFERENCES `campus` (`campus_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `building_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON UPDATE CASCADE;

--
-- Constraints for table `campus`
--
ALTER TABLE `campus`
  ADD CONSTRAINT `campus_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON UPDATE CASCADE;

--
-- Constraints for table `floor`
--
ALTER TABLE `floor`
  ADD CONSTRAINT `floor_ibfk_1` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `floor_ibfk_2` FOREIGN KEY (`campus_id`) REFERENCES `campus` (`campus_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `floor_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `form_area`
--
ALTER TABLE `form_area`
  ADD CONSTRAINT `form_area_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form_structure` (`form_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_area_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_area_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `form_building`
--
ALTER TABLE `form_building`
  ADD CONSTRAINT `form_building_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form_structure` (`form_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_building_ibfk_2` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_building_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `form_campus`
--
ALTER TABLE `form_campus`
  ADD CONSTRAINT `form_campus_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form_structure` (`form_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_campus_ibfk_2` FOREIGN KEY (`campus_id`) REFERENCES `campus` (`campus_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_campus_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `form_floor`
--
ALTER TABLE `form_floor`
  ADD CONSTRAINT `form_floor_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form_structure` (`form_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_floor_ibfk_2` FOREIGN KEY (`floor_id`) REFERENCES `floor` (`floor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_floor_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `form_port`
--
ALTER TABLE `form_port`
  ADD CONSTRAINT `form_port_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form_structure` (`form_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_port_ibfk_2` FOREIGN KEY (`port_id`) REFERENCES `port` (`port_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `form_port_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `form_structure`
--
ALTER TABLE `form_structure`
  ADD CONSTRAINT `form_structure_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`);

--
-- Constraints for table `hq`
--
ALTER TABLE `hq`
  ADD CONSTRAINT `hq_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `logo`
--
ALTER TABLE `logo`
  ADD CONSTRAINT `logo_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile_image`
--
ALTER TABLE `profile_image`
  ADD CONSTRAINT `profile_image_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON UPDATE CASCADE;

--
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`permission_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `role_permission_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_area`
--
ALTER TABLE `user_area`
  ADD CONSTRAINT `user_area_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_area_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_area_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_building`
--
ALTER TABLE `user_building`
  ADD CONSTRAINT `user_building_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_building_ibfk_2` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_building_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_campus`
--
ALTER TABLE `user_campus`
  ADD CONSTRAINT `user_campus_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_campus_ibfk_2` FOREIGN KEY (`campus_id`) REFERENCES `campus` (`campus_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_campus_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`);

--
-- Constraints for table `user_floor`
--
ALTER TABLE `user_floor`
  ADD CONSTRAINT `user_floor_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_floor_ibfk_2` FOREIGN KEY (`floor_id`) REFERENCES `floor` (`floor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_floor_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_port`
--
ALTER TABLE `user_port`
  ADD CONSTRAINT `user_port_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_port_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_port_ibfk_4` FOREIGN KEY (`port_id`) REFERENCES `port` (`port_id`);

--
-- Constraints for table `visitor`
--
ALTER TABLE `visitor`
  ADD CONSTRAINT `visitor_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visitor_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `form_structure` (`form_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
