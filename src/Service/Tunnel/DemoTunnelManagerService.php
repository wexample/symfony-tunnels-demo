<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel;

use Wexample\SymfonyTunnels\Interface\TunnelSessionStorageInterface;
use Wexample\SymfonyTunnels\Service\AbstractTunnelManagerService;
use Wexample\SymfonyTunnels\Service\Step\AbstractTunnelStep;
use Wexample\SymfonyTunnelsDemo\Service\Tunnel\Demo\IntroStep;

/**
 * A four-step flow branching on a plan, small enough to read as a whole and
 * wide enough to show what a tree of cursors buys over an ordered list.
 */
class DemoTunnelManagerService extends AbstractTunnelManagerService
{
    public function __construct(
        TunnelSessionStorageInterface $sessionStorage,
        private readonly IntroStep $introStep,
    ) {
        parent::__construct($sessionStorage);
    }

    public static function getName(): string
    {
        return 'demo';
    }

    public function getEntrypointStep(): AbstractTunnelStep
    {
        return $this->introStep;
    }
}
