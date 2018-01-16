<?php
namespace LeoGalleguillos\WordTest\Model\Service\Api\DictionaryApiCom;

use ArrayObject;
use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Factory as WordFactory;
use LeoGalleguillos\Word\Model\Service as WordService;
use LeoGalleguillos\Word\Model\Table as WordTable;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class ThesaurusTest extends TestCase
{
    protected function setUp()
    {
        $configArray = require(__DIR__ . '/../../../../../config/autoload/local.php');
        $apiKey      = $configArray['dictionaryapicom']['api_key'];
        $this->thesaurusApi = new WordService\Api\DictionaryApiCom\Thesaurus(
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
        $this->assertInstanceOf(
            SimpleXMLElement::class,
            $this->thesaurusApi->getXml('test')
        );
    }
}
