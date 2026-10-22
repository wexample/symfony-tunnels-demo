<?php

namespace Wexample\SymfonyTunnelsDemo\Service\Tunnel\Demo;

use Symfony\Component\Form\FormInterface;
use Wexample\SymfonyForms\Service\FormProcessor\AbstractFormProcessor;
use Wexample\SymfonyTunnels\Class\TunnelCursor;
use Wexample\SymfonyTunnels\Service\Step\AbstractFormTunnelStep;
use Wexample\SymfonyTunnelsDemo\Service\FormProcessor\Tunnel\DemoConfirmFormProcessor;

/**
 * Asks for a name before finishing, and shows it again when the visitor comes
 * back to this step.
 */
class ConfirmStep extends AbstractFormTunnelStep
{
    public const string STEP_NAME = 'confirm';

    public const string VARIABLE_NAME = 'name';

    public function __construct(
        private readonly DemoConfirmFormProcessor $formProcessor,
        private readonly DoneStep $doneStep,
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
        return ['name' => $cursor->getVariableValue(self::VARIABLE_NAME)];
    }

    public function onFormValid(FormInterface $form, TunnelCursor $cursor): ?TunnelCursor
    {
        $cursor->setVariableValue(self::VARIABLE_NAME, $form->get('name')->getData());

        return parent::onFormValid($form, $cursor);
    }

    public function buildSummary(TunnelCursor $cursor): ?string
    {
        $name = $cursor->getVariableValue(self::VARIABLE_NAME);

        return $name ? 'Name: ' . $name : null;
    }

    public function getAllowedNextSteps(TunnelCursor $cursor): array
    {
        return [
            $this->doneStep,
        ];
    }
}
