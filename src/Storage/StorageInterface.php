<?php

declare(strict_types = 1);

namespace LoversOfBehat\ScreenshotExtension\Storage;

use LoversOfBehat\ScreenshotExtension\ScreenshotInterface;

/**
 * Interface for a screenshot storage plugin.
 */
interface StorageInterface
{

    /**
     * Returns the storage plugin ID.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Stores a screenshot.
     *
     * @param ScreenshotInterface $screenshot
     */
    public function store(ScreenshotInterface $screenshot): void;

    /**
     * Returns whether or not the storage engine is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool;

}
