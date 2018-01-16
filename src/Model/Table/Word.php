<?php
namespace LeoGalleguillos\Word\Model\Table;

use ArrayObject;
use Exception;
use Zend\Db\Adapter\Adapter;

class Word
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
     * @return int Primary key or 0 for failed insert
     */
    public function insertIgnore(
        string $word,
        string $thesaurusUpdated = null
    ) {
        $sql = '
            INSERT IGNORE
              INTO `word` (`word`, `thesaurus_updated`)
            VALUES (?, ?)
                 ;
        ';
        $parameters = [
            $word,
            $thesaurusUpdated,
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

    public function selectThesaurusUpdatedWhereWordId(int $wordId)
    {
        $sql = '
            SELECT `word`.`thesaurus_updated`
              FROM `word`
             WHERE `word`.`word_id` = ?
                 ;
        ';
        $arrayObject = $this->adapter->query($sql, [$wordId])->current();

        if (empty($arrayObject)) {
            throw new Exception('Word ID not found.');
        }

        return $arrayObject['thesaurus_updated'];
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
                 , `word`.`word`
                 , `word`.`thesaurus_updated`
              FROM `word`
             WHERE `word`.`word_id` = ?
                 ;
        ';
        $arrayObject = $this->adapter->query($sql, [$wordId])->current();

        if (empty($arrayObject)) {
            throw new Exception('Word ID not found.');
        }

        return $arrayObject;
    }

    /**
     * Update set `thesaurus_updated` column to NOW()
     *
     * @param int $wordId
     * @return bool Whether or not update was successful.
     */
    public function updateSetThesaurusUpdatedToNowWhereWordId(int $wordId) : bool
    {
        $sql = '
            UPDATE `word`
               SET `word`.`thesaurus_updated` = NOW()
             WHERE `word`.`word_id` = ?
                 ;
        ';
        return (bool) $this->adapter->query($sql, [$wordId])->getAffectedRows();
    }
}
