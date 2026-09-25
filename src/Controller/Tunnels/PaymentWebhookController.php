<?php

namespace Wexample\SymfonyTunnelsDemo\Controller\Tunnels;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Wexample\SymfonyTunnels\Class\TunnelCursor;
use Wexample\SymfonyTunnels\Enum\TunnelSessionStatus;
use Wexample\SymfonyTunnels\Service\AbstractTunnelManagerService;
use Wexample\SymfonyTunnels\Service\TunnelResumeService;
use Wexample\SymfonyTunnels\Service\TunnelRoutingService;
use Wexample\SymfonyTunnelsDemo\Service\Tunnel\Subscription\PaymentStep;

/**
 * Stands in for the bank: what its webhook would do, a button of the demo
 * does. It resumes the session waiting on the reference, then sends the
 * visitor back to the page they were waiting on, which moves on by itself.
 */
final class PaymentWebhookController
{
    public function __construct(
        private readonly TunnelResumeService $tunnelResumeService,
        private readonly TunnelRoutingService $tunnelRoutingService,
    ) {
    }

    #[Route(
        path: '/_tunnels-demo/payment-webhook',
        name: 'tunnels_demo_payment_webhook',
        methods: ['POST']
    )]
    public function confirm(Request $request): RedirectResponse
    {
        $waitingUrl = null;

        $this->tunnelResumeService->resumeByVariable(
            PaymentStep::VARIABLE_NAME_REFERENCE,
            $request->request->getString('reference'),
            function (?TunnelCursor $payment, AbstractTunnelManagerService $tunnel) use (&$waitingUrl): void {
                $waiting = $payment->findFirstNext();
                $waiting->setComplete();
                $tunnel->setSessionStatus(TunnelSessionStatus::OPENED);

                $waitingUrl = $this->tunnelRoutingService->buildCursorUrl($waiting);
            }
        );

        if (! $waitingUrl) {
            throw new NotFoundHttpException('No payment is waiting on this reference.');
        }

        return new RedirectResponse($waitingUrl);
    }
}
