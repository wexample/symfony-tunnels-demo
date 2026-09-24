<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Demo;

use Wexample\SymfonyTunnels\Class\TunnelCursor;

class DoneStep extends AbstractDemoStep
{
    public const string STEP_NAME = 'done';

    public function buildViewParams(TunnelCursor $cursor): array
    {
        return [
            'name' => $cursor->previous->getVariableValue(ConfirmStep::VARIABLE_NAME),
        ];
    }
}
