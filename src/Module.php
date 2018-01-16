<?php
namespace LeoGalleguillos\Word;

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
                WordService\Thesaurus::class => function ($serviceManager) {
                    return new WordService\Thesaurus(
                        $serviceManager->get(WordFactory\Word::class),
                        $serviceManager->get(WordTable\Thesaurus::class)
                    );
                },
                WordTable\Thesaurus::class => function ($serviceManager) {
                    return new WordTable\Word(
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
