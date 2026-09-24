<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Demo;

use Wexample\SymfonyTunnels\Class\TunnelCursor;

class IntroStep extends AbstractDemoStep
{
    public const string STEP_NAME = 'intro';

    public function __construct(
        private readonly PlanStep $planStep,
    ) {
    }

    public function getAllowedNextSteps(TunnelCursor $cursor): array
    {
        return [
            [
                'step' => $this->planStep,
                'name' => 'plan-free',
                'options' => [PlanStep::OPTION_NAME_PLAN => 'free'],
            ],
            [
                'step' => $this->planStep,
                'name' => 'plan-paid',
                'options' => [PlanStep::OPTION_NAME_PLAN => 'paid'],
            ],
        ];
    }
}
