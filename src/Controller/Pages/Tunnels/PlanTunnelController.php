<?php

namespace Wexample\SymfonyTunnelsDemo\Controller\Pages\Tunnels;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Wexample\SymfonyTunnels\Attribute\TunnelRoute;
use Wexample\SymfonyTunnels\Controller\AbstractTunnelController;
use Wexample\SymfonyTunnelsDemo\Service\Tunnel\DemoTunnelManagerService;
use Wexample\SymfonyTunnelsDemo\Traits\SymfonyTunnelsDemoBundleClassTrait;

/**
 * Mounts the tunnel below its page, tunnels/plan: each step at tunnels/plan/<step>.
 */
#[Route(path: 'tunnels/plan/', name: 'tunnels_plan_')]
final class PlanTunnelController extends AbstractTunnelController
{
    use SymfonyTunnelsDemoBundleClassTrait;

    public static function getTunnelManagerClass(): string
    {
        return DemoTunnelManagerService::class;
    }

    #[TunnelRoute(cursorPlaceholder: '{step}')]
    public function index(Request $request): Response
    {
        return $this->handleTunnelRequest($request);
    }
}
