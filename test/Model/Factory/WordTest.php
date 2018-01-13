<?php
namespace LeoGalleguillos\WordTest\Model\Factory;

use ArrayObject;
use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Factory as WordFactory;
use LeoGalleguillos\Word\Model\Table as WordTable;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class WordTest extends TestCase
{
    protected function setUp()
    {
        $this->wordTableMock = $this->createMock(
            WordTable\Word::class
        );
        $this->wordFactory = new WordFactory\Word(
            $this->wordTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(WordFactory\Word::class, $this->wordFactory);
    }
}
