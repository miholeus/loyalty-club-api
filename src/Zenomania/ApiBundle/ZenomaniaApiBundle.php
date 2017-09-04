<?php

namespace Zenomania\ApiBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Zenomania\ApiBundle\DependencyInjection\Compiler\ExceptionNormalizerPass;

class ZenomaniaApiBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ExceptionNormalizerPass());
    }
}
