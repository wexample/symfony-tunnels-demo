<?php

namespace Wexample\SymfonyTunnelsDemo\Form\Tunnel;

use Symfony\Component\Form\FormBuilderInterface;
use Wexample\SymfonyForms\Form\AbstractForm;
use Wexample\SymfonyForms\Form\Type\TextInputType;

/**
 * No submit button: in a tunnel, the way on is the next button of the step.
 */
class DemoConfirmForm extends AbstractForm
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('name', TextInputType::class, [
                self::FIELD_OPTION_NAME_LABEL => true,
                self::FIELD_OPTION_NAME_REQUIRED => true,
            ]);
    }
}
