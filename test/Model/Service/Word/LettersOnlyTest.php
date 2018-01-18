<?php
namespace LeoGalleguillos\WordTest\Model\Service\Word;

use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Service as WordService;
use PHPUnit\Framework\TestCase;

class LettersOnlyTest extends TestCase
{
    protected function setUp()
    {
        $this->lettersOnlyService = new WordService\Word\LettersOnly();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordService\Word\LettersOnly::class,
            $this->lettersOnlyService
        );
    }

    public function testGetLettersOnly()
    {
        $wordEntity = new WordEntity\Word();
        $this->assertSame(
            '',
            $this->lettersOnlyService->getLettersOnly($wordEntity)
        );

        $wordEntity->word = 'hello';
        $this->assertSame(
            'hello',
            $this->lettersOnlyService->getLettersOnly($wordEntity)
        );

        $wordEntity->word = 'Hello World';
        $this->assertSame(
            'HelloWorld',
            $this->lettersOnlyService->getLettersOnly($wordEntity)
        );

        $wordEntity->word = '[]\A!@#a$%^B&*(b)_+C<>?c,./';
        $this->assertSame(
            'AaBbCc',
            $this->lettersOnlyService->getLettersOnly($wordEntity)
        );
    }
}
