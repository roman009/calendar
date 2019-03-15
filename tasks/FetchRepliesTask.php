<?php

use Crunz\Schedule;
use Symfony\Component\Lock\Store\FlockStore;

$store = new FlockStore(__DIR__ . '/../var/locks/');

$schedule = new Schedule();
$schedule
    ->run('./bin/console', ['-vvv', 'app:smart-invite-handle-test'])
    ->everyMinute()
    ->preventOverlapping($store);

return $schedule;