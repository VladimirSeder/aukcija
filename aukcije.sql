-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 12, 2018 at 12:51 PM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aukcije`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `id_korisnika` int(255) NOT NULL AUTO_INCREMENT,
  `email_korisnika` varchar(255) NOT NULL,
  `sifra_korisnika` varchar(255) NOT NULL,
  `ime_korisnika` varchar(255) NOT NULL,
  `prezime_korisnika` varchar(255) NOT NULL,
  `adresa_korisnika` varchar(255) NOT NULL,
  `telefon_korisnika` varchar(255) NOT NULL,
  `profilna_slika` varchar(255) DEFAULT 'img/default.png',
  `pitanje` varchar(255) NOT NULL,
  `odgovor` varchar(255) NOT NULL,
  PRIMARY KEY (`id_korisnika`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id_korisnika`, `email_korisnika`, `sifra_korisnika`, `ime_korisnika`, `prezime_korisnika`, `adresa_korisnika`, `telefon_korisnika`, `profilna_slika`, `pitanje`, `odgovor`) VALUES
(29, 'slobodanp@email.com', '$2y$10$FUmgJ8ydiiijj8ZHbpdgAeGSEfzn7/e72EU5ULNY3U6X3nrG5046O', 'Slobodan', 'Pavlov', 'Temerinska 34, Novi Sad', '063132343', 'images/default.png', 'Koja je tvoja omiljena knjiga?', '$2y$10$IeLn1r4NZH6aWiZFtug5Vef2ukBamXNSW1qj0ahosUM1HGTGKhBKq'),
(28, 'danijelar@email.com', '$2y$10$rgG9o0XV4kfglJnLJHg08ermRQ.OLKsg1GdcxreFxSeiXQmHlRorC', 'Danijela', 'Novakovic', 'Maksima Gorkog 11, Novi Sad', '0698765421', 'images/default.png', 'Koja je tvoja omiljena knjiga?', '$2y$10$0.yk1LqVYF1z11oXynLOVONAZrSty97L9uV/sfmGa9xfI5Y9ENfg2'),
(27, 'korisnik@aukcija.net', '$2y$10$olsVkaIYAVe2.zig0PfFsOiZa.FPnDCQwvRF8XKCDXBVPjjo.0qC6', 'Nikola', 'Savic', 'Bulevar oslobodjenja 123, Novi Sad', '061234567', 'images/12-07-2018-1531395094.png', 'Koja je tvoja omiljena knjiga?', '$2y$10$UDHcx2kGePhyBmR6ZoWaEetJpbRrq5EJZNHMZzA9G28Z2FJRC5nHS');

-- --------------------------------------------------------

--
-- Table structure for table `ponuda`
--

DROP TABLE IF EXISTS `ponuda`;
CREATE TABLE IF NOT EXISTS `ponuda` (
  `id_ponude` int(255) NOT NULL AUTO_INCREMENT,
  `id_predmeta_sk` int(255) NOT NULL,
  `id_korisnika_sk` int(255) NOT NULL,
  `vrednost_ponude` int(255) DEFAULT NULL,
  `vreme_ponude` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_ponude`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ponuda`
--

INSERT INTO `ponuda` (`id_ponude`, `id_predmeta_sk`, `id_korisnika_sk`, `vrednost_ponude`, `vreme_ponude`) VALUES
(125, 92, 27, 511, '1531399243'),
(124, 91, 28, 12100, '1531399078'),
(123, 89, 27, 300, '1531398776'),
(122, 88, 27, 630, '1531398747'),
(121, 90, 27, 220, '1531398733'),
(109, 86, 29, 5111, '1531397625'),
(114, 85, 29, 35100, '1531398143'),
(115, 87, 29, 3555, '1531398185'),
(116, 88, 29, 601, '1531398195'),
(101, 85, 28, 32000, '1531397276'),
(102, 86, 28, 5100, '1531397295');

-- --------------------------------------------------------

--
-- Table structure for table `predmet`
--

DROP TABLE IF EXISTS `predmet`;
CREATE TABLE IF NOT EXISTS `predmet` (
  `id_predmeta` int(255) NOT NULL AUTO_INCREMENT,
  `id_korisnika_sk` int(255) NOT NULL,
  `naziv_predmeta` varchar(255) DEFAULT NULL,
  `opis_predmeta` varchar(2000) DEFAULT NULL,
  `pocetna_cena` int(255) DEFAULT NULL,
  `nacin_placanja` varchar(255) DEFAULT NULL,
  `nacin_isporuke` varchar(255) DEFAULT NULL,
  `slika_predmeta` varchar(255) DEFAULT 'img/defaultp.png',
  `vreme_postavljanja` varchar(255) DEFAULT NULL,
  `vreme_isteka` varchar(255) DEFAULT NULL,
  `trenutna_cena` int(255) DEFAULT NULL,
  PRIMARY KEY (`id_predmeta`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `predmet`
--

INSERT INTO `predmet` (`id_predmeta`, `id_korisnika_sk`, `naziv_predmeta`, `opis_predmeta`, `pocetna_cena`, `nacin_placanja`, `nacin_isporuke`, `slika_predmeta`, `vreme_postavljanja`, `vreme_isteka`, `trenutna_cena`) VALUES
(89, 29, 'Sony Ericson P1i', 'ne koristim ga, stoji u fioci. /br\r\n\r\nako nekom treba za delove ili da ga napuni pa da proba da ga osposobi. /br\r\n\r\nne znam da li je ispravan, nisam ga palio, nemam novu bateriju ni punjaÄ. /br/br\r\n\r\nslanje poÅ¡tom ili preuzimanje u Zemunu', 199, 'Pouzecem', 'Kurirska sluzba', 'images/12-07-2018-1531398306.jpg', '1531398306', '1532348706', 300),
(90, 29, 'Ivan SergejeviÄ‡ Turgenjev - Sabrana dela 15 knjiga', 'Na poÄetku prve knjige postoji fotografija pisca, kao i priÄa o njegovom Å¾ivotu i delu na 30 strana /br\r\n\r\n1/ LovÄeve beleÅ¡ke /br\r\n2/ LovÄeve beleÅ¡ke /br\r\n3/ Ocevi i deca /br\r\n4/ NEDOSTAJE /br\r\n5/ Dim /br\r\n6/ PlemiÄ‡ko gnezdo /br\r\n7/ Novina /br\r\n8/ RuÄ‘in /br\r\n9/ Andreja Kolosov i druge pripovetke /br\r\n10/ NEDOSTAJE /br\r\n11/ NEDOSTAJE /br\r\n12/ Prva ljubav i druge pripovetke /br\r\n13/ NEDOSTAJE /br\r\n14/ ProleÄ‡nje vode /br\r\n15/ NEDOSTAJE /br\r\n16/ KnjiÅ¾evne i Å¾ivotne uspomene /br\r\n17/ Scene i komedije I /br\r\n18/ Scene i komedije II /br\r\n19/ Scene i komedije III /br\r\n20/ Kritike i pisma/br', 199, 'Pouzecem', 'Kurirska sluzba', 'images/12-07-2018-1531398459.jpg', '1531398459', '1532176059', 220),
(86, 27, 'Sony DSX-A40UI', 'ORIGINALNI SONY Multimedijalni muzicki plejer za automobil sa mogucnoscu direktne reprodukcije muzike sa uredjaja iPod, iPhone, mp3 plejer ili fles memorije USB vezom, AUX-IN ulazom i funkcijom Quick-BrowZera. /br\r\nKontrolisite muziku, aplikacije i druge sadrzaje sa uredjaja iPod, iPhone ili fles memorije. \r\nPovezite mp3 plejer preko USB ili AUX prikljucka. /br\r\nBrze pronadjite zeljenu numeru uz Quick-Browzera. \r\nDirektno upravljanje iPod/iPhone uredjajem - Povezite iPod, iPhone, fles uredjaj ili drugi USB uredjaj radi trenutne reprodukcije muzike. \r\nPonesite mp3 muziku sa sobom - Reprodukujte hiljade mp3/WMA/AAC numera u automobilu jednostavnim ubacivanjem USB memorije u prednju stranu jedinice. /br\r\nKada pronadjete zeljenu numeru, dodirnite je da biste je reprodukovali ili pauzirali. \r\ncetiri kanala snaznog zvuka -cetiri kanala snage po 55 W obezbedjuju snazan zvuk koji ispunjava automobil. ', 5000, 'Pouzecem', 'Kurirska sluzba', 'images/12-07-2018-1531396616.jpg', '1531396616', '1532260616', 5111),
(85, 27, 'Nikon d850', 'Novo u kutiji, nekorisceno. /br/br\r\n\r\nCena je fenomenalna, pa zaista molim samo ozbiljni kupci da se javljaju, koji zele da kupe. /br/br\r\n\r\nGarancija je 24 meseca i ostvaruje se preko nas. Molimo vas da nam ne saljete SMS poruke. Poziv ili poruka je najbolji nacin da nas kontaktirate. /br/br\r\n\r\nMoguca nabavka i druge interesantne brendirane foto opreme. Slobodno pitajte za cenu svega sto vas interesuje. /br /br\r\n\r\nNIkakve zamene ne radimo - prodajemo samo nove i nekoriscene stvari. /br/br\r\n\r\nOkvirni rok isporuke je desetak dana! /br/br\r\n\r\nHvala na interesovanju!', 31000, 'Pouzecem', 'Kurirska sluzba', 'images/12-07-2018-1531395924.jpg', '1531395924', '1532691924', 35100),
(87, 28, 'Original Sioux Grashopper', '*Original Sioux Grashopper vrhunske,koÅ¾ne cipele,Nove,u besprekornom stanju /br\r\n*spolja izraÄ‘ene od meke,prirodne lak boks koÅ¾e u crnoj boji.Prednji deo je fantastiÄno odraÅ¾en,od ,materjal je izuzetan,neka vrsta elastiÄnog platna preko koga je rupiÄasti filc /br\r\n*unutraÅ¡njost je postavljena glatkom koÅ¾om,tabanica je koÅ¾na sa Activ air sistemom za ventilaciju stopala /br\r\n*Ä‘on izraÄ‘en od memo pene,sa rebrastom Å¡arom na gaziÅ¡tu,blago uzdignut /br\r\n*cipele su lagane,izuzetno udobne /br\r\n*oznaÄena veliÄina 81/2,evropski 42,5,sa maksimalnom duÅ¾inom unutraÅ¡njeg gaziÅ¡ta 28cm,korisno 27,5cm,visina Ä‘ona na peti 2cm', 3500, 'Pouzecem', 'Kurirska sluzba', 'images/12-07-2018-1531396827.jpg', '1531396827', '1532347227', 3555),
(88, 28, '10 casa', '10 novih ÄaÅ¡a iz pakovanja piÄ‡a sa ÄaÅ¡ama... /br/br\r\n2 Teachers, 4 Balantines i 4 Gorki list /br\r\nObratiti paÅ¾nju da je moguÄ‡e samo liÄno preuzimanje.', 600, 'Licno', 'Licno preuzimanje', 'images/12-07-2018-1531397219.jpg', '1531397219', '1532347619', 630),
(91, 27, 'Xbox 360 Slim konzola 250GB', 'Xbox 360 Slim konzola RGH ÄŒIPOVANA KONZOLA + igrice gratis /br\r\n\r\nKonzola je kuÄ‡no koriÅ¡tena, u odliÄnom stanju, 100% ispravna.  /br /br\r\n\r\nU paketu se dobija:  /br\r\n\r\nXbox360 Slim konzola â€“ 250 GB Hard Disk  /br\r\nAV / HDMI kabl  /br\r\nNapajanje  /br\r\nXbox 360 originalni kontroler-1 komad.  /br\r\nPreko 30 igara, Å¡to moÅ¾ete videti na slikama.  /br /br\r\n\r\nDrugi kontoler posebno prodajem jer je dva puta koruÅ¡ten i joÅ¡ uvek je pod garancijom.', 10000, 'Pouzecem', 'Kurirska sluzba', 'images/12-07-2018-1531398979.jpg', '1531398979', '1531485379', 12100),
(92, 28, 'Logitech G231', 'Vrhunske gejmerske slusalice, Logitech G231, u odlicnom stanju. Sve je ispravno na njima.', 510, 'Pouzecem', 'Kurirska sluzba', 'images/12-07-2018-1531399189.jpg', '1531399189', '1531485589', 511);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
