<?php
namespace LeoGalleguillos\Word\Model\Service;

use Exception;
use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Factory as WordFactory;
use LeoGalleguillos\Word\Model\Service as WordService;
use LeoGalleguillos\Word\Model\Table as WordTable;

class Thesaurus
{
    /**
     * Construct.
     */
    public function __construct(
        WordFactory\Word $wordFactory,
        WordService\Api\DictionaryApiCom\Thesaurus $apiThesaurusService,
        WordService\Thesaurus\MySql $thesaurusMySqlService,
        WordService\Word $wordService,
        WordTable\Thesaurus $thesaurusTable,
        WordTable\Word $wordTable
    ) {
        $this->wordFactory           = $wordFactory;
        $this->apiThesaurusService   = $apiThesaurusService;
        $this->thesaurusMySqlService = $thesaurusMySqlService;
        $this->wordService           = $wordService;
        $this->thesaurusTable        = $thesaurusTable;
        $this->wordTable             = $wordTable;
    }

    /**
     * Get synonyms.
     *
     * @param string $word
     * @return WordEntity\Word[]
     */
    public function getSynonyms(
        string $word
    ) : array {
        $wordEntity = $this->wordService->getEntityFromString($word);

        if ($this->thesaurusMySqlService->shouldSynonymsBeRetrievedFromMySql($wordEntity)) {
            return $this->thesaurusMySqlService->getSynonyms($wordEntity);
        }

        if ($this->apiThesaurusService->wasApiCalledRecently()) {
            return [];
        }

        $wordEntities = [];
        $synonyms     = $this->apiThesaurusService->getSynonyms($wordEntity->word);

        foreach ($synonyms as $synonym) {
            $wordEntities[] = $this->wordService->getEntityFromString($synonym);
        }

        $this->setSynonyms($wordEntity, $wordEntities);

        return $wordEntities;
    }

    /**
     * Set synonyms.
     *
     * Update the thesaurus_updated timestamp and insert IDs into thesaurus table.
     *
     * @param WordEntity\Word $wordEntity
     * @param WordEntity\Word[] $synonymEntities
     */
    public function setSynonyms(
        WordEntity\Word $wordEntity,
        array $synonymEntities
    ) {
        $this->wordTable->updateSetThesaurusUpdatedToNowWhereWordId(
            $wordEntity->wordId
        );

        $order = 0;
        foreach ($synonymEntities as $synonymEntity) {
            $order++;
            $this->thesaurusTable->insertIgnore(
                $wordEntity->wordId,
                $synonymEntity->wordId,
                $order
            );
        }
    }
}
