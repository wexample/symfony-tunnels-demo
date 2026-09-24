<?php

namespace Wexample\SymfonyTunnelsDemo\Form\Tunnel;

use Symfony\Component\Form\FormBuilderInterface;
use Wexample\SymfonyForms\Form\AbstractForm;
use Wexample\SymfonyForms\Form\Type\SubmitInputType;
use Wexample\SymfonyForms\Form\Type\TextInputType;

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
            ])
            ->add('submit', SubmitInputType::class, [
                self::FIELD_OPTION_NAME_LABEL => 'action.submit',
                'primary' => true,
            ]);
    }
}
