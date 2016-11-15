<?php

namespace FooBundle\Tests\Integration;

use AppBundle\DataFixtures\Tests\DataLoader;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class OrmTestCase.
 *
 * This is the base class to load doctrine fixtures using the symfony configuration
 */
class OrmTestCase extends WebTestCase
{
    const DATE_FORMAT = DATE_ISO8601;

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @var DocumentManager
     */
    protected $dm;

    /**
     * @var string
     */
    protected $environment = 'test';

    /**
     * @var bool
     */
    protected $debug = true;

    /**
     * @var string
     */
    protected $entityManagerServiceId = 'doctrine.odm.mongodb.document_manager';

    /**
     * 
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Constructor.
     *
     * @param string|null $name     Test name
     * @param array       $data     Test data
     * @param string      $dataName Data name
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        if (null !== static::$kernel) {
            static::$kernel->shutdown();
        }

        static::$kernel = static::createKernel([
            'environment' => $this->environment,
            'debug' => $this->debug,
        ]);
        static::$kernel->boot();

        $this->container = static::$kernel->getContainer();
        $this->dm = $this->getDocumentManager();
    }

    /**
     * Returns DI Container.
     *
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * Returns the doctrine odm manager.
     *
     * @return DocumentManager
     */
    protected function getDocumentManager()
    {
        return $this->container->get($this->entityManagerServiceId);
    }

    /**
     * @param array $fixtures
     */
    protected function loadFixtures(array $fixtures)
    {
        $loader = new DataLoader();
        $loader->setContainer($this->getContainer());

        foreach ($fixtures as $fixture) {
            if (count($fixture) == 1) {
                $fixture[] = 1;
                $fixture[] = null;
            } elseif (count($fixture) == 2) {
                $fixture[] = null;
            }

            list($fixtureClass, $count, $dir) = $fixture;
            $loader->addFixture($fixtureClass, $count ? $count : null, $dir ? $dir : null);
        }

        $loader->load($this->getDocumentManager());
    }
}
