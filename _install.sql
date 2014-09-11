SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `blogdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `blogdb`;

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

INSERT INTO `posts` (`id`, `userid`, `text`, `title`) VALUES
(20, 9, 'qqqqqqqq', 'qqqqqqqq'),
(3, 6, '3q qfr qwegf qew Lorem ipsum dolor sit amet, c\r\n\r\n\r\nqwef qw\r\n qwef\r\n qewf qwef\r\nqew \r\n\r\ne\r\nee\r\ne\r\neonsectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.qfr qwegf qew Lorem ipsum dolor sit amet, c\r\n\r\n\r\nqwef qw\r\n qwef\r\n qewf qwef\r\nqew \r\n\r\ne\r\nee\r\ne\r\neonsectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.qfr qwegf qew Lorem ipsum dolor sit amet, c\r\n\r\n\r\nqwef qw\r\n qwef\r\n qewf qwef\r\nqew \r\n\r\ne\r\nee\r\ne\r\neonsectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'newtitle!!!'),
(4, 6, '4  e et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'fugiat nulla'),
(6, 6, '6 rcitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in rep\r\n\r\n       rehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur Lorem ipsum dolor sit amet, consectetur adipiscing el\r\n       it, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exe. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'occaecat cupidatat non '),
(7, 6, '7 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem Ipsum'),
(8, 6, '8 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem Ipsum'),
(9, 6, '9 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem Ipsum'),
(10, 6, '10 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem Ipsum'),
(11, 6, '11 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem Ipsum'),
(12, 6, '12 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem Ipsum');

CREATE TABLE IF NOT EXISTS `tagbp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postid` int(11) NOT NULL,
  `tagid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

INSERT INTO `tagbp` (`id`, `postid`, `tagid`) VALUES
(1, 3, 1),
(2, 3, 2),
(3, 4, 2),
(4, 4, 3),
(5, 6, 3),
(6, 6, 4);

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

INSERT INTO `tags` (`id`, `tag`) VALUES
(1, 'новости'),
(2, 'интересно'),
(3, 'шоубизнес'),
(4, 'политика');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `passhash` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sesshash` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(10) unsigned NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

INSERT INTO `users` (`id`, `login`, `fullname`, `passhash`, `sesshash`, `role`) VALUES
(6, 'john', '', 'fb386cfd7213b45446a9e5137d44358397b2b1910dd992f9fd95e31d8ff1df37', 'a78f28f49bee957e2faefce76698b407e8bb6618f5f26306717d979bc6eca646', 2),
(7, 'andrew', '', '5fe3b861a1951a2bf841ea5068b3684091689590d2f5e5b9db3e2204cf435cad', '599be221b0838a27482660fdd10dc136ff9afa0f4d7d4218cb4feede939cc2df', 2),
(8, 'admin', '', '49b148bd4df6ba4ee192c3a3debf3eddbb7ff9eb1d0c4d83592a02b9decdf037', 'db8f67139295b7dcdc91e13a7b702c76a104b1284da2568e4da805019e0fba7e', 1),
(9, 'alex', '', '49b148bd4df6ba4ee192c3a3debf3eddbb7ff9eb1d0c4d83592a02b9decdf037', '7f518610cea3a20dc3bbcf60d7a183eea1b86979b004e8907731f05fff57f8cc', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
