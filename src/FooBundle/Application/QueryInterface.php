<?php

namespace FooBundle\Application;

interface QueryInterface
{
    /**
     * @param array $queryArray
     * 
     * @return array
     */
    public function getDocument($queryArray);
}
