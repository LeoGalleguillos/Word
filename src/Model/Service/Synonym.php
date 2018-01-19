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
        WordService\Capitalization $capitalizationService,
        WordService\Thesaurus $thesaurusService,
        WordService\Word $wordService
    ) {
        $this->capitalizationService = $capitalizationService;
        $this->thesaurusService      = $thesaurusService;
        $this->wordService           = $wordService;
    }

    /**
     * Get synonym.
     *
     * @param string $word
     * @param int $dividend
     * @return WordEntity\Word
     * @throws Exception
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

    /**
     * Get synonym.
     *
     * @param string $word
     * @param int $dividend
     * @return WordEntity\Word
     * @throws Exception
     */
    public function getSynonymWithCapitalization(
        string $word,
        int $dividend
    ) {
        $synonym        = $this->getSynonym($word, $dividend);
        $wordEntity     = $this->wordService->getEntityFromString($word);
        $capitalization = $this->capitalizationService->getCapitalization($wordEntity);
        $synonym        = $this->capitalizationService->setCapitalization(
            $synonym,
            $capitalization
        );

        return $synonym;
    }
}
