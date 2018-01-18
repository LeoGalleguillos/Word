<?php
namespace LeoGalleguillos\WordTest\Model\Entity;

use LeoGalleguillos\Word\Model\Entity as WordEntity;
use PHPUnit\Framework\TestCase;

class UppercaseTest extends TestCase
{
    protected function setUp()
    {
        $this->uppercaseEntity = new WordEntity\Capitalization\Uppercase();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordEntity\Capitalization::class,
            $this->uppercaseEntity
        );

        $this->assertInstanceOf(
            WordEntity\Capitalization\Uppercase::class,
            $this->uppercaseEntity
        );
    }
}
