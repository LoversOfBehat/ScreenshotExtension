<?php

declare(strict_types = 1);

namespace LoversOfBehat\ScreenshotExtension\Storage;

use LoversOfBehat\ScreenshotExtension\Exception\StorageConfigNotDefinedException;
use Symfony\Component\Console\Output\ConsoleOutputInterface;

/**
 * Base class for storage plugins.
 */
abstract class StorageBase implements StorageInterface
{

    /**
     * @var ConsoleOutputInterface
     */
    private $output;

    /**
     * The configuration for the screenshot extension.
     *
     * @var array
     */
    private $config;

    /**
     * Constructs a storage plugin.
     *
     * @param ConsoleOutputInterface $output
     * @param array $config
     */
    public function __construct(ConsoleOutputInterface $output, array $config)
    {
        $this->output = $output;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(): bool
    {
        try {
            $config = $this->getConfiguration();
        } catch (StorageConfigNotDefinedException $e) {
            return false;
        }

        if (!isset($config['enabled']) || !is_bool($config['enabled'])) {
            throw new StorageConfigNotDefinedException($this->getId(), '"enabled" key is not defined or not a boolean value.');
        }
        return $config['enabled'];
    }

    /**
     * Returns the plugin configuration.
     *
     * @return array
     *
     * @throws StorageConfigNotDefinedException
     *   Thrown when no config has been defined.
     */
    protected function getConfiguration(): array
    {
        $config = $this->config['storage'][$this->getId()] ?? false;
        if ($config === false) {
            throw new StorageConfigNotDefinedException($this->getId());
        }
        return $config;
    }

    /**
     * @return ConsoleOutputInterface
     */
    protected function output(): ConsoleOutputInterface
    {
        return $this->output;
    }

}
