-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 11 dec 2014 om 18:31
-- Serverversie: 5.6.16
-- PHP-versie: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `gallery`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `title` varchar(25) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `displayname` varchar(16) NOT NULL,
  `bio` text,
  `password` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `background` varchar(255) NOT NULL DEFAULT 'background4.jpg',
  `profile_picture` varchar(255) NOT NULL DEFAULT 'default_picture.jpg',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `username`, `displayname`, `bio`, `password`, `email`, `background`, `profile_picture`) VALUES
(3, 'baasb', 'basvandijkk', 'Ik ben Bas, ik ben de oprichter van deze website, dit is dus een van de eerste profielen hier.', '906072001efddf3e11e6d2b5782f4777fe038739', 'bas@email.nl', 'wallpaper-photos-3.jpg', 'd0491264-0e08-4385-be0a-69686979b912.jpg'),
(4, 'Tjapp', 'Tjappie', NULL, '906072001efddf3e11e6d2b5782f4777fe038739', 'tjapp@rtjap.nl', 'background4.jpg', 'default_picture.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
