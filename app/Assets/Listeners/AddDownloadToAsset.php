<?php


namespace PN\Assets\Listeners;


use Illuminate\Foundation\Bus\DispatchesJobs;
use PN\Assets\Events\UserDownloadedAsset;
use PN\Tracking\Jobs\AddDownload;

/**
 * Class AddDownloadToAsset
 * @package PN\Assets\Listeners
 */
class AddDownloadToAsset
{
    use DispatchesJobs;

    /**
     * @param UserDownloadedAsset $event
     */
    public function handle(UserDownloadedAsset $event)
    {
        $this->dispatch(new AddDownload($event->user, $event->asset, \Request::ip()));
    }
}