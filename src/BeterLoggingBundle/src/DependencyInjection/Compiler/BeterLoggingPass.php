<?php

declare(strict_types=1);

namespace App\BeterLoggingBundle\src\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BeterLoggingPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $containerBuilder)
    {

    }
}