-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 20 Eki 2019, 13:38:55
-- Sunucu sürümü: 10.1.39-MariaDB
-- PHP Sürümü: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `myexcel`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `datas`
--

CREATE TABLE `datas` (
  `id` int(11) NOT NULL,
  `rNo` int(11) NOT NULL,
  `cNo` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `data` varchar(40) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `datas`
--

INSERT INTO `datas` (`id`, `rNo`, `cNo`, `s_id`, `data`) VALUES
(499, 1, 1, 68, '4'),
(502, 2, 1, 68, '4');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `files`
--

CREATE TABLE `files` (
  `f_id` int(11) NOT NULL,
  `f_name` text COLLATE utf8_turkish_ci NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `files`
--

INSERT INTO `files` (`f_id`, `f_name`, `create_date`, `update_date`) VALUES
(14, 'file5', '2019-10-19 15:05:43', '2019-10-20'),
(15, 'file6', '2019-10-19 15:11:43', '0000-00-00'),
(16, 'file7', '2019-10-19 15:11:48', '2019-10-19'),
(17, 'file10', '2019-10-19 15:18:48', '0000-00-00'),
(18, 'fdsf', '2019-10-19 19:09:41', '0000-00-00'),
(19, 'fdsf', '2019-10-19 19:09:41', '0000-00-00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sheets`
--

CREATE TABLE `sheets` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `f_id` int(11) NOT NULL,
  `maxRow` int(11) NOT NULL,
  `maxColumn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `sheets`
--

INSERT INTO `sheets` (`s_id`, `s_name`, `f_id`, `maxRow`, `maxColumn`) VALUES
(66, 'shet2', 14, 5, 5),
(67, 'shet3', 14, 6, 4),
(68, 'shet4', 14, 5, 5);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `datas`
--
ALTER TABLE `datas`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`f_id`);

--
-- Tablo için indeksler `sheets`
--
ALTER TABLE `sheets`
  ADD PRIMARY KEY (`s_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `datas`
--
ALTER TABLE `datas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=503;

--
-- Tablo için AUTO_INCREMENT değeri `files`
--
ALTER TABLE `files`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `sheets`
--
ALTER TABLE `sheets`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
