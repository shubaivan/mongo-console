<?php

namespace FooBundle\Domain\News;

use AppBundle\Document\Repository\NewsRepository;

class News implements NewsInterface
{
    /**
     * @var NewsRepository
     */
    private $newsRepository;

    /**
     * News constructor.
     * @param NewsRepository $newsRepository
     */
    public function __construct(
        NewsRepository $newsRepository
    ) {
        $this->newsRepository = $newsRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getConsoleQuery($queryArray){
        return $this->getNewsRepository()->getConsoleQuery($queryArray);
    }

    /**
     * @return NewsRepository
     */
    private function getNewsRepository() {
        return $this->newsRepository;
    }
}
