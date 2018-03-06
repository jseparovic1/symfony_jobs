<?php

namespace App\Util\StateMachine;

/**
 * Class JobTransitions
 */
class JobTransitions
{
    const GRAPH = 'job';

    const TRANSITION_PAY = 'pay';
    const TRANSITION_EXPIRE = 'expire';
    const TRANSITION_REFUND = 'refund';
    const TRANSITION_RENEW = 'renew';
    const TRANSITION_FULFILL = 'fulfill';
}
