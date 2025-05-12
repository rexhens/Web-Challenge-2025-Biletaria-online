-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 09:02 AM
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
(3, 'MetroFest', 'Për të pestin vit me radhë, Teatri Metropol organizon festivalin dedikuar veprës shqiptare të arkivit. Puna për realizim ka nisur në muajin tetor, ndërsa muaji nëntor do të jetë muaji në të cilin do të nisë premiera e pare dhe data 9 dhjetor do të jetë mbyllja e këtij realizimi që i përket trashëgimisë dramatike, teatrit dhe edukimit.\r\nNë këtë edicion janë përzgjedhur për t’u vendosur në skenë larmi tekstesh që i përkasin viteve 1900 dhe jo vetëm: në datën 4-7 nëntor 2021, ora 19:00 do të shfaqet “Kapterr Behari” me autor dhe regji nga Stefan Çapaliku; 11-14 nëntor 2021, ora 19:00, komedia zbavitëse “Luloja” botuar më 1922 nga Dhori Kote e në regjinë e Blendi Arifit; 18- 21 nëntor 2021, ora 19:00 do të jetë shfaqje përshëndetëse komedia “Sot tetë ditë” me autor Josip Relën në 1932 dhe regji nga Elona Hyseni; Në datat 25-28 nëntor 2021 do të prezantohet ajo që njihet si drama e parë e absurdit në shqip “Gof” me autor Anton Pashku dhe përpunim tekstor dhe regjia nga Shkëlzen Berisha; në data 4-5 dhjetor 2021 do të jetë një ekspozitë e pikturës dhe shfaqja e monodramës me titull “Duan të fluturojnë” e autorit Lekë Tasi, në regjinë e Klesta Sheros; Ndërsa pikëtakimi final i këtij edicioni do të jetë në datën 9 dhjetor 2021 me prezantimin e krijuar në punë laboratorike të skicës dramatike “Roli i Lule-Borës” botuar në 1932 me regji nga Sonila Kapidani dhe koreograf Erdet Miraka. Një tryezë bisedë do të zhvillohet mbi Zërin, Praninë dhe Lëvizjen në punën e aktorit.\r\n\r\nImagjinoni ç’mund të ndodhë nëse takohen autorë të një kohe më të vjetër dhe krijues të rinj me një mori spektatorësh teatri që argëtohen dhe mbështesin … emocionohen, reflektojnë, shkëmbejnë të qeshura, lot, ide, bashkëndajnë njerëzillëk dhe premtojnë vazhdimësi!\r\nLajmëroni miqtë, ju mirëpresim!\r\n\r\n4 Nëntor – 9 Dhjetor 2021 në Teatri Metropol – Qendra Kulturore Tirana\r\n\r\nInfo & Rezervime\r\n☎️ +355 67 227 0668\r\n\r\n#metrofest #teatrimetropol\r\n\r\nGjatë këtyre pesë viteve janë lexuar rreth 70 vepra shqiptare të arkivit që kanë qenë kryesisht të njohura si letërsi dramatike dhe janë vënë në skenë 20 prej tyre, të shkruara nga autorët Martin Camaj, Ernest Koliqi, Shpëtim Gina, Kristo Floqi, Lazër Lumezi, Halil Laze, Milo Duçi, At Zef Pllumi, Lumo Skëndo, Minush Jero, Jeronim De Rada, Kristë Berisha, etj. Në këto 5 vite janë angazhuar 115 artistë nga të gjitha brezat; janë tashmë dy pamje të teksteve – origjinali dhe përpunimet; janë bërë disa programe si vazhdimësi në shkolla për të rinjtë që të njihen me\r\ntrashëgiminë tonë dramatike si edhe është bërë një botim nga tryeza e rrumbullakët.', 'Bodrum', '19:00:00', 'C:/xampp/htdocs/biletaria_online/assets/img/events/poster_680d05e97c7b53.97042460viewspng', 900, 'https://www.youtube.com/watch?v=Jek-mbP7EKc'),
(7, 'Festivali Adriatik', 'Kemi kënaqësinë të çelim sezonin e ri artistik me festivalin “Adriatik” i cili do të prezantohet për publikun e Tiranës me shfaqje teatrore, koncerte dhe takime studiuesish në datat 6-19 Shtator.\r\nKy festival organizohet në kuadër të projektit AIDA – Adriatic Identity through Development of Arts një projekt i përbashkët dhe i rëndësishëm mes Italisë – Shqipërisë dhe Malit të Zi. Ky projekt, i cili ka nisur një vit më parë, ka si synim të krijojë një model identiteti bazuar mbi vetëdijen dhe memorien kolektive të komuniteteve pranë detit Adriatik. Projekti ka krijuar rrjete bashkëpunimi me qytetet Leçe, Campobasso, Tiranë dhe Ulqin, të cilat së bashku do të përfaqësohen në Tiranë gjatë netëve të festivalit me shfaqjen “Riparimi” me regji nga Cesar Brie dhe aktorë nga të tre shtetet.\r\nTeatri Metropol si pjesë e këtij projekti ka hulumtuar specifikisht mbi historikun dhe zhvillimin e ngjarjeve sociale dhe kulturore të lagjes së Kombinatit. Ndërsa projekti vetë ka për qëllim të tregojë se është e mundur të shqyrtohen shumë vendndodhje të rajonit nga një këndvështrim i vetëm, duke hedhur dritë mbi shumë të përbashkëta dhe pika kontakti midis qytetarëve dhe komuniteteve të territoreve të ndryshme të përfshira në projekt.\r\nKalendari i Festivalit 6-19 Shtator 2021\r\n– 6 shtator: “N’Konak” koncert nga Ansambli Tirana, koreograf Sedmir Memia (Amfiteatri i Tiranës)\r\n– 7 shtator: “N’Konak” koncert nga Ansambli Tirana, koreograf Sedmir Memia (Amfiteatri i Tiranës)\r\n– 8 shtator: “Këngëtarja Tullace”, dance – teatër me regji dhe koreografi nga Gjergj Prevazi (Amfiteatri i Tiranës)\r\n– 9 shtator: “Këngëtarja Tullace”, dance – teatër me regji dhe koreografi nga Gjergj Prevazi (Amfiteatri i Tiranës)\r\n– 9 shtator: “Kapter Behari” shfaqje nga Stefan Çapaliku, (Teatri Metropol)\r\n– 10 shtator: “Kapter Behari” shfaqje nga Stefan Çapaliku, (Teatri Metropol)\r\n– 11 shtator: “Kapter Behari” shfaqje nga Stefan Çapaliku, (Teatri Metropol)\r\n– 12 shtator: “Kapter Behari” shfaqje nga Stefan Çapaliku, (Teatri Metropol)\r\n– 15 shtator: “Riparimi” shfaqje e përbashkët Itali – Shqipëri – Mal i Zi, me regji nga Cesar Brie (Teatri Metropol)\r\n– 16 shtator: “Il Companatico” shfaqje nga Salvatore Tramacera, (Teatri Metropol)\r\n– 17 shtator: Takim me studiues për të diskutuar mbi temën e Kombinatit (Teatri Metropol\r\n– 18 shtator: “Audienca e Vaclav Havelit” shfaqje me regji te Agon Myftarit (Teatri Metropol)\r\n– 19 shtator: “N’Konak” koncert nga Ansambli Tirana, koreograf Sedmir Memia (Sheshi i Kombinatit)\r\n\r\nENGLISH:\r\n\r\nWe are pleased to open the new artistic season with the “Adriatik” festival, which will be presented to the public of Tirana with theater performances, concerts and meetings of researchers on September 6-19.\r\nThis festival is organized within the project AIDA – Adriatic Identity through Development of Arts, a joint and important project between Italy – Albania and Montenegro. This project, which started a year ago, aims to create an identity model based on the consciousness and collective memory of the communities near the Adriatic Sea. The project has created cooperation networks with the cities of Leçe, Campobasso, Tirana and Ulcin, which together will be represented in Tirana during the nights of the festival with the show “Repair” directed by Cesar Brie and actors from the three countries.\r\nAs part of this project, the Metropol Theater has specifically researched the history and development of social and cultural events in the Kombinat neighborhood. While the project itself aims to show that it is possible to examine many locations of the region from a single perspective, shedding light on many commonalities and points of contact between citizens and communities of the different territories included in the project.\r\n\r\nFestival Calendar 6-19 September 2021\r\n– September 6: “N’Konak” concert by Tirana Ensemble, choreographer Sedmir Memia (Tirana Amphitheater)\r\n– September 7: “N’Konak” concert by Tirana Ensemble, choreographer Sedmir Memia (Tirana Amphitheater)\r\n– September 8: “Bald Singer”, dance – theater directed and choreographed by Gjergj Prevazi (Tirana Amphitheater)\r\n– September 9: “Bald Singer”, dance-theatre directed and choreographed by Gjergj Prevazi (Amphitheater of Tirana)\r\n– September 9: “Captain Behari” performance by Stefan Çapaliku, (Teatri Metropol)\r\n– September 10: “Captain Behari” performance by Stefan Çapaliku, (Teatri Metropol)\r\n– September 11: “Captain Behari” performance by Stefan Çapaliku, (Teatri Metropol)\r\n– September 12: “Captain Behari” performance by Stefan Çapaliku, (Teatri Metropol)\r\n– September 15: “Repair” joint show Italy – Albania – Montenegro, directed by Cesar Brie (Metropol Theatre)\r\n– September 16: “Il Companatico” performance by Salvatore Tramacera, (Teatri Metropol)\r\n– September 17: Meeting with researchers to discuss the theme of the Combine (Teatri Metropol\r\n– September 18: “Audience of Vaclav Havel” directed by Agon Myftari (Metropol Theater)\r\n– September 19: “N’Konak” concert by the Tirana Ensemble, choreographer Sedmir Memia (Kombinat Square)\r\n\r\n#teatrimetropol #aida #kombinati', 'Çehov', '19:00:00', 'C:/xampp/htdocs/biletaria_online/assets/img/events/poster_680e1b5a5753a8.65912679viewspng', 900, 'https://www.youtube.com/watch?v=9YUfUt6lwW8');

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
(66, 3, '2025-04-11'),
(67, 3, '2025-04-29'),
(108, 7, '2025-04-09'),
(109, 7, '2025-04-10'),
(110, 7, '2025-04-11'),
(111, 7, '2025-04-12'),
(112, 7, '2025-05-08'),
(113, 7, '2025-05-09'),
(114, 7, '2025-05-10'),
(115, 7, '2025-05-22'),
(116, 7, '2025-05-23'),
(117, 7, '2025-05-24');

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
  `date` timestamp NOT NULL DEFAULT current_timestamp()
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
  `seat_id` int(11) NOT NULL,
  `ticket_code` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `show_date` date NOT NULL,
  `show_time` time NOT NULL,
  `total_price` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `show_id`, `event_id`, `full_name`, `email`, `phone`, `created_at`, `hall`, `seat_id`, `ticket_code`, `expires_at`, `paid`, `show_date`, `show_time`, `total_price`) VALUES
(2, 11, NULL, 'Klevis Pllumbi', 'pllumbiklevis1@gmail.com', '0683678406', '2025-05-05 13:17:26', 'Shakespare', 1, 'testtesttest', '2025-05-05 13:14:55', 1, '2025-05-22', '19:00:00', 900);

-- --------------------------------------------------------

--
-- Table structure for table `reservation_seats`
--

CREATE TABLE `reservation_seats` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `show_date` date NOT NULL,
  `show_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `email`, `show_id`, `event_id`, `rating`, `comment`, `date`) VALUES
(2, 'pllumbiklevis1@gmail.com', 11, NULL, 3, 'Shfaqja kishte disa momente të bukura, por gjithsej nuk më la një përshtypje të fortë. Aktorët ishin të mirë, por disa prej performancave ndiheshin pak të ngurta dhe nuk arrinin të transmetonin plotësisht emocionet që kërkonte historia. Regjia ishte e thjeshtë, dhe ndonjëherë skenografia nuk i shërbeu aq mirë ngjarjes, duke e bërë disa pjesë të shfaqjes të dukeshin pak të zbrazëta. Historia kishte potencial, por ndonjëherë dija dhe dialogu ndiheshin të parregullta, duke i lënë disa pyetje pa përgjigje. Efektet vizuale ishin të mira, por jo të mjaftueshme për të shpëtuar shfaqjen nga disavantazhet e tjera. Një shfaqje që ka disa pika të forta, por që mund të përmirësohet në shumë aspekte.', '2025-05-04 17:08:34');

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
(1, 'Shakespare', 'A', 1, 'standard'),
(2, 'Shakespare', 'A', 2, 'standard'),
(3, 'Shakespare', 'A', 3, 'standard'),
(4, 'Shakespare', 'A', 4, 'standard'),
(5, 'Shakespare', 'B', 1, 'premium'),
(6, 'Shakespare', 'B', 2, 'premium'),
(7, 'Shakespare', 'B', 3, 'premium'),
(8, 'Shakespare', 'B', 4, 'premium'),
(9, 'Shakespare', 'C', 1, 'standard'),
(10, 'Shakespare', 'C', 2, 'standard'),
(11, 'Shakespare', 'C', 3, 'standard'),
(12, 'Shakespare', 'C', 4, 'standard');

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
(12, 'Tre dimra', 'Një shfaqje që vë në optikën e kohërave figurën e gruas dhe zërin e saj. Tre periudhat historike të tranzicionit që ka kaluar apo vazhdojnë të jenë në proces popujt e rajonit tonë, si Shqipëria e Kroacia me një ngjashmëri të plotë me realitetet e tre periudhave: në 1945 me ardhjen në pushtet të komunistëve, në 1990 ardhja e një demokracie të brishtë dhe në 2011 prona akoma e pa zgjidhur dhe përpjekja për të hyrë në Europë. Këto periudha janë të vëzhguara nëpërmjet rrugëtimit të një familjeje në Zagreb të Kroacisë.\r\nTre netë të gjata dimri, në periudha historike me ngjarje vendimtare që ndryshojnë rrjedhën logjike të këtyre personazheve, katër breza grashë me ngjarje personale, sekrete që mbeten për t’u zbuluar.\r\nMbrëmje-natë zhvillohen ngjarjet në tre vitet – stacione biografike. Zbulimi i rrënjëve të kësaj familjeje dhe sekretet e saj, na krijojnë këtë portret familjar të udhëhequr nga dashuria.\r\nShfaqja ka gjuhë filmike si në mënyrën e rrëfimit të historisë po ashtu edhe në aksionin e skenave dhe diskursin e personazheve.\r\n\r\nAutor: Tena Štivičić\r\nRegjia: Rozi Kostani\r\nMe pjesëmarrjen e jashtëzakonshme të aktorëve: Yllka Mujo, Luiza Xhuvani, Marjeta Ljarja, Viktor Zhusti, Sokol Angjeli, Elia Zaharia, Armela Demaj, Sonila Kapidani, Xhino Musollari, Klea Konomi, Kastriot Ramollari, Klesta Shero, Ketjona Pecnikaj, Ina Morinaj, Amri Hasanlliu dhe Lindar Kaja.\r\nTrupa e Ansamblit Tirana: Sedmir Memia, Erdet Miraka, Sara Koçi, Xhoni Spahi, Luisa Dinellari, Mario Bali, Adela Gjyla, Stiv Osmanaj, Megi Duka, Mariglen Domi\r\nStudentët e Universitetit të Arteve: Ergi Hasani, Serxhjo Danga, Enxhi Balla, Edison Kajdomqaj, Griselda Prendaj, Romeo Bushati, Antonela Çina, Ardien Gjabri\r\nAs. Regjisor: Elona Hyseni\r\nMuzika: Genti Rushi\r\nMjeshtër vokali: Suzana Turku\r\nSkenograf: Stjuart Reçi\r\nKostumograf: Frenci Gjerasi\r\nNdriçimi: Ergys Baki\r\nGrimi: Marinela Halilaj\r\nNë datat: 24, 25, 26, 27 Shkurt, 3, 4, 5, 24, 25, 26, 31 Mars, 1, 2, 3, 7, 8, 9, 10 Prill – Ora 19:00\r\n\r\nInfo & Rezervime:\r\n☎️ +355 67 227 0668\r\n\r\nTeatri Metropol vë në skenë për herë të parë, duke çelur sezonin e ri artistik shfaqjen “Tri dimrat” një vepër e autores Tena Stiviçiç me regji nga Rozi Kostani. Kjo shfaqje e shkruar nga autorja kroate është një vepër që ndjek fatet e katër brezave të grave të një familjeje gjatë një shekulli të trazuar. Eshtë një vepër, e cila hedh dritë mbi problemet në shoqërinë moderne duke vëzhguar gjendjen e botës nga këndvështrimi i grave.\r\nNgjarjet e veprës zhvillohen në një vilë të ndërtuar në vitin1898 në Zagreb të Kroacisë. Ky udhëtim në kohë ndodh gjatë 75 viteve, ku ngjarjet fokusohen në tre dimra, në tre pika të ndryshme të zhvillimit të vendit, në vitin 1945 gjatë krijimit të Republikës Socialiste Federative të Jugosllavisë, në vitin 1990 te shpërbërja e saj, e më pas deri në 2011 kur Kroacia e pavarur, aspiron e negocion për t’u bashkuar me BE-në. Ndërkohë që fokusi i shfaqjes është vetëm një shtëpi dhe një familje, në atë shtëpi është shkruar e gjithë historia e fundit e Kroacisë dhe bashkë me të forcat kryesore politike dhe ndryshimet ideologjike që kanë formësuar Evropën moderne.\r\n“Janë tre periudha historike të tranzicionit që ka kaluar apo vazhdojnë të jenë në process popujt e rajonit tonë, si Shqipëria ashtu edhe Kroacia me një ngjashmëri të plotë me realitetet e tre periudhave: në 1945 me ardhjen në pushtet të komunistëve, në 1990 ardhja e një demokracie të brishtë dhe në 2011 prona akoma e pa zgjidhur dhe përpjekja për të hyrë në Europë. Këto periudha janë të vëzhguara nëpërmjet rrugëtimit të një familjeje në Zagreb të Kroacisë. Tre netë të gjata dimri, në tre periudha historike me ngjarje vendimtare që ndryshojnë rrjedhën logjike të këtyre personazheve, gjithashtu edhe me ngjarje personale” shprehet regjisorja Rozi Kostani. Sipas saj, kjo vepër trajton historinë e një familje eklektike, të mbajtur së bashku nga guximi për të mbijetuar. “Nga mbetjet e monarkisë, përmes komunizmit, më pas demokracisë, luftës dhe pranimit eventual në një Evropë më të gjerë, katër breza të grave të Kos, secila më e pavarur se tjera, të cilat duhet të përshtaten për të mbijetuar. E vetmja konstante është shtëpia: e ndërtuar nga aristokratët, e ndarë, e nacionalizuar, ajo është dëshmitare e brezave që kalojnë”, shprehet regjisorja Rozi Kostani.\r\n***\r\nAutorja nuk ka për qëllim të jap një mësim historie për vendin ku u lind dhe u rrit. “Kjo nuk do të më interesonte kurrë si dramaturg. Shpresoj se po hedh dritë mbi marrëdhëniet brenda familjes”, shprehet Stiviçiç në një interpvistë të vitit 2014 dhënë në Londër. Ajo tregon se stërgjyshja e saj ishte një grua e klasës punëtore e pa shkolluar, e cila nuk kishte zë në shoqëri për të shprehur çfarëdo mendimi apo dhe dëshire që kishte. “Njëqind vjet më parë stërgjyshja ime ishte shërbëtore në një shtëpi luksoze,” thotë Tena, duke shtuar se ajo ishte analfabete, mbeti shtatzënë jashtë martese, u përjashtua nga komuniteti i saj rural dhe e mbajti atë njollë gjatë gjithë jetës së saj. Ajo nuk kishte zë për të shprehur zhgënjimin e saj apo për të kuptuar pozicionin e saj. Por ajo kishte instinktin për ta dërguar vajzën e saj në shkollë. . . dhe më pas fëmijët e saj mbaruan kolegjin. Dhe tani unë stërmbesa e saj jo vetëm që kam një zë, por po e përdor atë në më shumë se një gjuhë”, shprehet autorja e veprës Siç thotë Stivicic, kjo vepër është një udhëtim, bashkë me faktorët personalë dhe politikë që qëndrojnë pas këtij udhëtimi që drejtojnë komplotin e “Tre dimrave”. Vepra është një dramë me ngjyrime komike jetësore.\r\n***\r\nStivicic pati suksesin e saj të parë si dramaturge në vitin 1999 me Can’t Escape Sundays, e cila u shfaq në Slloveni dhe Serbi, si dhe në vendin e saj të lindjes.\r\nVeprat e saj që atëherë janë vënë në skenë në Gjermani, dhe në vitin 2007 Fragile! premierë në Arcola në Londër. Ajo është inskenuar në Londër mes emigrantëve nga Serbia dhe Kroacia dhe që atëherë është parë në disa vende të Ballkanit. Tena Stivicic jetoi një pjesë të kësaj periudhe të trazuar. Tani banon në Londër. Autorja u rrit në Kroaci dhe ishte vetëm 13 vjeç kur Jugosllavia filloi të shpërbëhej dhe tensionet etnike shpërthyen në një luftë të tmerrshme. Familja e saj, që jetonte në Zagreb, ishte relativisht e sigurt. Drama “3 dimrat” e Tena Štivičić u shfaq premierë në Teatrin Kombëtar, Londër, në nëntor 2014 dhe fitoi çmimin Susan Smith Blackburn 2015.', '19:00:00', 'Cehov', 2, 'C:/xampp/htdocs/biletaria_online/assets/img/shows/poster_680d1eb62398f7.54902705viewsjpeg', 'https://www.youtube.com/watch?v=-o6T-X-02ts', 900, 2),
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
(384, 13, '2025-05-14'),
(385, 13, '2025-05-15'),
(386, 13, '2025-05-16'),
(387, 13, '2025-05-17'),
(388, 13, '2025-05-21'),
(389, 13, '2025-05-22'),
(390, 13, '2025-05-23'),
(391, 13, '2025-05-24'),
(400, 11, '2025-04-30'),
(401, 11, '2025-05-01'),
(402, 11, '2025-05-02'),
(403, 11, '2025-05-03'),
(404, 11, '2025-05-07'),
(405, 11, '2025-05-08'),
(406, 11, '2025-05-09'),
(407, 11, '2025-05-10');

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
  `status` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `phone`, `password`, `failed_attempts`, `lock_time`, `is_verified`, `remember_token`, `verification_token`, `role`, `status`) VALUES
(1, 'Klevis', 'Pllumbi', 'pllumbiklevis1@gmail.com', '+355 68 36 78 406', '$2y$10$v9a2IrNza2RXg6HJAmsEeeO20XDraFrgMs38Hv.gQbR8ZbuqtAgiK', 0, NULL, 1, '5b8eec91af558a37f259c06cab6acc26f7d41d334673e21c086284f305ed6039', 'f26d3389c4bcbe123ccee1094c744a68', 'admin', 'active'),
(2, 'Albion', 'Pllumbi', 'onisinger@gmail.com', '+355 68 2600456', '$2y$10$BuFyuXU0GQijgeNk8h1lguRAnkXwaJLEYNxKpPdWJSk88JbN5iwH2', 0, NULL, 1, NULL, '1e4fbe96e0eedec15990aa46211a5310', 'user', 'active'),
(3, 'Sara', 'Deda', 'saradeda09@gmail.com', '0683687936', '$2y$10$iquWzaXVh8HKPrWZEQS1he4HPLgQQzjU.uWHiawk.LEKND40MBQgS', 0, '0000-00-00 00:00:00', 0, '', '9912551ea68ee5223cf19a3314d30acf', 'user', 'active'),
(4, 'Kejsi', 'Pllumbi', 'kejsipllumbi22@gmail.com', '0676694720', '$2y$10$TKM00Otienj/ph02jyLXNOT/.bm/gI6BOeIzdw3vZZ8VPihd7.gl.', 0, '0000-00-00 00:00:00', 1, '', 'df0e3cedf62f4a6c06c312f8ae12e131', 'user', 'active'),
(5, 'Test', 'test', 'kot@kot.com', '+355 68 31 63 980', '$2y$10$6nke1JLIKlTlwYJiNgfQ4ektaEFD5T3sITunoPSYNJD7zwpueIZ8C', 0, '0000-00-00 00:00:00', 0, '', 'ce0a29d2bc69101bffffe649d2663b6c', 'user', 'not active'),
(6, 'Elida', 'Pllumbi', 'pllumbielida@gmail.com', '+355 68 31 63 980', '$2y$10$2R.gMjhIUW3Hikvu/JiTXuHtschWh01//EFSMbA0CNii30772YGHW', 0, '0000-00-00 00:00:00', 1, '7dad4bbeedb1676e3d0c1a231caed9c4f06f051f25396786826b3868a26cf22d', 'de4b577492f76e5d93ae35b93b3e3230', 'user', 'active'),
(8, 'Test', 'Test', 'test@test.com', '0683678406', '$2y$10$93rlHQnELTNlMxeBbawd4O8VPIHEg41Pc6hTkj8/0Fbm.1L5fJIr.', 0, NULL, 1, NULL, '3369ac0fe7ff14f0e27c75ef647702cb', 'ticketOffice', 'active'),
(10, 'Diti', 'sok', 'ditisokoli1@gmail.com', '0684896606', '$2y$10$A27kKdSj2w1adNHnEFYah.F4POUS.qf0g.BgT2eoqi4FePJNVPfCm', 0, NULL, 1, NULL, 'bd4000ec18733b4aa3d44a978e244f8e', 'user', 'active'),
(11, 'Test', 'test', 'test@kot.com', '+355 68 31 63 980', '$2y$10$BvlslgR5EVzaRVqSUJKZzu6E7AoxWGbgnO1ze1PNWCI8jlCgfV0sW', 0, NULL, 0, NULL, '30c15504150df5db1c376e6f6f49e260', 'user', 'active');

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
-- Indexes for table `reservation_seats`
--
ALTER TABLE `reservation_seats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `show_id` (`show_id`,`show_date`,`show_time`,`seat_id`),
  ADD KEY `reservation_id` (`reservation_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservation_seats`
--
ALTER TABLE `reservation_seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `shows`
--
ALTER TABLE `shows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `show_actors`
--
ALTER TABLE `show_actors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `show_dates`
--
ALTER TABLE `show_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=410;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  ADD CONSTRAINT `fk_reservation_seat` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`show_id`) REFERENCES `shows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation_seats`
--
ALTER TABLE `reservation_seats`
  ADD CONSTRAINT `reservation_seats_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE;

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
