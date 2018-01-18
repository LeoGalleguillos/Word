<?php
namespace LeoGalleguillos\WordTest\Model\Service;

use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Service as WordService;
use PHPUnit\Framework\TestCase;

class CapitalizationTest extends TestCase
{
    protected function setUp()
    {
        $this->lettersOnlyServiceMock = $this->createMock(
            WordService\LettersOnly::class
        );
        $this->capitalizationService = new WordService\Capitalization(
            $this->lettersOnlyServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordService\Capitalization::class,
            $this->capitalizationService
        );
    }
}
