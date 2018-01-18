<?php
namespace LeoGalleguillos\WordTest\Model\Entity;

use LeoGalleguillos\Word\Model\Entity as WordEntity;
use PHPUnit\Framework\TestCase;

class WordTest extends TestCase
{
    protected function setUp()
    {
        $this->wordEntity = new WordEntity\Word();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(WordEntity\Word::class, $this->wordEntity);
    }

    public function testToString()
    {
        $wordEntity = new WordEntity\Word();
        $this->assertSame(
            '',
            (string) $wordEntity
        );

        $wordEntity->wordId = 123;
        $wordEntity->word   = 'hello';
        $this->assertSame(
            'hello',
            (string) $wordEntity
        );
    }
}
