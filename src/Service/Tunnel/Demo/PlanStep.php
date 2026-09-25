<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Demo;

use Wexample\SymfonyTunnels\Class\TunnelCursor;
use Wexample\SymfonyTunnelsDemo\Service\Tunnel\AbstractDemoStep;

/**
 * The same step twice, once per plan, which is what the visitor's answer on the
 * previous step decides between.
 */
class PlanStep extends AbstractDemoStep
{
    public const string STEP_NAME = 'plan';

    public const string OPTION_NAME_PLAN = 'plan';

    public function __construct(
        private readonly ConfirmStep $confirmStep,
    ) {
    }

    /**
     * Two cursors of the same step, so the plan has to come from the options to
     * tell them apart, in the stepper as on the page.
     */
    public function buildLabel(TunnelCursor $cursor): string
    {
        return ucfirst($cursor->options[self::OPTION_NAME_PLAN]) . ' plan';
    }

    public function getAllowedNextSteps(TunnelCursor $cursor): array
    {
        return [
            $this->confirmStep,
        ];
    }
}
