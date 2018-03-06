<?php

namespace App\Util\StateMachine;

/**
 * Class JobStatus
 */
class JobStates
{
    const STATE_CREATED = 'created';
    const STATE_ACTIVE = 'active';
    const STATE_EXPIRED = 'expired';
    const STATE_REFUNDED = 'refunded';
    const STATE_FULFILLED = 'fulfilled';
}
