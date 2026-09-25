<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Subscription;

use Wexample\SymfonyTunnels\Class\TunnelCursor;
use Wexample\SymfonyTunnelsDemo\Service\Tunnel\AbstractDemoStep;

/**
 * Reached by both branches, each through a cursor of its own; closes the
 * session once displayed.
 */
class WelcomeStep extends AbstractDemoStep
{
    public const string STEP_NAME = 'welcome';

    public function initAsCurrentStep(TunnelCursor $cursor): void
    {
        parent::initAsCurrentStep($cursor);

        $cursor->manager->setSessionComplete();
    }

    public function buildViewParams(TunnelCursor $cursor): array
    {
        return [
            'offer' => $cursor->getPreviousTrace()[1]->options[OfferStep::OPTION_NAME_OFFER],
        ];
    }
}
