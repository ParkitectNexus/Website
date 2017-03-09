<?php

namespace PN\Tracking\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use PN\Jobs\Job;
use PN\Tracking\View;
use PN\Users\User;

/**
 * Class AddView
 * @package PN\Tracking\Jobs
 */
class AddView extends Job implements ShouldQueue
{
    use SerializesModels;
    
    /**
     * @var User|null
     */
    private $user;

    /**
     * @var Model
     */
    private $viewable;

    /**
     * @var string
     */
    private $ip;

    /**
     * AddView constructor.
     * @param $user
     * @param Model $viewable
     * @param $ip
     */
    public function __construct($user, Model $viewable, $ip)
    {
        $this->user = $user;
        $this->viewable = $viewable;
    }

    public function handle()
    {
        $view = new View();

        if($this->user != null){
            $view->setUser($this->user);
        }

        $view->setViewable($this->viewable);
        $view->ip = $this->ip;

        \ViewRepo::add($view);
    }
}
