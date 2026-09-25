<?php

namespace Wexample\SymfonyTunnelsDemo\Service\FormProcessor\Tunnel;

use Wexample\SymfonyForms\Service\FormProcessor\AbstractFormProcessor;
use Wexample\SymfonyHelpers\Helper\RoleHelper;

class SubscriptionPaymentFormProcessor extends AbstractFormProcessor
{
    public function getRequiredRoles(): array
    {
        return [RoleHelper::PUBLIC_ACCESS];
    }
}
