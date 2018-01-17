<?php
namespace LeoGalleguillos\WordTest\Model\Service\Api\DictionaryApiCom;

use ArrayObject;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Factory as WordFactory;
use LeoGalleguillos\Word\Model\Service as WordService;
use LeoGalleguillos\Word\Model\Table as WordTable;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use SimpleXMLElement;

class ThesaurusTest extends TestCase
{
    protected function setUp()
    {
        $this->memcached = new MemcachedService\Memcached();
        $configArray = require(__DIR__ . '/../../../../../config/autoload/local.php');
        $apiKey      = $configArray['dictionaryapicom']['api_key'];
        $this->apiTableMock = $this->createMock(
            WordTable\Api::class
        );
        $this->thesaurusApi = new WordService\Api\DictionaryApiCom\Thesaurus(
            $this->memcached,
            $apiKey,
            $this->apiTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordService\Api\DictionaryApiCom\Thesaurus::class,
            $this->thesaurusApi
        );
    }

    public function testGetSimpleXmlElement()
    {
        $reflectionClass = new ReflectionClass($this->thesaurusApi);
        $reflectionMethod = $reflectionClass->getMethod('getSimpleXmlElement');
        $reflectionMethod->setAccessible(true);
        $simpleXmlElement = $reflectionMethod->invokeArgs(
            $this->thesaurusApi,
            ['test']
        );
        $this->assertInstanceOf(
            SimpleXMLElement::class,
            $simpleXmlElement
        );
    }

    public function testGetSynonyms()
    {
        $synonyms = [
            'essay',
            'exam',
            'experimentation',
            'quiz',
            'sample',
            'strain',
            'stretch',
            'tax',
            'trial',
        ];
        $this->assertSame(
            $synonyms,
            $this->thesaurusApi->getSynonyms('test')
        );
    }

    public function testInsertOnDuplicateKeyUpdate()
    {
        $this->assertNull(
            $this->thesaurusApi->insertOnDuplicateKeyUpdate()
        );
    }

    public function testWasApiCalledRecently()
    {
        $this->apiTableMock->method('selectValueWhereKey')->will(
            $this->onConsecutiveCalls(
                null,
                microtime(true),
                microtime(true) - 89,
                microtime(true) + 10,
                microtime(true) - 100
            )
        );

        $this->assertFalse($this->thesaurusApi->wasApiCalledRecently());
        $this->assertTrue($this->thesaurusApi->wasApiCalledRecently());
        $this->assertTrue($this->thesaurusApi->wasApiCalledRecently());
        $this->assertTrue($this->thesaurusApi->wasApiCalledRecently());
        $this->assertFalse($this->thesaurusApi->wasApiCalledRecently());
    }
}
