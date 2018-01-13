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
     * @return int Primary key
     */
    public function insert(
        string $domain,
        string $name,
        string $googleAnalyticsTrackingId
    ) {
        $sql = '
            INSERT
              INTO `word` (`domain`, `name`, `google_analytics_tracking_id`)
            VALUES (?, ?, ?)
                 ;
        ';
        $parameters = [
            $domain,
            $name,
            $googleAnalyticsTrackingId,
        ];
        return $this->adapter
                    ->query($sql, $parameters)
                    ->getGeneratedValue();
    }

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
