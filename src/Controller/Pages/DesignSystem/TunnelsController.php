<?php

namespace Wexample\SymfonyTunnelsDemo\Controller\Pages\DesignSystem;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Wexample\SymfonyLoader\Controller\AbstractPagesController;
use Wexample\SymfonyLoader\Controller\Pages\AbstractDesignSystemController;
use Wexample\SymfonyTunnels\Helper\TunnelTreeHelper;
use Wexample\SymfonyTunnels\Service\AbstractTunnelManagerService;
use Wexample\SymfonyTunnelsDemo\Service\Tunnel\DemoTunnelManagerService;
use Wexample\SymfonyTunnelsDemo\Service\Tunnel\SubscriptionTunnelManagerService;
use Wexample\SymfonyTunnelsDemo\Traits\SymfonyTunnelsDemoBundleClassTrait;

/**
 * The pages the demo tunnels are started from, one per route: each becomes an
 * entry of the Tunnels menu.
 */
#[Route(
    name: 'wexample_tunnels_demo_',
    path: AbstractDesignSystemController::CONTROLLER_BASE_ROUTE . '/tunnels/',
)]
final class TunnelsController extends AbstractPagesController
{
    use SymfonyTunnelsDemoBundleClassTrait;

    #[Route(name: 'index', path: '')]
    public function index(): Response
    {
        return $this->renderPage('index');
    }

    #[Route(name: 'plan', path: 'plan')]
    public function plan(DemoTunnelManagerService $tunnel): Response
    {
        return $this->renderPage('plan', [
            'paths' => $this->buildPaths($tunnel),
        ]);
    }

    #[Route(name: 'subscription', path: 'subscription')]
    public function subscription(SubscriptionTunnelManagerService $tunnel): Response
    {
        return $this->renderPage('subscription', [
            'paths' => $this->buildPaths($tunnel),
        ]);
    }

    #[Route(name: 'concepts', path: 'concepts')]
    public function concepts(): Response
    {
        return $this->renderPage('concepts');
    }

    /**
     * Every road through the tunnel, as the design system timeline draws it,
     * with the options that set it apart from the others. Only built, never
     * walked: no session is involved.
     *
     * @return array<array{options: array, timeline: array}>
     */
    private function buildPaths(AbstractTunnelManagerService $tunnel): array
    {
        $paths = [];

        foreach (TunnelTreeHelper::buildPaths($tunnel->createEntrypoint()) as $path) {
            $options = [];
            $items = [];

            foreach ($path as $cursor) {
                $options += $cursor->options;
                $items[] = ['title' => $cursor->step->buildLabel($cursor)];
            }

            $paths[] = [
                'options' => $options,
                'timeline' => ['numbered' => true, 'items' => $items],
            ];
        }

        return $paths;
    }
}
