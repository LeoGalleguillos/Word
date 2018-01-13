<?php
namespace LeoGalleguillos\Word\Model\Entity;

use DateTime;

class Word
{
    /**
     * @var DateTime
     */
    public $thesaurusUpdated;

    /**
     * @var string
     */
    public $word;

    /**
     * Word ID.
     */
    public $wordId;
}
