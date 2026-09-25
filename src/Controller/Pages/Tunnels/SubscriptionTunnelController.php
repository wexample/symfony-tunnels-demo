<?php

namespace Wexample\SymfonyTunnelsDemo\Controller\Pages\Tunnels;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Wexample\SymfonyTunnels\Attribute\TunnelRoute;
use Wexample\SymfonyTunnels\Controller\AbstractTunnelController;
use Wexample\SymfonyTunnelsDemo\Service\Tunnel\SubscriptionTunnelManagerService;
use Wexample\SymfonyTunnelsDemo\Traits\SymfonyTunnelsDemoBundleClassTrait;

/**
 * Mounts the tunnel below its page, tunnels/subscription: each step at tunnels/subscription/<step>.
 */
#[Route(path: 'tunnels/subscription/', name: 'tunnels_subscription_')]
final class SubscriptionTunnelController extends AbstractTunnelController
{
    use SymfonyTunnelsDemoBundleClassTrait;

    public static function getTunnelManagerClass(): string
    {
        return SubscriptionTunnelManagerService::class;
    }

    #[TunnelRoute(cursorPlaceholder: '{step}')]
    public function index(Request $request): Response
    {
        return $this->handleTunnelRequest($request);
    }
}
