<?php
namespace LeoGalleguillos\Word\Model\Service;

use Exception;
use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Factory as WordFactory;
use LeoGalleguillos\Word\Model\Service as WordService;
use LeoGalleguillos\Word\Model\Table as WordTable;

class Thesaurus
{
    /**
     * Construct.
     */
    public function __construct(
        WordFactory\Word $wordFactory,
        WordService\Thesaurus\MySql $thesaurusMySqlService,
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
     * @param string $word
     * @return WordEntity\Word[]
     */
    public function getSynonyms(
        string $word
    ) : array {

        // (insert and get) or (get) every word
        // return all word entities
        return [];
    }
}
