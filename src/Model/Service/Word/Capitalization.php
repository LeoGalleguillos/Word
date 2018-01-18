<?php
namespace LeoGalleguillos\Word\Model\Service\Word;

use LeoGalleguillos\Word\Model\Entity as WordEntity;

class Capitalization
{
    public function getCapitalization(
        WordEntity\Word $wordEntity
    ) : WordEntity\Capitalization {
        $letters = $this->lettersOnly->getLettersOnly($wordEntity);
    }

    public function setCapitalization(
        WordEntity\Word $wordEntity,
        WordEntity\Capitalization $capitalizationEntity
    ) {

    }
}
