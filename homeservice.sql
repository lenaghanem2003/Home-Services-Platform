-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 11 يوليو 2026 الساعة 23:06
-- إصدار الخادم: 5.7.44-log
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `homeservice`
--

-- --------------------------------------------------------

--
-- بنية الجدول `account`
--

CREATE TABLE `account` (
  `User_ID` int(11) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `User_Name` varchar(20) NOT NULL,
  `Role_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- إرجاع أو استيراد بيانات الجدول `account`
--

INSERT INTO `account` (`User_ID`, `Password`, `Email`, `User_Name`, `Role_ID`) VALUES
(6, '$2y$10$/eb3qLNfZF6JpvWvJddOf.W5mxefZyWP49tblf6mlxBxkxqS5mr/6', 'lena.ghanem2003@gmail.com', 'leena ghanem', 1),
(25, '$2y$10$n6orXr4o8nE8Veh2rcpN1eZTtpBnxQeNmetheZUgDVE6GZTvl6DN.', 'waseem.ghanem1990@gmail.com', 'Waseem ghanem', 2),
(49, '$2y$10$h2htbkHUbDlRy2OlPkQtVuRTY8Skf791p/SA8VB.IB2kxllWyiqLe', 'masa.ddaa123@gmail.com', 'masa badran', 2),
(51, '$2y$10$i0Z1wZ7jeS.HS91kHMDHqeXSasERhIK5eqCz57AIuCFNVHBwo88qa', 'masa.oepw123@gmail.com', 'masa badran', 2),
(57, '$2y$10$cYnunLnmwGHY4WeixGv3k.Voe58ggkVDPXd8XGMn0fnrwC1gPyk5i', 'lena.ghanem234@gmail.com', 'Leena ghanem', 3),
(61, '$2y$10$1CN9.Aihi/5xdbKvMmrwhuumE1jubgVNV44DR2v11T6JXKFRJqMze', 'marah.ghanem123@gmail.com', 'marah ghanem', 2),
(63, '$2y$10$1CNRzrJPLGhkn3O0cElOo.xgkhTJ2dKUjKeItc.tsfUNCmHYzfG0.', 'marah.ghanem12@gmail.com', 'marah ghanem', 2),
(64, '$2y$10$0j2ylDbJVQwGw1T6.JOgnOT1Q9HAFshPOBbNLMcemF5/D9Hby6IN.', 'maram.ahmad@gmail.com', 'maram ahmad', 2),
(65, '$2y$10$EflFeE.bfrJi9Ws6LM4v1OIvTW7jsM8/x0VqnzDziSWgk3EhwBUla', 'lama.ahmad123@gmail.com', 'lama ahmad', 2),
(66, '$2y$10$uKGYYLTEqPpiJEgIL1WxOOt4gVSZC9Vkr60ZbkFdvvL3bgTGkDl/y', 'samer.ghanem123@gmail.com', 'samer ghanem', 1),
(69, '$2y$10$QadHxpOF6uoNkRDd2Jnyn.lUHNI4MRb4Z2SbkTxcWnj9/kgJm8YwC', 'mohanad.ali123@gmail.com', 'mohanad ali', 2),
(70, '$2y$10$e3wTNOaEMNEQ5Z0moVnxTuXGHgiJylYWNHwHFBhedjG4OPjzU6PZK', 'mohanad.ahmad908@gmail.com', 'mohanad ahmad', 2),
(71, '$2y$10$uFvYyNqebBjbTjWV8USBb.AvcL2UOr/hsDdej58o3ghJz2Oie2Tc6', 'mela.ghanem123@gmail.com', 'mela ghanem', 2),
(73, '$2y$10$LLgf6vjMykbBbm7576S9meyQEdoGtKD.0sAM.KRD0DWI209n51Wuy', 'mela.ghanem12@gmail.com', 'mela ghanem', 2),
(75, '$2y$10$mRz7O7B2D2G6XpUeKkF3OubvX1B5Mh7q4T8gA/Wk9L6pYnZJeDGyC', 'admin@homeservice.com', 'Main_Admin', 3),
(76, '$2y$10$72QG4Eb6SneAE..QW8bRv.PgU4gO8wkChZ0OdN.3j2Pybw9DVaIHC', 'manal.ghanem123@gmail.com', 'manal ghanem', 2),
(77, '$2y$10$ZiOz/SZ/retSbu..W64MBO8oAC.fIwZZy5fwXMEgc/Nqo9qwHDR2G', 'misk.ghanem123@gmail.com', 'misk ghanem', 1),
(78, '$2y$10$CFh3JirykpsgK3PkHKgevuvGSLNcjMeMj8pmFCPVAilGdgUjRrdm2', 'Alaa.ghanem123@gmail.com', 'Alaa ghanem', 1),
(79, '$2y$10$0DielOoxp0KbSmJ0i8FP/OhAP0Nact0HrWGaHWsQt2t97Mp9gDO4q', 'ahmad.gh097@gmail.com', 'Ahmad ghanem', 1),
(80, '$2y$10$y4hZRLTgU9CNL1FblbfTCefQEqHQlfFjV1j3JNRXvNdYxDZaUgiIe', 'maram.ah2005@gmail.com', 'maram ahmad', 1),
(81, '$2y$10$rPk8UptQwxxdyL0OmPPeTO.wyT.S3pK6JkyApqP00DVeiSHLlSk86', 'lelean.al2005@gmail.com', 'Lelean Alali', 2),
(82, '$2y$10$i3.UPGvFgPb2nVx.aLkMPeZ8FlvnMrhB//FuVUoQu4RVMNmLUKBiO', 'merna.bader980@gmail.com', 'merna bader', 1),
(83, '$2y$10$AGHlDv91u2rmeVj8K70/Buj1rk72x9NqHPxnm4GzwfTvYv1p5NNHm', 'maha.ghanem098@gmail.com', 'maha ghanem', 1),
(85, '$2y$10$8NVFIG/nEzS5tKNMFusenODdnSGRHhpGMXRFlz.sP1kdNKyY2kupW', 'maram.gh098@gmail.com', 'maram ghanem', 2);

-- --------------------------------------------------------

--
-- بنية الجدول `booking`
--

CREATE TABLE `booking` (
  `Booking_ID` int(11) NOT NULL,
  `Customer_ID` int(11) DEFAULT NULL,
  `Service_ID` int(11) DEFAULT NULL,
  `Booking_Time` time DEFAULT NULL,
  `Booking_Date` date DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `Provider_ID` int(11) DEFAULT NULL,
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `note_ar` varchar(255) DEFAULT NULL,
  `note_en` varchar(255) DEFAULT NULL,
  `location_lat` decimal(10,8) DEFAULT NULL,
  `location_lng` decimal(11,8) DEFAULT NULL,
  `location_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- إرجاع أو استيراد بيانات الجدول `booking`
--

INSERT INTO `booking` (`Booking_ID`, `Customer_ID`, `Service_ID`, `Booking_Time`, `Booking_Date`, `note`, `Provider_ID`, `status`, `note_ar`, `note_en`, `location_lat`, `location_lng`, `location_text`) VALUES
(45, 10, 24, '12:00:00', '2026-06-05', '', 40, 'confirmed', NULL, NULL, NULL, NULL, NULL),
(46, 18, 24, '12:00:00', '2026-06-19', '', 40, 'completed', NULL, NULL, NULL, NULL, NULL),
(48, 10, 24, '12:00:00', '2026-06-14', '', 42, 'pending', NULL, NULL, NULL, NULL, NULL),
(49, 10, 24, '13:00:00', '2026-06-14', '', 42, 'pending', NULL, NULL, NULL, NULL, NULL),
(53, 10, 24, '10:00:00', '2026-06-25', '', 40, 'completed', NULL, NULL, 32.35769891, 35.07117951, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(54, 10, 24, '14:00:00', '2026-06-26', '', 40, 'completed', NULL, NULL, 32.35768185, 35.07115144, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(55, 10, 24, '14:00:00', '2026-06-19', '', 40, 'completed', NULL, NULL, 32.35768185, 35.07115144, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(56, 10, 24, '12:00:00', '2026-06-12', '', 40, 'completed', NULL, NULL, 32.35768185, 35.07115144, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(57, 10, 24, '13:00:00', '2026-06-14', '', 40, 'confirmed', NULL, NULL, 32.35768185, 35.07115144, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(58, 10, 24, '12:00:00', '2026-06-18', '', 40, 'cancelled', NULL, NULL, 0.00000000, 0.00000000, 'Ø¹ØªÙŠÙ„ Ø§Ù„Ø´Ø§Ø±Ø¹ Ø§Ù„Ø±Ø¦ÙŠØ³ÙŠ'),
(59, 10, 24, '13:30:00', '2026-06-14', '', 40, 'cancelled', NULL, NULL, 32.35767349, 35.07117267, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(60, 10, 24, '11:00:00', '2026-06-14', '', 40, 'completed', NULL, NULL, 32.35767004, 35.07115142, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(61, 10, 24, '10:00:00', '2026-07-23', '', 40, 'confirmed', NULL, NULL, 32.35768185, 35.07112157, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(62, 10, 24, '14:00:00', '2026-06-14', '', 40, 'completed', NULL, NULL, 0.00000000, 0.00000000, ''),
(63, 10, 24, '14:30:00', '2026-06-14', '', 40, 'completed', NULL, NULL, 32.35768185, 35.07115144, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(65, 10, 24, '10:00:00', '2026-06-21', '', 40, 'completed', NULL, NULL, 0.00000000, 0.00000000, ''),
(66, 10, 24, '14:00:00', '2026-06-03', '', 40, 'completed', NULL, NULL, 32.35769951, 35.07113013, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(69, 24, 24, '12:00:00', '2026-06-25', '', 40, 'completed', NULL, NULL, 32.35768445, 35.07117751, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(70, 26, 24, '12:00:00', '2026-06-25', '', 40, 'confirmed', NULL, NULL, 32.35769951, 35.07113013, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(71, 10, 24, '12:00:00', '2026-06-26', '', 40, 'confirmed', NULL, NULL, 32.35778229, 35.07127386, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(72, 10, 24, '12:00:00', '2026-06-30', '', 40, 'cancelled', NULL, NULL, 32.35768852, 35.07117158, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©'),
(73, 10, 24, '12:00:00', '2026-06-30', '', 40, 'confirmed', NULL, NULL, 32.35768852, 35.07117158, 'Ù‚Ø§Ù‚ÙˆÙ†, Ø¯ÙŠØ± Ø§Ù„ØºØµÙˆÙ†, Ù…Ù†Ø·Ù‚Ø© Ø¨, Ø§Ù„Ø¶ÙØ© Ø§Ù„ØºØ±Ø¨ÙŠØ©, 113, Ø§Ù„Ø£Ø±Ø§Ø¶ÙŠ Ø§Ù„ÙÙ„Ø³Ø·ÙŠÙ†ÙŠØ©');

-- --------------------------------------------------------

--
-- بنية الجدول `category`
--

CREATE TABLE `category` (
  `Category_ID` int(11) NOT NULL,
  `Category_Name` varchar(50) NOT NULL,
  `category_description` text,
  `Category_Name_ar` varchar(50) DEFAULT NULL,
  `Category_Name_en` varchar(50) DEFAULT NULL,
  `category_description_ar` text,
  `category_description_en` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- إرجاع أو استيراد بيانات الجدول `category`
--

INSERT INTO `category` (`Category_ID`, `Category_Name`, `category_description`, `Category_Name_ar`, `Category_Name_en`, `category_description_ar`, `category_description_en`) VALUES
(15, 'Cooking Services', ' Professional home cooking services for preparing fresh, delicious meals tailored to your preferences and dietary needs. Ideal for daily meals, family gatherings, and special occasions.', '- Ø®Ø¯Ù…Ø§ØªÙŠ Ù„Ù„Ø·Ø¨Ø® .', 'Cooking Services', 'Ø®Ø¯Ù…Ø§Øª Ø·Ù‡ÙŠ Ù…Ù†Ø²Ù„ÙŠØ© Ø§Ø­ØªØ±Ø§ÙÙŠØ© Ù„Ø¥Ø¹Ø¯Ø§Ø¯ ÙˆØ¬Ø¨Ø§Øª Ø·Ø§Ø²Ø¬Ø© ÙˆÙ„Ø°ÙŠØ°Ø© Ù…ØµÙ…Ù…Ø© Ø®ØµÙŠØµÙ‹Ø§ Ù„ØªÙØ¶ÙŠÙ„Ø§ØªÙƒ ÙˆØ§Ø­ØªÙŠØ§Ø¬Ø§ØªÙƒ Ø§Ù„ØºØ°Ø§Ø¦ÙŠØ©. Ù…Ø«Ø§Ù„ÙŠØ© Ù„Ù„ÙˆØ¬Ø¨Ø§Øª Ø§Ù„ÙŠÙˆÙ…ÙŠØ© ÙˆØ§Ù„ØªØ¬Ù…Ø¹Ø§Øª Ø§Ù„Ø¹Ø§Ø¦Ù„ÙŠØ© ÙˆØ§Ù„Ù…Ù†Ø§Ø³Ø¨Ø§Øª Ø§Ù„Ø®Ø§ØµØ©.', ' Professional home cooking services for preparing fresh, delicious meals tailored to your preferences and dietary needs. Ideal for daily meals, family gatherings, and special occasions.'),
(24, 'beauty service', 'hair style, make up', 'Ø®Ø¯Ù…Ø© Ø§Ù„ØªØ¬Ù…ÙŠÙ„', 'beauty service', 'ØªØµÙÙŠÙ Ø§Ù„Ø´Ø¹Ø±ØŒ Ø§Ù„Ù…ÙƒÙŠØ§Ø¬', 'hair style, make up');

-- --------------------------------------------------------

--
-- بنية الجدول `customer`
--

CREATE TABLE `customer` (
  `Customer_ID` int(11) NOT NULL,
  `First_Name` varchar(20) NOT NULL,
  `Last_Name` varchar(20) NOT NULL,
  `Phone_No` varchar(20) DEFAULT NULL,
  `Street` varchar(50) DEFAULT NULL,
  `Village` varchar(50) DEFAULT NULL,
  `Zip_Code` varchar(50) DEFAULT NULL,
  `Governorate` varchar(50) DEFAULT NULL,
  `User_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- إرجاع أو استيراد بيانات الجدول `customer`
--

INSERT INTO `customer` (`Customer_ID`, `First_Name`, `Last_Name`, `Phone_No`, `Street`, `Village`, `Zip_Code`, `Governorate`, `User_ID`) VALUES
(10, 'Leena', 'ghanem', '+970 5678349', 'Main Street', 'Deir al-Ghusun', NULL, 'Tulkarm', 6),
(17, 'Leena', 'ghanem', '+970 403 174', 'Tulkarem', NULL, NULL, NULL, 57),
(18, 'samer', 'ghanem', '+970 201 355', 'Main Street', 'Deir al-Ghusun', NULL, 'Tulkarem', 66),
(21, 'misk', 'ghanem', '+970 382 102', 'Jerusalem Street', 'Al-Bireh', NULL, 'Ramallah', 77),
(22, 'Alaa', 'ghanem', '+970 582 174', 'Al-Tall Street', 'Deir Dibwan', NULL, 'Ramallah', 78),
(23, 'Ahmaad', 'ghanem', '+970 201 425', 'Jerusalem Street', 'Hawara', NULL, 'Nablus', 79),
(24, 'maram', 'ahmad', '+970 503 209 ', 'Al-Tall Street', 'Deir Dibwan', NULL, 'Ramallah', 80),
(25, 'merna', 'bader', '+970 610 361', 'Jerusalem Street', 'Hawara', NULL, 'Nablus', 82),
(26, 'maha', 'ghanem', '+970 139 840', 'Al-Tall Street', 'Deir Dibwan', NULL, 'Ramallah', 83);

-- --------------------------------------------------------

--
-- بنية الجدول `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- إرجاع أو استيراد بيانات الجدول `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expires_at`, `created_at`) VALUES
(1, 'lena.ghanem2003@gmail.com', '$2y$10$tmx.lSEdXrzRtBPdbpIBwuDam.lWdtpGHGMn0yxea.h3m/I9aKeEm', '2026-06-19 19:08:24', '2026-06-19 16:08:24'),
(2, 'lena.ghanem2005@gmail.com', '$2y$10$YqWgHUytnGr1pj5gHlBmauMiwqX6AgLVHZl2eUWfJ/or2IfNkzATy', '2026-06-19 19:09:10', '2026-06-19 16:09:10');

-- --------------------------------------------------------

--
-- بنية الجدول `provider`
--

CREATE TABLE `provider` (
  `Provider_ID` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Phone_No` varchar(50) NOT NULL,
  `Governorate` varchar(50) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- إرجاع أو استيراد بيانات الجدول `provider`
--

INSERT INTO `provider` (`Provider_ID`, `First_Name`, `Last_Name`, `Phone_No`, `Governorate`, `User_ID`, `profile_image`) VALUES
(33, 'masa', 'badran', '+970 172 184', 'Tulkarem', 51, NULL),
(40, 'marah', 'samer', '+970  120 461', 'Tulkarem,Ramallah', 63, NULL),
(41, 'maram', 'ahmad', '+970 391 305', 'Nablus', 64, NULL),
(42, 'lama', 'ahmad', '+970 130 724', 'Nablus', 65, NULL),
(43, 'mohanad', 'ali', '+97059904011', 'Tulkarem', 69, NULL),
(44, 'mohanad', 'ahmad', '+970452109', 'Tulkarem', 70, NULL),
(46, 'manal', 'ghanem', '+970 841 309', 'Tulkarem', 76, NULL),
(47, 'Lelean', 'Alali', '+970 201 784', 'Ramallah', 81, NULL),
(48, 'maram', 'ghanem', '+970 540 194', 'Tulkarem', 85, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `rating`
--

CREATE TABLE `rating` (
  `Rating_ID` int(11) NOT NULL,
  `Customer_ID` int(11) DEFAULT NULL,
  `Service_ID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Score` int(11) DEFAULT NULL,
  `Comment` text,
  `Comment_ar` text,
  `Comment_en` text,
  `Booking_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- إرجاع أو استيراد بيانات الجدول `rating`
--

INSERT INTO `rating` (`Rating_ID`, `Customer_ID`, `Service_ID`, `Date`, `Score`, `Comment`, `Comment_ar`, `Comment_en`, `Booking_ID`) VALUES
(6, 10, 24, '2026-06-14', 3, 'Ø§Ù„Ø·Ø¹Ø§Ù… ÙƒØ§Ù† Ø¬ÙŠØ¯Ù‹Ø§ Ø¬Ø¯Ù‹Ø§ ÙˆØ§Ù„Ø·Ø¹Ù… Ù…Ù…ÙŠØ²ØŒ Ù„ÙƒÙ† ÙƒØ§Ù† Ù‡Ù†Ø§Ùƒ ØªØ£Ø®ÙŠØ± Ø¨Ø³ÙŠØ· ÙÙŠ Ø§Ù„ØªØ³Ù„ÙŠÙ…. Ø¨Ø´ÙƒÙ„ Ø¹Ø§Ù… Ø§Ù„Ø®Ø¯Ù…Ø© Ù…Ù…ØªØ§Ø²Ø© ÙˆØªØ³ØªØ­Ù‚ Ø§Ù„ØªØ¬Ø±Ø¨Ø©.', 'Ø§Ù„Ø·Ø¹Ø§Ù… ÙƒØ§Ù† Ø¬ÙŠØ¯Ù‹Ø§ Ø¬Ø¯Ù‹Ø§ ÙˆØ§Ù„Ø·Ø¹Ù… Ù…Ù…ÙŠØ²ØŒ Ù„ÙƒÙ† ÙƒØ§Ù† Ù‡Ù†Ø§Ùƒ ØªØ£Ø®ÙŠØ± Ø¨Ø³ÙŠØ· ÙÙŠ Ø§Ù„ØªØ³Ù„ÙŠÙ…. Ø¨Ø´ÙƒÙ„ Ø¹Ø§Ù… Ø§Ù„Ø®Ø¯Ù…Ø© Ù…Ù…ØªØ§Ø²Ø© ÙˆØªØ³ØªØ­Ù‚ Ø§Ù„ØªØ¬Ø±Ø¨Ø©.', 'The food was very good and the taste was distinctive, but there was a slight delay in delivery. Overall the service is excellent and worth a try.', NULL),
(7, 10, 24, '2026-06-14', 4, 'Ø·Ø¹Ø§Ù… Ù„Ø°ÙŠØ° ÙˆÙ…Ù†Ø¸Ù… Ø¨Ø´ÙƒÙ„ Ø±Ø§Ø¦Ø¹ØŒ Ø§Ù„ØªØ²Ø§Ù… Ø¨Ø§Ù„Ù…ÙˆØ§Ø¹ÙŠØ¯ ÙˆØ¬ÙˆØ¯Ø© Ù…Ù…ØªØ§Ø²Ø©. ØªØ¬Ø±Ø¨Ø© Ø±Ø§Ø¦Ø¹Ø© ÙˆØ³Ø£Ø·Ù„Ø¨ Ø§Ù„Ø®Ø¯Ù…Ø© Ù…Ø±Ø© Ø£Ø®Ø±Ù‰.', 'Ø·Ø¹Ø§Ù… Ù„Ø°ÙŠØ° ÙˆÙ…Ù†Ø¸Ù… Ø¨Ø´ÙƒÙ„ Ø±Ø§Ø¦Ø¹ØŒ Ø§Ù„ØªØ²Ø§Ù… Ø¨Ø§Ù„Ù…ÙˆØ§Ø¹ÙŠØ¯ ÙˆØ¬ÙˆØ¯Ø© Ù…Ù…ØªØ§Ø²Ø©. ØªØ¬Ø±Ø¨Ø© Ø±Ø§Ø¦Ø¹Ø© ÙˆØ³Ø£Ø·Ù„Ø¨ Ø§Ù„Ø®Ø¯Ù…Ø© Ù…Ø±Ø© Ø£Ø®Ø±Ù‰.', 'Delicious and exquisitely organized food, punctuality and excellent quality. Great experience and I\'ll ask for the service again.', NULL),
(8, 10, 24, '2026-06-14', 3, '', '', '', 62),
(9, 10, 24, '2026-06-14', 5, '\"Ø·Ø¹Ø§Ù… Ù„Ø°ÙŠØ° ÙˆÙ…Ù†Ø¸Ù… Ø¨Ø´ÙƒÙ„ Ø±Ø§Ø¦Ø¹ØŒ Ø§Ù„ØªØ²Ø§Ù… Ø¨Ø§Ù„Ù…ÙˆØ§Ø¹ÙŠØ¯ ÙˆØ¬ÙˆØ¯Ø© Ù…Ù…ØªØ§Ø²Ø©. ØªØ¬Ø±Ø¨Ø© Ø±Ø§Ø¦Ø¹Ø© ÙˆØ³Ø£Ø·Ù„Ø¨ Ø§Ù„Ø®Ø¯Ù…Ø© Ù…Ø±Ø© Ø£Ø®Ø±Ù‰.\"', '\"Ø·Ø¹Ø§Ù… Ù„Ø°ÙŠØ° ÙˆÙ…Ù†Ø¸Ù… Ø¨Ø´ÙƒÙ„ Ø±Ø§Ø¦Ø¹ØŒ Ø§Ù„ØªØ²Ø§Ù… Ø¨Ø§Ù„Ù…ÙˆØ§Ø¹ÙŠØ¯ ÙˆØ¬ÙˆØ¯Ø© Ù…Ù…ØªØ§Ø²Ø©. ØªØ¬Ø±Ø¨Ø© Ø±Ø§Ø¦Ø¹Ø© ÙˆØ³Ø£Ø·Ù„Ø¨ Ø§Ù„Ø®Ø¯Ù…Ø© Ù…Ø±Ø© Ø£Ø®Ø±Ù‰.\"', 'â€œDelicious and wonderfully organized food, punctuality and excellent quality. Great experience and I\'ll ask for the service again.â€', 63),
(10, 10, 24, '2026-06-20', 3, 'nice service', '-Ø®Ø¯Ù…Ø© Ø±Ø§Ø¦Ø¹Ø© .', 'nice service', 54),
(11, 10, 24, '2026-06-20', 3, 'good service', 'Good service', 'good service', 53);

-- --------------------------------------------------------

--
-- بنية الجدول `role`
--

CREATE TABLE `role` (
  `Role_ID` int(11) NOT NULL,
  `Role_Name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- إرجاع أو استيراد بيانات الجدول `role`
--

INSERT INTO `role` (`Role_ID`, `Role_Name`) VALUES
(1, 'Customer'),
(2, 'Provider'),
(3, 'Admin');

-- --------------------------------------------------------

--
-- بنية الجدول `service`
--

CREATE TABLE `service` (
  `Service_ID` int(11) NOT NULL,
  `Service_Name` varchar(50) NOT NULL,
  `Category_ID` int(11) DEFAULT NULL,
  `Service_Name_ar` varchar(50) DEFAULT NULL,
  `Service_Name_en` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- إرجاع أو استيراد بيانات الجدول `service`
--

INSERT INTO `service` (`Service_ID`, `Service_Name`, `Category_ID`, `Service_Name_ar`, `Service_Name_en`) VALUES
(24, 'Party Food Preparation', 15, 'ØªØ­Ø¶ÙŠØ± Ø·Ø¹Ø§Ù… Ø§Ù„Ø­ÙÙ„Ø§Øª', 'Party Food Preparation'),
(30, 'make up', 24, NULL, NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `servicepro`
--

CREATE TABLE `servicepro` (
  `Servicepro_ID` int(11) NOT NULL,
  `Provider_ID` int(11) DEFAULT NULL,
  `Service_ID` int(11) DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Service_Description` text,
  `Status` tinyint(1) DEFAULT '1',
  `working_days` varchar(255) DEFAULT NULL,
  `working_hours` varchar(100) DEFAULT NULL,
  `Service_Description_ar` text,
  `Service_Description_en` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- إرجاع أو استيراد بيانات الجدول `servicepro`
--

INSERT INTO `servicepro` (`Servicepro_ID`, `Provider_ID`, `Service_ID`, `Price`, `Service_Description`, `Status`, `working_days`, `working_hours`, `Service_Description_ar`, `Service_Description_en`) VALUES
(29, 40, 24, 40.00, 'Preparation of delicious snacks, appetizers, and meals for parties and special occasions, tailored to your event size and preferences.', 1, 'Sunday,Tuesday,Thursday,Friday,Saturday', '12:00-14:00', 'ØªØ­Ø¶ÙŠØ± Ø§Ù„ÙˆØ¬Ø¨Ø§Øª Ø§Ù„Ø®ÙÙŠÙØ© Ø§Ù„Ù„Ø°ÙŠØ°Ø© ÙˆØ§Ù„Ù…Ù‚Ø¨Ù„Ø§Øª ÙˆØ§Ù„ÙˆØ¬Ø¨Ø§Øª Ù„Ù„Ø­ÙÙ„Ø§Øª ÙˆØ§Ù„Ù…Ù†Ø§Ø³Ø¨Ø§Øª Ø§Ù„Ø®Ø§ØµØ©ØŒ Ø§Ù„Ù…ØµÙ…Ù…Ø© Ø®ØµÙŠØµÙ‹Ø§ Ù„Ø­Ø¬Ù… Ø§Ù„Ø­Ø¯Ø« ÙˆØªÙØ¶ÙŠÙ„Ø§ØªÙƒ.', 'Preparation of delicious snacks, appetizers, and meals for parties and special occasions, tailored to your event size and preferences.'),
(30, 41, 24, 70.00, 'cooking', 1, 'Sunday,Thursday,Saturday', '12:00-16:00', 'Ø·Ù‡ÙŠ', 'cooking'),
(31, 42, 24, 70.00, 'cooking', 1, 'Sunday,Thursday,Saturday', '12:00-16:00', 'Ø·Ù‡ÙŠ', 'cooking');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `Role_ID` (`Role_ID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Booking_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`),
  ADD KEY `Service_ID` (`Service_ID`),
  ADD KEY `Provider_ID` (`Provider_ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Customer_ID`),
  ADD UNIQUE KEY `Phone_No` (`Phone_No`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`Provider_ID`),
  ADD UNIQUE KEY `Phone_No` (`Phone_No`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`Rating_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`),
  ADD KEY `Service_ID` (`Service_ID`),
  ADD KEY `Booking_ID` (`Booking_ID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`Role_ID`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`Service_ID`),
  ADD KEY `Category_ID` (`Category_ID`);

--
-- Indexes for table `servicepro`
--
ALTER TABLE `servicepro`
  ADD PRIMARY KEY (`Servicepro_ID`),
  ADD KEY `Provider_ID` (`Provider_ID`),
  ADD KEY `Service_ID` (`Service_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `Booking_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Customer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `Provider_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `Rating_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `Role_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `Service_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `servicepro`
--
ALTER TABLE `servicepro`
  MODIFY `Servicepro_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`Role_ID`) REFERENCES `role` (`Role_ID`);

--
-- قيود الجداول `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`Customer_ID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`Service_ID`) REFERENCES `service` (`Service_ID`),
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`Provider_ID`) REFERENCES `provider` (`Provider_ID`);

--
-- قيود الجداول `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `account` (`User_ID`);

--
-- قيود الجداول `provider`
--
ALTER TABLE `provider`
  ADD CONSTRAINT `provider_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `account` (`User_ID`);

--
-- قيود الجداول `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`Customer_ID`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`Service_ID`) REFERENCES `service` (`Service_ID`),
  ADD CONSTRAINT `rating_ibfk_3` FOREIGN KEY (`Booking_ID`) REFERENCES `booking` (`Booking_ID`);

--
-- قيود الجداول `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`);

--
-- قيود الجداول `servicepro`
--
ALTER TABLE `servicepro`
  ADD CONSTRAINT `servicepro_ibfk_1` FOREIGN KEY (`Provider_ID`) REFERENCES `provider` (`Provider_ID`),
  ADD CONSTRAINT `servicepro_ibfk_2` FOREIGN KEY (`Service_ID`) REFERENCES `service` (`Service_ID`);

DELIMITER $$
--
-- أحداث
--
CREATE DEFINER=`root`@`localhost` EVENT `auto_complete_bookings` ON SCHEDULE EVERY 15 MINUTE STARTS '2026-06-03 04:07:56' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE bookings
  SET status = 'completed'
  WHERE status = 'confirmed'
    AND Booking_Time < NOW()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
