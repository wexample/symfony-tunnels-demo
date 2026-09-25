<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Demo;

use Wexample\SymfonyTunnelsDemo\Service\Tunnel\AbstractDemoStep;
use Wexample\SymfonyTunnels\Class\TunnelCursor;

/**
 * Closes the session once displayed: opening the tunnel again starts over.
 */
class DoneStep extends AbstractDemoStep
{
    public const string STEP_NAME = 'done';

    public function initAsCurrentStep(TunnelCursor $cursor): void
    {
        parent::initAsCurrentStep($cursor);

        $cursor->manager->setSessionComplete();
    }

    public function buildViewParams(TunnelCursor $cursor): array
    {
        return [
            'name' => $cursor->previous->getVariableValue(ConfirmStep::VARIABLE_NAME),
        ];
    }
}
