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
        $this->apiThesaurusServiceMock = $this->createMock(
            WordService\Api\DictionaryApiCom\Thesaurus::class
        );
        $this->thesaurusMySqlServiceMock = $this->createMock(
            WordService\Thesaurus\MySql::class
        );
        $this->wordServiceMock = $this->createMock(
            WordService\Word::class
        );
        $this->thesaurusTableMock = $this->createMock(
            WordTable\Thesaurus::class
        );
        $this->wordTableMock = $this->createMock(
            WordTable\Word::class
        );
        $this->thesaurusService = new WordService\Thesaurus(
            $this->wordFactoryMock,
            $this->apiThesaurusServiceMock,
            $this->thesaurusMySqlServiceMock,
            $this->wordServiceMock,
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

        $wordEntity2         = new WordEntity\Word();
        $wordEntity2->wordId = 2;
        $wordEntity2->word   = 'essay';

        $wordEntity3         = new WordEntity\Word();
        $wordEntity3->wordId = 3;
        $wordEntity3->word   = 'trial';

        $this->wordServiceMock->method('getEntityFromString')->will(
            $this->onConsecutiveCalls(
                $wordEntity1, $wordEntity1, $wordEntity2, $wordEntity3
            )
        );
        $this->thesaurusMySqlServiceMock
             ->method('shouldSynonymsBeRetrievedFromMySql')
             ->will(
            $this->onConsecutiveCalls(
                true, false
            )
        );
        $this->thesaurusMySqlServiceMock->method('getSynonyms')->willReturn([
            $wordEntity2, $wordEntity3
        ]);

        $this->thesaurusMySqlServiceMock->expects($this->once())->method('getSynonyms');
        $this->assertSame(
            [$wordEntity2, $wordEntity3],
            $this->thesaurusService->getSynonyms($wordEntity1->word)
        );

        $this->apiThesaurusServiceMock->method('getSynonyms')->willReturn(
            [$wordEntity2->word, $wordEntity3->word]
        );

        $this->apiThesaurusServiceMock->expects($this->once())->method('getSynonyms');
        $this->wordServiceMock
             ->expects($this->exactly(3))
             ->method('getEntityFromString');
        $this->assertEquals(
            [$wordEntity2, $wordEntity3],
            $this->thesaurusService->getSynonyms($wordEntity1->word)
        );
    }
}
