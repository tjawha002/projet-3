-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.8-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table test.saves
CREATE TABLE IF NOT EXISTS `saves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(50) DEFAULT NULL,
  `value` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table test.saves: ~0 rows (approximately)
/*!40000 ALTER TABLE `saves` DISABLE KEYS */;
INSERT INTO `saves` (`id`, `user_email`, `value`) VALUES
	(1, 'p@gmail.com', 'a:10:{s:8:"patentID";s:19:"USD0873502-20200121";s:3:"pid";s:6:"p-0040";s:11:"is_multiple";s:1:"0";s:11:"origreftext";s:7:"FIG. 40";s:5:"figid";s:2:"40";s:6:"subfig";s:0:"";s:10:"is_caption";s:1:"1";s:11:"description";s:189:"Fig. 40 is a right side view of the combined mat and stand component <span class="highlighted">show</span>n in fig. 36, a left side view thereof being a mirror image of the right side view;";s:6:"aspect";s:11:"right side ";s:6:"object";s:12:"combined mat";}'),
	(2, 'p@gmail.com', 'a:10:{s:8:"patentID";s:19:"USD0873000-20200121";s:3:"pid";s:6:"p-0040";s:11:"is_multiple";s:1:"0";s:11:"origreftext";s:7:"FIG. 40";s:5:"figid";s:2:"40";s:6:"subfig";s:0:"";s:10:"is_caption";s:1:"1";s:11:"description";s:139:"Fig. 40 is a back perspective view of the electric self propelled motorized suitcase in which the handle is open and the bracket is closed.";s:6:"aspect";s:17:"back perspective ";s:6:"object";s:13:"electric self";}'),
	(3, 'p@gmail.com', 'a:10:{s:8:"patentID";s:19:"USD0873147-20200121";s:3:"pid";s:6:"p-0040";s:11:"is_multiple";s:1:"0";s:11:"origreftext";s:7:"FIG. 40";s:5:"figid";s:2:"40";s:6:"subfig";s:0:"";s:10:"is_caption";s:1:"1";s:11:"description";s:43:"Fig. 40 is bottom perspective view thereof.";s:6:"aspect";s:19:"bottom perspective ";s:6:"object";s:1:"0";}'),
	(4, 'p@gmail.com', 'a:10:{s:8:"patentID";s:19:"USD0873007-20200121";s:3:"pid";s:6:"p-0040";s:11:"is_multiple";s:1:"0";s:11:"origreftext";s:7:"FIG. 40";s:5:"figid";s:2:"40";s:6:"subfig";s:0:"";s:10:"is_caption";s:1:"1";s:11:"description";s:61:"Fig. 40 is a rear perspective view thereof, taken from below.";s:6:"aspect";s:17:"rear perspective ";s:6:"object";s:1:"0";}'),
	(5, 'p@gmail.com', 'a:10:{s:8:"patentID";s:19:"USD0873147-20200121";s:3:"pid";s:6:"p-0040";s:11:"is_multiple";s:1:"0";s:11:"origreftext";s:7:"FIG. 40";s:5:"figid";s:2:"40";s:6:"subfig";s:0:"";s:10:"is_caption";s:1:"1";s:11:"description";s:43:"Fig. 40 is bottom perspective view thereof.";s:6:"aspect";s:19:"bottom perspective ";s:6:"object";s:1:"0";}');
/*!40000 ALTER TABLE `saves` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
