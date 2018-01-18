<?php
namespace LeoGalleguillos\WordTest\Model\Entity;

use LeoGalleguillos\Word\Model\Entity as WordEntity;
use PHPUnit\Framework\TestCase;

class CapitalizedTest extends TestCase
{
    protected function setUp()
    {
        $this->capitalizedEntity = new WordEntity\Capitalization\Capitalized();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordEntity\Capitalization::class,
            $this->capitalizedEntity
        );

        $this->assertInstanceOf(
            WordEntity\Capitalization\Capitalized::class,
            $this->capitalizedEntity
        );
    }
}
