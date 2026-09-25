<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Subscription;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Wexample\SymfonyTunnels\Class\TunnelCursor;
use Wexample\SymfonyTunnels\Enum\TunnelStepCompleteStrategy;
use Wexample\SymfonyTunnelsDemo\Service\Tunnel\AbstractDemoStep;

/**
 * Done by nobody in the request: the bank's answer, taken up by
 * TunnelResumeService, completes it. Shown again once that happened, it moves
 * the visitor on by itself.
 */
class WaitingStep extends AbstractDemoStep
{
    public const string STEP_NAME = 'waiting';

    public function __construct(
        private readonly WelcomeStep $welcomeStep,
    ) {
    }

    public function completeStrategy(): TunnelStepCompleteStrategy
    {
        return TunnelStepCompleteStrategy::MANUAL;
    }

    public function needsRedirect(TunnelCursor $cursor): null|RedirectResponse|TunnelCursor
    {
        return $cursor->isComplete()
            ? $cursor->findFirstNext()
            : parent::needsRedirect($cursor);
    }

    public function buildViewParams(TunnelCursor $cursor): array
    {
        return [
            'paymentReference' => $cursor->previous->getVariableValue(PaymentStep::VARIABLE_NAME_REFERENCE),
        ];
    }

    public function getAllowedNextSteps(TunnelCursor $cursor): array
    {
        return [
            $this->welcomeStep,
        ];
    }
}
