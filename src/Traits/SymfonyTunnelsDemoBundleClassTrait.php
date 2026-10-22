<?php

namespace Wexample\SymfonyTunnelsDemo\Traits;

use Wexample\SymfonyHelpers\Traits\BundleClassTrait;
use Wexample\SymfonyTunnelsDemo\WexampleSymfonyTunnelsDemoBundle;

trait SymfonyTunnelsDemoBundleClassTrait
{
    use BundleClassTrait;

    public static function getBundleClassName(): string
    {
        return WexampleSymfonyTunnelsDemoBundle::class;
    }
}
