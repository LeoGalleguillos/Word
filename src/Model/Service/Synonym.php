<?php
namespace LeoGalleguillos\Word\Model\Service;

use Exception;
use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Service as WordService;

class Synonym
{
    /**
     * Construct.
     */
    public function __construct(
        WordService\Thesaurus $thesaurusService
    ) {
        $this->thesaurusService = $thesaurusService;
    }

    /**
     * Get synonym.
     *
     * @param string $word
     * @param int $dividend
     * @return WordEntity\Word[]
     */
    public function getSynonym(
        string $word,
        int $dividend
    ) : WordEntity\Word {
        $synonyms = $this->thesaurusService->getSynonyms($word);

        if (empty($synonyms)) {
            throw new Exception('Unable to get synonyms.');
        }

        $divisor = count($synonyms);
        $index   = $dividend % $divisor;
        return $synonyms[$index];
    }
}
