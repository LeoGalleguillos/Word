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
        $this->thesaurusApi = new WordService\Api\DictionaryApiCom\Thesaurus(
            $this->memcached,
            $apiKey
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            WordService\Api\DictionaryApiCom\Thesaurus::class,
            $this->thesaurusApi
        );
    }

    public function testGetXml()
    {
        $reflectionClass = new ReflectionClass($this->thesaurusApi);
        $reflectionMethod = $reflectionClass->getMethod('getXml');
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
}
