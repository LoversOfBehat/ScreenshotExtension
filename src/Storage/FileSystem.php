<?php

declare(strict_types = 1);

namespace LoversOfBehat\ScreenshotExtension\Storage;

use const DIRECTORY_SEPARATOR;
use LoversOfBehat\ScreenshotExtension\Exception\InvalidStorageConfigException;
use LoversOfBehat\ScreenshotExtension\ScreenshotInterface;

/**
 * Storage plugin that stores plugins on the local filesystem.
 */
class FileSystem extends StorageBase
{

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return 'filesystem';
    }

    /**
     * {@inheritdoc}
     */
    public function store(ScreenshotInterface $screenshot): void
    {
        $path = $this->getPath();

        // If the folder does not exist, try to create it.
        if (!is_dir($path) && !mkdir($path, 0755, TRUE)) {
            throw new InvalidStorageConfigException($this->getId(), "The directory '$path' does not exist and could not be created.");
        }

        $filename = $path . DIRECTORY_SEPARATOR . $screenshot->getFilename();
        file_put_contents($filename, $screenshot->getImage());

        $this->output()->writeln("Saved screenshot in $filename");
    }

    /**
     * Returns the path where the screenshots should be stored.
     *
     * @return string
     */
    protected function getPath(): string
    {
        $config = $this->getConfiguration();
        if (empty($config['path']) || !is_string($config['path'])) {
            throw new InvalidStorageConfigException($this->getId(), 'The "path" key is not defined or is invalid.');
        }

        return rtrim($config['path'], '/');
    }

}