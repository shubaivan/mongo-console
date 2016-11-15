<?php

namespace FooBundle\Tests\Integration\Application\Notifications;

use AppBundle\Document\Repository\NewsRepository;
use FooBundle\Command\HelloCommand;
use FooBundle\Tests\Integration\OrmTestCase;
use FooBundle\Application\News\News;
use AppBundle\Document\News as NewsDoc;

class AppNewsTest extends OrmTestCase
{
    /**
     * @var NewsRepository
     */
    private $newsRepository;
    
    /**
     * Set up.
     */
    public function setUp()
    {
        $documentManager = $this->getDocumentManager();
        $this->newsRepository = $documentManager->getRepository(NewsDoc::class);
        parent::setUp();
    }
    
    public function testGetDocumnetTest() 
    {
        $repository = $this->newsRepository;
        /** @var NewsDoc[] $news */
        $newsExist = $repository->findAll();

        foreach ($newsExist as $item) {
            $this->getDocumentManager()->remove($item);            
        }
        $this->getDocumentManager()->flush();
        $this->loadFixtures([[NewsDoc::class, 3]]);

        /** @var NewsDoc[] $news */
        $news = $repository->findAll();
        $this->assertCount(3, $news);
        
        $new2 = $news[1];
        $new3 = $news[2];
        
        $expected = 
            '_id='.'\''.(string)$new2->getId().'\''.', title='.'\''.$new2->getTitle().'\''.', description='.'\''.$new2->getDescription().'\''."\n".
            '_id='.'\''.(string)$new3->getId().'\''.', title='.'\''.$new3->getTitle().'\''.', description='.'\''.$new3->getDescription().'\''."\n";

        $array = [];
        $array[HelloCommand::SELECT] = 'title,description';
        $array[HelloCommand::FROM] = 'news';
        $array[HelloCommand::WHERE] = 'title=culpa';
        $array[HelloCommand::ORDER_BY_FIELD] = 'title';
        $array[HelloCommand::ORDER_BY] = 'desc';
        $array[HelloCommand::SKIP] = '1';
        $array[HelloCommand::LIMIT] = '2';

        $queryArray = array_filter($array, function($value) {
            return $value !== null && $value != "null";
        });
        
        $response = $this->getService()
            ->getDocumnet($queryArray);

        $this->assertEquals($response, $expected);
    }

    /**
     * @return News
     */
    private function getService()
    {
        return new News(
            $this->getContainer()->get('app.domain.news')
        );
    }
}
