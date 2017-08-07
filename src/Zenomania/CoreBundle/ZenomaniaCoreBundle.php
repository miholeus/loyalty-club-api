<?php

namespace Zenomania\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zenomania\CoreBundle\DependencyInjection\Compiler\DoctrineEntityListenerPass;
use Zenomania\CoreBundle\DependencyInjection\Sms\SmsServiceExtension;

class ZenomaniaCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DoctrineEntityListenerPass());
    }

    public function getContainerExtension()
    {
        return new SmsServiceExtension();
    }
}
