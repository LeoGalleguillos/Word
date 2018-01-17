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
        WordService\Word $wordService,
        WordTable\Thesaurus $thesaurusTable,
        WordTable\Word $wordTable
    ) {
        $this->wordFactory           = $wordFactory;
        $this->thesaurusMySqlService = $thesaurusMySqlService;
        $this->wordService           = $wordService;
        $this->thesaurusTable        = $thesaurusTable;
        $this->wordTable             = $wordTable;
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
        $wordEntity = $this->wordService->getEntityFromString($word);

        if ($this->thesaurusMySqlService->shouldSynonymsBeRetrievedFromMySql($wordEntity)) {
            return $this->thesaurusMySqlService->getSynonyms($wordEntity);
        }

        // (insert and get) or (get) every word
        // return all word entities
        return [];
    }
}
