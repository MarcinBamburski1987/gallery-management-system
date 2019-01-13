

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;





CREATE TABLE IF NOT EXISTS `pracownicy` (
`id` int(11) NOT NULL,
  `user` text COLLATE utf8_polish_ci NOT NULL,
  `pozycja` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;



INSERT INTO `pracownicy` (`id`, `user`, `pozycja`) VALUES
(1, 'adam', 'administrator'),
(2, 'marek', 'ochroniarz'),
(3, 'anna', 'sprzataczka'),
(4, 'andrzej', 'ksiegowy'),
(5, 'justyna', 'ochroniarka'),
(6, 'kasia', 'parkingowy'),
(7, 'beata', 'kierowniczka'),
(8, 'jakub', 'magazynier'),
(9, 'janusz', 'kierowca'),
(10, 'roman', 'wozkowy');


ALTER TABLE `pracownicy`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);


ALTER TABLE `pracownicy`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
