<?php
namespace LeoGalleguillos\Word\Model\Table;

use ArrayObject;
use Zend\Db\Adapter\Adapter;

class Thesaurus
{
    /**
     * Construct.
     *
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Insert ignore.
     *
     * @param string $word
     * @return bool
     */
    public function insertIgnore(
        int $wordId,
        int $synonymWordId
    ) : bool {
        $sql = '
            INSERT IGNORE
              INTO `thesaurus` (`word_id`, `synonym_word_id`)
            VALUES (?, ?)
                 ;
        ';
        $parameters = [
            $wordId,
            $synonymWordId,
        ];
        return $this->adapter
                          ->query($sql, $parameters)
                          ->getAffectedRows();
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
            SELECT `word`.`word_id`
                 , `word`.`word`
                 , `word`.`thesaurus_updated`
              FROM `thesaurus`

              JOIN `word`
                ON `thesaurus`.`synonym_word_id` = `word`.`word_id`

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
