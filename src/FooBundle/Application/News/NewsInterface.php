<?php

namespace FooBundle\Application\News;

interface NewsInterface
{
    /**
     * @param array $queryArray
     * 
     * @return array
     */
    public function getDocument($queryArray);
}
