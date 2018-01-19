<?php
namespace LeoGalleguillos\WordTest\Model\Service;

use ArrayObject;
use Exception;
use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Factory as WordFactory;
use LeoGalleguillos\Word\Model\Service as WordService;
use LeoGalleguillos\Word\Model\Table as WordTable;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class SynonymTest extends TestCase
{
    protected function setUp()
    {
        $this->thesaurusServiceMock = $this->createMock(
            WordService\Thesaurus::class
        );
        $this->synonymService = new WordService\Synonym(
            $this->thesaurusServiceMock
        );

        $this->wordEntity1         = new WordEntity\Word();
        $this->wordEntity1->wordId = 1;
        $this->wordEntity1->word   = 'test';

        $this->wordEntity2         = new WordEntity\Word();
        $this->wordEntity2->wordId = 2;
        $this->wordEntity2->word   = 'essay';

        $this->wordEntity3         = new WordEntity\Word();
        $this->wordEntity3->wordId = 3;
        $this->wordEntity3->word   = 'experimentation';

        $this->wordEntity4         = new WordEntity\Word();
        $this->wordEntity4->wordId = 4;
        $this->wordEntity4->word   = 'experimentation';

        $this->wordEntities        = [
            $this->wordEntity2,
            $this->wordEntity3,
            $this->wordEntity4,
        ];
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordService\Synonym::class,
            $this->synonymService
        );
    }

    public function testGetSynonym()
    {
        $this->thesaurusServiceMock->method('getSynonyms')->will(
            $this->onConsecutiveCalls(
                [], $this->wordEntities, $this->wordEntities, $this->wordEntities
            )
        );

        try {
            $this->synonymService->getSynonym('test', 3);
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Unable to get synonyms.',
                $exception->getMessage()
            );
        }

        for ($x = 0; $x < 3; $x++) {
            $randomNumber = rand(1, 10000);
            $this->assertSame(
                $this->wordEntities[2 % count($this->wordEntities)],
                $this->synonymService->getSynonym('test', 2)
            );
        }
    }
}
