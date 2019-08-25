<?php

declare(strict_types = 1);

namespace LoversOfBehat\ScreenshotExtension;

/**
 * Interface for screenshot objects.
 */
interface ScreenshotInterface
{

    /**
     * Returns the image data.
     *
     * @return string
     */
    public function getImage(): string;

    /**
     * Returns the filename.
     *
     * @return string
     */
    public function getFilename(): string;

}