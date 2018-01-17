<?php
namespace LeoGalleguillos\WordTest\Model\Table;

use ArrayObject;
use Exception;
use LeoGalleguillos\WordTest\TableTestCase;
use LeoGalleguillos\Word\Model\Table as WordTable;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class WordTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath = __DIR__ . '/../../..' . '/sql/leogalle_test/word/';

    protected function setUp()
    {
        $configArray     = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray     = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter   = new Adapter($configArray);
        $this->wordTable = new WordTable\Word($this->adapter);

        $this->setForeignKeyChecks0();
        $this->dropTable();
        $this->createTable();
        $this->setForeignKeyChecks1();
    }

    protected function dropTable()
    {
        $sql = file_get_contents($this->sqlPath . 'drop.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    protected function createTable()
    {
        $sql = file_get_contents($this->sqlPath . 'create.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(WordTable\Word::class, $this->wordTable);
    }

    public function testInsertIgnore()
    {
        $this->assertSame(
            1,
            $this->wordTable->insertIgnore('word')
        );
        $this->assertSame(
            2,
            $this->wordTable->insertIgnore('another')
        );
        $this->assertSame(
            0,
            $this->wordTable->insertIgnore('word')
        );
        $this->assertSame(
            4,
            $this->wordTable->insertIgnore('again')
        );
    }

    public function testSelectCount()
    {
        $this->assertSame(
            0,
            $this->wordTable->selectCount()
        );
        $this->wordTable->insertIgnore('word');
        $this->assertSame(
            1,
            $this->wordTable->selectCount()
        );
    }

    public function testSelectCountWhereWord()
    {
        $this->assertSame(
            0,
            $this->wordTable->selectCountWhereWord('word')
        );
        $this->wordTable->insertIgnore('word');
        $this->assertSame(
            1,
            $this->wordTable->selectCountWhereWord('word')
        );
    }

    public function testSelectThesaurusUpdatedWhereWordId()
    {
        try {
            $this->wordTable->selectThesaurusUpdatedWhereWordId(1);
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Word ID not found.',
                $exception->getMessage()
            );
        }

        $this->wordTable->insertIgnore('hello');
        $this->assertNull($this->wordTable->selectThesaurusUpdatedWhereWordId(1));

        $this->wordTable->updateSetThesaurusUpdatedToNowWhereWordId(1);
        $this->assertNotNull($this->wordTable->selectThesaurusUpdatedWhereWordId(1));
    }

    public function testSelectWhereWordId()
    {
        try {
            $this->wordTable->selectWhereWordId(1);
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Word ID not found.',
                $exception->getMessage()
            );
        }

        $this->wordTable->insertIgnore('word', '2018-01-16 14:37:30');
        $arrayObject = new ArrayObject([
            'word_id'           => '1',
            'word'              => 'word',
            'thesaurus_updated' => '2018-01-16 14:37:30',
        ]);
        $this->assertEquals(
            $arrayObject,
            $this->wordTable->selectWhereWordId(1)
        );
    }

    public function testSelectWhereWord()
    {
        try {
            $this->wordTable->selectWhereWord('test');
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Word not found.',
                $exception->getMessage()
            );
        }

        $this->wordTable->insertIgnore('word', '2018-01-16 14:37:30');
        $arrayObject = new ArrayObject([
            'word_id'           => '1',
            'word'              => 'word',
            'thesaurus_updated' => '2018-01-16 14:37:30',
        ]);
        $this->assertEquals(
            $arrayObject,
            $this->wordTable->selectWhereWord('word')
        );
    }

    public function testUpdateSetThesaurusUpdatedToNowWhereWordId()
    {
        $this->assertFalse(
            $this->wordTable->updateSetThesaurusUpdatedToNowWhereWordId(1)
        );
        $this->wordTable->insertIgnore('word', '2018-01-16 14:37:30');
        $this->assertTrue(
            $this->wordTable->updateSetThesaurusUpdatedToNowWhereWordId(1)
        );
    }
}
