

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;





CREATE TABLE IF NOT EXISTS `uzytkownicy` (
`id` int(11) NOT NULL,
  `user` text COLLATE utf8_polish_ci NOT NULL,
  `pass` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;



INSERT INTO `uzytkownicy` (`id`, `user`, `pass`) VALUES
(1, 'adam', 'qwerty'),
(2, 'marek', 'asdfg'),
(3, 'anna', 'zxcvb'),
(4, 'andrzej', 'asdfg'),
(5, 'justyna', 'yuiop'),
(6, 'kasia', 'hjkkl'),
(7, 'beata', 'fgthj'),
(8, 'jakub', 'ertyu'),
(9, 'janusz', 'cvbnm'),
(10, 'roman', 'dfghj');


ALTER TABLE `uzytkownicy`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);


ALTER TABLE `uzytkownicy`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
