<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Subscription;

use Wexample\SymfonyTunnels\Class\TunnelCursor;
use Wexample\SymfonyTunnelsDemo\Service\Tunnel\AbstractDemoStep;

/**
 * The entrypoint: the offer picked is carried as an option by every cursor
 * below, which is what lets a later step grow a branch of its own.
 */
class OfferStep extends AbstractDemoStep
{
    public const string STEP_NAME = 'offer';

    public const string OPTION_NAME_OFFER = 'offer';

    public const string OFFER_FREE = 'free';

    public const string OFFER_PAID = 'paid';

    public function __construct(
        private readonly AccountStep $accountStep,
    ) {
    }

    public function getAllowedNextSteps(TunnelCursor $cursor): array
    {
        return array_map(
            fn (string $offer): array => [
                'step' => $this->accountStep,
                'name' => 'account-' . $offer,
                'options' => [self::OPTION_NAME_OFFER => $offer],
            ],
            [self::OFFER_FREE, self::OFFER_PAID]
        );
    }
}
