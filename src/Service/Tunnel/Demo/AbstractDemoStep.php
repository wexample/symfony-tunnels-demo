<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Demo;

use Wexample\SymfonyTunnels\Service\Step\AbstractTunnelStep;

abstract class AbstractDemoStep extends AbstractTunnelStep
{
    public static function getName(): string
    {
        return static::STEP_NAME;
    }
}
