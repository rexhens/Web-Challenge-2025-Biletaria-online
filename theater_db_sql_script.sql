-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 08:33 PM
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
-- Database: `theater_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `actors`
--

CREATE TABLE `actors` (
  `id` int(20) NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(30) NOT NULL,
  `birthday` date NOT NULL,
  `description` text NOT NULL,
  `poster` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `actors`
--

INSERT INTO `actors` (`id`, `name`, `email`, `birthday`, `description`, `poster`) VALUES
(4, 'Olta Daku', 'olta@test.com', '1976-12-01', 'Olta ka studiuar flaut dhe kanto në Liceun Artistik, por në vitin 1997 ajo ndjek studimet e larta për aktore dhe diplomohet në aktrim nën drejtimin e aktorit dhe pedagogut të saj, Mario Ashiku në 2001-shin. Në vitin 2003, ajo emërohet aktore e Teatrit Kombëtar. [1] Rrjedh nga një familje muzikantësh. Mamaja e saj është Xhovana Daku, mexosoprano, dhe babai i saj është Kristo Daku, pedagog i klarinetës në Akademinë e Arteve.', 'C:/xampp/htdocs/biletaria_online/assets/img/actors/poster_680ea44db7a269.41694025views.webp'),
(5, 'Ermal Mamaqi', 'ermal@test.com', '1982-03-21', 'Ermal Mamaqi është lindur më 21 mars 1982 është aktor, humorist, këngëtar, DJ dhe prezantues.\r\nMamaqi shkëputet nga spektakli', 'C:/xampp/htdocs/biletaria_online/assets/img/actors/poster_680ea46166acf6.78336176views.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `hall` varchar(20) NOT NULL,
  `time` time NOT NULL,
  `poster` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `trailer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `hall`, `time`, `poster`, `price`, `trailer`) VALUES
(3, 'MetroFest', 'Për të pestin vit me radhë, Teatri Metropol organizon festivalin dedikuar veprës shqiptare të arkivit. Puna për realizim ka nisur në muajin tetor, ndërsa muaji nëntor do të jetë muaji në të cilin do të nisë premiera e pare dhe data 9 dhjetor do të jetë mbyllja e këtij realizimi që i përket trashëgimisë dramatike, teatrit dhe edukimit.\r\nNë këtë edicion janë përzgjedhur për t’u vendosur në skenë larmi tekstesh që i përkasin viteve 1900 dhe jo vetëm: në datën 4-7 nëntor 2021, ora 19:00 do të shfaqet “Kapterr Behari” me autor dhe regji nga Stefan Çapaliku; 11-14 nëntor 2021, ora 19:00, komedia zbavitëse “Luloja” botuar më 1922 nga Dhori Kote e në regjinë e Blendi Arifit; 18- 21 nëntor 2021, ora 19:00 do të jetë shfaqje përshëndetëse komedia “Sot tetë ditë” me autor Josip Relën në 1932 dhe regji nga Elona Hyseni; Në datat 25-28 nëntor 2021 do të prezantohet ajo që njihet si drama e parë e absurdit në shqip “Gof” me autor Anton Pashku dhe përpunim tekstor dhe regjia nga Shkëlzen Berisha; në data 4-5 dhjetor 2021 do të jetë një ekspozitë e pikturës dhe shfaqja e monodramës me titull “Duan të fluturojnë” e autorit Lekë Tasi, në regjinë e Klesta Sheros; Ndërsa pikëtakimi final i këtij edicioni do të jetë në datën 9 dhjetor 2021 me prezantimin e krijuar në punë laboratorike të skicës dramatike “Roli i Lule-Borës” botuar në 1932 me regji nga Sonila Kapidani dhe koreograf Erdet Miraka. Një tryezë bisedë do të zhvillohet mbi Zërin, Praninë dhe Lëvizjen në punën e aktorit.\r\n\r\nImagjinoni ç’mund të ndodhë nëse takohen autorë të një kohe më të vjetër dhe krijues të rinj me një mori spektatorësh teatri që argëtohen dhe mbështesin … emocionohen, reflektojnë, shkëmbejnë të qeshura, lot, ide, bashkëndajnë njerëzillëk dhe premtojnë vazhdimësi!\r\nLajmëroni miqtë, ju mirëpresim!\r\n\r\n4 Nëntor – 9 Dhjetor 2021 në Teatri Metropol – Qendra Kulturore Tirana\r\n\r\nInfo & Rezervime\r\n☎️ +355 67 227 0668\r\n\r\n#metrofest #teatrimetropol\r\n\r\nGjatë këtyre pesë viteve janë lexuar rreth 70 vepra shqiptare të arkivit që kanë qenë kryesisht të njohura si letërsi dramatike dhe janë vënë në skenë 20 prej tyre, të shkruara nga autorët Martin Camaj, Ernest Koliqi, Shpëtim Gina, Kristo Floqi, Lazër Lumezi, Halil Laze, Milo Duçi, At Zef Pllumi, Lumo Skëndo, Minush Jero, Jeronim De Rada, Kristë Berisha, etj. Në këto 5 vite janë angazhuar 115 artistë nga të gjitha brezat; janë tashmë dy pamje të teksteve – origjinali dhe përpunimet; janë bërë disa programe si vazhdimësi në shkolla për të rinjtë që të njihen me\r\ntrashëgiminë tonë dramatike si edhe është bërë një botim nga tryeza e rrumbullakët.', 'Bodrum', '19:00:00', 'C:/xampp/htdocs/biletaria_online/assets/img/events/poster_680d05e97c7b53.97042460viewspng', 900, 'https://www.youtube.com/watch?v=Jek-mbP7EKc');

-- --------------------------------------------------------

--
-- Table structure for table `event_dates`
--

CREATE TABLE `event_dates` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_dates`
--

INSERT INTO `event_dates` (`id`, `event_id`, `event_date`) VALUES
(125, 3, '2025-04-11'),
(126, 3, '2025-04-12'),
(127, 3, '2025-04-29'),
(128, 3, '2025-05-15'),
(129, 3, '2025-05-18'),
(130, 3, '2025-05-19');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `genre_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `genre_name`) VALUES
(1, 'Komedi'),
(2, 'Dramë'),
(3, 'Tragjedi'),
(4, 'Teatër për fëmijë'),
(11, 'Melodramë'),
(12, 'Satirë'),
(13, 'Monodramë'),
(14, 'Muzikal'),
(15, 'Absurd'),
(16, 'Tragjikomedi'),
(17, 'Pantomimë'),
(18, 'Teatër eksperimental'),
(19, 'Teatër fizik'),
(20, 'Teatër politik'),
(21, 'Teatër kukullash'),
(22, 'Teatër improvizues'),
(23, 'Teatër bashkëkohor'),
(24, 'Teatër klasik'),
(25, 'Monolog'),
(26, 'Performancë live'),
(27, 'Teatër muzikor'),
(28, 'Teatër dokumentar');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `show_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `hall` varchar(20) NOT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `ticket_code` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `show_date` date NOT NULL,
  `show_time` time NOT NULL,
  `total_price` int(11) NOT NULL DEFAULT 0,
  `online` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `show_id`, `event_id`, `full_name`, `email`, `phone`, `created_at`, `hall`, `seat_id`, `ticket_code`, `expires_at`, `paid`, `show_date`, `show_time`, `total_price`, `online`) VALUES
(4, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-12 09:01:28', 'Çehov', 212, '21e7aecd9878fe36', '2025-05-13 09:01:28', 0, '2025-04-15', '19:00:00', 900, 0),
(5, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-12 09:01:28', 'Çehov', 219, 'a8ffbdad6ea1d837', '2025-05-13 19:01:28', 0, '2025-04-15', '19:00:00', 900, 0),
(6, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-12 09:01:28', 'Çehov', 220, '3061f2c8992c8448', '2025-05-13 09:01:28', 1, '2025-04-15', '19:00:00', 900, 0),
(7, 13, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-12 09:05:02', 'Shakespare', 1, 'eb3d0a0a249d1b0f', '2025-05-13 19:05:02', 0, '2025-05-23', '19:00:00', 900, 0),
(8, 13, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-12 09:05:02', 'Shakespare', 2, '00f589392b464027', '2025-05-13 09:05:02', 0, '2025-05-23', '19:00:00', 900, 0),
(9, 13, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '+355 68 31 63 980', '2025-05-12 09:06:38', 'Shakespare', 3, '789b8816a0a6d3eb', '2025-05-13 09:06:38', 0, '2025-05-23', '19:00:00', 900, 0),
(10, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '+355 68 31 63 980', '2025-05-12 09:18:39', 'Çehov', 218, '4729d34ca8cbbd33', '2025-05-13 09:18:39', 1, '2025-05-19', '19:00:00', 900, 0),
(11, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '+355 68 31 63 980', '2025-05-12 09:18:39', 'Çehov', 219, '7d70538f634d13fe', '2025-05-13 09:18:39', 1, '2025-05-19', '19:00:00', 900, 0),
(12, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '+355 68 31 63 980', '2025-05-12 09:18:39', 'Çehov', 220, 'fd978f6a717835a0', '2025-05-13 09:18:39', 1, '2025-05-19', '19:00:00', 900, 0),
(13, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-13 11:40:05', 'Çehov', 41, 'c0465b701733c3d4', '2025-05-14 11:40:05', 0, '2025-05-18', '19:00:00', 900, 0),
(14, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-13 11:40:05', 'Çehov', 42, '946693cd199973a2', '2025-05-14 11:40:05', 0, '2025-05-18', '19:00:00', 900, 0),
(15, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-13 11:40:05', 'Çehov', 43, 'a916a10ce10dc01d', '2025-05-14 11:40:05', 0, '2025-05-18', '19:00:00', 900, 0),
(16, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-13 11:48:19', 'Çehov', 57, 'ef67714afefcbfc6', '2025-05-14 11:48:19', 0, '2025-05-18', '19:00:00', 900, 0),
(17, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-13 11:48:19', 'Çehov', 58, '88527c4318b187b4', '2025-05-14 11:48:19', 0, '2025-05-18', '19:00:00', 900, 0),
(18, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-13 11:49:25', 'Çehov', 27, '72171b3337d68eb7', '2025-05-14 11:49:25', 0, '2025-05-18', '19:00:00', 900, 0),
(20, 13, NULL, 'Blevis Allushi', 'blevis.alluashi@gmail.com', '0673323332', '2025-05-13 13:50:44', 'Shakespare', 8, 'bf7f0a8d423cbc81', '2025-05-14 13:50:44', 0, '2025-05-16', '19:00:00', 900, 1),
(21, 13, NULL, 'Blevis Allushi', 'blevis.alluashi@gmail.com', '0673323332', '2025-05-13 13:50:44', 'Shakespare', 9, 'e130b8d5f391b073', '2025-05-14 13:50:44', 0, '2025-05-16', '19:00:00', 900, 1),
(22, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-13 19:41:27', 'Çehov', 74, 'e78d7ac729b12280', '2025-05-14 19:41:27', 0, '2025-05-18', '19:00:00', 900, 0),
(23, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-13 19:41:27', 'Çehov', 75, 'bcb3421e70376d4a', '2025-05-14 19:41:27', 0, '2025-05-18', '19:00:00', 900, 0),
(26, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-13 21:05:17', 'Çehov', 42, '5699f94308a204b7', '2025-05-14 21:05:17', 0, '2025-05-19', '19:00:00', 900, 0),
(27, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-13 21:05:17', 'Çehov', 43, '75d8013af9d11c55', '2025-05-14 21:05:17', 0, '2025-05-19', '19:00:00', 900, 0),
(28, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-13 21:05:17', 'Çehov', 44, 'afaaf313891ffa60', '2025-05-14 21:05:17', 0, '2025-05-19', '19:00:00', 900, 0),
(29, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-14 10:40:43', 'Çehov', 22, 'ddbd214d5e9a7577', '2025-05-15 10:40:43', 0, '2025-05-19', '19:00:00', 900, 0),
(30, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-14 10:40:43', 'Çehov', 23, 'e4fda8d046a9374c', '2025-05-15 10:40:43', 0, '2025-05-19', '19:00:00', 900, 0),
(31, 12, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-14 10:40:43', 'Çehov', 24, '9c5314156dce1bc9', '2025-05-15 10:40:43', 0, '2025-05-19', '19:00:00', 900, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `show_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `hall` varchar(50) NOT NULL,
  `row_number` varchar(10) NOT NULL,
  `seat_number` int(11) NOT NULL,
  `seat_type` varchar(20) DEFAULT 'standard'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `hall`, `row_number`, `seat_number`, `seat_type`) VALUES
(1, 'shakespare', 'A', 1, 'standard'),
(2, 'shakespare', 'A', 2, 'standard'),
(3, 'shakespare', 'A', 3, 'standard'),
(4, 'shakespare', 'A', 4, 'standard'),
(5, 'shakespare', 'A', 5, 'standard'),
(6, 'shakespare', 'A', 6, 'standard'),
(7, 'shakespare', 'A', 7, 'standard'),
(8, 'shakespare', 'A', 8, 'standard'),
(9, 'shakespare', 'A', 9, 'standard'),
(10, 'shakespare', 'A', 10, 'standard'),
(11, 'shakespare', 'A', 11, 'standard'),
(12, 'shakespare', 'A', 12, 'standard'),
(13, 'shakespare', 'A', 13, 'standard'),
(14, 'shakespare', 'A', 14, 'standard'),
(15, 'shakespare', 'A', 15, 'standard'),
(16, 'shakespare', 'A', 16, 'standard'),
(17, 'shakespare', 'A', 17, 'standard'),
(18, 'shakespare', 'A', 18, 'standard'),
(19, 'shakespare', 'A', 19, 'standard'),
(20, 'shakespare', 'A', 20, 'standard'),
(21, 'shakespare', 'A', 21, 'standard'),
(22, 'shakespare', 'A', 22, 'standard'),
(23, 'shakespare', 'A', 23, 'standard'),
(24, 'shakespare', 'A', 24, 'standard'),
(25, 'shakespare', 'A', 25, 'standard'),
(26, 'shakespare', 'A', 26, 'standard'),
(27, 'shakespare', 'B', 27, 'standard'),
(28, 'shakespare', 'B', 28, 'standard'),
(29, 'shakespare', 'B', 29, 'standard'),
(30, 'shakespare', 'B', 30, 'standard'),
(31, 'shakespare', 'B', 31, 'standard'),
(32, 'shakespare', 'B', 32, 'standard'),
(33, 'shakespare', 'B', 33, 'standard'),
(34, 'shakespare', 'B', 34, 'standard'),
(35, 'shakespare', 'B', 35, 'standard'),
(36, 'shakespare', 'B', 36, 'standard'),
(37, 'shakespare', 'B', 37, 'standard'),
(38, 'shakespare', 'B', 38, 'standard'),
(39, 'shakespare', 'B', 39, 'standard'),
(40, 'shakespare', 'B', 40, 'standard'),
(41, 'shakespare', 'B', 41, 'standard'),
(42, 'shakespare', 'B', 42, 'standard'),
(43, 'shakespare', 'B', 43, 'standard'),
(44, 'shakespare', 'B', 44, 'standard'),
(45, 'shakespare', 'B', 45, 'standard'),
(46, 'shakespare', 'B', 46, 'standard'),
(47, 'shakespare', 'B', 47, 'standard'),
(48, 'shakespare', 'B', 48, 'standard'),
(49, 'shakespare', 'B', 49, 'standard'),
(50, 'shakespare', 'B', 50, 'standard'),
(51, 'shakespare', 'B', 51, 'standard'),
(52, 'shakespare', 'B', 52, 'standard'),
(53, 'shakespare', 'B', 53, 'standard'),
(54, 'shakespare', 'B', 54, 'standard'),
(55, 'shakespare', 'B', 55, 'standard'),
(56, 'shakespare', 'C', 56, 'standard'),
(57, 'shakespare', 'C', 57, 'standard'),
(58, 'shakespare', 'C', 58, 'standard'),
(59, 'shakespare', 'C', 59, 'standard'),
(60, 'shakespare', 'C', 60, 'standard'),
(61, 'shakespare', 'C', 61, 'standard'),
(62, 'shakespare', 'C', 62, 'standard'),
(63, 'shakespare', 'C', 63, 'standard'),
(64, 'shakespare', 'C', 64, 'standard'),
(65, 'shakespare', 'C', 65, 'standard'),
(66, 'shakespare', 'C', 66, 'standard'),
(67, 'shakespare', 'C', 67, 'standard'),
(68, 'shakespare', 'C', 68, 'standard'),
(69, 'shakespare', 'C', 69, 'standard'),
(70, 'shakespare', 'C', 70, 'standard'),
(71, 'shakespare', 'C', 71, 'standard'),
(72, 'shakespare', 'C', 72, 'standard'),
(73, 'shakespare', 'C', 73, 'standard'),
(74, 'shakespare', 'C', 74, 'standard'),
(75, 'shakespare', 'C', 75, 'standard'),
(76, 'shakespare', 'C', 76, 'standard'),
(77, 'shakespare', 'C', 77, 'standard'),
(78, 'shakespare', 'C', 78, 'standard'),
(79, 'shakespare', 'C', 79, 'standard'),
(80, 'shakespare', 'C', 80, 'standard'),
(81, 'shakespare', 'C', 81, 'standard'),
(82, 'shakespare', 'C', 82, 'standard'),
(83, 'shakespare', 'C', 83, 'standard'),
(84, 'shakespare', 'C', 84, 'standard'),
(85, 'shakespare', 'C', 85, 'standard'),
(86, 'shakespare', 'C', 86, 'standard'),
(87, 'shakespare', 'C', 87, 'standard'),
(88, 'shakespare', 'C', 88, 'standard'),
(89, 'shakespare', 'C', 89, 'standard'),
(90, 'shakespare', 'C', 90, 'standard'),
(91, 'shakespare', 'D', 91, 'standard'),
(92, 'shakespare', 'D', 92, 'standard'),
(93, 'shakespare', 'D', 93, 'standard'),
(94, 'shakespare', 'D', 94, 'standard'),
(95, 'shakespare', 'D', 95, 'standard'),
(96, 'shakespare', 'D', 96, 'standard'),
(97, 'shakespare', 'D', 97, 'standard'),
(98, 'shakespare', 'D', 98, 'standard'),
(99, 'shakespare', 'D', 99, 'standard'),
(100, 'shakespare', 'D', 100, 'standard'),
(101, 'shakespare', 'D', 101, 'standard'),
(102, 'shakespare', 'D', 102, 'standard'),
(103, 'shakespare', 'D', 103, 'standard'),
(104, 'shakespare', 'D', 104, 'standard'),
(105, 'shakespare', 'D', 105, 'standard'),
(106, 'shakespare', 'D', 106, 'standard'),
(107, 'shakespare', 'D', 107, 'standard'),
(108, 'shakespare', 'E', 108, 'standard'),
(109, 'shakespare', 'E', 109, 'standard'),
(110, 'shakespare', 'E', 110, 'standard'),
(111, 'shakespare', 'E', 111, 'standard'),
(112, 'shakespare', 'E', 112, 'standard'),
(113, 'shakespare', 'E', 113, 'standard'),
(114, 'shakespare', 'E', 114, 'standard'),
(115, 'shakespare', 'E', 115, 'standard'),
(116, 'shakespare', 'E', 116, 'standard'),
(117, 'shakespare', 'E', 117, 'standard'),
(118, 'shakespare', 'E', 118, 'standard'),
(119, 'shakespare', 'E', 119, 'standard'),
(120, 'shakespare', 'E', 120, 'standard'),
(121, 'shakespare', 'E', 121, 'standard'),
(122, 'shakespare', 'E', 122, 'standard'),
(123, 'shakespare', 'E', 123, 'standard'),
(124, 'shakespare', 'E', 124, 'standard'),
(125, 'shakespare', 'E', 125, 'standard'),
(126, 'shakespare', 'E', 126, 'standard'),
(127, 'shakespare', 'F', 127, 'standard'),
(128, 'shakespare', 'F', 128, 'standard'),
(129, 'shakespare', 'F', 129, 'standard'),
(130, 'shakespare', 'F', 130, 'standard'),
(131, 'shakespare', 'F', 131, 'standard'),
(132, 'shakespare', 'F', 132, 'standard'),
(133, 'shakespare', 'F', 133, 'standard'),
(134, 'shakespare', 'F', 134, 'standard'),
(135, 'shakespare', 'F', 135, 'standard'),
(136, 'shakespare', 'F', 136, 'standard'),
(137, 'shakespare', 'F', 137, 'standard'),
(138, 'shakespare', 'F', 138, 'standard'),
(139, 'shakespare', 'F', 139, 'standard'),
(140, 'shakespare', 'F', 140, 'standard'),
(141, 'shakespare', 'F', 141, 'standard'),
(142, 'shakespare', 'F', 142, 'standard'),
(143, 'shakespare', 'F', 143, 'standard'),
(144, 'shakespare', 'F', 144, 'standard'),
(145, 'shakespare', 'F', 145, 'standard'),
(146, 'shakespare', 'F', 146, 'standard'),
(147, 'shakespare', 'F', 147, 'standard'),
(148, 'shakespare', 'F', 148, 'standard'),
(149, 'shakespare', 'F', 149, 'standard'),
(150, 'shakespare', 'F', 150, 'standard'),
(151, 'shakespare', 'F', 151, 'standard'),
(152, 'shakespare', 'F', 152, 'standard'),
(153, 'shakespare', 'F', 153, 'standard'),
(154, 'shakespare', 'F', 154, 'standard'),
(155, 'shakespare', 'F', 155, 'standard'),
(156, 'shakespare', 'F', 156, 'standard'),
(157, 'shakespare', 'F', 157, 'standard'),
(158, 'shakespare', 'G', 158, 'standard'),
(159, 'shakespare', 'G', 159, 'standard'),
(160, 'shakespare', 'G', 160, 'standard'),
(161, 'shakespare', 'G', 161, 'standard'),
(162, 'shakespare', 'G', 162, 'standard'),
(163, 'shakespare', 'G', 163, 'standard'),
(164, 'shakespare', 'G', 164, 'standard'),
(165, 'shakespare', 'G', 165, 'standard'),
(166, 'shakespare', 'G', 166, 'standard'),
(167, 'shakespare', 'G', 167, 'standard'),
(168, 'shakespare', 'G', 168, 'standard'),
(169, 'shakespare', 'G', 169, 'standard'),
(170, 'shakespare', 'G', 170, 'standard'),
(171, 'shakespare', 'G', 171, 'standard'),
(172, 'shakespare', 'G', 172, 'standard'),
(173, 'shakespare', 'G', 173, 'standard'),
(174, 'shakespare', 'G', 174, 'standard'),
(175, 'shakespare', 'G', 175, 'standard'),
(176, 'shakespare', 'G', 176, 'standard'),
(177, 'shakespare', 'G', 177, 'standard'),
(178, 'shakespare', 'G', 178, 'standard'),
(179, 'shakespare', 'G', 179, 'standard'),
(180, 'shakespare', 'G', 180, 'standard'),
(181, 'shakespare', 'G', 181, 'standard'),
(182, 'shakespare', 'G', 182, 'standard'),
(183, 'shakespare', 'G', 183, 'standard'),
(184, 'shakespare', 'G', 184, 'standard'),
(185, 'shakespare', 'G', 185, 'standard'),
(186, 'shakespare', 'G', 186, 'standard'),
(187, 'shakespare', 'G', 187, 'standard'),
(188, 'shakespare', 'H', 188, 'standard'),
(189, 'shakespare', 'H', 189, 'standard'),
(190, 'shakespare', 'H', 190, 'standard'),
(191, 'shakespare', 'H', 191, 'standard'),
(192, 'shakespare', 'H', 192, 'standard'),
(193, 'shakespare', 'H', 193, 'standard'),
(194, 'shakespare', 'H', 194, 'standard'),
(195, 'shakespare', 'H', 195, 'standard'),
(196, 'shakespare', 'H', 196, 'standard'),
(197, 'shakespare', 'H', 197, 'standard'),
(198, 'shakespare', 'H', 198, 'standard'),
(199, 'shakespare', 'H', 199, 'standard'),
(200, 'shakespare', 'H', 200, 'standard'),
(201, 'shakespare', 'H', 201, 'standard'),
(202, 'shakespare', 'H', 202, 'standard'),
(203, 'shakespare', 'H', 203, 'standard'),
(204, 'shakespare', 'H', 204, 'standard'),
(205, 'shakespare', 'H', 205, 'standard'),
(206, 'shakespare', 'H', 206, 'standard'),
(207, 'shakespare', 'H', 207, 'standard'),
(208, 'shakespare', 'H', 208, 'standard'),
(209, 'shakespare', 'H', 209, 'standard'),
(210, 'shakespare', 'H', 210, 'standard'),
(211, 'shakespare', 'H', 211, 'standard'),
(212, 'shakespare', 'H', 212, 'standard'),
(213, 'cehov', 'A', 1, 'standard'),
(214, 'cehov', 'A', 2, 'standard'),
(215, 'cehov', 'A', 3, 'standard'),
(216, 'cehov', 'A', 4, 'standard'),
(217, 'cehov', 'A', 5, 'standard'),
(218, 'cehov', 'A', 6, 'standard'),
(219, 'cehov', 'A', 7, 'standard'),
(220, 'cehov', 'A', 8, 'standard'),
(221, 'cehov', 'A', 9, 'standard'),
(222, 'cehov', 'A', 10, 'standard'),
(223, 'cehov', 'A', 11, 'standard'),
(224, 'cehov', 'A', 12, 'standard'),
(225, 'cehov', 'A', 13, 'standard'),
(226, 'cehov', 'A', 14, 'standard'),
(227, 'cehov', 'A', 15, 'standard'),
(228, 'cehov', 'A', 16, 'standard'),
(229, 'cehov', 'A', 17, 'standard'),
(230, 'cehov', 'B', 18, 'standard'),
(231, 'cehov', 'B', 19, 'standard'),
(232, 'cehov', 'B', 20, 'standard'),
(233, 'cehov', 'B', 21, 'standard'),
(234, 'cehov', 'B', 22, 'standard'),
(235, 'cehov', 'B', 23, 'standard'),
(236, 'cehov', 'B', 24, 'standard'),
(237, 'cehov', 'B', 25, 'standard'),
(238, 'cehov', 'B', 26, 'standard'),
(239, 'cehov', 'B', 27, 'standard'),
(240, 'cehov', 'B', 28, 'standard'),
(241, 'cehov', 'B', 29, 'standard'),
(242, 'cehov', 'B', 30, 'standard'),
(243, 'cehov', 'B', 31, 'standard'),
(244, 'cehov', 'B', 32, 'standard'),
(245, 'cehov', 'B', 33, 'standard'),
(246, 'cehov', 'B', 34, 'standard'),
(247, 'cehov', 'C', 35, 'standard'),
(248, 'cehov', 'C', 36, 'standard'),
(249, 'cehov', 'C', 37, 'standard'),
(250, 'cehov', 'C', 38, 'standard'),
(251, 'cehov', 'C', 39, 'standard'),
(252, 'cehov', 'C', 40, 'standard'),
(253, 'cehov', 'C', 41, 'standard'),
(254, 'cehov', 'C', 42, 'standard'),
(255, 'cehov', 'C', 43, 'standard'),
(256, 'cehov', 'C', 44, 'standard'),
(257, 'cehov', 'C', 45, 'standard'),
(258, 'cehov', 'C', 46, 'standard'),
(259, 'cehov', 'C', 47, 'standard'),
(260, 'cehov', 'C', 48, 'standard'),
(261, 'cehov', 'C', 49, 'standard'),
(262, 'cehov', 'C', 50, 'standard'),
(263, 'cehov', 'D', 51, 'standard'),
(264, 'cehov', 'D', 52, 'standard'),
(265, 'cehov', 'D', 53, 'standard'),
(266, 'cehov', 'D', 54, 'standard'),
(267, 'cehov', 'D', 55, 'standard'),
(268, 'cehov', 'D', 56, 'standard'),
(269, 'cehov', 'D', 57, 'standard'),
(270, 'cehov', 'D', 58, 'standard'),
(271, 'cehov', 'D', 59, 'standard'),
(272, 'cehov', 'D', 60, 'standard'),
(273, 'cehov', 'D', 61, 'standard'),
(274, 'cehov', 'D', 62, 'standard'),
(275, 'cehov', 'D', 63, 'standard'),
(276, 'cehov', 'D', 64, 'standard'),
(277, 'cehov', 'D', 65, 'standard'),
(278, 'cehov', 'D', 66, 'standard'),
(279, 'cehov', 'E', 67, 'standard'),
(280, 'cehov', 'E', 68, 'standard'),
(281, 'cehov', 'E', 69, 'standard'),
(282, 'cehov', 'E', 70, 'standard'),
(283, 'cehov', 'E', 71, 'standard'),
(284, 'cehov', 'E', 72, 'standard'),
(285, 'cehov', 'E', 73, 'standard'),
(286, 'cehov', 'E', 74, 'standard'),
(287, 'cehov', 'E', 75, 'standard'),
(288, 'cehov', 'E', 76, 'standard'),
(289, 'cehov', 'E', 77, 'standard'),
(290, 'cehov', 'E', 78, 'standard'),
(291, 'cehov', 'E', 79, 'standard'),
(292, 'cehov', 'E', 80, 'standard'),
(293, 'cehov', 'E', 81, 'standard'),
(294, 'cehov', 'E', 82, 'standard'),
(295, 'cehov', 'E', 83, 'standard'),
(296, 'cehov', 'E', 84, 'standard'),
(297, 'cehov', 'F', 85, 'standard'),
(298, 'cehov', 'F', 86, 'standard'),
(299, 'cehov', 'F', 87, 'standard'),
(300, 'cehov', 'F', 88, 'standard'),
(301, 'cehov', 'F', 89, 'standard'),
(302, 'cehov', 'F', 90, 'standard'),
(303, 'cehov', 'F', 91, 'standard'),
(304, 'cehov', 'F', 92, 'standard'),
(305, 'cehov', 'F', 93, 'standard'),
(306, 'cehov', 'F', 94, 'standard'),
(307, 'cehov', 'F', 95, 'standard'),
(308, 'cehov', 'F', 96, 'standard'),
(309, 'cehov', 'F', 97, 'standard'),
(310, 'cehov', 'F', 98, 'standard'),
(311, 'cehov', 'F', 99, 'standard'),
(312, 'cehov', 'F', 100, 'standard');

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE `shows` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `time` time NOT NULL,
  `hall` varchar(50) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `trailer` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `validity_days` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`id`, `title`, `description`, `time`, `hall`, `genre_id`, `poster`, `trailer`, `price`, `validity_days`) VALUES
(11, 'Mbreti Lir', '“Mbreti Lir” një nga tragjeditë më të mëdha të Uilliam Shekspir, do të ngjitet së shpejti në skenën e Teatrit Metropol, si premiera e cila do të çelë sezonin e ri artistik. Me regjinë e Jonida Beqos dhe një kast fantastik aktorësh, fundjavën e fundit të shtatorit dhe gjatë gjithë muajit tetor do të keni mundësinë të shihni një produksion jashtë të zakonshmes.\r\n“Mbreti Lir” është një histori e dy familjeve jofunksionale, me dinamika të ndryshme, të cilat shumë prej nesh mund t’i njohin nga afër. Po çfarë e shtyn një mbret të qëndrojë përballë tre vajzave të tij dhe të pyesë se kush e do më shumë?! Çfarë e mirë mund të ndodhë kur Mbreti është i çmendur dhe budallai është i mençur?! Kur njerëzit e ndershëm ndëshkohen dhe internohen, kur një djalë kthehet kundër babait të tij?!\r\nTitulli: Mbreti Lir\r\nAutor: Uilliam Shekspir\r\nRegjia: Jonida Beqo\r\nMe pjesëmarrjen e Viktor Zhustit\r\nInterpretojnë: Amri Hasanlliu, Armela Demaj, Dinorah Beqiraj, Edvin Mustafa, Erdet Miraka, Klea Konomi, Klesta Shero, Kriks Dumo, Luisa Dinellari, Lulzim Zeqja, Mariglen Domi, Mario Bali, Marius Dhrami, Roerd Toçe, Sara Koçi, Sedmir Memia, Silva Brahimataj, Silvio Goskova, Sokol Angjeli, Stiv Osmanaj, Xhino Musollari, Xhoni Spahi\r\nAs.regjisor: Joana Omeraj, Ana Guçe\r\nFormulues muzikor: Robert Bisha\r\nKostumograf: Jonida Beqo\r\nAs. Kostumograf: Frenci Gjerasi\r\nSkenograf: Elvis Themeli\r\nNdriçimi: Ergys Baki\r\nGrimi: Marinela Halilaj\r\nInfo & Rezervime:\r\n☎️ +355 67 227 0668', '20:00:00', 'Shakespare', 3, 'C:/xampp/htdocs/biletaria_online/assets/img/shows/poster_6810d06821b429.41732082views.jpeg', 'https://www.youtube.com/watch?v=8uSCpCnATx8', 900, 2),
(12, 'Tre dimra', 'Një shfaqje që vë në optikën e kohërave figurën e gruas dhe zërin e saj. Tre periudhat historike të tranzicionit që ka kaluar apo vazhdojnë të jenë në proces popujt e rajonit tonë, si Shqipëria e Kroacia me një ngjashmëri të plotë me realitetet e tre periudhave: në 1945 me ardhjen në pushtet të komunistëve, në 1990 ardhja e një demokracie të brishtë dhe në 2011 prona akoma e pa zgjidhur dhe përpjekja për të hyrë në Europë. Këto periudha janë të vëzhguara nëpërmjet rrugëtimit të një familjeje në Zagreb të Kroacisë.\r\nTre netë të gjata dimri, në periudha historike me ngjarje vendimtare që ndryshojnë rrjedhën logjike të këtyre personazheve, katër breza grashë me ngjarje personale, sekrete që mbeten për t’u zbuluar.\r\nMbrëmje-natë zhvillohen ngjarjet në tre vitet – stacione biografike. Zbulimi i rrënjëve të kësaj familjeje dhe sekretet e saj, na krijojnë këtë portret familjar të udhëhequr nga dashuria.\r\nShfaqja ka gjuhë filmike si në mënyrën e rrëfimit të historisë po ashtu edhe në aksionin e skenave dhe diskursin e personazheve.\r\n\r\nAutor: Tena Štivičić\r\nRegjia: Rozi Kostani\r\nMe pjesëmarrjen e jashtëzakonshme të aktorëve: Yllka Mujo, Luiza Xhuvani, Marjeta Ljarja, Viktor Zhusti, Sokol Angjeli, Elia Zaharia, Armela Demaj, Sonila Kapidani, Xhino Musollari, Klea Konomi, Kastriot Ramollari, Klesta Shero, Ketjona Pecnikaj, Ina Morinaj, Amri Hasanlliu dhe Lindar Kaja.\r\nTrupa e Ansamblit Tirana: Sedmir Memia, Erdet Miraka, Sara Koçi, Xhoni Spahi, Luisa Dinellari, Mario Bali, Adela Gjyla, Stiv Osmanaj, Megi Duka, Mariglen Domi\r\nStudentët e Universitetit të Arteve: Ergi Hasani, Serxhjo Danga, Enxhi Balla, Edison Kajdomqaj, Griselda Prendaj, Romeo Bushati, Antonela Çina, Ardien Gjabri\r\nAs. Regjisor: Elona Hyseni\r\nMuzika: Genti Rushi\r\nMjeshtër vokali: Suzana Turku\r\nSkenograf: Stjuart Reçi\r\nKostumograf: Frenci Gjerasi\r\nNdriçimi: Ergys Baki\r\nGrimi: Marinela Halilaj\r\nNë datat: 24, 25, 26, 27 Shkurt, 3, 4, 5, 24, 25, 26, 31 Mars, 1, 2, 3, 7, 8, 9, 10 Prill – Ora 19:00\r\n\r\nInfo & Rezervime:\r\n☎️ +355 67 227 0668\r\n\r\nTeatri Metropol vë në skenë për herë të parë, duke çelur sezonin e ri artistik shfaqjen “Tri dimrat” një vepër e autores Tena Stiviçiç me regji nga Rozi Kostani. Kjo shfaqje e shkruar nga autorja kroate është një vepër që ndjek fatet e katër brezave të grave të një familjeje gjatë një shekulli të trazuar. Eshtë një vepër, e cila hedh dritë mbi problemet në shoqërinë moderne duke vëzhguar gjendjen e botës nga këndvështrimi i grave.\r\nNgjarjet e veprës zhvillohen në një vilë të ndërtuar në vitin1898 në Zagreb të Kroacisë. Ky udhëtim në kohë ndodh gjatë 75 viteve, ku ngjarjet fokusohen në tre dimra, në tre pika të ndryshme të zhvillimit të vendit, në vitin 1945 gjatë krijimit të Republikës Socialiste Federative të Jugosllavisë, në vitin 1990 te shpërbërja e saj, e më pas deri në 2011 kur Kroacia e pavarur, aspiron e negocion për t’u bashkuar me BE-në. Ndërkohë që fokusi i shfaqjes është vetëm një shtëpi dhe një familje, në atë shtëpi është shkruar e gjithë historia e fundit e Kroacisë dhe bashkë me të forcat kryesore politike dhe ndryshimet ideologjike që kanë formësuar Evropën moderne.\r\n“Janë tre periudha historike të tranzicionit që ka kaluar apo vazhdojnë të jenë në process popujt e rajonit tonë, si Shqipëria ashtu edhe Kroacia me një ngjashmëri të plotë me realitetet e tre periudhave: në 1945 me ardhjen në pushtet të komunistëve, në 1990 ardhja e një demokracie të brishtë dhe në 2011 prona akoma e pa zgjidhur dhe përpjekja për të hyrë në Europë. Këto periudha janë të vëzhguara nëpërmjet rrugëtimit të një familjeje në Zagreb të Kroacisë. Tre netë të gjata dimri, në tre periudha historike me ngjarje vendimtare që ndryshojnë rrjedhën logjike të këtyre personazheve, gjithashtu edhe me ngjarje personale” shprehet regjisorja Rozi Kostani. Sipas saj, kjo vepër trajton historinë e një familje eklektike, të mbajtur së bashku nga guximi për të mbijetuar. “Nga mbetjet e monarkisë, përmes komunizmit, më pas demokracisë, luftës dhe pranimit eventual në një Evropë më të gjerë, katër breza të grave të Kos, secila më e pavarur se tjera, të cilat duhet të përshtaten për të mbijetuar. E vetmja konstante është shtëpia: e ndërtuar nga aristokratët, e ndarë, e nacionalizuar, ajo është dëshmitare e brezave që kalojnë”, shprehet regjisorja Rozi Kostani.\r\n***\r\nAutorja nuk ka për qëllim të jap një mësim historie për vendin ku u lind dhe u rrit. “Kjo nuk do të më interesonte kurrë si dramaturg. Shpresoj se po hedh dritë mbi marrëdhëniet brenda familjes”, shprehet Stiviçiç në një interpvistë të vitit 2014 dhënë në Londër. Ajo tregon se stërgjyshja e saj ishte një grua e klasës punëtore e pa shkolluar, e cila nuk kishte zë në shoqëri për të shprehur çfarëdo mendimi apo dhe dëshire që kishte. “Njëqind vjet më parë stërgjyshja ime ishte shërbëtore në një shtëpi luksoze,” thotë Tena, duke shtuar se ajo ishte analfabete, mbeti shtatzënë jashtë martese, u përjashtua nga komuniteti i saj rural dhe e mbajti atë njollë gjatë gjithë jetës së saj. Ajo nuk kishte zë për të shprehur zhgënjimin e saj apo për të kuptuar pozicionin e saj. Por ajo kishte instinktin për ta dërguar vajzën e saj në shkollë. . . dhe më pas fëmijët e saj mbaruan kolegjin. Dhe tani unë stërmbesa e saj jo vetëm që kam një zë, por po e përdor atë në më shumë se një gjuhë”, shprehet autorja e veprës Siç thotë Stivicic, kjo vepër është një udhëtim, bashkë me faktorët personalë dhe politikë që qëndrojnë pas këtij udhëtimi që drejtojnë komplotin e “Tre dimrave”. Vepra është një dramë me ngjyrime komike jetësore.\r\n***\r\nStivicic pati suksesin e saj të parë si dramaturge në vitin 1999 me Can’t Escape Sundays, e cila u shfaq në Slloveni dhe Serbi, si dhe në vendin e saj të lindjes.\r\nVeprat e saj që atëherë janë vënë në skenë në Gjermani, dhe në vitin 2007 Fragile! premierë në Arcola në Londër. Ajo është inskenuar në Londër mes emigrantëve nga Serbia dhe Kroacia dhe që atëherë është parë në disa vende të Ballkanit. Tena Stivicic jetoi një pjesë të kësaj periudhe të trazuar. Tani banon në Londër. Autorja u rrit në Kroaci dhe ishte vetëm 13 vjeç kur Jugosllavia filloi të shpërbëhej dhe tensionet etnike shpërthyen në një luftë të tmerrshme. Familja e saj, që jetonte në Zagreb, ishte relativisht e sigurt. Drama “3 dimrat” e Tena Štivičić u shfaq premierë në Teatrin Kombëtar, Londër, në nëntor 2014 dhe fitoi çmimin Susan Smith Blackburn 2015.', '19:00:00', 'Çehov', 2, 'C:/xampp/htdocs/biletaria_online/assets/img/shows/poster_680d1eb62398f7.54902705viewsjpeg', 'https://www.youtube.com/watch?v=-o6T-X-02ts', 900, 2),
(13, 'Pikaso dhe Ajnshtajn në një bar në Paris', '“Pikaso dhe Ajnshtajn në një bar në Paris” – Premierë\r\n\r\nAutori: Steve Martin\r\nRegjia: Armela Demaj\r\nAs/ regji: Joana Omeraj\r\nInterpretojnë: Aleksandër Kondi, Amri Hasanlliu, Blendi Arifi, Erdet Miraka, Ermir Hoxhaj, Klodjana Keco, Kristjana Dodaj, Roerd Toçe, Sara Koçi, Silva Brahimataj, Silvio Goskova\r\nFormulues Muzikor: Gent Rushi\r\nKëngëtare: Laura Hoxha\r\nSkenografia: Klodiana Beqiraj\r\nKoreografia: Sara Koçi\r\nKostumografia: Frenci Gjerasi\r\n\r\n23, 24, 25, 30 Shtator, 1, 2 Tetor\r\nOra: 19:00\r\n\r\n“Pikaso dhe Anjshtanji në një bar në Paris” është premiera e re ekskluzive e Teatrit Metropol, e cila rikthehet në skenë në datat 23, 24, 25, 30 Shtator, 1, 2 Tetor, Ora: 19:00.\r\nVepra e jashtëzakonshme e shkruar nga Steve Martin, do të ngjitet në skenë nga regjisorja Armela Demaj, e cila ka bërë bashkë një kast aktorësh e muzikantësh për këtë shfaqje teatrale. Ky produksion i ri, do të sjellë historinë komike të takimit midis dy gjenish, Pikasos dhe Anjshtanjit në fillimin e shek XX, kohë ku do të ndërthuren rikrijimi i elementeve vizual dhe interpretativ me muzikën dhe këngën e kësaj periudhe. \r\nShfaqja në qendër ka dy personazhet kryesor, piktorin e njohur Pablo Pikaso dhe shkenctarin Albert Anjshtanj, të cilët takohen në një mbrëmje në lokalin “Lapin Agile” (Lepuri i shkathët) në Montmartre, në Paris.\r\n\r\nNgjarjet janë vendosur në një mbrëmje tetori në vitin 1904, kohë kur të dy gjenitë janë në prag të zbulimit të ideve të tyre mahnitëse (Ajnshtajni, përpara se të botojë teorinë e tij të relativitetit në 1905 dhe Pikaso, para se të pikturoj veprën “Zonjat e Avinjonit” “Les Demoiselles d’Avignon” në vitin 1907. Në bar ata kanë një debat të gjatë në lidhje me vlerën e gjeniut dhe talentit, ndërsa bashkëveprojnë me një mori personazhesh të tjerë, mes tyre dhe Elvis Preslin para se të bëhej një muzikant i njohur.\r\nSteve Martin ka thënë se “duke u ndalur në Teorinë e Relativitetit të Ajnshtajnit dhe pikturën e njohur “Zonjat e Avinjonit” të Pikasos, vepra përpiqet të shpjegojë në një mënyrë sa më të thjeshtë ngjashmërinë e procesit krijues, duke përfshirë imagjinatën në art dhe po ashtu edhe zbulimin shkencor.\r\n\r\nImagjinoni në një pjesë të humbur të Parisit, në fillim të shekullin XX Pikason një artist në fillimet e veta të famës, dhe një gjeni të ardhshëm të shkencës si Anjshtanin. Përfshi këtu edhe disa personazhe të tjerë të mistershëm, që debatojnë, me egot e tyre po aq të mëdha sa dhe vetë intelekti i tyre, përfshihen në diskutime për artin, shkencën, inspirimin, dashurinë, muzikën, dhe premtimin e shekullit XX.\r\n“Në këtë komedi të parë për teatër, Steve Martin të mahnit me lojërat e fjalëve dhe të papriturat që thyejnë konvencione dhe do t’ju bëjnë të ndiheni si një fëmijë që po zbulon lojëra të reja. Kubizmi dhe relativiteti nuk kanë qenë kurrë më parë kaq gallatë”, shkruan New York Times.\r\n\r\nZbërthimi i karaktereve të veprës të cilët në ndërthurje me njëri- tjetrin sjellin situata komike duke vënë në dukje optika të ndryshme të mënyrës se si shihet bota dhe marrëdhëniet njerëzore brenda saj. Projekti krijon një copëz jete 100 min nga një periudhë e largët siç është viti 1904 ku arritjet e shkencëtarëve dhe artistëve ishin ngjarjet më frymëzuese të kohës.\r\n\r\nMuzika do të jetë pjesë integrale e kësaj shfaqjeje e cila do te jetë e gjitha “live” ku do të ndërthuret muzika instrumentale dhe vokale duke ruajtur atmosferën e periudhës në të cilën zhvillohet shfaqja dhe vendi ku zhvillohet. Ndërsa qasja skenografike është në sintoni me periudhën historike të viteve 1900 gjithashtu edhe kostumet do të qëndrojnë në stilin e kësaj epoke.\r\n\r\n23, 24, 25, 30 Shtator, 1, 2 Tetor\r\nOra: 19:00', '19:00:00', 'Shakespare', 1, 'C:/xampp/htdocs/biletaria_online/assets/img/shows/poster_680d20e4bd7989.35780960viewspng', 'https://www.youtube.com/watch?v=N3hTkxFnMJA', 900, 2);

-- --------------------------------------------------------

--
-- Table structure for table `show_actors`
--

CREATE TABLE `show_actors` (
  `id` int(11) NOT NULL,
  `actor_id` int(11) DEFAULT NULL,
  `show_id` int(11) DEFAULT NULL,
  `role_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `show_dates`
--

CREATE TABLE `show_dates` (
  `id` int(11) NOT NULL,
  `show_id` int(11) DEFAULT NULL,
  `show_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `show_dates`
--

INSERT INTO `show_dates` (`id`, `show_id`, `show_date`) VALUES
(330, NULL, '2025-04-23'),
(331, NULL, '2025-04-24'),
(332, NULL, '2025-04-25'),
(333, NULL, '2025-04-26'),
(334, NULL, '2025-04-30'),
(335, NULL, '2025-05-01'),
(336, NULL, '2025-05-02'),
(337, NULL, '2025-05-03'),
(338, NULL, '2025-04-29'),
(339, NULL, '2025-04-22'),
(372, 12, '2025-04-13'),
(373, 12, '2025-04-14'),
(374, 12, '2025-04-15'),
(375, 12, '2025-04-16'),
(376, 12, '2025-05-04'),
(377, 12, '2025-05-05'),
(378, 12, '2025-05-06'),
(379, 12, '2025-05-11'),
(380, 12, '2025-05-19'),
(381, 12, '2025-05-12'),
(382, 12, '2025-05-13'),
(383, 12, '2025-05-18'),
(420, 11, '2025-04-29'),
(421, 11, '2025-04-30'),
(422, 11, '2025-05-01'),
(423, 11, '2025-05-02'),
(424, 11, '2025-05-03'),
(425, 11, '2025-05-07'),
(426, 11, '2025-05-08'),
(427, 11, '2025-05-09'),
(428, 11, '2025-05-10'),
(429, 11, '2025-05-11'),
(439, 13, '2025-05-13'),
(440, 13, '2025-05-14'),
(441, 13, '2025-05-15'),
(442, 13, '2025-05-16'),
(443, 13, '2025-05-17'),
(444, 13, '2025-05-21'),
(445, 13, '2025-05-22'),
(446, 13, '2025-05-23'),
(447, 13, '2025-05-24'),
(448, 13, '2025-05-20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `failed_attempts` int(10) NOT NULL DEFAULT 0,
  `lock_time` datetime DEFAULT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `remember_token` varchar(255) DEFAULT NULL,
  `verification_token` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `subscribe` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `phone`, `password`, `failed_attempts`, `lock_time`, `is_verified`, `remember_token`, `verification_token`, `role`, `status`, `subscribe`) VALUES
(1, 'Klevis', 'Pllumbi', 'pllumbiklevis1@gmail.com', '+355 68 36 78 406', '$2y$10$U6H1OMypmS60tWrmB47GnuTYfZgz6ndmgcZhWU31BGMQXxb7tiQIa', 0, NULL, 1, '1c2f46380a0d66f282fe73164ad330aebdb42b4455954c89602fa654cb1d96ba', '6a40486179bd2e918330b10d6ce7f975', 'admin', 'active', 1),
(2, 'Albion', 'Pllumbi', 'onisinger@gmail.com', '+355 68 2600456', '$2y$10$BuFyuXU0GQijgeNk8h1lguRAnkXwaJLEYNxKpPdWJSk88JbN5iwH2', 0, NULL, 1, NULL, '1e4fbe96e0eedec15990aa46211a5310', 'user', 'active', 0),
(3, 'Sara', 'Deda', 'saradeda09@gmail.com', '0683687936', '$2y$10$iquWzaXVh8HKPrWZEQS1he4HPLgQQzjU.uWHiawk.LEKND40MBQgS', 0, '0000-00-00 00:00:00', 0, '', '9912551ea68ee5223cf19a3314d30acf', 'user', 'not active', 0),
(4, 'Kejsi', 'Pllumbi', 'kejsipllumbi22@gmail.com', '0676694720', '$2y$10$TKM00Otienj/ph02jyLXNOT/.bm/gI6BOeIzdw3vZZ8VPihd7.gl.', 0, '0000-00-00 00:00:00', 1, '', 'df0e3cedf62f4a6c06c312f8ae12e131', 'user', 'active', 0),
(5, 'Test', 'test', 'kot@kot.com', '+355 68 31 63 980', '$2y$10$6nke1JLIKlTlwYJiNgfQ4ektaEFD5T3sITunoPSYNJD7zwpueIZ8C', 0, '0000-00-00 00:00:00', 0, '', 'ce0a29d2bc69101bffffe649d2663b6c', 'user', 'not active', 0),
(6, 'Elida', 'Pllumbi', 'pllumbielida@gmail.com', '+355 68 31 63 980', '$2y$10$2R.gMjhIUW3Hikvu/JiTXuHtschWh01//EFSMbA0CNii30772YGHW', 0, NULL, 1, NULL, 'de4b577492f76e5d93ae35b93b3e3230', 'user', 'active', 0),
(8, 'Test', 'Test', 'test@test.com', '0683678406', '$2y$10$93rlHQnELTNlMxeBbawd4O8VPIHEg41Pc6hTkj8/0Fbm.1L5fJIr.', 0, NULL, 1, NULL, '3369ac0fe7ff14f0e27c75ef647702cb', 'ticketOffice', 'active', 0),
(10, 'Diti', 'sok', 'ditisokoli1@gmail.com', '0684896606', '$2y$10$A27kKdSj2w1adNHnEFYah.F4POUS.qf0g.BgT2eoqi4FePJNVPfCm', 0, NULL, 1, NULL, 'bd4000ec18733b4aa3d44a978e244f8e', 'user', 'not active', 0),
(11, 'Test', 'test', 'test@kot.com', '+355 68 31 63 980', '$2y$10$BvlslgR5EVzaRVqSUJKZzu6E7AoxWGbgnO1ze1PNWCI8jlCgfV0sW', 0, NULL, 0, NULL, '30c15504150df5db1c376e6f6f49e260', 'user', 'active', 0),
(12, 'Test', 'Test', 'test@test2.com', '+355 68 31 63 980', '$2y$10$Yo2PVGCbQ5X0SGyQ.J.xJ.4usV9w9cB35lFQNkz3pqt895FEFEKMK', 0, NULL, 1, NULL, '6edb4496c36cb5a5702d896da7a72240', 'user', 'active', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_dates`
--
ALTER TABLE `event_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `show_id` (`show_id`),
  ADD KEY `fk_reservation_seat` (`seat_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `show_id` (`show_id`),
  ADD KEY `reviews_ibfk_3` (`event_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_seat` (`hall`,`row_number`,`seat_number`);

--
-- Indexes for table `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `show_actors`
--
ALTER TABLE `show_actors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actor_id` (`actor_id`),
  ADD KEY `show_id` (`show_id`);

--
-- Indexes for table `show_dates`
--
ALTER TABLE `show_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `show_id` (`show_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actors`
--
ALTER TABLE `actors`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `event_dates`
--
ALTER TABLE `event_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;

--
-- AUTO_INCREMENT for table `shows`
--
ALTER TABLE `shows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `show_actors`
--
ALTER TABLE `show_actors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `show_dates`
--
ALTER TABLE `show_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=453;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_dates`
--
ALTER TABLE `event_dates`
  ADD CONSTRAINT `event_dates_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservation_seat` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`show_id`) REFERENCES `shows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`show_id`) REFERENCES `shows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shows`
--
ALTER TABLE `shows`
  ADD CONSTRAINT `shows_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `show_actors`
--
ALTER TABLE `show_actors`
  ADD CONSTRAINT `show_actors_ibfk_1` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `show_actors_ibfk_2` FOREIGN KEY (`show_id`) REFERENCES `shows` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `show_dates`
--
ALTER TABLE `show_dates`
  ADD CONSTRAINT `show_dates_ibfk_1` FOREIGN KEY (`show_id`) REFERENCES `shows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
