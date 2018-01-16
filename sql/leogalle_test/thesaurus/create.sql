CREATE TABLE `thesaurus` (
      `word_id` int(10) unsigned NOT NULL,
      `synonym_word_id` int(10) unsigned NOT NULL,
      `order` int(3) unsigned NOT NULL,
      PRIMARY KEY (`word_id`, `synonym_word_id`),
      UNIQUE (`word_id`, `order`),
      CONSTRAINT `word_id` FOREIGN KEY (`word_id`) REFERENCES `word` (`word_id`) ON DELETE CASCADE ON UPDATE CASCADE,
      CONSTRAINT `synonym_word_id` FOREIGN KEY (`synonym_word_id`) REFERENCES `word` (`word_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
