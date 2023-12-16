-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-06-14 11:42:18
-- 伺服器版本： 8.0.28
-- PHP 版本： 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `db`
--
CREATE DATABASE IF NOT EXISTS `db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db`;

-- --------------------------------------------------------

--
-- 資料表結構 `sign`
--

CREATE TABLE `sign` (
  `ID` int NOT NULL COMMENT '自動編號',
  `account` varchar(64) NOT NULL COMMENT '帳號',
  `password` varchar(64) NOT NULL COMMENT '密碼',
  `name` varchar(64) NOT NULL COMMENT '姓名',
  `email` varchar(64) NOT NULL COMMENT '信箱',
  `gender` varchar(64) NOT NULL COMMENT '性別',
  `type` int NOT NULL DEFAULT '0' COMMENT '類別',
  `question` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '問題',
  `answer` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '答案',
  `picid` int NOT NULL COMMENT '頭像編號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='登入註冊';

--
-- 傾印資料表的資料 `sign`
--

INSERT INTO `sign` (`ID`, `account`, `password`, `name`, `email`, `gender`, `type`, `question`, `answer`, `picid`) VALUES
(21, 'wangwang', 'wangwang', '王老闆', 'wang@gmail.com', 'M', 1, '您的生肖？', '馬', 18),
(22, 'chenchen', 'chenchen', '陳小姐', 'chen@gmail.com', 'F', 0, '您的生肖？', '羊', 4),
(26, 'account', 'password', '測試', 'email', 'F', 1, '您的生肖？', '馬', 12);

-- --------------------------------------------------------

--
-- 資料表結構 `task`
--

CREATE TABLE `task` (
  `ID` int NOT NULL COMMENT '自動編號',
  `title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '案件名稱',
  `text` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '案件內容',
  `money` int NOT NULL COMMENT '派發稿費',
  `translator` varchar(64) NOT NULL COMMENT '負責譯者',
  `transtext` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '負責範圍',
  `transclient` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '派件客戶',
  `date1` date NOT NULL COMMENT '派件日期',
  `date2` date NOT NULL COMMENT '交件日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='案件';

--
-- 傾印資料表的資料 `task`
--

INSERT INTO `task` (`ID`, `title`, `text`, `money`, `translator`, `transtext`, `transclient`, `date1`, `date2`) VALUES
(4, 'XX公司介紹簡報', 'PTT檔案，中翻英', 250, '陳小姐', '整份PTT檔案共50頁', '王老闆', '2022-06-14', '2022-06-20');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `sign`
--
ALTER TABLE `sign`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`ID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sign`
--
ALTER TABLE `sign`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT COMMENT '自動編號', AUTO_INCREMENT=27;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `task`
--
ALTER TABLE `task`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT COMMENT '自動編號', AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
