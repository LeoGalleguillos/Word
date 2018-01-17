<?php
namespace LeoGalleguillos\Word;

use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Word\Model\Factory as WordFactory;
use LeoGalleguillos\Word\Model\Service as WordService;
use LeoGalleguillos\Word\Model\Table as WordTable;

class Module
{
    public function getConfig()
    {
        return [
            'view_helpers' => [
                'aliases' => [
                ],
                'factories' => [
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                WordFactory\Word::class => function ($serviceManager) {
                    return new WordFactory\Word(
                        $serviceManager->get(WordTable\Word::class)
                    );
                },
                WordService\Api\DictionaryApiCom\Thesaurus::class => function ($serviceManager) {
                    $config = $serviceManager->get('Config');
                    return new WordService\Api\DictionaryApiCom\Thesaurus(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $config['dictionaryapicom']['api_key'],
                        $serviceManager->get(WordTable\Api::class)
                    );
                },
                WordService\Thesaurus::class => function ($serviceManager) {
                    return new WordService\Thesaurus(
                        $serviceManager->get(WordFactory\Word::class),
                        $serviceManager->get(WordService\Api\DictionaryApiCom\Thesaurus::class),
                        $serviceManager->get(WordService\Thesaurus\MySql::class),
                        $serviceManager->get(WordService\Word::class),
                        $serviceManager->get(WordTable\Thesaurus::class),
                        $serviceManager->get(WordTable\Word::class)
                    );
                },
                WordService\Thesaurus\MySql::class => function ($serviceManager) {
                    return new WordService\Thesaurus\MySql(
                        $serviceManager->get(WordFactory\Word::class),
                        $serviceManager->get(WordTable\Thesaurus::class),
                        $serviceManager->get(WordTable\Word::class)
                    );
                },
                WordService\Word::class => function ($serviceManager) {
                    return new WordService\Word(
                        $serviceManager->get(WordFactory\Word::class),
                        $serviceManager->get(WordTable\Word::class)
                    );
                },
                WordTable\Api::class => function ($serviceManager) {
                    return new WordTable\Api(
                        $serviceManager->get('word')
                    );
                },
                WordTable\Thesaurus::class => function ($serviceManager) {
                    return new WordTable\Thesaurus(
                        $serviceManager->get('word')
                    );
                },
                WordTable\Word::class => function ($serviceManager) {
                    return new WordTable\Word(
                        $serviceManager->get('word')
                    );
                },
            ],
        ];
    }
}
