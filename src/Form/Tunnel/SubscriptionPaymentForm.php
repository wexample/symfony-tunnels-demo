<?php

namespace Wexample\SymfonyTunnelsDemo\Form\Tunnel;

use Symfony\Component\Form\FormBuilderInterface;
use Wexample\SymfonyForms\Form\AbstractForm;

/**
 * Nothing to fill in: a real one would hold the card, here paying is pressing
 * the button.
 */
class SubscriptionPaymentForm extends AbstractForm
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
    }
}
