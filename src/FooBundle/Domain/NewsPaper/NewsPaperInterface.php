<?php

namespace FooBundle\Domain\NewsPaper;

interface NewsPaperInterface
{
    /**
     * @param array $queryArray
     * 
     * @return array
     */
    public function getConsoleQuery($queryArray);
}
