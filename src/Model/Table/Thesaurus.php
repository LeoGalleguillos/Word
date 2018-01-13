<?php
namespace LeoGalleguillos\Word\Model\Table;

use ArrayObject;
use Zend\Db\Adapter\Adapter;

class Thesaurus
{
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Insert ignore.
     *
     * @param string $word
     * @return int Primary key or 0 for failed insert
     */
    public function insertIgnore(
        int $wordId,
        int $synonymWordId
    ) {
        $sql = '
            INSERT IGNORE
              INTO `thesaurus` (`word_id`, `sysnonym_word_id`)
            VALUES (?, ?)
                 ;
        ';
        $parameters = [
            $word,
            $synonymWordId,
        ];
        return $this->adapter
                    ->query($sql, $parameters)
                    ->getGeneratedValue();
    }

    /**
     * Select count.
     *
     * @return int
     */
    public function selectCount()
    {
        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `thesaurus`
                 ;
        ';
        $row = $this->adapter->query($sql)->execute()->current();
        return (int) $row['count'];
    }

    /**
     * Select where word ID.
     *
     * @param int $wordId
     * @return ArrayObject
     */
    public function selectWhereWordId(int $wordId)
    {
        $sql = '
            SELECT `thesaurus`.`word_id`
                 , `thesaurus`.`synonym_word_id`
              FROM `thesaurus`
             WHERE `thesaurus`.`word_id` = ?
                 ;
        ';

        $results = $this->adapter->query($sql, [$wordId]);

        $rows = [];
        foreach ($results as $row) {
            $rows[] = (array) $row;
        }

        return $rows;
    }
}
