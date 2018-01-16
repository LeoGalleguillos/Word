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
        $this->thesaurusTableMock = $this->createMock(
            WordTable\Thesaurus::class
        );
        $this->wordTableMock = $this->createMock(
            WordTable\Word::class
        );
        $this->thesaurusService = new WordService\Thesaurus(
            $this->wordFactoryMock,
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

    public function testGetSynonymsFromMySql()
    {
        $arrayObject1        = new ArrayObject([
            'word_id' => '1',
            'word'    => 'test',
            'thesaurus_updated' => null,
        ]);
        $wordEntity1         = new WordEntity\Word();
        $wordEntity1->wordId = 1;
        $wordEntity1->word   = 'test';

        $wordEntity2         = new WordEntity\Word();
        $wordEntity2->wordId = 2;
        $wordEntity2->word   = 'essay';
        $arrayObject2        = new ArrayObject([
            'word_id' => '2',
            'word'    => 'essay',
            'thesaurus_updated' => null,
        ]);

        $wordEntity3         = new WordEntity\Word();
        $wordEntity3->wordId = 3;
        $wordEntity3->word   = 'trial';
        $arrayObject3        = new ArrayObject([
            'word_id' => '3',
            'word'    => 'trial',
            'thesaurus_updated' => null,
        ]);

        $this->thesaurusTableMock->method('selectWhereWordId')->will(
            $this->onConsecutiveCalls(
                [],
                [
                    $arrayObject2,
                    $arrayObject3,
                ]
            )
        );
        $this->wordFactoryMock->method('buildFromArrayObject')->will(
            $this->onConsecutiveCalls($wordEntity2, $wordEntity3)
        );

        $reflectionClass = new ReflectionClass($this->thesaurusService);
        $reflectionMethod = $reflectionClass->getMethod('getSynonymsFromMySql');
        $reflectionMethod->setAccessible(true);

        $this->assertEquals(
            [],
            $reflectionMethod->invokeArgs($this->thesaurusService, [$wordEntity1])
        );

        $this->assertEquals(
            [
                $wordEntity2,
                $wordEntity3,
            ],
            $reflectionMethod->invokeArgs($this->thesaurusService, [$wordEntity1])
        );
    }
}
