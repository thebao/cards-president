<?php

namespace OC\PlatformBundle\DataFixtures\ORM;


;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Nelmio\Alice\Fixtures;
use JA\CableBundle\Entity\Cable;

class LoadCables extends DataFixtureLoader
{
    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        return  array(
            __DIR__ . '/cables.yml'
        );
    }
}