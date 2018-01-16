<?php
namespace LeoGalleguillos\WordTest\Model\Service;

use LeoGalleguillos\Word\Model\Service as WordService;
use LeoGalleguillos\Word\Model\Table as WordTable;
use PHPUnit\Framework\TestCase;

class WordTest extends TestCase
{
    protected function setUp()
    {
        $this->wordTableMock = $this->createMock(
            WordTable\Word::class
        );
        $this->wordService = new WordService\Word(
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
