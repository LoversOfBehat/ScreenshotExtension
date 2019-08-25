<?php

declare(strict_types = 1);

namespace LoversOfBehat\ScreenshotExtension;

use Behat\Mink\Mink;

/**
 * Service that takes screenshots.
 */
class Photographer implements PhotographerInterface
{

    /**
     * The Mink session.
     *
     * @var Mink
     */
    protected $mink;

    /**
     * Constructs a Photographer service.
     *
     * @param Mink $mink
     */
    public function __construct(Mink $mink)
    {
        $this->mink = $mink;
    }

    /**
     * {@inheritdoc}
     */
    public function snap(string $filename): ?ScreenshotInterface
    {
        try {
            if ($this->mink->getSession()->getDriver() instanceof Selenium2Driver) {
                // The Selenium driver returns screenshots as PNG images.
                $image = $this->mink->getSession()->getDriver()->getScreenshot();
                return new Screenshot($image, $filename . '.png');
            }
            else {
                // Fall back to returning the HTML page if Selenium is not used.
                $image = $this->mink->getSession()->getPage()->getContent();
                return new Screenshot($image, $filename . '.html');
            }
        }
        catch (DriverException $e) {
            // A DriverException might occur if no page has been loaded yet so no
            // screenshot can yet be taken. In this case we exit silently, allowing
            // the remainder of the test suite to run.
            return NULL;
        }
    }

}