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

    public function getSynonyms(string $word) : array
    {
        $synonyms = [];

        $simpleXmlElement = $this->getSimpleXmlElement($word);
        foreach ($simpleXmlElement->{'entry'} as $entry) {
            foreach ($entry->{'sens'} as $sense) {
                $synonymsString = (string) $sense->{'syn'};
                $synonymsArray  = explode(', ', $synonymsString);
                $synonyms       = array_merge($synonyms, $synonymsArray);
            }
        }

        $synonyms = array_unique($synonyms);

        foreach ($synonyms as $index => $synonym) {
            if ($word == $synonym) {
                unset($synonyms[$index]);
                break;
            }
        }

        sort($synonyms);

        return $synonyms;
    }

    protected function getSimpleXmlElement(string $word)
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
