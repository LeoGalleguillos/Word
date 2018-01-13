CREATE TABLE `word` (
      `word_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `word` varchar(255) NOT NULL,
      `thesaurus_updated` datetime DEFAULT NULL,
      PRIMARY KEY (`word_id`),
      UNIQUE KEY `word` (`word`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
