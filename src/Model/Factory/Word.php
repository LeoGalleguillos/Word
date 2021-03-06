<?php
namespace LeoGalleguillos\Word\Model\Factory;

use ArrayObject;
use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Table as WordTable;
use Zend\Db\Adapter\Adapter;

class Word
{
    public function __construct(
        WordTable\Word $wordTable
    ) {
        $this->wordTable = $wordTable;
    }

    public function buildFromArrayObject(
        ArrayObject $arrayObject
    ) : WordEntity\Word {
        $wordEntity = new WordEntity\Word();

        $wordEntity->wordId           = (int) $arrayObject['word_id'];
        $wordEntity->word             = $arrayObject['word'];
        $wordEntity->thesaurusUpdated = $arrayObject['thesaurus_updated'] ?? null;

        return $wordEntity;
    }

    public function buildFromWord(string $word) : WordEntity\Word
    {
        $wordEntity = $this->buildFromArrayObject(
            $this->wordTable->selectWhereWord($word)
        );
        $wordEntity->word = $word;
        return $wordEntity;
    }
}
