<?php

declare(strict_types = 1);

namespace LoversOfBehat\ScreenshotExtension;

/**
 * Interface for services that handle storage of screenshots.
 */
interface StorageHandlerInterface
{

    /**
     * Stores a screenshot in the configured storage plugin(s).
     *
     * @param ScreenshotInterface $screenshot
     */
    public function store(ScreenshotInterface $screenshot): void;

}