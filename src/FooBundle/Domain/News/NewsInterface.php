<?php

namespace FooBundle\Domain\News;

interface NewsInterface
{
    /**
     * @param array $queryArray
     * 
     * @return array
     */
    public function getConsoleQuery($queryArray);
}
