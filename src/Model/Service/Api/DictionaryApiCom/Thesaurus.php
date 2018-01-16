<?php
namespace LeoGalleguillos\Word\Model\Service\Api\DictionaryApiCom;

use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use SimpleXMLElement;

class Thesaurus
{
    public function __construct(
        MemcachedService\Memcached $memcached,
        string $apiKey
    ) {
        $this->memcached = $memcached;
        $this->apiKey    = $apiKey;
    }

    protected function getXml(string $word)
    {
        return new SimpleXmlElement(
            $this->getXmlString($word)
        );
    }

    protected function getXmlString(string $word)
    {
        $cacheKey = md5(__METHOD__ . $word);
        if (null !== ($xmlString = $this->memcached->get($cacheKey))) {
            return $xmlString;
        }

        $url       = 'https://www.dictionaryapi.com'
                   . '/api/v1/references/thesaurus/xml/test?key='
                   . $this->apiKey;
        $xmlString = file_get_contents($url);

        $this->memcached->setForMinutes($cacheKey, $xmlString, 3);
        return $xmlString;
    }
}
