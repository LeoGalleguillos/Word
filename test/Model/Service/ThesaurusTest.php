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
        $this->thesaurusService = new WordService\Thesaurus(
            //$this->wordTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordService\Thesaurus::class,
            $this->thesaurusService
        );
    }
}
