<?php
namespace LeoGalleguillos\Word\Model\Service\Word;

use LeoGalleguillos\Word\Model\Entity as WordEntity;

class LettersOnly
{
    public function getLettersOnly(WordEntity\Word $wordEntity) : string
    {
        return preg_replace(
            '/[^A-Za-z]/',
            '',
            $wordEntity->word
        );
    }
}
