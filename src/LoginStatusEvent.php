<?php

namespace PHPMaker2024\sgq;

use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Login Status Event
 */
class LoginStatusEvent extends GenericEvent
{
    public const NAME = "login.status";
}
