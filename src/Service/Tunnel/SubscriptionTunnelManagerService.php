<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel;

use Wexample\SymfonyTunnels\Interface\TunnelSessionStorageInterface;
use Wexample\SymfonyTunnels\Service\AbstractTunnelManagerService;
use Wexample\SymfonyTunnels\Service\Step\AbstractTunnelStep;
use Wexample\SymfonyTunnelsDemo\Service\Tunnel\Subscription\OfferStep;

/**
 * A subscription whose paid branch goes through a payment the free one never
 * sees: a step held for minutes, waiting on the bank, and closing the way back.
 */
class SubscriptionTunnelManagerService extends AbstractTunnelManagerService
{
    public function __construct(
        TunnelSessionStorageInterface $sessionStorage,
        private readonly OfferStep $offerStep,
    ) {
        parent::__construct($sessionStorage);
    }

    public static function getName(): string
    {
        return 'subscription';
    }

    public function getEntrypointStep(): AbstractTunnelStep
    {
        return $this->offerStep;
    }
}
