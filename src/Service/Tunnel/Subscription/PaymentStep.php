<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Subscription;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Wexample\SymfonyForms\Service\FormProcessor\AbstractFormProcessor;
use Wexample\SymfonyTunnels\Class\TunnelCursor;
use Wexample\SymfonyTunnels\Enum\TunnelSessionStatus;
use Wexample\SymfonyTunnels\Enum\TunnelStepPreviousLoadingStrategy;
use Wexample\SymfonyTunnels\Service\Step\AbstractFormTunnelStep;
use Wexample\SymfonyTunnelsDemo\Service\FormProcessor\Tunnel\SubscriptionPaymentFormProcessor;

/**
 * Only on the paid branch. The session is held for minutes while it is shown,
 * as a reserved seat would be; once paid, the flow waits for the bank, and
 * nothing before this step can be reached or undone any more.
 */
class PaymentStep extends AbstractFormTunnelStep
{
    public const string STEP_NAME = 'payment';

    /**
     * The identifier the bank sends back, and what the demo webhook looks for.
     */
    public const string VARIABLE_NAME_REFERENCE = 'payment-reference';

    public const string SESSION_EXPIRATION = '15 minutes';

    public function __construct(
        private readonly SubscriptionPaymentFormProcessor $formProcessor,
        private readonly WaitingStep $waitingStep,
    ) {
    }

    public static function getName(): string
    {
        return self::STEP_NAME;
    }

    public function getFormProcessor(TunnelCursor $cursor): AbstractFormProcessor
    {
        return $this->formProcessor;
    }

    public function buildSubmitLabel(TunnelCursor $cursor): string
    {
        return 'WexampleSymfonyTunnelsDemoBundle.common.tunnel::button.pay';
    }

    public function getSessionExpiration(TunnelCursor $cursor): string
    {
        return self::SESSION_EXPIRATION;
    }

    public function onFormValid(FormInterface $form, TunnelCursor $cursor): ?TunnelCursor
    {
        $cursor->setVariableValue(self::VARIABLE_NAME_REFERENCE, 'PAY-' . strtoupper(bin2hex(random_bytes(4))));
        $cursor->manager->setSessionStatus(TunnelSessionStatus::PENDING_ASYNC_ACTION);

        return parent::onFormValid($form, $cursor);
    }

    public function buildSummary(TunnelCursor $cursor): ?string
    {
        return $cursor->getVariableValue(self::VARIABLE_NAME_REFERENCE);
    }

    /**
     * Once paid, going back before this step would undo nothing the bank did.
     */
    public function allowAccessOf(
        TunnelCursor $cursor,
        TunnelCursor $siblingCursor,
    ): bool {
        return ! $cursor->isComplete() || ! $cursor->hasPreviousRecursive($siblingCursor);
    }

    /**
     * Nor is the payment form offered twice.
     */
    public function allowDirectAccess(
        TunnelCursor $cursor,
        TunnelCursor $cursorFrom,
    ): bool {
        return ($cursor === $cursorFrom || ! $cursor->isComplete())
            && parent::allowDirectAccess($cursor, $cursorFrom);
    }

    public function needsRedirect(TunnelCursor $cursor): null|RedirectResponse|TunnelCursor
    {
        return $cursor->isComplete()
            ? $cursor->findFirstNext()
            : parent::needsRedirect($cursor);
    }

    /**
     * A payment survives the visitor looking back at earlier steps.
     */
    public function previousStepLoadingStrategy(): TunnelStepPreviousLoadingStrategy
    {
        return TunnelStepPreviousLoadingStrategy::KEEP;
    }

    public function getAllowedNextSteps(TunnelCursor $cursor): array
    {
        return [
            $this->waitingStep,
        ];
    }
}
