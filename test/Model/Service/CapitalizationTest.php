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

    public function testGetCapitalization()
    {
        $wordEntity = new WordEntity\Word();

        $this->lettersOnlyServiceMock->method('getLettersOnly')->will(
            $this->onConsecutiveCalls(
                '', 'a', 'z', 'abc', 'aBc', 'aBC', 'Abc', 'AbC', 'A', 'ABC'
            )
        );

        $this->assertInstanceOf(
            WordEntity\Capitalization\Unknown::class,
            $this->capitalizationService->getCapitalization($wordEntity)
        );
        $this->assertInstanceOf(
            WordEntity\Capitalization\Lowercase::class,
            $this->capitalizationService->getCapitalization($wordEntity)
        );
        $this->assertInstanceOf(
            WordEntity\Capitalization\Lowercase::class,
            $this->capitalizationService->getCapitalization($wordEntity)
        );
        $this->assertInstanceOf(
            WordEntity\Capitalization\Lowercase::class,
            $this->capitalizationService->getCapitalization($wordEntity)
        );
        $this->assertInstanceOf(
            WordEntity\Capitalization\Lowercase::class,
            $this->capitalizationService->getCapitalization($wordEntity)
        );
        $this->assertInstanceOf(
            WordEntity\Capitalization\Lowercase::class,
            $this->capitalizationService->getCapitalization($wordEntity)
        );
        $this->assertInstanceOf(
            WordEntity\Capitalization\Capitalized::class,
            $this->capitalizationService->getCapitalization($wordEntity)
        );
        $this->assertInstanceOf(
            WordEntity\Capitalization\Capitalized::class,
            $this->capitalizationService->getCapitalization($wordEntity)
        );
        $this->assertInstanceOf(
            WordEntity\Capitalization\Uppercase::class,
            $this->capitalizationService->getCapitalization($wordEntity)
        );
        $this->assertInstanceOf(
            WordEntity\Capitalization\Uppercase::class,
            $this->capitalizationService->getCapitalization($wordEntity)
        );
    }

    public function testSetCapitalization()
    {
        $wordEntity = new WordEntity\Word();
        $wordEntity->word = 'HELLO';

        $this->capitalizationService->setCapitalization(
            $wordEntity,
            new WordEntity\Capitalization\Lowercase()
        );
        $this->assertSame(
            'hello',
            $wordEntity->word
        );

        $this->capitalizationService->setCapitalization(
            $wordEntity,
            new WordEntity\Capitalization\Uppercase()
        );
        $this->assertSame(
            'HELLO',
            $wordEntity->word
        );

        $this->capitalizationService->setCapitalization(
            $wordEntity,
            new WordEntity\Capitalization\Capitalized()
        );
        $this->assertSame(
            'Hello',
            $wordEntity->word
        );

        $wordEntity->word = 'A!@#a';

        $this->capitalizationService->setCapitalization(
            $wordEntity,
            new WordEntity\Capitalization\Lowercase()
        );
        $this->assertSame(
            'a!@#a',
            $wordEntity->word
        );

        $this->capitalizationService->setCapitalization(
            $wordEntity,
            new WordEntity\Capitalization\Uppercase()
        );
        $this->assertSame(
            'A!@#A',
            $wordEntity->word
        );

        $this->capitalizationService->setCapitalization(
            $wordEntity,
            new WordEntity\Capitalization\Capitalized()
        );
        $this->assertSame(
            'A!@#a',
            $wordEntity->word
        );

        $wordEntity->word = '';

        $this->capitalizationService->setCapitalization(
            $wordEntity,
            new WordEntity\Capitalization\Lowercase()
        );
        $this->assertSame(
            '',
            $wordEntity->word
        );

        $this->capitalizationService->setCapitalization(
            $wordEntity,
            new WordEntity\Capitalization\Uppercase()
        );
        $this->assertSame(
            '',
            $wordEntity->word
        );

        $this->capitalizationService->setCapitalization(
            $wordEntity,
            new WordEntity\Capitalization\Capitalized()
        );
        $this->assertSame(
            '',
            $wordEntity->word
        );
    }
}
