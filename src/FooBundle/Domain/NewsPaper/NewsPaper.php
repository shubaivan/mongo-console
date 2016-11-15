<?php

namespace FooBundle\Domain\NewsPaper;

use AppBundle\Document\Repository\NewsPaperRepository;

class NewsPaper implements NewsPaperInterface
{
    /**
     * @var NewsPaperRepository
     */
    private $newsPaperRepository;

    /**
     * News constructor.
     *
     * @param NewsPaperRepository $newsPaperRepository
     */
    public function __construct(
        NewsPaperRepository $newsPaperRepository
    ) {
        $this->newsPaperRepository = $newsPaperRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getConsoleQuery($queryArray)
    {
        return $this->getNewsPaperRepository()->getConsoleQuery($queryArray);
    }

    /**
     * @return NewsPaperRepository
     */
    private function getNewsPaperRepository()
    {
        return $this->newsPaperRepository;
    }
}
