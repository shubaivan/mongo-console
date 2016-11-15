<?php

namespace AppBundle\DataFixtures\MongoDB;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class MemoryFixturesLoader extends DataFixtureLoader
{
    public function getFixtures()
    {
        return [
            __DIR__.'/fixtures.yml',
        ];
    }
}
