<?php
namespace LeoGalleguillos\Word\Model\Service;

use LeoGalleguillos\Word\Model\Factory as WordFactory;
use LeoGalleguillos\Word\Model\Table as WordTable;

class Word
{
    /**
     * Construct.
     */
    public function __construct(
        WordFactory\Word $wordFactory,
        WordTable\Word $wordTable
    ) {
        $this->wordFactory = $wordFactory;
        $this->wordTable   = $wordTable;
    }

    public function getEntityFromString(string $word)
    {
        if ($this->isWordInTable($word)) {
            return $this->wordFactory->buildFromWord($word);
        }

        $this->wordTable->insertIgnore($word);
        return $this->wordFactory->buildFromWord($word);
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
