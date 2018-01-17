<?php
namespace LeoGalleguillos\Word\Model\Service\Thesaurus;

use Exception;
use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Factory as WordFactory;
use LeoGalleguillos\Word\Model\Table as WordTable;

class MySql
{
    /**
     * Construct.
     */
    public function __construct(
        WordFactory\Word $wordFactory,
        WordTable\Thesaurus $thesaurusTable,
        WordTable\Word $wordTable
    ) {
        $this->wordFactory    = $wordFactory;
        $this->thesaurusTable = $thesaurusTable;
        $this->wordTable      = $wordTable;
    }

    /**
     * Get synonyms.
     *
     * @param WordEntity\Word $wordEntity
     * @return WordEntity\Word[]
     */
    public function getSynonyms(
        WordEntity\Word $wordEntity
    ) : array {
        $wordEntities = [];

        $arrayObjects = $this->thesaurusTable->selectWhereWordId(
            $wordEntity->wordId
        );

        foreach ($arrayObjects as $arrayObject) {
            $wordEntities[] = $this->wordFactory->buildFromArrayObject($arrayObject);
        }

        return $wordEntities;
    }

    /**
     * Should synonyms be retrieved from MySQL.
     *
     * @param WordEntity\Word $wordEntity
     * @return bool
     */
    public function shouldSynonymsBeRetrievedFromMySql(
        WordEntity\Word $wordEntity
    ) : bool {
        try {
            $thesaurusUpdated = $this->wordTable->selectThesaurusUpdatedWhereWordId(
                $wordEntity->wordId
            );
        } catch (Exception $exception) {
            return false;
        }
        return (bool) $thesaurusUpdated;
    }
}
