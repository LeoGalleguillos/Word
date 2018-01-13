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
}
