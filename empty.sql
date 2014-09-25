SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(10000) COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `postid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postid` int(10) unsigned NOT NULL,
  `filename` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=67 ;

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(10) unsigned NOT NULL,
  `browser` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `os` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `fromurl` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `url` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `uniq` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3310 ;

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(10000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

TRUNCATE TABLE `pages`;
INSERT INTO `pages` (`id`, `title`, `text`) VALUES
(1, 'Краткая информация об этом блоге', ''),
(2, 'Полезные ссылки по теме блога', '');

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `date` int(10) unsigned NOT NULL DEFAULT '946684800',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=73 ;

DROP TABLE IF EXISTS `tagbp`;
CREATE TABLE IF NOT EXISTS `tagbp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postid` int(11) NOT NULL,
  `tagid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=181 ;

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=67 ;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `passhash` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sesshash` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(10) unsigned NOT NULL DEFAULT '3',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

TRUNCATE TABLE `users`;
INSERT INTO `users` (`id`, `login`, `fullname`, `passhash`, `sesshash`, `role`, `email`) VALUES
(25, 'user', 'User User', '49b148bd4df6ba4ee192c3a3debf3eddbb7ff9eb1d0c4d83592a02b9decdf037', '10833ab354398e60d15a0ab4d13814e10dc7a5ff6ae5ab5245a496693f8a35d4', 3, ''),
(8, 'admin', 'Админ', '49b148bd4df6ba4ee192c3a3debf3eddbb7ff9eb1d0c4d83592a02b9decdf037', 'f17a15f107ea7852e44fe7ac462594799aba3754cb853789daa130e50d5a2444', 1, 'admin@localhost'),
(23, 'editor', 'Editor One', '49b148bd4df6ba4ee192c3a3debf3eddbb7ff9eb1d0c4d83592a02b9decdf037', '91488f29df72b34a8da8d4863bf8b7e2ec0b4fbe1931afbec287f94aa961a44c', 2, 'editor@localhost'),
(24, 'john', 'John Locke', '49b148bd4df6ba4ee192c3a3debf3eddbb7ff9eb1d0c4d83592a02b9decdf037', 'e2eedb974af95010c97d35438db7b09d24ca2e5387c21c20dece39f0f5f56682', 2, 'asdasdas@mail.ru');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
