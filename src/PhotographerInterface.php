<?php

declare(strict_types = 1);

namespace LoversOfBehat\ScreenshotExtension;

/**
 * Interface for services that take screenshots.
 */
interface PhotographerInterface
{

    /**
     * Takes a screenshot.
     *
     * @param string $filename
     *   The filename to use for the screenshot, without extension.
     *
     * @return ScreenshotInterface|null
     *   The screenshot, or NULL if no screenshot could be taken.
     */
    public function snap(string $filename): ?ScreenshotInterface;

}
