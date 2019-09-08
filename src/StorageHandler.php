<?php

declare(strict_types = 1);

namespace LoversOfBehat\ScreenshotExtension;

use LoversOfBehat\ScreenshotExtension\Storage\StorageInterface;

/**
 * Default implementation of the service that handles screenshot storage.
 */
class StorageHandler implements StorageHandlerInterface
{

    /**
     * @var iterable
     */
    protected $plugins;

    /**
     * The configuration for the screenshot extension.
     *
     * @var array
     */
    protected $config;

    /**
     * Constructs a StorageHandler service.
     *
     * @param iterable $plugins
     *   The storage plugins.
     * @param array $config
     *   The configuration for the screenshot extension.
     */
    public function __construct(iterable $plugins, array $config)
    {
        $this->plugins = $plugins;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function store(ScreenshotInterface $screenshot): void
    {
        $iterator = $this->plugins->getIterator();
        foreach ($iterator as $plugin) {
            if (!$plugin instanceof StorageInterface) {
                throw new \DomainException('All services tagged with "screenshot_extension.storage" should implement \LoversOfBehat\ScreenshotExtension\Storage\StorageInterface.');
            }
            if ($plugin->isEnabled()) {
                $plugin->store($screenshot);
            }
        }
    }

}
