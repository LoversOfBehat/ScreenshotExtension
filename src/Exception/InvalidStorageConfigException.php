<?php

declare(strict_types = 1);

namespace LoversOfBehat\ScreenshotExtension\Exception;

/**
 * Exception thrown when the configuration of a storage plugin is invalid.
 */
class InvalidStorageConfigException extends \LogicException
{

    /**
     * Constructs an InvalidStorageConfigException.
     *
     * @param string $pluginId
     *   The ID of the storage plugin that has invalid configuration.
     * @param string $reason
     *   The reason why the plugin configuration is invalid.
     */
    public function __construct(string $pluginId, string $reason)
    {
        $message = "The configuration for the $pluginId plugin is invalid: $reason";
        parent::__construct($message);
    }

}