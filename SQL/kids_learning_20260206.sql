-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2026 at 08:39 PM
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
-- Database: `kids_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `content_link` varchar(255) DEFAULT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `category`, `thumbnail`, `content_link`, `description`, `created_at`) VALUES
(1, 'อุณหภูมิ', 'วิทยาศาสตร์', '1770308177_temp.jpg', 'temp.php', '', '2026-02-05 16:16:17'),
(2, 'เรียนรู้เรื่องเวลา', 'คณิตศาสตร์', '1770309179_clock_full.jpg', 'clock-page.php', 'เรียนรู้เรื่องเวลา', '2026-02-05 16:20:39'),
(3, 'ของแข็ง vs ของเหลว', 'วิทยาศาสตร์', '1770312622_Learn_img_state_fuid.jpg', 'states-of-matter.php', '', '2026-02-05 17:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT 1,
  `total_stars` int(11) DEFAULT 0,
  `lessons_completed` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_progress`
--

INSERT INTO `user_progress` (`id`, `user_id`, `total_stars`, `lessons_completed`) VALUES
(1, 1, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `worksheets`
--

CREATE TABLE `worksheets` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT 'ชื่อหัวข้อใบงาน',
  `preview_image` varchar(255) NOT NULL COMMENT 'ชื่อไฟล์รูปตัวอย่าง (เก็บใน uploads/previews/)',
  `file_path` varchar(255) NOT NULL COMMENT 'ชื่อไฟล์เอกสาร PDF (เก็บใน uploads/files/)',
  `pdf_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `download_count` int(11) DEFAULT 0 COMMENT 'จำนวนครั้งที่ถูกดาวน์โหลด',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่อัปโหลด',
  `is_premium` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `worksheets`
--

INSERT INTO `worksheets` (`id`, `title`, `preview_image`, `file_path`, `pdf_file`, `download_count`, `created_at`, `is_premium`) VALUES
(1, 'การบอกเวลา', '1770315822_clock_worksheet.jpg', '1770315822_clock_worksheet_pdf.pdf', NULL, 8, '2026-02-05 18:23:42', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worksheets`
--
ALTER TABLE `worksheets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `worksheets`
--
ALTER TABLE `worksheets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
