<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Demo;

use Wexample\SymfonyTunnels\Class\TunnelCursor;

/**
 * The same step twice, once per plan, which is what the visitor's answer on the
 * previous step decides between.
 */
class ChoiceStep extends AbstractDemoStep
{
    public const string STEP_NAME = 'choice';

    public const string OPTION_NAME_PLAN = 'plan';

    public function __construct(
        private readonly ConfirmStep $confirmStep,
    ) {
    }

    public function getAllowedNextSteps(TunnelCursor $cursor): array
    {
        return [
            $this->confirmStep,
        ];
    }
}
