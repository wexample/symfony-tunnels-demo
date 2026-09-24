<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Demo;

use Wexample\SymfonyTunnels\Class\TunnelCursor;

class ConfirmStep extends AbstractDemoStep
{
    public const string STEP_NAME = 'confirm';

    public function __construct(
        private readonly DoneStep $doneStep,
    ) {
    }

    public function getAllowedNextSteps(TunnelCursor $cursor): array
    {
        return [
            $this->doneStep,
        ];
    }
}
