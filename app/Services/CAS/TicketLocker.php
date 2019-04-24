<?php
namespace App\Services\CAS;

use Leo108\CAS\Contracts\TicketLocker as TicketLockerContract;

class TicketLocker implements TicketLockerContract
{
    public function acquireLock($key, $timeout)
    {
        return true;
    }

    public function releaseLock($key)
    {
        return true;
    }
}