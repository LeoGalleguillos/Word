<?php
namespace LeoGalleguillos\Word\Model\Service;

use Exception;
use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Factory as WordFactory;
use LeoGalleguillos\Word\Model\Table as WordTable;

class Thesaurus
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
        try {
            $thesaurusUpdated = $this->wordTable->selectThesaurusUpdatedWhereWordId(
                $wordEntity->wordId
            );
        } catch (Exception $exception) {

        }
        if ($thesaurusUpdated ?? null) {
            return $this->getSynonymsFromMySql($wordEntity);
        }

        $this->wordTable->updateSetThesaurusUpdatedToNowWhereWordId(
            $wordEntity->wordId
        );
        // (insert and get) or (get) every word
        // return all word entities
        return [];
    }
}
