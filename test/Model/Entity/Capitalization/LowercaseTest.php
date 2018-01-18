<?php
namespace LeoGalleguillos\WordTest\Model\Entity;

use LeoGalleguillos\Word\Model\Entity as WordEntity;
use PHPUnit\Framework\TestCase;

class LowercaseTest extends TestCase
{
    protected function setUp()
    {
        $this->lowercaseEntity = new WordEntity\Capitalization\Lowercase();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordEntity\Capitalization::class,
            $this->lowercaseEntity
        );

        $this->assertInstanceOf(
            WordEntity\Capitalization\Lowercase::class,
            $this->lowercaseEntity
        );
    }
}
