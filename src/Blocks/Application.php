<?php

namespace Blocks;

use Blocks\Cache\StatelessCache;
use Blocks\DI\DIAsSingleton;
use Blocks\DI\DIAsValue;
use Blocks\DI\DIContainer;
use Blocks\Logger\StatelessLogger;

abstract class Application
{

    const APPLICATION = 'application';
    const CONTAINER = 'container';
    const CACHE = 'cache';
    const EVENT_DISPATCHER = 'event-dispatcher';
    const CONFIGURATION = 'configuration';
    const LOGGER = 'logger';

    private static $instance = null;

    /**
     * @return self
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * @var string[]
     */
    private $packages;

    /**
     * @var DIContainer
     */
    private $container;

//    /**
//     * @var EventDispatcher
//     */
//    private $eventDispatcher;

    /**
     * @var string
     */
    private $rootPath;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * Application constructor.
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        self::$instance = $this;

        $this->packages = [];
        $this->container = new DIContainer($configuration);
        $this->configuration = $configuration;

        $this->rootPath = dirname(filter_input(INPUT_SERVER, 'SCRIPT_FILENAME'));
        $this->configuration->set('application.root-path', $this->getRootPath());

//        $this->eventDispatcher = new EventDispatcher();

        $this->container->addServices([
            (new DIAsValue(self::CONFIGURATION, $this->configuration)),
            (new DIAsSingleton(self::LOGGER, StatelessLogger::class)),
            (new DIAsValue(self::CONTAINER, $this->container)),
            (new DIAsValue(self::APPLICATION, $this)),
//            (new DIAsValue(self::EVENT_DISPATCHER, $this->eventDispatcher)),
            (new DIAsSingleton(self::CACHE, StatelessCache::class)),
        ]);
    }

    /**
     * @return $this
     */
    public function run()
    {
        $this->beforeProcess();
        $this->process();
        $this->afterProcess();
    }

    /**
     * @param Package[] $packages
     * @return $this
     */
    public function addPackages(array $packages = [])
    {
        foreach ($packages as $package) {
            $this->addPackage($package);
        }
        return $this;
    }

    /**
     * @param Package $package
     * @return $this
     */
    public function addPackage(Package $package)
    {
        $this->packages[] = $package;
        return $this;
    }

    /**
     * @return DIContainer
     */
    public function getContainer()
    {
        return $this->container;
    }

//    /**
//     * @return EventDispatcher
//     */
//    public function getEventDispatcher()
//    {
//        return $this->eventDispatcher;
//    }

    /**
     * @return string
     */
    public function getRootPath()
    {
        return $this->rootPath;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return $this
     */
    protected function beforeProcess()
    {
        //        $event = new ApplicationBeforeProcessEvent();
//        $this->eventDispatcher->dispatch($event, $this);
        return $this;
    }

    /**
     * @return $this
     */
    abstract protected function process();

    /**
     * @return $this
     */
    protected function afterProcess()
    {
        //        $event = new ApplicationAfterProcessEvent();
//        $this->eventDispatcher->dispatch($event, $this);
        return $this;
    }

    /**
     * @param \Exception $exception
     * @throws \Exception
     */
    protected function onException(\Exception $exception)
    {
        throw $exception;
    }
}
