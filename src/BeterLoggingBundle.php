<?php

namespace Beter\Bundle\BeterLoggingBundle;

use Beter\Bundle\BeterLoggingBundle\DependencyInjection\BeterLoggingExtension;
use Beter\Bundle\BeterLoggingBundle\DependencyInjection\Compiler\BeterLoggingPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BeterLoggingBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function build(ContainerBuilder $containerBuilder): void
    {
        parent::build($containerBuilder);

        $containerBuilder->addCompilerPass(new BeterLoggingPass());
    }

    public function getContainerExtension(): BeterLoggingExtension
    {
        return new BeterLoggingExtension();
    }
}