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

    public function testBuildFromArrayObject()
    {
        $arrayObject = new ArrayObject([
            'word_id'           => '1',
            'word'              => 'word',
            'thesaurus_updated' => null,
        ]);
        $wordEntity = new WordEntity\Word();
        $wordEntity->wordId           = 1;
        $wordEntity->word             = 'word';
        $wordEntity->thesaurusUpdated = null;

        $this->assertEquals(
            $wordEntity,
            $this->wordFactory->buildFromArrayObject($arrayObject)
        );
    }

    public function testBuildFromWord()
    {
        $arrayObject = new ArrayObject([
            'word_id'           => '10',
            'word'              => 'test',
            'thesaurus_updated' => '2018-01-17 08:39:12',
        ]);
        $wordEntity = new WordEntity\Word();
        $wordEntity->wordId           = 10;
        $wordEntity->word             = 'test';
        $wordEntity->thesaurusUpdated = '2018-01-17 08:39:12';

        $this->wordTableMock->method('selectWhereWord')->willReturn(
            $arrayObject
        );

        $this->assertEquals(
            $wordEntity,
            $this->wordFactory->buildFromWord('test')
        );
    }
}
