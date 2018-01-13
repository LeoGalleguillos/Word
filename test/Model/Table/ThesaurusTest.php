<?php
namespace LeoGalleguillos\WordTest\Model\Table;

use ArrayObject;
use LeoGalleguillos\WordTest\TableTestCase;
use LeoGalleguillos\Word\Model\Table as WordTable;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class ThesaurusTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath = __DIR__ . '/../../..' . '/sql/leogalle_test/thesaurus/';

    protected function setUp()
    {
        $configArray     = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray     = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter   = new Adapter($configArray);
        $this->thesaurusTable = new WordTable\Thesaurus($this->adapter);
        $this->wordTable      = new WordTable\Word($this->adapter);

        $this->dropTable();
        $this->createTable();
    }

    protected function dropTable()
    {
        $sql = file_get_contents($this->sqlDatabaseDirectory . '/thesaurus/drop.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    protected function createTable()
    {
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
        $this->assertSame(
            true,
            $this->thesaurusTable->insertIgnore(1, 2)
        );
    }
}
