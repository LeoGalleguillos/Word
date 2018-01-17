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

        $this->wordEntity1         = new WordEntity\Word();
        $this->wordEntity1->wordId = 1;
        $this->wordEntity1->word   = 'test';

        $this->wordEntity2         = new WordEntity\Word();
        $this->wordEntity2->wordId = 2;
        $this->wordEntity2->word   = 'essay';

        $this->wordEntity3         = new WordEntity\Word();
        $this->wordEntity3->wordId = 3;
        $this->wordEntity3->word   = 'trial';
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordService\Thesaurus::class,
            $this->thesaurusService
        );
    }

    public function testGetSynonymsFromMySql()
    {
        $this->wordServiceMock->method('getEntityFromString')->willReturn(
            $this->wordEntity1
        );
        $this->thesaurusMySqlServiceMock
             ->method('shouldSynonymsBeRetrievedFromMySql')
             ->will(
            $this->onConsecutiveCalls(
                true, false
            )
        );
        $this->thesaurusMySqlServiceMock->method('getSynonyms')->willReturn([
            $this->wordEntity2, $this->wordEntity3
        ]);

        $this->thesaurusMySqlServiceMock->expects($this->once())->method('getSynonyms');
        $this->assertSame(
            [$this->wordEntity2, $this->wordEntity3],
            $this->thesaurusService->getSynonyms($this->wordEntity1->word)
        );
    }

    public function testGetSynonymsFromApi()
    {
        $this->wordServiceMock->method('getEntityFromString')->willReturn(
            $this->wordEntity1,
            $this->wordEntity1,
            $this->wordEntity2,
            $this->wordEntity3
        );
        $this->apiThesaurusServiceMock
             ->method('wasApiCalledRecently')
             ->will(
            $this->onConsecutiveCalls(
                true, false
            )
        );

        $this->assertEquals(
            [],
            $this->thesaurusService->getSynonyms($this->wordEntity1->word)
        );

        $this->apiThesaurusServiceMock->method('getSynonyms')->willReturn(
            [$this->wordEntity2->word, $this->wordEntity3->word]
        );
        $this->assertEquals(
            [$this->wordEntity2, $this->wordEntity3],
            $this->thesaurusService->getSynonyms($this->wordEntity1->word)
        );
    }

    public function testSetSynonyms()
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

        $wordEntities = [
            $wordEntity2,
            $wordEntity3,
        ];

        $this->wordTableMock
             ->expects($this->once())
             ->method('updateSetThesaurusUpdatedToNowWhereWordId');
        $this->thesaurusTableMock
             ->expects($this->exactly(count($wordEntities)))
             ->method('insertIgnore');

        $this->thesaurusService->setSynonyms($wordEntity1, $wordEntities);
    }
}
