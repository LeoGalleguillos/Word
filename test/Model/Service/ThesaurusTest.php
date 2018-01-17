<?php
namespace LeoGalleguillos\WordTest\Model\Service;

use ArrayObject;
use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Factory as WordFactory;
use LeoGalleguillos\Word\Model\Service as WordService;
use LeoGalleguillos\Word\Model\Table as WordTable;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ThesaurusTest extends TestCase
{
    protected function setUp()
    {
        $this->wordFactoryMock = $this->createMock(
            WordFactory\Word::class
        );
        $this->thesaurusMySqlServiceMock = $this->createMock(
            WordService\Thesaurus\MySql::class
        );
        $this->thesaurusTableMock = $this->createMock(
            WordTable\Thesaurus::class
        );
        $this->wordTableMock = $this->createMock(
            WordTable\Word::class
        );
        $this->thesaurusService = new WordService\Thesaurus(
            $this->wordFactoryMock,
            $this->thesaurusMySqlServiceMock,
            $this->thesaurusTableMock,
            $this->wordTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordService\Thesaurus::class,
            $this->thesaurusService
        );
    }

    public function testGetSynonyms()
    {
        $wordEntity1         = new WordEntity\Word();
        $wordEntity1->wordId = 1;
        $wordEntity1->word   = 'test';

        $this->assertSame(
            [],
            $this->thesaurusService->getSynonyms($wordEntity1)
        );
    }
}
