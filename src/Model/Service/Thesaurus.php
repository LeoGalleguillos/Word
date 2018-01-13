<?php
namespace LeoGalleguillos\Word\Model\Service;

use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Table as WordTable;

class Thesaurus
{
    /**
     * Construct.
     */
    public function __construct(
        WordTable\Thesaurus $thesaurusTable
    ) {
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
}
