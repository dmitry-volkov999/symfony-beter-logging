<?php

declare(strict_types=1);

namespace Beter\Bundle\BeterLoggingBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Class BeterLoggingExtension
 * @package Beter\Bundle\BeterLoggingBundle\DependencyInjection
 */
class BeterLoggingExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');

        $parameterBag = $container->getParameterBag();
        $parameterBag->add([
            'beter.logger.start_time' => microtime(true),
            'beter.logger.basic_processor.exec_type' => php_sapi_name() === 'cli' ? 'cli' : 'web',
            'beter.logger.basic_processor.host' => gethostname(),
        ]);
    }
}
