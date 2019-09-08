<?php

declare(strict_types = 1);

namespace LoversOfBehat\ScreenshotExtension;

/**
 * Base implementation of a screenshot.
 */
class Screenshot implements ScreenshotInterface
{

    /**
     * The image data.
     *
     * @var string
     */
    protected $image;

    /**
     * The filename.
     *
     * @var string
     */
    protected $filename;

    /**
     * Constructs a screenshot.
     *
     * @param string $image
     *   The screenshot image as a string of data.
     * @param string $filename
     *   The filename.
     */
    public function __construct(string $image, string $filename)
    {
        $this->image = $image;
        $this->filename = $filename;
    }

    /**
     * {@inheritdoc}
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

}
