<?php
namespace LeoGalleguillos\Word\Model\Service;

use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Service as WordService;

class Capitalization
{
    public function __construct(
        WordService\LettersOnly $lettersOnlyService
    ) {
        $this->lettersOnlyService = $lettersOnlyService;
    }

    public function getCapitalization(
        WordEntity\Word $wordEntity
    ) : WordEntity\Capitalization {
        $letters = $this->lettersOnlyService->getLettersOnly($wordEntity);

        if (empty($letters)) {
            return new WordEntity\Capitalization\Unknown();
        }
    }

    public function setCapitalization(
        WordEntity\Word $wordEntity,
        WordEntity\Capitalization $capitalizationEntity
    ) {

    }
}
