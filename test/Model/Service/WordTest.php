<?php
namespace LeoGalleguillos\WordTest\Model\Service;

use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Factory as WordFactory;
use LeoGalleguillos\Word\Model\Service as WordService;
use LeoGalleguillos\Word\Model\Table as WordTable;
use PHPUnit\Framework\TestCase;

class WordTest extends TestCase
{
    protected function setUp()
    {
        $this->wordFactoryMock = $this->createMock(
            WordFactory\Word::class
        );
        $this->wordTableMock = $this->createMock(
            WordTable\Word::class
        );
        $this->wordService = new WordService\Word(
            $this->wordFactoryMock,
            $this->wordTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordService\Word::class,
            $this->wordService
        );
    }

    public function testGetEntityFromString()
    {
        $wordEntity1         = new WordEntity\Word();
        $wordEntity1->wordId = 1;
        $wordEntity1->word   = 'test';

        $wordEntity2         = new WordEntity\Word();
        $wordEntity2->wordId = 2;
        $wordEntity2->word   = 'essay';

        $wordEntity3         = new WordEntity\Word();
        $wordEntity3->wordId = 3;
        $wordEntity3->word   = 'trial';

        $this->wordTableMock->method('selectCountWhereWord')->will(
            $this->onConsecutiveCalls(1, 0, 1)
        );

        $this->wordFactoryMock->method('buildFromWord')->will(
            $this->onConsecutiveCalls($wordEntity1, $wordEntity2, $wordEntity3)
        );

        $this->wordTableMock->expects($this->once())->method('insertIgnore');

        $this->assertEquals(
            $wordEntity1,
            $this->wordService->getEntityFromString($wordEntity1->word)
        );

        $this->assertEquals(
            $wordEntity2,
            $this->wordService->getEntityFromString($wordEntity2->word)
        );

        $this->assertEquals(
            $wordEntity3,
            $this->wordService->getEntityFromString($wordEntity3->word)
        );
    }

    public function testIsWordInTable()
    {
        $this->wordTableMock->method('selectCountWhereWord')->will(
            $this->onConsecutiveCalls(0, 1, 0, 1)
        );
        $this->assertFalse($this->wordService->isWordInTable('test'));
        $this->assertTrue($this->wordService->isWordInTable('test'));
        $this->assertFalse($this->wordService->isWordInTable('test'));
        $this->assertTrue($this->wordService->isWordInTable('test'));
    }
}
