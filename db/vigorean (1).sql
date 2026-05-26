-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2026 at 06:44 PM
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
-- Database: `vigorean`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `access_type`) VALUES
(1, 'moizmalikofficiall@gmail.com', '1234', 'full');

-- --------------------------------------------------------

--
-- Table structure for table `auth_audit`
--

CREATE TABLE `auth_audit` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ip` varchar(45) NOT NULL,
  `event_type` enum('register','otp_sent','verify_email','verify_failed','resend_otp') NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auth_audit`
--

INSERT INTO `auth_audit` (`id`, `user_id`, `email`, `ip`, `event_type`, `user_agent`, `created_at`) VALUES
(1183, NULL, 'johncorona28@gmail.com', '46.246.3.217', 'otp_sent', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36', '2025-10-01 04:25:02'),
(1184, NULL, 'aamedicine2015@gmail.com', '46.246.3.217', 'otp_sent', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.53 Safari/537.36', '2025-10-01 04:34:06'),
(1185, NULL, '08-finale-buoys@icloud.com', '46.246.3.217', 'otp_sent', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36', '2025-10-01 04:47:41'),
(1186, NULL, 'bayouprakoso23@gmail.com', '46.246.122.182', 'otp_sent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36 OpenWave/97.4.2043.44', '2025-10-01 05:34:46'),
(1187, NULL, 'tmad5050@yahoo.com', '46.246.122.182', 'otp_sent', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36', '2025-10-01 05:44:10'),
(1188, NULL, 'aleeshaali835@gmail.com', '103.66.149.239', 'otp_sent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 05:46:18'),
(1189, NULL, 'aleeshaali835@gmail.com', '103.66.149.239', 'verify_email', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 05:47:51'),
(1190, NULL, 'aleeshaali835@gmail.com', '103.66.149.239', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 05:48:05'),
(1191, NULL, 'caugliv1@gmail.com', '46.246.122.182', 'otp_sent', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36', '2025-10-01 06:33:57'),
(1192, NULL, 'wengerremo13@gmail.com', '46.246.122.182', 'otp_sent', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36', '2025-10-01 07:24:31'),
(1193, NULL, 'garysingh3699@gmail.com', '46.246.122.182', 'otp_sent', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36', '2025-10-01 07:48:16'),
(1194, NULL, 'ignacioiribarrenbega@gmail.com', '46.246.122.182', 'otp_sent', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36', '2025-10-01 07:52:29'),
(1195, NULL, 'pastorandersonsantos2010@gmail.com', '46.246.122.182', 'otp_sent', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.114 Safari/537.36', '2025-10-01 08:07:48'),
(1196, NULL, 'ramoserika777@gmail.com', '46.246.122.182', 'otp_sent', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.66 Safari/537.36', '2025-10-01 08:10:00'),
(1197, NULL, 'rudolfnosal75@gmail.com', '46.246.122.182', 'otp_sent', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.66 Safari/537.36', '2025-10-01 08:18:34'),
(1198, NULL, 'dieter.markert1@yahoo.de', '46.246.122.182', 'otp_sent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.66 Safari/537.36', '2025-10-01 08:27:14'),
(1199, NULL, 'smithtaylor1090@gmail.com', '46.246.122.182', 'otp_sent', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36', '2025-10-01 08:42:03'),
(1200, NULL, 'laskila.69@gmail.com', '103.66.149.239', 'otp_sent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-01 09:06:29'),
(1201, NULL, 'jeanjoel925@gmail.com', '46.246.122.182', 'otp_sent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.53 Safari/537.36', '2025-10-01 09:14:44');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `alt` text NOT NULL,
  `image_url` varchar(100) NOT NULL,
  `text` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `alt`, `image_url`, `text`) VALUES
(11, 'Hello_World', 'pictures/banners/two.jpg', 'three'),
(13, 'main', 'pictures/banners/main.jpg', 'three'),
(14, 'three', 'pictures/banners/three.jpg', 'three');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`blog_id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `meta_keywords`, `featured_image`, `created_at`) VALUES
(1, 'My First Blog', 'myfirstblog', 'This is my conent for 1st blog', 'My First Blog', 'description', 'hello, world, me, roohafza', NULL, '2025-05-16 05:34:15'),
(2, 'My 2nd Blog', 'my-2nd-blog', 'Who, parvez kana, who who', 'My 2nd Blog', 'My 2nd Blog', 'My 2nd Blog', '../pictures/blogs/_6826e7d0e7611.jpg', '2025-05-16 07:22:56');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(150) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `c_description` varchar(2000) NOT NULL,
  `c_image` varchar(500) DEFAULT NULL,
  `c_img2` varchar(500) NOT NULL,
  `meta_title` varchar(150) DEFAULT NULL,
  `meta_description` varchar(160) DEFAULT NULL,
  `meta_keywords` varchar(250) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`c_id`, `c_name`, `slug`, `c_description`, `c_image`, `c_img2`, `meta_title`, `meta_description`, `meta_keywords`, `parent_id`) VALUES
(3, 'T-Shirts', 'surgical-instruments', 'T-Shirts', 'pictures/category/1773614640_cat5.jpg', '', 'T-Shirts', 'T-Shirts', 'T-Shirts', 12),
(4, 'Baseball', 'dental-instruments', 'Baseball Uniform', 'pictures/category/1774033950_prod1.jpg', '', 'Baseball Uniform', 'Baseball Uniform', 'Baseball Uniform', NULL),
(12, 'Sportswear', '', 'no', 'pictures/category/1773614099_cat1.webp', 'pictures/category/1773614099_cat1.webp', 'Sportswear', 'Sportswear', 'Sportswear', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `color_id` int(11) NOT NULL,
  `color_name` varchar(50) NOT NULL,
  `color_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`color_id`, `color_name`, `color_code`) VALUES
(1, 'Cyan Blue ', '#009ce5'),
(2, 'Lemon Yellow', '#c1a600'),
(3, 'Pearl Blue', '#001593'),
(4, 'Red Yam', ' #900d09'),
(5, 'Flame Blue', '#1e52a1'),
(6, 'Stove Green', '#309b87');

-- --------------------------------------------------------

--
-- Table structure for table `email_verifications`
--

CREATE TABLE `email_verifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token_hash` char(64) NOT NULL,
  `purpose` enum('verify_email_otp','reset_password') NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `tracking_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `invoice_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `phone`, `address`, `total`, `status`, `created_at`, `invoice_no`) VALUES
(1, 'Aleesha Ali', '03146698575', 'Khajiuriwaal,Head Marala Road 51310', 461.00, 'Pending', '2026-03-25 20:02:06', ''),
(2, 'Aleesha Ali', '03146698575', 'Khajiuriwaal,Head Marala Road 51310', 235.00, 'Pending (cod)', '2026-03-27 21:20:14', ''),
(3, 'Aleesha Ali', '03146698575', 'Khajiuriwaal,Head Marala Road 51310', 67.00, 'Pending (cod)', '2026-03-30 19:39:01', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(1, 1, 18, 45.00, 9),
(2, 1, 13, 56.00, 1),
(3, 2, 20, 67.00, 1),
(4, 2, 15, 56.00, 3),

-- --------------------------------------------------------
--
-- Table structure for table `user_chats`
--

CREATE TABLE `user_chats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role` varchar(10) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `user_searches`
--

CREATE TABLE `user_searches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `query` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
(5, 3, 20, 67.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `otp_rate_limit`
--

CREATE TABLE `otp_rate_limit` (
  `id` int(11) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `attempt_count` int(11) NOT NULL DEFAULT 0,
  `last_attempt` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `publish_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `meta_keywords`, `parent_id`, `is_published`, `publish_date`, `created_at`, `updated_at`) VALUES
(1, 'About Us', 'about-us', '<style>\r\n     :root {\r\n            --primary-color: #3bafc0;\r\n            --primary-light: #e9f1ff;\r\n            --text-dark: #212529;\r\n            --text-medium: #495057;\r\n            --text-light: #6c757d;\r\n            --border-color: #e0e7f5;\r\n            --background-light: #fafcff;\r\n            --radius: 8px;\r\n            --transition: all 0.3s ease;\r\n        }\r\n       \r\n        .medical-container {\r\n            max-width: 1200px;\r\n            margin: 0 auto;\r\n            padding: 0;\r\n        }\r\n        \r\n        .medical-title {\r\n            font-size: 2rem;\r\n            font-weight: 700;\r\n            margin-bottom: 1.5rem;\r\n            color: var(--text-dark);\r\n            position: relative;\r\n            padding-bottom: 0.75rem;\r\n        }\r\n        \r\n        .medical-title::after {\r\n            content: \'\';\r\n            position: absolute;\r\n            bottom: 0;\r\n            left: 0;\r\n            width: 50px;\r\n            height: 3px;\r\n            background: var(--primary-color);\r\n            border-radius: 2px;\r\n        }\r\n        \r\n        .section-divider {\r\n            height: 1px;\r\n            background: linear-gradient(90deg, transparent, var(--border-color), transparent);\r\n            margin: 3.5rem 0;\r\n        }\r\n        \r\n        /* Card Design */\r\n        .medical-card {\r\n            background: #ffffff;\r\n            border-radius: var(--radius);\r\n            border: 1px solid var(--border-color);\r\n            transition: var(--transition);\r\n            height: 100%;\r\n            overflow: hidden;\r\n            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);\r\n        }\r\n        \r\n        .medical-card:hover {\r\n            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);\r\n            transform: translateY(-3px);\r\n        }\r\n        \r\n        /* Quality Badges */\r\n        .quality-badge {\r\n            display: flex;\r\n            align-items: center;\r\n            background: var(--background-light);\r\n            padding: 1.25rem;\r\n            border-radius: var(--radius);\r\n            margin-bottom: 1rem;\r\n            transition: var(--transition);\r\n            border: 1px solid var(--border-color);\r\n        }\r\n        \r\n        .quality-badge:hover {\r\n            background: rgba(13, 110, 253, 0.03);\r\n        }\r\n        \r\n        .quality-badge i {\r\n            font-size: 1.25rem;\r\n            color: var(--primary-color);\r\n            background: rgba(13, 110, 253, 0.1);\r\n            border-radius: 50%;\r\n            padding: 0.7rem;\r\n            margin-right: 1.5rem;\r\n            min-width: 45px;\r\n            min-height: 45px;\r\n            display: flex;\r\n            align-items: center;\r\n            justify-content: center;\r\n        }\r\n        \r\n        /* Steps */\r\n        .step {\r\n            display: flex;\r\n            gap: 1.5rem;\r\n            align-items: flex-start;\r\n            margin-bottom: 2rem;\r\n            position: relative;\r\n            padding-left: 1.5rem;\r\n        }\r\n        \r\n        .step:before {\r\n            content: \"\";\r\n            position: absolute;\r\n            left: 22px;\r\n            top: 40px;\r\n            bottom: -20px;\r\n            width: 1px;\r\n            background: var(--border-color);\r\n        }\r\n        \r\n        .step:last-child:before {\r\n            display: none;\r\n        }\r\n        \r\n        .step .number {\r\n            background: #ffffff;\r\n            color: var(--primary-color);\r\n            width: 40px;\r\n            height: 40px;\r\n            font-weight: 700;\r\n            font-size: 1rem;\r\n            border-radius: 50%;\r\n            display: flex;\r\n            align-items: center;\r\n            justify-content: center;\r\n            flex-shrink: 0;\r\n            border: 1px solid var(--primary-color);\r\n        }\r\n        \r\n        .step-content h5 {\r\n            margin-bottom: 0.8rem;\r\n            color: var(--text-dark);\r\n        }\r\n        \r\n        /* Mission Block */\r\n        .mission-block {\r\n            background: var(--background-light);\r\n            border-left: 3px solid var(--primary-color);\r\n            border-radius: var(--radius);\r\n            padding: 2rem;\r\n            height: 100%;\r\n            position: relative;\r\n            overflow: hidden;\r\n        }\r\n        \r\n        .mission-block h4 {\r\n            color: var(--text-dark);\r\n            margin-bottom: 1.5rem;\r\n        }\r\n        \r\n        /* Check Items */\r\n        .check-item {\r\n            display: flex;\r\n            align-items: flex-start;\r\n            gap: 1.25rem;\r\n            margin-bottom: 1.5rem;\r\n            padding: 1rem 0;\r\n            border-bottom: 1px solid var(--border-color);\r\n        }\r\n        \r\n        .check-item:last-child {\r\n            border-bottom: none;\r\n            margin-bottom: 0;\r\n        }\r\n        \r\n        .check-item i {\r\n            font-size: 1.25rem;\r\n            color: var(--primary-color);\r\n            margin-top: 0.3rem;\r\n            min-width: 30px;\r\n        }\r\n        \r\n        .check-content h6 {\r\n            color: var(--text-dark);\r\n            margin-bottom: 0.5rem;\r\n            font-weight: 600;\r\n        }\r\n        \r\n        /* Subtle Animations */\r\n        @keyframes fadeIn {\r\n            from { opacity: 0; transform: translateY(10px); }\r\n            to { opacity: 1; transform: translateY(0); }\r\n        }\r\n        \r\n        .fade-in {\r\n            animation: fadeIn 0.6s ease forwards;\r\n            opacity: 0;\r\n        }\r\n        \r\n        .delay-1 { animation-delay: 0.1s; }\r\n        .delay-2 { animation-delay: 0.2s; }\r\n        .delay-3 { animation-delay: 0.3s; }\r\n        .delay-4 { animation-delay: 0.4s; }\r\n        \r\n        /* Responsive Design */\r\n        @media (max-width: 768px) {\r\n            .step:before {\r\n                left: 20px;\r\n                top: 40px;\r\n            }\r\n            \r\n            .quality-badge {\r\n                padding: 1rem;\r\n            }\r\n            \r\n            .quality-badge i {\r\n                margin-right: 1rem;\r\n                min-width: 40px;\r\n                min-height: 40px;\r\n            }\r\n            \r\n            .medical-title {\r\n                font-size: 1.8rem;\r\n            }\r\n            \r\n       \r\n        }\r\n  </style> \r\n<p class=\"py-5\" style=\"text-align: justify; \">MediTip is a trusted name in the surgical instruments industry, proudly delivering quality and precision for over 28 years. We specialize in manufacturing and supplying high-grade surgical instruments designed to meet the highest standards of accuracy and durability. With nearly three decades of expertise, MediTip ensures that every tool we offer is crafted with meticulous attention to detail and performance. Our commitment to excellence extends beyond our products—we also provide convenient doorstep delivery, making it easier than ever for healthcare professionals to access reliable instruments when and where they need them. </p>\r\n        <!-- Quality Section -->\r\n        <section class=\"row mb-5\">\r\n\r\n            <div class=\"col-lg-5 mb-4 fade-in\">\r\n                <div class=\"medical-card h-100\">\r\n                    <div class=\"p-4\">\r\n                        <h3 class=\"mb-4\" style=\"color: var(--text-dark);\">Uncompromising Standards</h3>\r\n                        <p>At Meditip Hospital Supplies, we exclusively distribute top-quality instruments developed and produced in the CE world-leading medical technology center of Trullingen.</p>\r\n                        <p>Our manufacturers must meet our high-quality standards daily, ensuring you receive the best tools for medical practice.</p>\r\n\r\n                        <div class=\"mt-4\">\r\n                            <div class=\"quality-badge fade-in delay-1\">\r\n                                <i class=\"bi bi-shield-check\"></i>\r\n                                <div>\r\n                                    <h6 class=\"mb-1\" style=\"color: var(--text-dark);\">DIN EN ISO 13485</h6>\r\n                                    <small class=\"text-muted\">Certified quality management</small>\r\n                                </div>\r\n                            </div>\r\n\r\n                            <div class=\"quality-badge fade-in delay-2\">\r\n                                <i class=\"bi bi-file-earmark-medical\"></i>\r\n                                <div>\r\n                                    <h6 class=\"mb-1\" style=\"color: var(--text-dark);\">EU Directive 93/42/ECE</h6>\r\n                                    <small class=\"text-muted\">Compliance with CE marking</small>\r\n                                </div>\r\n                            </div>\r\n\r\n                            <div class=\"quality-badge fade-in delay-3\">\r\n                                <i class=\"bi bi-clipboard2-check\"></i>\r\n                                <div>\r\n                                    <h6 class=\"mb-1\" style=\"color: var(--text-dark);\">Medical Device Regulation</h6>\r\n                                    <small class=\"text-muted\">MDR compliance since 2017</small>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"col-lg-7 fade-in delay-1\">\r\n                <div class=\"medical-card h-100\">\r\n                    <div class=\"p-4\">\r\n                        <h3 class=\"mb-4\" style=\"color: var(--text-dark);\">Our Quality Assurance Process</h3>\r\n                        <div class=\"step\">\r\n                            <div class=\"number\">1</div>\r\n                            <div class=\"step-content\">\r\n                                <h5>Supplier Audits</h5>\r\n                                <p class=\"mb-0\">Regular audits ensure manufacturers maintain the highest standards of production and compliance.</p>\r\n                            </div>\r\n                        </div>\r\n\r\n                        <div class=\"step\">\r\n                            <div class=\"number\">2</div>\r\n                            <div class=\"step-content\">\r\n                                <h5>Comprehensive Inspection</h5>\r\n                                <p class=\"mb-0\">Each product is carefully inspected by our experienced QA team before shipping.</p>\r\n                            </div>\r\n                        </div>\r\n\r\n                        <div class=\"step\">\r\n                            <div class=\"number\">3</div>\r\n                            <div class=\"step-content\">\r\n                                <h5>Performance Testing</h5>\r\n                                <p class=\"mb-0\">Instruments undergo rigorous testing to ensure they meet the demands of medical practice.</p>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </section>\r\n\r\n        <div class=\"section-divider\"></div>\r\n\r\n        <!-- Mission Section -->\r\n        <section class=\"row mb-5\">\r\n            <div class=\"col-12 mb-4\">\r\n                <h2 class=\"medical-title fade-in\">Our Mission</h2>\r\n            </div>\r\n\r\n            <div class=\"col-lg-6 mb-4 fade-in\">\r\n                <div class=\"mission-block\">\r\n                    <h4>Advancing Medical Technology</h4>\r\n                    <p>Our drive is to advance the medical technology industry through innovation, quality, and service. We understand the challenges faced by doctors and medical facilities and offer solutions that save time, optimize costs, and guarantee the highest quality standards.</p>\r\n                    <p>We believe in partnerships that transform healthcare delivery through technology and expertise.</p>\r\n                </div>\r\n            </div>\r\n\r\n            <div class=\"col-lg-6 fade-in delay-1\">\r\n                <div class=\"medical-card h-100\">\r\n                    <div class=\"p-4\">\r\n                        <h4 class=\"mb-4\" style=\"color: var(--text-dark);\">Why Meditip Hospital Supplies?</h4>\r\n                        <div class=\"check-item fade-in delay-1\">\r\n                            <i class=\"bi bi-check2-circle\"></i>\r\n                            <div class=\"check-content\">\r\n                                <h6>High-Quality Products</h6>\r\n                                <p class=\"mb-0\">Exclusively from the medical technology center of Trullingen</p>\r\n                            </div>\r\n                        </div>\r\n\r\n                        <div class=\"check-item fade-in delay-2\">\r\n                            <i class=\"bi bi-check2-circle\"></i>\r\n                            <div class=\"check-content\">\r\n                                <h6>Comprehensive Quality Assurance</h6>\r\n                                <p class=\"mb-0\">Every instrument is inspected before shipping</p>\r\n                            </div>\r\n                        </div>\r\n\r\n                        <div class=\"check-item fade-in delay-3\">\r\n                            <i class=\"bi bi-check2-circle\"></i>\r\n                            <div class=\"check-content\">\r\n                                <h6>Wide Range of Products</h6>\r\n                                <p class=\"mb-0\">For all medical specialties</p>\r\n                            </div>\r\n                        </div>\r\n\r\n                        <div class=\"check-item fade-in delay-4\">\r\n                            <i class=\"bi bi-check2-circle\"></i>\r\n                            <div class=\"check-content\">\r\n                                <h6>Reliable Service</h6>\r\n                                <p class=\"mb-0\">Fast delivery and expert advice</p>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </section>', 'About Us | MHS Surgical Instruments', 'MHS promises the finest precision & quality of surgical instruments for individual use.', 'surgical instruments, single use instruments, beauty instruments, about us, overview, ecommerce store', NULL, 1, NULL, '2025-08-01 05:11:54', '2025-08-01 05:11:54'),
(2, 'Terms and Condition', 'terms-and-condition', '<style>\r\n\r\n\r\n    .sidebar {\r\n      background: rgba(255, 255, 255, 0.85);\r\n      backdrop-filter: blur(8px);\r\n      border: 1px solid #d5deed;\r\n      border-radius: 16px;\r\n      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);\r\n      padding: 20px;\r\n    }\r\n\r\n    .sidebar .nav-link2 {\r\n      color: #333;\r\n      font-size: 0.95rem;\r\n     padding:10px 15px;\r\n      border-radius: 8px;\r\n      transition: 0.3s ease;\r\n    }\r\n\r\n    .sidebar .nav-link2:hover,\r\n    .sidebar .nav-link2.active {\r\n      background-color: #e0f7fa;\r\n      color: ##3bafc0;\r\n      font-weight: 500;\r\n    }\r\n\r\n    .content-box {\r\n      background: #ffffff;\r\n      padding: 2.5rem;\r\n      border-radius: 18px;\r\n      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.03);\r\n      border: 1px solid #d5deed;\r\n    }\r\n\r\n    h2 {\r\n      font-weight: 600;\r\n      font-size: 2rem;\r\n      margin-bottom: 1rem;\r\n    }\r\n\r\n    h4 {\r\n      font-size: 1.25rem;\r\n      color: #0d6efd;\r\n      margin-top: 2rem;\r\n      margin-bottom: 0.5rem;\r\n    }\r\n\r\n    .breadcrumb {\r\n      font-size: 0.85rem;\r\n    }\r\n\r\n    ul li {\r\n      margin-bottom: 6px;\r\n    }\r\n\r\n    a {\r\n      text-decoration: none;\r\n    }\r\n\r\n    @media (max-width: 768px) {\r\n      .sidebar {\r\n        margin-bottom: 1.5rem;\r\n      }\r\n    }\r\n  </style>\r\n\r\n<div class=\"container\">\r\n  <!-- Breadcrumb -->\r\n\r\n  <div class=\"row\">\r\n    <!-- Sidebar -->\r\n    <div class=\"col-md-4 col-lg-3\">\r\n      <div class=\"sidebar\">\r\n        <h6 class=\"text-center fw-bold mb-3\" style=\"text-align: center; \">Information Pages</h6>\r\n        <nav class=\"nav flex-column\" style=\"border-top:1px solid #5b5758;\">\r\n          <a class=\"nav-link2 active\" href=\"terms-and-condition\"><i class=\"bi bi-info-circle me-2\"></i>Terms &amp; conditions</a>\r\n         \r\n          <a class=\"nav-link2\" href=\"shipping-and-delivery\"><i class=\"bi bi-truck me-2\"></i>Shpping &amp; Delivery</a>\r\n          <a class=\"nav-link2 \" href=\"return-and-refunds\"><i class=\"bi bi-arrow-counterclockwise me-2\"></i>Returns &amp; Refunds</a>\r\n          <a class=\"nav-link2\" href=\"payment-and-financing\"><i class=\"bi bi-credit-card me-2\"></i>Payment &amp; Financing</a>\r\n          \r\n          <a class=\"nav-link2\" href=\"my-account\"><i class=\"bi bi-person-circle me-2\"></i>My Account</a>\r\n          <a class=\"nav-link2\" href=\"newsletter\"><i class=\"bi bi-envelope-open me-2\"></i>Newsletter</a>\r\n      \r\n          <a class=\"nav-link2\" href=\"how-to-order\"><i class=\"bi bi-cart-plus me-2\"></i>How to Order</a>\r\n         \r\n          <a class=\"nav-link2\" href=\"product-advice\"><i class=\"bi bi-patch-check me-2\"></i>Product Advice</a>\r\n          <a class=\"nav-link2\" href=\"preferred-delivery\"><i class=\"bi bi-box2-heart me-2\"></i>Preferred Delivery</a>\r\n        </nav>\r\n      </div>\r\n    </div>\r\n\r\n    <!-- Content -->\r\n    <div class=\"col-md-8 col-lg-9\">\r\n      <div class=\"content-box\">\r\n        <h2>Terms &amp; Conditions</h2>\r\n        <p class=\"text-muted\"><span style=\"color: rgb(33, 37, 41);\">Welcome to our online store. These Terms and Conditions (\"Terms\") govern your access to and use of our website and services related to the sale of surgical instruments. By placing an order, you agree to be bound by these Terms.</span></p>\r\n        <hr>\r\n\r\n        <h4><font color=\"#25a0b1\">General Information</font></h4>\r\n        <p>MediTip Surgical Instruments is a trusted provider of high-quality surgical and medical tools, committed to serving healthcare professionals with precision, reliability, and value. Our platform offers a wide range of carefully crafted instruments suitable for various medical fields. All purchases made through our store are subject to the terms and conditions outlined below, which ensure clarity, fairness, and legal compliance for both the buyer and MediTip.</p>\r\n\r\n        <h4><font color=\"#25a0b1\">Pricing and Currency</font></h4>\r\n        <p><span style=\"color: rgb(33, 37, 41);\">All prices are listed in&nbsp;</span><span style=\"font-weight: bolder; color: rgb(33, 37, 41);\">Euros (€)</span><span style=\"color: rgb(33, 37, 41);\">&nbsp;and exclude applicable taxes, customs duties, and shipping fees unless stated otherwise. Prices are subject to change without notice.</span></p>\r\n\r\n        <h4><font color=\"#25a0b1\">Product Information</font></h4>\r\n        <ul>\r\n          <li>All products are manufactured using high-grade materials and undergo quality control checks.</li>\r\n          <li>Product images on the website are for view purposes; actual items may vary slightly.</li>\r\n          <li>Any medical or surgical instruments listed are intended for professional use only.</li>\r\n          <li>It is the buyer’s responsibility to ensure the product\'s suitability for its intended use.</li><li>Custom or OEM products may have different lead times, terms, and return policies.</li><li>MediTip reserves the right to modify product details or discontinue items without prior notice.</li>\r\n        </ul>\r\n\r\n        <h4><font color=\"#25a0b1\">Warranty and Liability</font></h4>\r\n        <ul>\r\n          <li><span style=\"color: rgb(33, 37, 41);\">Products carry standard manufacturer warranties unless noted.</span></li>\r\n          <li><span style=\"color: rgb(33, 37, 41);\">We are not liable for indirect or consequential damages.</span></li><li><span style=\"color: rgb(33, 37, 41);\">Products should be used by qualified professionals only.</span></li>\r\n        </ul>\r\n\r\n        <h4><font color=\"#25a0b1\">Changes to Terms</font></h4>\r\n        <p>MediTip Surgical Instruments reserves the right to update, modify, or revise these Terms &amp; Conditions at any time without prior notice. Any changes will become effective immediately upon being posted on our website. It is your responsibility to regularly review the Terms to stay informed of any updates. Continued use of our website or services following any modifications constitutes acceptance of the revised terms.</p>\r\n\r\n        <h4><font color=\"#42adc2\">Need assistance?</font></h4>\r\n        <p>Email us at <strong>info@meditip.store</strong> or chat with our team online during business hours.</p>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</div>', 'Terms and Conditions | Meditip Hospital Supplies', 'Review the terms and conditions for our surgical instruments eCommerce store. Learn about pricing in euros, shipping policies, returns, warranties, and more. Your trust and satisfaction are our priority.', 'terms and conditions, surgical instruments, ecommerce, medical instruments, pricing in euros, shipping policy, return policy, warranty, CE certified instruments, ISO standards, online medical store', NULL, 1, NULL, '2025-08-07 10:59:39', '2025-08-07 10:59:39'),
(3, 'Return and Refunds', 'return-and-refunds', '<style>\r\n\r\n\r\n    .sidebar {\r\n      background: rgba(255, 255, 255, 0.85);\r\n      backdrop-filter: blur(8px);\r\n      border: 1px solid #d5deed;\r\n      border-radius: 16px;\r\n      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);\r\n      padding: 20px;\r\n    }\r\n\r\n    .sidebar .nav-link2 {\r\n      color: #333;\r\n      font-size: 0.95rem;\r\n     padding:10px 15px;\r\n      border-radius: 8px;\r\n      transition: 0.3s ease;\r\n    }\r\n\r\n    .sidebar .nav-link2:hover,\r\n    .sidebar .nav-link2.active {\r\n      background-color: #e0f7fa;\r\n      color: ##3bafc0;\r\n      font-weight: 500;\r\n    }\r\n\r\n    .content-box {\r\n      background: #ffffff;\r\n      padding: 2.5rem;\r\n      border-radius: 18px;\r\n      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.03);\r\n      border: 1px solid #d5deed;\r\n    }\r\n\r\n    h2 {\r\n      font-weight: 600;\r\n      font-size: 2rem;\r\n      margin-bottom: 1rem;\r\n    }\r\n\r\n    h4 {\r\n      font-size: 1.25rem;\r\n      color: #0d6efd;\r\n      margin-top: 2rem;\r\n      margin-bottom: 0.5rem;\r\n    }\r\n\r\n    .breadcrumb {\r\n      font-size: 0.85rem;\r\n    }\r\n\r\n    ul li {\r\n      margin-bottom: 6px;\r\n    }\r\n\r\n    a {\r\n      text-decoration: none;\r\n    }\r\n\r\n    @media (max-width: 768px) {\r\n      .sidebar {\r\n        margin-bottom: 1.5rem;\r\n      }\r\n    }\r\n  </style>\r\n\r\n<div class=\"container\">\r\n  <!-- Breadcrumb -->\r\n\r\n  <div class=\"row\">\r\n    <!-- Sidebar -->\r\n    <div class=\"col-md-4 col-lg-3\">\r\n      <div class=\"sidebar\">\r\n        <h6 class=\"text-center fw-bold mb-3\" style=\"text-align: center; \">Information Pages</h6>\r\n        <nav class=\"nav flex-column\" style=\"border-top:1px solid #5b5758;\">\r\n          <a class=\"nav-link2\" href=\"terms-and-condition\"><i class=\"bi bi-info-circle me-2\"></i>Terms &amp; Conditions</a>\r\n         \r\n          <a class=\"nav-link2\" href=\"shipping-and-delivery\"><i class=\"bi bi-truck me-2\"></i>Shpping &amp; Delivery</a>\r\n          <a class=\"nav-link2 active\" href=\"return-and-refunds\"><i class=\"bi bi-arrow-counterclockwise me-2\"></i>Returns &amp; Refunds</a>\r\n          <a class=\"nav-link2\" href=\"payment-and-financing\"><i class=\"bi bi-credit-card me-2\"></i>Payment &amp; Financing</a>\r\n          \r\n          <a class=\"nav-link2\" href=\"my-account\"><i class=\"bi bi-person-circle me-2\"></i>My Account</a>\r\n          <a class=\"nav-link2\" href=\"newsletter\"><i class=\"bi bi-envelope-open me-2\"></i>Newsletter</a>\r\n\r\n          <a class=\"nav-link2\" href=\"how-to-order\"><i class=\"bi bi-cart-plus me-2\"></i>How to Order</a>\r\n         \r\n          <a class=\"nav-link2\" href=\"product-advice\"><i class=\"bi bi-patch-check me-2\"></i>Product Advice</a>\r\n          <a class=\"nav-link2\" href=\"preferred-delivery\"><i class=\"bi bi-box2-heart me-2\"></i>Preferred Delivery</a>\r\n        </nav>\r\n      </div>\r\n    </div>\r\n\r\n    <!-- Content -->\r\n    <div class=\"col-md-8 col-lg-9\">\r\n      <div class=\"content-box\">\r\n        <h2>Returns &amp; Refunds</h2>\r\n        <p class=\"text-muted\">We make returns simple and worry-free. Learn how to return items, request refunds, and get support if needed.</p>\r\n        <hr>\r\n\r\n        <h4><font color=\"#25a0b1\">How do I return an item?</font></h4>\r\n        <p>You may return any eligible item within 14 days of delivery. Items must be unused and in their original packaging. Certain products such as customized or intimate goods are not returnable.</p>\r\n\r\n        <h4><font color=\"#25a0b1\">How do I pack an item for return?</font></h4>\r\n        <p>Use the original packaging where possible. Ensure the product is secure to avoid damage during transit.</p>\r\n\r\n        <h4><font color=\"#25a0b1\">Returning as a registered customer:</font></h4>\r\n        <ul>\r\n          <li>Login to your account and go to <strong>My Orders</strong>.</li>\r\n          <li>Select the product and click <strong>“Return Item”</strong>.</li>\r\n          <li>We will email you a prepaid return label.</li>\r\n          <li>Print and attach the label to your package, and drop it at a return point.</li>\r\n        </ul>\r\n\r\n        <h4><font color=\"#25a0b1\">Returning as a guest:</font></h4>\r\n        <ul>\r\n          <li>Email us at <font color=\"#311873\"><b>info</b></font><a href=\"mailto:support@example.com\"><font color=\"#311873\"><b>@meditip.</b></font></a><font color=\"#311873\"><b>store</b></font>&nbsp;with your order details.</li>\r\n          <li>We will send you a return label with further instructions.</li>\r\n        </ul>\r\n\r\n        <h4><font color=\"#25a0b1\">Refund timeline</font></h4>\r\n        <p>Refunds are processed within 5–7 business days after inspection of returned items. You will be notified via email once the refund is issued.</p>\r\n\r\n        <h4><font color=\"#42adc2\">Need assistance?</font></h4>\r\n        <p>Call us at <strong>+92 321 6101111</strong> or chat with our team online during business hours.</p>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</div>', 'Return and Refunds | Meditip Hospital Supplies', 'Easily return your purchase within 14 days. Our clear returns and refund policy ensures a smooth process for both registered and guest customers.', 'returns, refunds, return policy, exchange, online shopping, YourBrandName, cancel order, refund process', NULL, 1, NULL, '2025-08-08 04:54:34', '2025-08-08 04:54:34'),
(4, 'Shipping and Delivery', 'shipping-and-delivery', '<style>\r\n\r\n\r\n    .sidebar {\r\n      background: rgba(255, 255, 255, 0.85);\r\n      backdrop-filter: blur(8px);\r\n      border: 1px solid #d5deed;\r\n      border-radius: 16px;\r\n      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);\r\n      padding: 20px;\r\n    }\r\n\r\n    .sidebar .nav-link2 {\r\n      color: #333;\r\n      font-size: 0.95rem;\r\n     padding:10px 15px;\r\n      border-radius: 8px;\r\n      transition: 0.3s ease;\r\n    }\r\n\r\n    .sidebar .nav-link2:hover,\r\n    .sidebar .nav-link2.active {\r\n      background-color: #e0f7fa;\r\n      color: ##3bafc0;\r\n      font-weight: 500;\r\n    }\r\n\r\n    .content-box {\r\n      background: #ffffff;\r\n      padding: 2.5rem;\r\n      border-radius: 18px;\r\n      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.03);\r\n      border: 1px solid #d5deed;\r\n    }\r\n\r\n    h2 {\r\n      font-weight: 600;\r\n      font-size: 2rem;\r\n      margin-bottom: 1rem;\r\n    }\r\n\r\n    h4 {\r\n      font-size: 1.25rem;\r\n      color: #0d6efd;\r\n      margin-top: 2rem;\r\n      margin-bottom: 0.5rem;\r\n    }\r\n\r\n    .breadcrumb {\r\n      font-size: 0.85rem;\r\n    }\r\n\r\n    ul li {\r\n      margin-bottom: 6px;\r\n    }\r\n\r\n    a {\r\n      text-decoration: none;\r\n    }\r\n\r\n    @media (max-width: 768px) {\r\n      .sidebar {\r\n        margin-bottom: 1.5rem;\r\n      }\r\n    }\r\n  </style>\r\n\r\n<div class=\"container\">\r\n  <!-- Breadcrumb -->\r\n\r\n  <div class=\"row\">\r\n    <!-- Sidebar -->\r\n    <div class=\"col-md-4 col-lg-3\">\r\n      <div class=\"sidebar\">\r\n        <h6 class=\"text-center fw-bold mb-3\" style=\"text-align: center; \">Information Pages</h6>\r\n        <nav class=\"nav flex-column\" style=\"border-top:1px solid #5b5758;\">\r\n          <a class=\"nav-link2\" href=\"terms-and-condition\"><i class=\"bi bi-info-circle me-2\"></i>Terms &amp; conditions</a>\r\n         \r\n          <a class=\"nav-link2 active\" href=\"shipping-and-delivery\"><i class=\"bi bi-truck me-2\"></i>Shpping &amp; Delivery</a>\r\n          <a class=\"nav-link2 \" href=\"return-and-refunds\"><i class=\"bi bi-arrow-counterclockwise me-2\"></i>Returns &amp; Refunds</a>\r\n          <a class=\"nav-link2\" href=\"payment-and-financing\"><i class=\"bi bi-credit-card me-2\"></i>Payment &amp; Financing</a>\r\n          \r\n            <a class=\"nav-link2\" href=\"my-account\"><i class=\"bi bi-person-circle me-2\"></i>My Account</a>\r\n          <a class=\"nav-link2\" href=\"newsletter\"><i class=\"bi bi-envelope-open me-2\"></i>Newsletter</a>\r\n\r\n          <a class=\"nav-link2\" href=\"how-to-order\"><i class=\"bi bi-cart-plus me-2\"></i>How to Order</a>\r\n         \r\n          <a class=\"nav-link2\" href=\"product-advice\"><i class=\"bi bi-patch-check me-2\"></i>Product Advice</a>\r\n          <a class=\"nav-link2\" href=\"preferred-delivery\"><i class=\"bi bi-box2-heart me-2\"></i>Preferred Delivery</a>\r\n        </nav>\r\n      </div>\r\n    </div>\r\n\r\n    <!-- Content -->\r\n    <div class=\"col-md-8 col-lg-9\">\r\n      <div class=\"content-box\">\r\n        <h2>Shipping &amp; Delivery</h2>\r\n        <p class=\"text-muted\">We aim to provide fast, reliable, and secure delivery for all our customers worldwide.</p>\r\n        <hr>\r\n\r\n        <h4><font color=\"#25a0b1\">Shipment Info</font></h4>\r\n        <p style=\"text-align: justify; \">MediTip Surgical Instruments partners with <strong data-start=\"299\" data-end=\"314\">DHL Express</strong> for all international shipping, ensuring timely and trackable deliveries.</p>\r\n        <ul>\r\n          <li style=\"text-align: justify; \">Shipping charges and applicable <strong data-start=\"424\" data-end=\"449\">VAT (Value Added Tax)</strong> are <strong data-start=\"454\" data-end=\"482\">automatically calculated</strong> at checkout.</li>\r\n          <li style=\"text-align: justify; \">Once you <strong data-start=\"509\" data-end=\"535\">add items to your cart</strong> and <strong data-start=\"540\" data-end=\"571\">select your shipping region</strong>, the system will instantly calculate the shipping cost and VAT. These will be <strong data-start=\"650\" data-end=\"678\">added to your total bill</strong> before you complete your purchase.</li>\r\n          <li style=\"text-align: justify; \">All orders are processed and shipped on business days (Monday to Friday), excluding public holidays.</li>\r\n          <li style=\"text-align: justify; \">Estimated delivery times vary by destination.</li><li style=\"text-align: justify; \">Tracking information will be sent via email once your order is dispatched.</li><li style=\"text-align: justify; \">Customs duties, if applicable, are the responsibility of the recipient and may vary by country</li></ul><p style=\"text-align: justify; \">We are committed to ensuring your order arrives safely and as quickly as possible. If you experience any issues with delivery, please contact our support team for assistance.</p><ul>\r\n        </ul>\r\n\r\n        <h4><font color=\"#19a2be\">Order Processing</font></h4>\r\n        <p style=\"text-align: justify; \">Products that are <strong data-start=\"169\" data-end=\"181\">in stock</strong> will be processed <strong data-start=\"200\" data-end=\"215\">immediately</strong> upon <strong data-start=\"221\" data-end=\"253\">confirmation of your payment</strong>. Once you complete your checkout, an <strong data-start=\"291\" data-end=\"357\">invoice will be automatically generated and sent to your email</strong>. As soon as payment is cleared against this invoice, your order will enter processing and be prepared for dispatch without delay.</p>\r\n\r\n        <h4><font color=\"#19a2be\">Need assistance?</font></h4>\r\n        <p>Email us at <strong>info@meditip.store</strong> or chat with our team online during business hours.</p>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</div>', 'Shipping and Delivery | Meditip Surgical Instruments', 'Learn about MediTip\'s shipping and delivery process. We use DHL for international delivery, with automatic VAT and shipping cost calculation at checkout. Fast, reliable, and trackable service.', 'MediTip shipping, delivery policy, DHL shipping, international delivery, medical instrument shipping, VAT calculation, shipping calculator, surgical instruments delivery, online medical store logistics', NULL, 1, NULL, '2025-08-08 08:17:12', '2025-08-08 08:17:12'),
(5, 'Payment and Financing', 'payment-and-financing', '<style>\r\n\r\n\r\n    .sidebar {\r\n      background: rgba(255, 255, 255, 0.85);\r\n      backdrop-filter: blur(8px);\r\n      border: 1px solid #d5deed;\r\n      border-radius: 16px;\r\n      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);\r\n      padding: 20px;\r\n    }\r\n\r\n    .sidebar .nav-link2 {\r\n      color: #333;\r\n      font-size: 0.95rem;\r\n     padding:10px 15px;\r\n      border-radius: 8px;\r\n      transition: 0.3s ease;\r\n    }\r\n\r\n    .sidebar .nav-link2:hover,\r\n    .sidebar .nav-link2.active {\r\n      background-color: #e0f7fa;\r\n      color: ##3bafc0;\r\n      font-weight: 500;\r\n    }\r\n\r\n    .content-box {\r\n      background: #ffffff;\r\n      padding: 2.5rem;\r\n      border-radius: 18px;\r\n      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.03);\r\n      border: 1px solid #d5deed;\r\n    }\r\n\r\n    h2 {\r\n      font-weight: 600;\r\n      font-size: 2rem;\r\n      margin-bottom: 1rem;\r\n    }\r\n\r\n    h4 {\r\n      font-size: 1.25rem;\r\n      color: #0d6efd;\r\n      margin-top: 2rem;\r\n      margin-bottom: 0.5rem;\r\n    }\r\n\r\n    .breadcrumb {\r\n      font-size: 0.85rem;\r\n    }\r\n\r\n    ul li {\r\n      margin-bottom: 6px;\r\n    }\r\n\r\n    a {\r\n      text-decoration: none;\r\n    }\r\n\r\n    @media (max-width: 768px) {\r\n      .sidebar {\r\n        margin-bottom: 1.5rem;\r\n      }\r\n    }\r\n  </style>\r\n\r\n<div class=\"container\">\r\n  <!-- Breadcrumb -->\r\n\r\n  <div class=\"row\">\r\n    <!-- Sidebar -->\r\n    <div class=\"col-md-4 col-lg-3\">\r\n      <div class=\"sidebar\">\r\n        <h6 class=\"text-center fw-bold mb-3\" style=\"text-align: center; \">Information Pages</h6>\r\n        <nav class=\"nav flex-column\" style=\"border-top:1px solid #5b5758;\">\r\n          <a class=\"nav-link2\" href=\"terms-and-condition\"><i class=\"bi bi-info-circle me-2\"></i>Terms &amp; conditions</a>\r\n         \r\n          <a class=\"nav-link2 \" href=\"shipping-and-delivery\"><i class=\"bi bi-truck me-2\"></i>Shpping &amp; Delivery</a>\r\n          <a class=\"nav-link2 \" href=\"return-and-refunds\"><i class=\"bi bi-arrow-counterclockwise me-2\"></i>Returns &amp; Refunds</a>\r\n          <a class=\"nav-link2 active\" href=\"payment-and-financing\"><i class=\"bi bi-credit-card me-2\"></i>Payment &amp; Financing</a>\r\n          \r\n            <a class=\"nav-link2\" href=\"my-account\"><i class=\"bi bi-person-circle me-2\"></i>My Account</a>\r\n          <a class=\"nav-link2\" href=\"newsletter\"><i class=\"bi bi-envelope-open me-2\"></i>Newsletter</a>\r\n\r\n          <a class=\"nav-link2\" href=\"how-to-order\"><i class=\"bi bi-cart-plus me-2\"></i>How to Order</a>\r\n         \r\n          <a class=\"nav-link2\" href=\"product-advice\"><i class=\"bi bi-patch-check me-2\"></i>Product Advice</a>\r\n          <a class=\"nav-link2\" href=\"preferred-delivery\"><i class=\"bi bi-box2-heart me-2\"></i>Preferred Delivery</a>\r\n        </nav>\r\n      </div>\r\n    </div>\r\n\r\n    <!-- Content -->\r\n    <div class=\"col-md-8 col-lg-9\">\r\n      <div class=\"content-box\">\r\n        <h2>Payment &amp; Financing</h2>\r\n        <p class=\"text-muted\">At <strong data-start=\"229\" data-end=\"261\">MediTip Surgical Instruments</strong>, we use a secure and transparent <strong data-start=\"295\" data-end=\"327\">invoice-based payment system</strong> for all orders.</p>\r\n        <hr>\r\n\r\n        <h4><font color=\"#25a0b1\">How does it work</font></h4>\r\n        <p style=\"text-align: justify; \">MediTip Surgical Instruments partners with <strong data-start=\"299\" data-end=\"314\">DHL Express</strong> for all international shipping, ensuring timely and trackable deliveries.</p>\r\n        <ul>\r\n          <li style=\"text-align: justify; \">Once you place an order, a <strong data-start=\"396\" data-end=\"416\">detailed invoice</strong> is automatically <strong data-start=\"434\" data-end=\"466\">generated and emailed to you</strong>.</li>\r\n          <li style=\"text-align: justify; \">The invoice includes your selected products, applicable <strong data-start=\"526\" data-end=\"533\">VAT</strong>, <strong data-start=\"535\" data-end=\"555\">shipping charges</strong>, and the <strong data-start=\"565\" data-end=\"589\">total payable amount</strong>.</li>\r\n          <li style=\"text-align: justify; \">Payment details (such as bank transfer instructions) are clearly mentioned on the invoice</li></ul><ul>\r\n        </ul>\r\n\r\n        <h4><font color=\"#19a2be\">Accepted Payment Methods</font></h4>\r\n        <ul><li style=\"text-align: justify;\"><strong data-start=\"720\" data-end=\"737\">Bank Transfer</strong>: All payments must be made via bank transfer to the account details provided on your invoice.</li></ul><h4><font color=\"#19a2be\">Order Processing</font></h4><ul><li style=\"text-align: justify;\">Your order will be <strong data-start=\"881\" data-end=\"906\">immediately processed</strong> as soon as your payment is confirmed.</li><li style=\"text-align: justify;\">A confirmation email will follow, and your order will be prepared for shipping via <strong data-start=\"1030\" data-end=\"1045\">DHL Express</strong>.</li></ul><h4><font color=\"#19a2be\">Currency</font></h4><ul><li style=\"text-align: justify;\">All transactions are processed in <strong data-start=\"1100\" data-end=\"1113\">Euros (€)</strong>. Please ensure that any applicable conversion or transfer fees are covered on your end.</li></ul><h4><font color=\"#25a0b1\">Financing</font></h4><ul><li style=\"text-align: justify;\">We currently <strong data-start=\"1235\" data-end=\"1283\">do not offer credit or installment financing</strong>. For bulk or institutional orders, please contact <strong data-start=\"1334\" data-end=\"1356\"><a data-start=\"1336\" data-end=\"1354\" class=\"cursor-pointer\" rel=\"noopener\"><font color=\"#311873\">info@meditip.store</font></a></strong> to discuss customized terms.</li></ul>\r\n\r\n        <h4><font color=\"#19a2be\">Need assistance?</font></h4>\r\n        <p>Email us at <strong>info@meditip.store</strong> or chat with our team online during business hours.</p>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</div>', 'Payment and Financing | Meditip Surgical Instruments', 'Learn about MediTip\'s secure invoice-based payment process. View details on bank transfers, billing, order processing, and currency used for surgical instrument orders', 'MediTip payment, invoice payment, surgical instruments, bank transfer, payment process, medical instrument billing, order invoice, VAT billing, international payment, Euro payments', NULL, 1, NULL, '2025-08-08 11:24:12', '2025-08-08 11:24:12'),
(6, 'How to Order', 'how-to-order', '<style>\r\n\r\n    .sidebar {\r\n      background: rgba(255, 255, 255, 0.85);\r\n      backdrop-filter: blur(8px);\r\n      border: 1px solid #d5deed;\r\n      border-radius: 16px;\r\n      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);\r\n      padding: 20px;\r\n    }\r\n\r\n    .sidebar .nav-link2 {\r\n      color: #333;\r\n      font-size: 0.95rem;\r\n     padding:10px 15px;\r\n      border-radius: 8px;\r\n      transition: 0.3s ease;\r\n    }\r\n\r\n    .sidebar .nav-link2:hover,\r\n    .sidebar .nav-link2.active {\r\n      background-color: #e0f7fa;\r\n      color: ##3bafc0;\r\n      font-weight: 500;\r\n    }\r\n\r\n    .content-box {\r\n      background: #ffffff;\r\n      padding: 2.5rem;\r\n      border-radius: 18px;\r\n      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.03);\r\n      border: 1px solid #d5deed;\r\n    }\r\n\r\n    h2 {\r\n      font-weight: 600;\r\n      font-size: 2rem;\r\n      margin-bottom: 1rem;\r\n    }\r\n\r\n    h4 {\r\n      font-size: 1.25rem;\r\n      color: #0d6efd;\r\n      margin-top: 2rem;\r\n      margin-bottom: 0.5rem;\r\n    }\r\n\r\n    .breadcrumb {\r\n      font-size: 0.85rem;\r\n    }\r\n\r\n    ul li {\r\n      margin-bottom: 6px;\r\n    }\r\n\r\n    a {\r\n      text-decoration: none;\r\n    }\r\n\r\n    @media (max-width: 768px) {\r\n      .sidebar {\r\n        margin-bottom: 1.5rem;\r\n      }\r\n    }\r\n  </style>\r\n\r\n<div class=\"container\">\r\n  <!-- Breadcrumb -->\r\n\r\n  <div class=\"row\">\r\n    <!-- Sidebar -->\r\n    <div class=\"col-md-4 col-lg-3\">\r\n      <div class=\"sidebar\">\r\n        <h6 class=\"text-center fw-bold mb-3\" style=\"text-align: center; \">Information Pages</h6>\r\n        <nav class=\"nav flex-column\" style=\"border-top:1px solid #5b5758;\">\r\n          <a class=\"nav-link2\" href=\"terms-and-condition\"><i class=\"bi bi-info-circle me-2\"></i>Terms &amp; conditions</a>\r\n         \r\n          <a class=\"nav-link2 \" href=\"shipping-and-delivery\"><i class=\"bi bi-truck me-2\"></i>Shpping &amp; Delivery</a>\r\n          <a class=\"nav-link2 \" href=\"return-and-refunds\"><i class=\"bi bi-arrow-counterclockwise me-2\"></i>Returns &amp; Refunds</a>\r\n          <a class=\"nav-link2\" href=\"payment-and-financing\"><i class=\"bi bi-credit-card me-2\"></i>Payment &amp; Financing</a>\r\n          \r\n            <a class=\"nav-link2\" href=\"my-account\"><i class=\"bi bi-person-circle me-2\"></i>My Account</a>\r\n          <a class=\"nav-link2\" href=\"newsletter\"><i class=\"bi bi-envelope-open me-2\"></i>Newsletter</a>\r\n\r\n          <a class=\"nav-link2 active\" href=\"how-to-order\"><i class=\"bi bi-cart-plus me-2\"></i>How to Order</a>\r\n         \r\n          <a class=\"nav-link2\" href=\"product-advice\"><i class=\"bi bi-patch-check me-2\"></i>Product Advice</a>\r\n          <a class=\"nav-link2\" href=\"preferred-delivery\"><i class=\"bi bi-box2-heart me-2\"></i>Preferred Delivery</a>\r\n        </nav>\r\n      </div>\r\n    </div>\r\n\r\n    <!-- Content -->\r\n    <div class=\"col-md-8 col-lg-9\">\r\n      <div class=\"content-box\">\r\n        <h2>How to Order from MediTip Surgical Instruments</h2>\r\n        <p class=\"text-muted\">At <strong data-start=\"229\" data-end=\"261\">MediTip Hospital Supplies</strong>, we make ordering simple, transparent, and secure.\r\nFollow these steps to place your order:</p>\r\n        <hr>\r\n\r\n        <h4><font color=\"#25a0b1\">Step 1: Browse &amp; Select Products</font></h4>\r\n        <ul>\r\n          <li style=\"text-align: justify; \">Explore our range of <strong data-start=\"376\" data-end=\"408\">premium surgical instruments</strong>.</li>\r\n          <li style=\"text-align: justify; \">Click on a product to view details, specifications, and images.</li>\r\n          <li style=\"text-align: justify; \">Select the desired quantity and <strong data-start=\"510\" data-end=\"539\">add the item to your cart</strong>.</li></ul><ul>\r\n        </ul>\r\n\r\n        <h4><font color=\"#19a2be\">Step 2: Review Your Cart</font></h4>\r\n        <ul><li style=\"text-align: justify;\">Go to the <strong data-start=\"593\" data-end=\"606\">Cart Page</strong> to check your selected items.</li><li data-start=\"637\" data-end=\"809\"><p data-start=\"639\" data-end=\"809\">Use our <strong data-start=\"647\" data-end=\"679\">built-in shipping calculator</strong> by selecting your country/region, and it will automatically calculate <strong data-start=\"747\" data-end=\"767\">shipping charges</strong>, <strong data-start=\"769\" data-end=\"776\">VAT</strong>, and display the <strong data-start=\"794\" data-end=\"808\">total bill</strong>.</p>\r\n</li>\r\n</ul><h4><font color=\"#19a2be\">Step 3: Place Your Order</font></h4><ul><li style=\"text-align: justify;\">Proceed to checkout and fill in your <strong data-start=\"889\" data-end=\"921\">billing and shipping details</strong>.</li><li style=\"text-align: justify;\">Confirm your order to receive an <strong data-start=\"958\" data-end=\"993\">automatically generated invoice</strong> via email.</li></ul><h4><font color=\"#19a2be\">Step 4: Make Payment</font></h4><ul><li style=\"text-align: justify;\">The invoice will include <strong data-start=\"1068\" data-end=\"1093\">bank transfer details</strong> for payment.</li><li style=\"text-align: justify;\">Please make the payment using the provided <strong data-start=\"1152\" data-end=\"1180\">bank account information</strong>.</li><li style=\"text-align: justify;\">Ensure to mention your <strong data-start=\"1207\" data-end=\"1225\">Invoice Number</strong> in the payment reference.</li></ul><h4><font color=\"#25a0b1\">Step 5: Order Processing &amp; Shipping</font></h4><ul><li style=\"text-align: justify;\">As soon as we receive your payment confirmation, your order will be <strong data-start=\"1373\" data-end=\"1398\">immediately processed</strong>.</li><li style=\"text-align: justify;\">Products <strong data-start=\"1411\" data-end=\"1423\">in stock</strong> are packed and shipped promptly via <strong data-start=\"1460\" data-end=\"1475\">DHL Express</strong>.</li><li style=\"text-align: justify;\">A tracking link will be sent to your email so you can follow your shipment.</li></ul>\r\n\r\n        <h4><font color=\"#19a2be\">Need assistance?</font></h4>\r\n        <p>Email us at <strong>info@meditip.store</strong> or chat with our team online during business hours.</p>\r\n      </div><strong data-start=\"229\" data-end=\"261\">\r\n    </strong></div><strong data-start=\"229\" data-end=\"261\">\r\n  </strong></div><strong data-start=\"229\" data-end=\"261\">\r\n</strong></div>', 'How to Order | Meditip Surgical Instruments', 'Learn how to order surgical instruments from MediTip. Simple steps with invoice-based payment, automatic shipping cost calculation, and fast DHL delivery.', 'how to order MediTip, invoice payment, surgical instruments order, bank transfer payment, DHL shipping, VAT calculation, medical instruments online, MediTip store, order process, payment by invoice', NULL, 1, NULL, '2025-08-09 05:04:08', '2025-08-09 05:04:08');
INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `meta_keywords`, `parent_id`, `is_published`, `publish_date`, `created_at`, `updated_at`) VALUES
(7, 'Product Advice', 'product-advice', '<style>\r\n\r\n    .sidebar {\r\n      background: rgba(255, 255, 255, 0.85);\r\n      backdrop-filter: blur(8px);\r\n      border: 1px solid #d5deed;\r\n      border-radius: 16px;\r\n      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);\r\n      padding: 20px;\r\n    }\r\n\r\n    .sidebar .nav-link2 {\r\n      color: #333;\r\n      font-size: 0.95rem;\r\n     padding:10px 15px;\r\n      border-radius: 8px;\r\n      transition: 0.3s ease;\r\n    }\r\n\r\n    .sidebar .nav-link2:hover,\r\n    .sidebar .nav-link2.active {\r\n      background-color: #e0f7fa;\r\n      color: ##3bafc0;\r\n      font-weight: 500;\r\n    }\r\n\r\n    .content-box {\r\n      background: #ffffff;\r\n      padding: 2.5rem;\r\n      border-radius: 18px;\r\n      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.03);\r\n      border: 1px solid #d5deed;\r\n    }\r\n\r\n    h2 {\r\n      font-weight: 600;\r\n      font-size: 2rem;\r\n      margin-bottom: 1rem;\r\n    }\r\n\r\n    h4 {\r\n      font-size: 1.25rem;\r\n      color: #0d6efd;\r\n      margin-top: 2rem;\r\n      margin-bottom: 0.5rem;\r\n    }\r\n\r\n    .breadcrumb {\r\n      font-size: 0.85rem;\r\n    }\r\n\r\n    ul li {\r\n      margin-bottom: 6px;\r\n    }\r\n\r\n    a {\r\n      text-decoration: none;\r\n    }\r\n\r\n    @media (max-width: 768px) {\r\n      .sidebar {\r\n        margin-bottom: 1.5rem;\r\n      }\r\n    }\r\n  </style>\r\n\r\n<div class=\"container\">\r\n  <!-- Breadcrumb -->\r\n\r\n  <div class=\"row\">\r\n    <!-- Sidebar -->\r\n    <div class=\"col-md-4 col-lg-3\">\r\n      <div class=\"sidebar\">\r\n        <h6 class=\"text-center fw-bold mb-3\" style=\"text-align: center; \">Information Pages</h6>\r\n        <nav class=\"nav flex-column\" style=\"border-top:1px solid #5b5758;\">\r\n          <a class=\"nav-link2\" href=\"terms-and-condition\"><i class=\"bi bi-info-circle me-2\"></i>Terms &amp; conditions</a>\r\n         \r\n          <a class=\"nav-link2 \" href=\"shipping-and-delivery\"><i class=\"bi bi-truck me-2\"></i>Shpping &amp; Delivery</a>\r\n          <a class=\"nav-link2 \" href=\"return-and-refunds\"><i class=\"bi bi-arrow-counterclockwise me-2\"></i>Returns &amp; Refunds</a>\r\n          <a class=\"nav-link2\" href=\"payment-and-financing\"><i class=\"bi bi-credit-card me-2\"></i>Payment &amp; Financing</a>\r\n          \r\n            <a class=\"nav-link2\" href=\"my-account\"><i class=\"bi bi-person-circle me-2\"></i>My Account</a>\r\n          <a class=\"nav-link2\" href=\"newsletter\"><i class=\"bi bi-envelope-open me-2\"></i>Newsletter</a>\r\n\r\n          <a class=\"nav-link2\" href=\"how-to-order\"><i class=\"bi bi-cart-plus me-2\"></i>How to Order</a>\r\n         \r\n          <a class=\"nav-link2 active\" href=\"product-advice\"><i class=\"bi bi-patch-check me-2\"></i>Product Advice</a>\r\n          <a class=\"nav-link2\" href=\"preferred-delivery\"><i class=\"bi bi-box2-heart me-2\"></i>Preferred Delivery</a>\r\n        </nav>\r\n      </div>\r\n    </div>\r\n\r\n    <!-- Content -->\r\n    <div class=\"col-md-8 col-lg-9\">\r\n      <div class=\"content-box\">\r\n        <h2>Product Advice</h2>\r\n        <p class=\"text-muted\">At <strong data-start=\"141\" data-end=\"173\">MediTip Surgical Instruments</strong>, we understand that selecting the right surgical tools is a crucial decision that directly impacts patient outcomes and procedural success. That’s why we provide <strong data-start=\"321\" data-end=\"362\">clear, practical, and expert guidance</strong> to help you select products that perfectly match your professional requirements.</p>\r\n        <hr>\r\n\r\n        <h4><font color=\"#25a0b1\">Why Our Advice Matters</font></h4>\r\n <p>Our industry knowledge, combined with hands-on experience, means you get more than just product listings; you get <strong data-start=\"595\" data-end=\"631\">solutions tailored to your field</strong>. Whether you are a surgeon, dentist, or healthcare provider, our recommendations are based on <strong data-start=\"726\" data-end=\"768\">precision, durability, and reliability</strong>.</p>\r\n\r\n        <h4><font color=\"#19a2be\">How We Support You</font></h4>\r\n        <ul><li style=\"text-align: justify;\"><strong data-start=\"804\" data-end=\"836\">Personalized Recommendations</strong>: We consider your specialty, preferred techniques, and budget.</li><li style=\"text-align: justify;\"><strong data-start=\"905\" data-end=\"937\">Detailed Product Information:</strong>&nbsp;Each item includes specifications, material details, and usage guidelines.</li><li style=\"text-align: justify;\"><strong data-start=\"1019\" data-end=\"1047\">Procedure-Based Guidance:</strong>&nbsp;Suggesting instruments specifically designed for your type of procedures.</li><li style=\"text-align: justify;\"><strong data-start=\"1128\" data-end=\"1148\">Maintenance Tips:</strong>&nbsp;Expert advice to extend the life and performance of your instruments.</li><li data-start=\"637\" data-end=\"809\"><p data-start=\"639\" data-end=\"809\"><strong data-start=\"1225\" data-end=\"1253\">Direct Access to Experts</strong>: Contact us via phone, live chat, or email for immediate consultation.</p></li></ul>\r\n\r\n        <h4><font color=\"#19a2be\">Need assistance?</font></h4>\r\n        <p>Please email us at <strong>info@meditip.store</strong> or chat with our team online during business hours.</p>\r\n      </div><strong data-start=\"229\" data-end=\"261\">\r\n    </strong></div><strong data-start=\"229\" data-end=\"261\">\r\n  </strong></div><strong data-start=\"229\" data-end=\"261\">\r\n</strong></div>', 'Product Advice | Meditip Surgical Instruments', 'Get professional product advice from MediTip for selecting the right surgical instruments. Expert guidance, personalized recommendations, and usage tips to help you make the best choice.', 'MediTip product advice, surgical instrument guidance, medical tools recommendation, surgical instrument tips, product consultation, medical instrument advice, surgical tools help, MediTip support', NULL, 1, NULL, '2025-08-09 07:53:53', '2025-08-09 07:53:53');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `card_number` varchar(16) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `article_number` varchar(100) NOT NULL,
  `Fabric_Type` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `details` varchar(10000) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `img2` varchar(500) NOT NULL,
  `img3` varchar(3) NOT NULL,
  `size` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `document` varchar(300) NOT NULL,
  `c_id` int(11) DEFAULT NULL,
  `parent_cat` int(11) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `color_id` int(11) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `Designing` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `article_number`, `Fabric_Type`, `name`, `description`, `details`, `image_url`, `img2`, `img3`, `size`, `price`, `document`, `c_id`, `parent_cat`, `featured`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`, `color_id`, `slug`, `Designing`) VALUES
(13, '676', '', 'Black Shirt', 'Black Shirt', 'Black Shirt', 'pictures/products/1774037219_prod2.jpg', '', '', 'M', 56.00, '', NULL, 4, 0, 'Black Shirt', 'Black Shirt', 'Black Shirt', '2026-03-20 20:06:59', '2026-03-20 20:06:59', NULL, 'black-shirt', ''),
(15, '092235', '', 'Goodie shirt', 'Goodie shirt', 'Goodie shirt', 'pictures/products/1774440037_WhatsApp Image 2026-01-05 at 22.15.09.jpeg', '', '', 'M', 56.00, '', NULL, 4, 0, 'Goodie shirt', 'Goodie shirt', 'Goodie shirt', '2026-03-25 12:00:37', '2026-03-25 12:00:37', NULL, 'goodie-shirt', ''),
(18, '09223', 'Soft Cotton', 'TO MUCH Aura', ' $data[\'article_number\'],', ' $data[\'article_number\'],', 'pictures/products/1774440781_Gemini_Generated_Image_1r3wnl1r3wnl1r3w.png', '', '', 'M', 45.00, '', NULL, 12, 1, '0', ' $data[\'article_number\'],', ' $data[\'article_number\'],', '2026-03-25 12:13:01', '2026-03-27 20:25:14', NULL, 'to-much-aura', 'Self Embroided'),
(20, '0922356', 'Soft Cotton', 'Beautiful Pink', 'something something', 'something something', 'pictures/products/1774632814_cat5.jpg', '', '', 'M', 67.00, '', NULL, 12, 0, '0', 'something something', 'something something', '2026-03-27 17:33:34', '2026-03-27 17:33:34', NULL, 'beautiful-pink', 'Self Embroided');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `reviewer_name` varchar(100) DEFAULT NULL,
  `reviewer_email` varchar(100) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vat_rates`
--

CREATE TABLE `vat_rates` (
  `id` int(11) NOT NULL,
  `country` varchar(100) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `vat_rate` decimal(5,2) NOT NULL,
  `shipping_rat` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vat_rates`
--

INSERT INTO `vat_rates` (`id`, `country`, `slug`, `vat_rate`, `shipping_rat`) VALUES
(1, 'Germany', 'germany', 0.19, 5.00),
(2, 'Austria', 'austria', 0.20, 19.10),
(3, 'Belgium', 'belgium', 0.21, 19.21),
(4, 'Bulgaria', 'bulgaria', 0.20, 19.10),
(5, 'Czech Republic', 'czech republic', 0.21, 19.28),
(6, 'Croatia', 'croatia', 0.25, 19.88),
(7, 'Cyprus', 'cyprus', 0.19, 19.00),
(8, 'Denmark', 'denmark', 0.25, 19.80),
(11, 'Estonia', 'estonis', 0.20, 19.10),
(12, 'France', 'france', 0.20, 19.16),
(13, 'Finland', 'finland', 0.24, 19.75),
(14, 'Greece', 'greece', 0.24, 19.75),
(15, 'Hungary', 'hungary', 0.27, 20.22),
(16, 'Italy', 'italy', 0.23, 19.40),
(17, 'Ireland', 'ireland', 0.23, 19.60),
(18, 'Lativa', 'lativa', 0.21, 19.28),
(19, 'Luxembourg', 'luxembourg', 0.17, 18.63),
(20, 'Malta', 'malta', 0.18, 18.60),
(21, 'Netherlands', 'netherlands', 0.21, 19.28),
(22, 'Poland', 'poland', 0.23, 19.60),
(23, 'Portugal', 'portugal', 0.23, 19.60),
(24, 'Spain', 'spain', 0.21, 19.28);

-- --------------------------------------------------------

--
-- Table structure for table `web_settings`
--

CREATE TABLE `web_settings` (
  `id` int(1) NOT NULL,
  `web_name` varchar(250) NOT NULL,
  `web_mail` varchar(150) NOT NULL,
  `web_contact` varchar(100) NOT NULL,
  `facebook` varchar(200) NOT NULL,
  `instagram` varchar(200) NOT NULL,
  `pinterest` varchar(200) NOT NULL,
  `linkdin` varchar(200) NOT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_settings`
--

INSERT INTO `web_settings` (`id`, `web_name`, `web_mail`, `web_contact`, `facebook`, `instagram`, `pinterest`, `linkdin`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
(1, 'Stitch Smart', 'stitchsmartofficiall@gmail.com', '+92 12345565', 'https://www.facebook.com/stitch-smart', 'https://www.instagram.com/stitch-smart/', 'https://pinterest.com/stitch-smart', 'www.linkedin.com', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_audit`
--
ALTER TABLE `auth_audit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `c_name` (`c_name`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token_hash` (`token_hash`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_rate_limit`
--
ALTER TABLE `otp_rate_limit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identifier` (`identifier`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_number` (`article_number`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `c_id` (`c_id`),
  ADD KEY `parent_cat` (`parent_cat`),
  ADD KEY `fk_color` (`color_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vat_rates`
--
ALTER TABLE `vat_rates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_audit`
--
ALTER TABLE `auth_audit`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1202;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4041;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `otp_rate_limit`
--
ALTER TABLE `otp_rate_limit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4038;

--
-- AUTO_INCREMENT for table `vat_rates`
--
ALTER TABLE `vat_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_audit`
--
ALTER TABLE `auth_audit`
  ADD CONSTRAINT `auth_audit_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD CONSTRAINT `email_verifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_color` FOREIGN KEY (`color_id`) REFERENCES `colors` (`color_id`),
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `category` (`c_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`parent_cat`) REFERENCES `category` (`c_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
