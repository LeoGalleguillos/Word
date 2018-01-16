<?php
namespace LeoGalleguillos\Word\Model\Service;

use LeoGalleguillos\Word\Model\Table as WordTable;

class Word
{
    /**
     * Construct.
     */
    public function __construct(
        WordTable\Word $wordTable
    ) {
        $this->wordTable      = $wordTable;
    }

    /**
     * Is word in table.
     *
     * @param string $word
     * @return bool
     */
    public function isWordInTable(string $word) : bool
    {
        return (bool) $this->wordTable->selectCountWhereWord($word);
    }
}
