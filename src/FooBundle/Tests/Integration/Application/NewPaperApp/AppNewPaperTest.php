<?php

namespace FooBundle\Tests\Integration\Application\NewPaperApp;

use AppBundle\Document\NewsPaper;
use AppBundle\Document\Repository\NewsPaperRepository;
use FooBundle\Application\Query;
use FooBundle\Command\HelloCommand;
use FooBundle\Tests\Integration\OrmTestCase;
use FooBundle\Application\News\News;

class AppNewPaperTest extends OrmTestCase
{
    /**
     * @var NewsPaperRepository
     */
    private $newsPaperRepository;

    /**
     * Set up.
     */
    public function setUp()
    {
        $documentManager = $this->getDocumentManager();
        $this->newsPaperRepository = $documentManager->getRepository(NewsPaper::class);
        parent::setUp();
    }

    public function testGetDocumentTest()
    {
        $repository = $this->newsPaperRepository;
        /* @var NewsPaper[] $newsPapers */
        $newsPapers = $repository->findAll();

        foreach ($newsPapers as $item) {
            $this->getDocumentManager()->remove($item);
        }
        $this->getDocumentManager()->flush();
        $this->loadFixtures([[NewsPaper::class, 3]]);

        /** @var NewsPaper[] $newsPapers */
        $newsPapers = $repository->findAll();
        $this->assertCount(3, $newsPapers);

        $newsPaper2 = $newsPapers[1];
        $newsPaper3 = $newsPapers[2];

        $expected =
            '_id='.'\''.(string) $newsPaper2->getId().'\''.', name='.'\''.$newsPaper2->getName().'\''."\n".
            '_id='.'\''.(string) $newsPaper3->getId().'\''.', name='.'\''.$newsPaper3->getName().'\''."\n";

        $array = [];
        $array[HelloCommand::SELECT] = 'name';
        $array[HelloCommand::FROM] = 'newsPaper';
        $array[HelloCommand::WHERE] = 'null';
        $array[HelloCommand::ORDER_BY_FIELD] = 'null';
        $array[HelloCommand::ORDER_BY] = 'null';
        $array[HelloCommand::SKIP] = '1';
        $array[HelloCommand::LIMIT] = '2';

        $queryArray = array_filter($array, function ($value) {
            return $value !== null && $value != 'null';
        });

        $response = $this->getService()
            ->getDocument($queryArray);

        $this->assertEquals($response, $expected);
    }

    /**
     * @return News
     */
    private function getService()
    {
        return new Query(
            $this->getContainer()->get('app.application.news'),
            $this->getContainer()->get('app.application.news_paper')
        );
    }
}
