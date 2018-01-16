<?php
namespace LeoGalleguillos\Word\Model\Service\Api\DictionaryApiCom;

use SimpleXMLElement;

class Thesaurus
{
    public function __construct(
        string $apiKey
    ) {
        $this->apiKey = $apiKey;
    }

    public function getXml(string $word)
    {
        $url = 'https://www.dictionaryapi.com'
             . '/api/v1/references/thesaurus/xml/test?key='
             . $this->apiKey;
        return simplexml_load_file($url);
    }
}
