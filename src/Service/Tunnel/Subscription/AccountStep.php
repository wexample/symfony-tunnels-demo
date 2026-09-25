<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Subscription;

use Symfony\Component\Form\FormInterface;
use Wexample\SymfonyForms\Service\FormProcessor\AbstractFormProcessor;
use Wexample\SymfonyTunnels\Class\TunnelCursor;
use Wexample\SymfonyTunnels\Service\Step\AbstractFormTunnelStep;
use Wexample\SymfonyTunnelsDemo\Service\FormProcessor\Tunnel\SubscriptionAccountFormProcessor;

/**
 * The same form on both branches, whose next step depends on the offer its
 * cursor carries: the payment only exists below a paid account.
 */
class AccountStep extends AbstractFormTunnelStep
{
    public const string STEP_NAME = 'account';

    public const string VARIABLE_NAME_EMAIL = 'email';

    public function __construct(
        private readonly SubscriptionAccountFormProcessor $formProcessor,
        private readonly PaymentStep $paymentStep,
        private readonly WelcomeStep $welcomeStep,
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

    public function buildFormData(TunnelCursor $cursor): mixed
    {
        return ['email' => $cursor->getVariableValue(self::VARIABLE_NAME_EMAIL)];
    }

    public function onFormValid(FormInterface $form, TunnelCursor $cursor): ?TunnelCursor
    {
        $cursor->setVariableValue(self::VARIABLE_NAME_EMAIL, $form->get('email')->getData());

        return parent::onFormValid($form, $cursor);
    }

    public function buildSummary(TunnelCursor $cursor): ?string
    {
        return $cursor->getVariableValue(self::VARIABLE_NAME_EMAIL);
    }

    public function getAllowedNextSteps(TunnelCursor $cursor): array
    {
        return [
            $cursor->options[OfferStep::OPTION_NAME_OFFER] === OfferStep::OFFER_PAID
                ? $this->paymentStep
                : $this->welcomeStep,
        ];
    }
}
