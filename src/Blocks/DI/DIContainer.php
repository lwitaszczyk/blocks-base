<?php

namespace Blocks\DI;

use Blocks\Configuration;
use Blocks\DI\Exception\CannotOverrideDefinedServiceException;
use Blocks\DI\Exception\CannotOverrideInducedServiceException;
use Blocks\DI\Exception\ServiceNotDefinedInContainerException;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;

class DIContainer
{
    const PROXY_FACTORY = 'proxy-factory';

    const MODE_DISALLOW_OVERRIDE_DEFINED_SERVICE = 0;
    const MODE_ALLOW_OVERRIDE_DEFINED_SERVICE = 1;
    const MODE_ALLOW_OVERRIDE_INDUCED_SERVICE = 2;

    /**
     * @var int
     */
    private $overrideMode;

    /**
     * @var Service[]
     */
    private $services;

    /**
     * @var bool[]
     */
    private $inducedServices;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * DIContainer constructor.
     * @param Configuration $configuration
     * @param int $overrideMode
     */
    public function __construct(
        Configuration $configuration,
        $overrideMode = self::MODE_ALLOW_OVERRIDE_DEFINED_SERVICE
    ) {
        $this->configuration = $configuration;
        $this->overrideMode = $overrideMode;

        $this->services = [];
        $this->inducedServices = [];

        $this->add([
            (new DIAsSingleton(self::PROXY_FACTORY, LazyLoadingValueHolderFactory::class)),
        ]);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception\ServiceNotDefinedInContainerException
     */
    public function get($id)
    {
        $id = (string)$id;

        if (!$this->isDefined($id)) {
            throw new ServiceNotDefinedInContainerException($id);
        }

        $service = $this->services[$id]->get($this);
        $this->inducedServices[$id] = true;

        return $service;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        $id = (string)$id;

        if ($this->isDefined($id)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $tag
     * @return mixed[]
     */
    public function findByTag($tag)
    {
        $tag = (string)$tag;
        $taggedServices = [];
        foreach ($this->services as $service) {
            if ($service->hasTag($tag)) {
                $taggedServices[$service->getId()] = $service->get($this);
            }
        }
        return $taggedServices;
    }

    /**
     * @deprecated
     * @param Service[] $services
     * @return $this
     */
    public function add(array $services = [])
    {
        return $this->addServices($services);
    }

    /**
     * @param Service[] $services
     * @return $this
     */
    public function addServices(array $services = [])
    {
        foreach ($services as $service) {
            $this->addService($service);
        }
        return $this;
    }

    /**
     * @param Service $service
     * @return $this
     * @throws CannotOverrideDefinedServiceException
     * @throws CannotOverrideInducedServiceException
     */
    public function addService(Service $service)
    {
        $id = $service->getId();

        switch ($this->overrideMode) {
            case self::MODE_DISALLOW_OVERRIDE_DEFINED_SERVICE:
                if ($this->isDefined($id)) {
                    throw new CannotOverrideDefinedServiceException($service);
                }
                break;
            case self::MODE_ALLOW_OVERRIDE_DEFINED_SERVICE:
                if ($this->isInduced($id)) {
                    throw new CannotOverrideInducedServiceException($service);
                }
                break;
        }

        $this->services[$id] = $service;
        return $this;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param string $id
     * @return bool
     */
    private function isDefined($id)
    {
        return array_key_exists($id, $this->services);
    }

    /**
     * @param string $id
     * @return bool
     */
    private function isInduced($id)
    {
        return isset($this->inducedServices[$id]);
    }
}
