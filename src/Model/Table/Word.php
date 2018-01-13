<?php
namespace LeoGalleguillos\Word\Model\Table;

use ArrayObject;
use Zend\Db\Adapter\Adapter;

class Word
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
        string $word
    ) {
        $sql = '
            INSERT IGNORE
              INTO `word` (`word`)
            VALUES (?)
                 ;
        ';
        $parameters = [
            $word,
        ];
        return (int) $this->adapter
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
              FROM `word`
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
    public function selectWhereWordId(int $wordId) : ArrayObject
    {
        $sql = '
            SELECT `word`.`word_id`
                 , `word`.`title`
                 , `word`.`body`
                 , `word`.`thumbnail_root_relative_path`
              FROM `word`
             WHERE `word`.`word_id` = ?
                 ;
        ';
        $result = $this->adapter->query($sql, [$wordId])->current();

        return $result;
    }
}
