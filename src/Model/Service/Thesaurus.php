<?php
namespace LeoGalleguillos\Word\Model\Service;

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
        WordTable\Thesaurus $thesaurusTable
    ) {
        $this->wordFactory    = $wordFactory;
        $this->thesaurusTable = $thesaurusTable;
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
        $arrays = $this->thesaurusTable->selectWhereWordId(
            $wordEntity->wordId
        );

        return [];
    }

    public function getSynonymsFromMySql(
        WordEntity\Word $wordEntity
    ) : array {
        $wordEntities = [];

        $arrays = $this->thesaurusTable->selectWhereWordId(
            $wordEntity->wordId
        );

        foreach ($arrays as $array) {

        }

        return $wordEntities;
    }
}
