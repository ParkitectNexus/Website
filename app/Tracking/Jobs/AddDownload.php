<?php

namespace PN\Tracking\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use PN\Jobs\Job;
use PN\Tracking\Download;
use PN\Users\User;

/**
 * Class AddDownload
 * @package PN\Tracking\Jobs
 */
class AddDownload extends Job implements ShouldQueue
{
    use SerializesModels;
    
    /**
     * @var User|null
     */
    private $user;

    /**
     * @var Model
     */
    private $downloadable;

    /**
     * @var string
     */
    private $ip;

    /**
     * AddDownload constructor.
     * @param $user
     * @param Model $downloadable
     * @param $ip
     */
    public function __construct($user, Model $downloadable, $ip)
    {
        $this->user = $user;
        $this->downloadable = $downloadable;
        $this->ip = $ip;
    }

    public function handle()
    {
        $download = new Download();

        if($this->user != null){
            $download->setUser($this->user);
        }

        $download->setDownloadable($this->downloadable);
        $download->ip = $this->ip;

        \DownloadRepo::add($download);
    }
}
