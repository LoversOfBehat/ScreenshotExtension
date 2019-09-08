<?php

declare(strict_types = 1);

namespace LoversOfBehat\ScreenshotExtension\ServiceContainer;

use Behat\Behat\EventDispatcher\ServiceContainer\EventDispatcherExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use LoversOfBehat\ScreenshotExtension\Listener\FailedStepListener;
use LoversOfBehat\ScreenshotExtension\Photographer;
use LoversOfBehat\ScreenshotExtension\Storage\FileSystem;
use LoversOfBehat\ScreenshotExtension\StorageHandler;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ScreenshotExtension implements ExtensionInterface
{

    const CONFIG_KEY = 'screenshot';

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder->
            children()->
                arrayNode('storage')->
                    children()->
                        arrayNode('filesystem')->
                            children()->
                                scalarNode('path')->end()->
                                booleanNode('enabled')->defaultTrue()->end()->
                            end()->
                        end()->
                    end()->
                end()->
            end();
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        // Track our configuration on the container.
        $container->setParameter('screenshot_extension.parameters', $config);

        // Define the service that takes screenshots.
        $definition = new Definition(Photographer::class, [
            new Reference('mink'),
        ]);
        $container->setDefinition('screenshot_extension.photographer', $definition);

        // Define the storage plugin for the local filesystem.
        $definition = new Definition(FileSystem::class, [
            new Reference('cli.output'),
            '%screenshot_extension.parameters%',
        ]);
        $definition->addTag('screenshot_extension.storage');
        $container->setDefinition('screenshot_extension.storage.filesystem', $definition);

        // Define the service that handles storage for screenshots.
        $definition = new Definition(StorageHandler::class, [
            new TaggedIteratorArgument('screenshot_extension.storage'),
            '%screenshot_extension.parameters%',
        ]);
        $container->setDefinition('screenshot_extension.storage_handler', $definition);

        // Define the event listener that listens for failed steps.
        $definition = new Definition(FailedStepListener::class, [
            new Reference('screenshot_extension.photographer'),
            new Reference('screenshot_extension.storage_handler'),
        ]);
        $definition->addTag(EventDispatcherExtension::SUBSCRIBER_TAG, array('priority' => 0));
        $container->setDefinition('screenshot_extension.failed_step_listener', $definition);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return self::CONFIG_KEY;
    }

}
