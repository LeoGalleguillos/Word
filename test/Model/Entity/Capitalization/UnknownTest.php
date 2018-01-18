<?php
namespace LeoGalleguillos\WordTest\Model\Entity;

use LeoGalleguillos\Word\Model\Entity as WordEntity;
use PHPUnit\Framework\TestCase;

class UnknownTest extends TestCase
{
    protected function setUp()
    {
        $this->unknownEntity = new WordEntity\Capitalization\Unknown();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordEntity\Capitalization::class,
            $this->unknownEntity
        );

        $this->assertInstanceOf(
            WordEntity\Capitalization\Unknown::class,
            $this->unknownEntity
        );
    }
}
