<?php

declare(strict_types = 1);

namespace LoversOfBehat\ScreenshotExtension\Exception;

/**
 * Exception thrown when the configuration of a storage plugin is not defined.
 */
class StorageConfigNotDefinedException extends \LogicException
{

    /**
     * Constructs a StorageConfigNotDefinedException.
     *
     * @param string $pluginId
     *   The ID of the storage plugin that has no configuration.
     */
    public function __construct(string $pluginId)
    {
        $message = "No configuration is defined for the $pluginId plugin.";
        parent::__construct($message);
    }

}
