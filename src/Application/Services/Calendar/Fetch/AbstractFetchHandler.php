<?php

namespace App\Application\Services\Calendar\Fetch;

use App\Application\Services\Calendar\AbstractHandler;
use App\Entity\AuthToken;
use App\Entity\User;

abstract class AbstractFetchHandler extends AbstractHandler
{
    public function calendars(User $user, AuthToken $token): array
    {
        $calendars = $this->fetchCalendars($token);

        return $calendars;
    }

    abstract protected function fetchCalendars(AuthToken $token): array;
}