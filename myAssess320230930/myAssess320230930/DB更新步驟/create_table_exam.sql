-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- 主機： localhost:3306
-- 產生時間： 2023-09-30 11:49:37
-- 伺服器版本： 5.7.24
-- PHP 版本： 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫: `myassess3`
--

-- --------------------------------------------------------

--
-- 資料表結構 `exam_d`
--

DROP TABLE IF EXISTS `exam_d`;
CREATE TABLE `exam_d` (
  `id` bigint(20) NOT NULL,
  `exam_sid` varchar(50) NOT NULL,
  `questions_sid` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` bigint(20) NOT NULL,
  `sid` varchar(11) DEFAULT NULL,
  `correctValue` varchar(1) DEFAULT NULL,
  `info` text,
  `infoVideo` int(11) DEFAULT NULL,
  `keyword` varchar(20) DEFAULT NULL,
  `optionStr1` varchar(100) DEFAULT NULL,
  `optionVideo1` int(11) DEFAULT NULL,
  `optionStr2` varchar(100) DEFAULT NULL,
  `optionVideo2` int(11) DEFAULT NULL,
  `optionStr3` varchar(100) DEFAULT NULL,
  `optionVideo3` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `exam_d`
--
ALTER TABLE `exam_d`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `exam_d`
--
ALTER TABLE `exam_d`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
