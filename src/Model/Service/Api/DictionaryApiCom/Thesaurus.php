<?php
namespace LeoGalleguillos\Word\Model\Service\Api\DictionaryApiCom;

use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Word\Model\Table as WordTable;
use SimpleXMLElement;

class Thesaurus
{
    public function __construct(
        MemcachedService\Memcached $memcached,
        string $apiKey,
        WordTable\Api $apiTable
    ) {
        $this->memcached = $memcached;
        $this->apiKey    = $apiKey;
        $this->apiTable  = $apiTable;
    }

    /**
     * Get synonyms.
     *
     * @param string $word
     * @return string[]
     */
    public function getSynonyms(string $word) : array
    {
        $simpleXmlElement = $this->getSimpleXmlElement($word);
        $entry            = $simpleXmlElement->{'entry'};
        if (!isset($entry->{'sens'})) {
            return [];
        }

        $synonyms         = [];
        $sense            = $entry->{'sens'};
        $synonymsString   = (string) $sense->{'syn'};
        $synonymsArray    = explode(', ', $synonymsString);
        $synonyms         = array_merge($synonyms, $synonymsArray);

        $synonyms = array_unique($synonyms);

        foreach ($synonyms as $index => $synonym) {
            if ($word == $synonym) {
                unset($synonyms[$index]);
                continue;
            }

            $synonym = preg_replace('/\[.*\]?/', '', $synonym);
            $synonym = preg_replace('/\(.*\)?/', '', $synonym);
            $synonym = trim($synonym);
            $synonyms[$index] = $synonym;
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

        $this->insertOnDuplicateKeyUpdate();

        $url = 'https://www.dictionaryapi.com'
             . '/api/v1/references/thesaurus/xml/'
             . urlencode($word)
             . '?key='
             . $this->apiKey;
        $xmlString = file_get_contents($url);

        $this->memcached->setForMinutes($cacheKey, $xmlString, 3);
        return $xmlString;
    }

    public function insertOnDuplicateKeyUpdate()
    {
        $this->apiTable->insertOnDuplicateKeyUpdate(
            'dictionaryapicom_last_call_microtime',
            microtime(true)
        );
    }

    /**
     * Was API called recently.
     *
     * @return bool
     */
    public function wasApiCalledRecently()
    {
        $lastCallMicrotime = $this->apiTable->selectValueWhereKey(
            'dictionaryapicom_last_call_microtime'
        );

        return (microtime(true) - $lastCallMicrotime) < 90;
    }
}
