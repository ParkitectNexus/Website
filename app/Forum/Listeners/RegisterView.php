<?php

namespace PN\Forum\Listeners;


use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Forum\Events\UserViewingThread;
use PN\Tracking\Jobs\AddView;

/**
 * Class RegisterView
 * @package ParkitectNexus\Listeners
 */
class RegisterView
{
    use DispatchesJobs;

    public function handle(UserViewingThread $event)
    {
        $this->dispatch(new AddView(\Auth::user(), $event->thread, \Request::ip()));
    }
}
