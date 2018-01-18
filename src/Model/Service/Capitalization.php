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

        if (ctype_lower($letters[0])) {
            return new WordEntity\Capitalization\Lowercase();
        }

        $letters = str_split($letters);
        foreach ($letters as $letter) {
            if (ctype_lower($letter)) {
                return new WordEntity\Capitalization\Capitalized();
            }
        }

        return new WordEntity\Capitalization\Uppercase();
    }

    public function setCapitalization(
        WordEntity\Word $wordEntity,
        WordEntity\Capitalization $capitalizationEntity
    ) {
        switch (get_class($capitalizationEntity)) {
            case WordEntity\Capitalization\Capitalized::class:
                $wordEntity->word = strtolower($wordEntity->word);
                $wordEntity->word = ucfirst($wordEntity->word);
                break;
            case WordEntity\Capitalization\Lowercase::class:
                $wordEntity->word = strtolower($wordEntity->word);
                break;
            case WordEntity\Capitalization\Uppercase::class:
                $wordEntity->word = strtoupper($wordEntity->word);
                break;
        }

        return $wordEntity;
    }
}
