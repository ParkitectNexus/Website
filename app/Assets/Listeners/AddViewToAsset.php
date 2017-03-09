<?php


namespace PN\Assets\Listeners;


use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Assets\Events\UserViewingAsset;
use PN\Tracking\Jobs\AddView;

/**
 * Class AddViewToAsset
 * @package PN\Assets\Listeners
 */
class AddViewToAsset
{
    use DispatchesJobs;

    /**
     * @param UserViewingAsset $event
     */
    public function handle(UserViewingAsset $event)
    {
        $this->dispatch(new AddView($event->user, $event->asset, \Request::ip()));
    }
}