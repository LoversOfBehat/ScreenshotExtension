<?php

declare(strict_types = 1);

namespace LoversOfBehat\ScreenshotExtension\Listener;

use Behat\Behat\EventDispatcher\Event\AfterStepTested;
use Behat\Behat\EventDispatcher\Event\StepTested;
use Behat\Testwork\Tester\Result\TestResult;
use LoversOfBehat\ScreenshotExtension\Photographer;
use LoversOfBehat\ScreenshotExtension\PhotographerInterface;
use LoversOfBehat\ScreenshotExtension\StorageHandlerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event subscriber that fires when a step fails.
 */
class FailedStepListener implements EventSubscriberInterface
{

    /**
     * @var PhotographerInterface
     */
    protected $photographer;

    /**
     * @var StorageHandlerInterface
     */
    protected $storageHandler;

    /**
     * Constructs a FailedStepListener.
     *
     * @param PhotographerInterface $photographer
     * @param StorageHandlerInterface $storageHandler
     */
    public function __construct(PhotographerInterface $photographer, StorageHandlerInterface $storageHandler)
    {
        $this->photographer = $photographer;
        $this->storageHandler = $storageHandler;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [StepTested::AFTER => 'afterStep'];
    }

    /**
     * Saves a screenshot if the step failed.
     *
     * @param AfterStepTested $event
     */
    public function afterStep(AfterStepTested $event): void
    {
        // Skip if the step did not fail.
        if ($event->getTestResult()->getResultCode() !== TestResult::FAILED) {
            return;
        }

        $filename = $this->generateFilename($event);
        $screenshot = $this->photographer->snap($filename);

        // If no screenshot was taken we cannot store it. This can happen if e.g. a failure occurred before the first
        // page was loaded.
        if ($screenshot === NULL) {
            return;
        }

        // Save the screenshot in the configured storage(s).
        $this->storageHandler->store($screenshot);
    }

    /**
     * Returns a filename for a screenshot based on the current step and scenario.
     *
     * @param AfterStepTested $event
     *   The after step event from which to derive the filename.
     *
     * @return string
     *   The filename.
     */
    protected function generateFilename(AfterStepTested $event): string {
        $feature = $event->getFeature();
        $step = $event->getStep();

        // Get the UNIX timestamp.
        $timestamp = time();

        // Get the filename of the feature, stripping the path and the extension.
        preg_match('/.+\/(.+)\.feature/', $feature->getFile(), $matches);
        $feature_name = $matches[1];

        $line_number = $step->getLine();

        return "$timestamp-$feature_name-$line_number";
    }

}