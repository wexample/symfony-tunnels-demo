<?php

namespace Wexample\SymfonyTunnelsDemo\Controller\Tunnels;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Wexample\SymfonyTunnels\Attribute\TunnelRoute;
use Wexample\SymfonyTunnels\Controller\AbstractTunnelController;
use Wexample\SymfonyTunnelsDemo\Service\Tunnel\SubscriptionTunnelManagerService;
use Wexample\SymfonyTunnelsDemo\Traits\SymfonyTunnelsDemoBundleClassTrait;

final class SubscriptionTunnelController extends AbstractTunnelController
{
    use SymfonyTunnelsDemoBundleClassTrait;

    public static function getTunnelManagerClass(): string
    {
        return SubscriptionTunnelManagerService::class;
    }

    #[TunnelRoute]
    public function index(Request $request): Response
    {
        return $this->handleTunnelRequest($request);
    }
}
