<?php
namespace LeoGalleguillos\WordTest\Model\Table;

use ArrayObject;
use LeoGalleguillos\WordTest\TableTestCase;
use LeoGalleguillos\Word\Model\Table as WordTable;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class ThesaurusTest extends TableTestCase
{
    protected function setUp()
    {
        $configArray     = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray     = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter   = new Adapter($configArray);
        $this->thesaurusTable = new WordTable\Thesaurus($this->adapter);
        $this->wordTable      = new WordTable\Word($this->adapter);

        $this->setForeignKeyChecks0();
        $this->dropTables();
        $this->setForeignKeyChecks1();
        $this->createTables();
    }

    protected function dropTables()
    {
        $sql = file_get_contents($this->sqlDatabaseDirectory . '/thesaurus/drop.sql');
        $result = $this->adapter->query($sql)->execute();

        $sql = file_get_contents($this->sqlDatabaseDirectory . '/word/drop.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    protected function createTables()
    {
        $sql = file_get_contents($this->sqlDatabaseDirectory . '/word/create.sql');
        $result = $this->adapter->query($sql)->execute();

        $sql = file_get_contents($this->sqlDatabaseDirectory . '/thesaurus/create.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(WordTable\Thesaurus::class, $this->thesaurusTable);
    }

    public function testInsertIgnore()
    {
        $this->wordTable->insertIgnore('hello');
        $this->assertFalse(
            $this->thesaurusTable->insertIgnore(1, 2, 1)
        );

        $this->wordTable->insertIgnore('world');
        $this->assertTrue(
            $this->thesaurusTable->insertIgnore(1, 2, 1)
        );

        $this->assertFalse(
            $this->thesaurusTable->insertIgnore(1, 2, 1)
        );
        $this->assertFalse(
            $this->thesaurusTable->insertIgnore(1, 2, 2)
        );

        $this->wordTable->insertIgnore('again');
        $this->assertFalse(
            $this->thesaurusTable->insertIgnore(1, 3, 1)
        );
        $this->assertTrue(
            $this->thesaurusTable->insertIgnore(1, 3, 2)
        );
        $this->assertFalse(
            $this->thesaurusTable->insertIgnore(1, 3, 3)
        );
    }

    public function testSelectWhereWordId()
    {
        $this->assertSame(
            [],
            $this->thesaurusTable->selectWhereWordId(123)
        );

        $this->wordTable->insertIgnore('hello');
        $this->wordTable->insertIgnore('world');
        $this->wordTable->insertIgnore('again');

        $this->thesaurusTable->insertIgnore(1, 2, 1);
        $array = [
            new ArrayObject([
                'word_id' => '2',
                'word'    => 'world',
                'thesaurus_updated' => null,
            ]),
        ];
        $this->assertEquals(
            $array,
            $this->thesaurusTable->selectWhereWordId(1)
        );

        $this->thesaurusTable->insertIgnore(1, 3, 2);
        $array = [
            new ArrayObject([
                'word_id' => '2',
                'word'    => 'world',
                'thesaurus_updated' => null,
            ]),
            new ArrayObject([
                'word_id' => '3',
                'word'    => 'again',
                'thesaurus_updated' => null,
            ]),
        ];
        $this->assertEquals(
            $array,
            $this->thesaurusTable->selectWhereWordId(1)
        );
    }
}
