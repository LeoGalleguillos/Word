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
                WordTable\Word::class => function ($serviceManager) {
                    return new WordTable\Word(
                        $serviceManager->get('word')
                    );
                },
            ],
        ];
    }
}
