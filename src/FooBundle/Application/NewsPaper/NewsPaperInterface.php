<?php

namespace FooBundle\Application\NewsPaper;

interface NewsPaperInterface
{
    /**
     * @param array $queryArray
     * 
     * @return array
     */
    public function getDocument($queryArray);
}
