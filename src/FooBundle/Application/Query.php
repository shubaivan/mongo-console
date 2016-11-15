<?php

namespace FooBundle\Application;

use FooBundle\Application\News\News;
use FooBundle\Application\NewsPaper\NewsPaper;
use FooBundle\Command\HelloCommand;
use FooBundle\Domain\News\NewsInterface as NewsInterfaceDomain;

class Query implements QueryInterface
{
    /**
     * @var News
     */
    private $newsApp;

    /**
     * @var NewsPaper
     */
    private $newsPaper;

    /**
     * Query constructor.
     *
     * @param News $newsApp
     * @param NewsPaper $newsPaper
     */
    public function __construct(
        News $newsApp,
        NewsPaper $newsPaper
    ) {
        $this->newsApp = $newsApp;
        $this->newsPaper = $newsPaper;
    }

    /**
     * {@inheritdoc.
     */
    public function getDocument($queryArray)
    {
        if (array_key_exists(HelloCommand::FROM, $queryArray) 
            && !in_array($queryArray[HelloCommand::FROM], HelloCommand::TABLES)) 
        {
            throw new \Exception(
                "this table ".$queryArray[HelloCommand::FROM]." not exist\n
                exist: ".implode(', ', HelloCommand::TABLES)
            );
        }
        
        if ($queryArray[HelloCommand::FROM] == HelloCommand::TABLE_NEWS) {
            $return = $this->getNewsApp()->getDocument($queryArray);   
        } elseif ($queryArray[HelloCommand::FROM] == HelloCommand::TABLE_NEWS_PAPER) {
            $return = $this->getNewsPaperApp()->getDocument($queryArray);
        }

        return $return;
    }

    /**
     * @return News
     */
    private function getNewsApp()
    {
        return $this->newsApp;
    }

    /**
     * @return NewsPaper
     */
    private function getNewsPaperApp()
    {
        return $this->newsPaper;
    }
}
