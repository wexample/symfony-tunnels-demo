<?php

namespace Wexample\SymfonyTunnelsDemo\Controller\Pages\DesignSystem;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Wexample\SymfonyLoader\Controller\AbstractPagesController;
use Wexample\SymfonyLoader\Controller\Pages\AbstractDesignSystemController;
use Wexample\SymfonyLoader\Service\AdaptiveRendererService;
use Wexample\SymfonyLoader\Service\PageService;
use Wexample\SymfonyTunnels\Class\TunnelCursor;
use Wexample\SymfonyTunnelsDemo\Service\Tunnel\DemoTunnelManagerService;
use Wexample\SymfonyTunnelsDemo\Traits\SymfonyTunnelsDemoBundleClassTrait;

#[Route(
    name: 'wexample_tunnels_demo_',
    path: AbstractDesignSystemController::CONTROLLER_BASE_ROUTE . '/tunnels/',
)]
final class TunnelsController extends AbstractPagesController
{
    use SymfonyTunnelsDemoBundleClassTrait;

    public function __construct(
        AdaptiveRendererService $adaptiveRendererService,
        PageService $pageService,
        private readonly DemoTunnelManagerService $demoTunnel,
    ) {
        parent::__construct($adaptiveRendererService, $pageService);
    }

    /**
     * The tunnel is only built here, not walked: it shows the engine is wired
     * and what shape a tunnel takes, before any of it is put behind a URL.
     */
    #[Route(name: 'index', path: '')]
    public function index(): Response
    {
        return $this->renderPage('index', [
            'tunnelName' => $this->demoTunnel::getName(),
            'tunnelTree' => $this->buildTreeLines($this->demoTunnel->createEntrypoint()),
        ]);
    }

    /**
     * @return array<array{depth: int, name: string, options: string, hash: string}>
     */
    private function buildTreeLines(TunnelCursor $entrypoint): array
    {
        $lines = [];

        $entrypoint->forSelfAndNextRecursive(
            static function (TunnelCursor $cursor) use (&$lines): void {
                $lines[] = [
                    'depth' => $cursor->distanceFromRoot(),
                    'name' => $cursor->step::getName(),
                    'options' => $cursor->options ? json_encode($cursor->options) : '',
                    'hash' => $cursor->hash,
                ];
            }
        );

        return $lines;
    }
}
