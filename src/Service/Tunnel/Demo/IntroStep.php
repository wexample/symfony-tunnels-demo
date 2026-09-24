<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Demo;

use Wexample\SymfonyTunnels\Class\TunnelCursor;

class IntroStep extends AbstractDemoStep
{
    public const string STEP_NAME = 'intro';

    public function __construct(
        private readonly ChoiceStep $choiceStep,
    ) {
    }

    public function getAllowedNextSteps(TunnelCursor $cursor): array
    {
        return [
            [
                'step' => $this->choiceStep,
                'name' => 'plan-free',
                'options' => [ChoiceStep::OPTION_NAME_PLAN => 'free'],
            ],
            [
                'step' => $this->choiceStep,
                'name' => 'plan-paid',
                'options' => [ChoiceStep::OPTION_NAME_PLAN => 'paid'],
            ],
        ];
    }
}
