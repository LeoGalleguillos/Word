<?php
namespace LeoGalleguillos\WordTest\Model\Entity;

use LeoGalleguillos\Word\Model\Entity as WordEntity;
use PHPUnit\Framework\TestCase;

class CapitalizationTest extends TestCase
{
    protected function setUp()
    {
        $this->capitalizationEntity = $this->getMockForAbstractClass(
            WordEntity\Capitalization::class
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordEntity\Capitalization::class,
            $this->capitalizationEntity
        );
    }
}
