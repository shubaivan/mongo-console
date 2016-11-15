<?php

namespace FooBundle\Application\News;

use Symfony\Component\HttpFoundation\ParameterBag;

interface NewsInterface
{
    /**
     * @param array $queryArray
     * 
     * @return array
     */
    public function getDocumnet($queryArray);
}
