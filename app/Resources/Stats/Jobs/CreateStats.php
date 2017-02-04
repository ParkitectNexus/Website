<?php

namespace PN\Resources\Stats\Jobs;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use PN\Resources\Stats\Jobs\CreateBlueprintStats;
use PN\Resources\Stats\Jobs\CreateParkStats;
use PN\Jobs\Job;
use PN\Resources\Resource;

/**
 * Class CreateStats
 * @package PN\Resources\Stats\Jobs
 */
class CreateStats extends Job
{
    /**
     * @var \PN\Resources\Resource
     */
    private $resource;

    /**
     * CreateStats constructor.
     * @param $resource
     */
    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return mixed|null
     */
    public function handle()
    {
        switch($this->resource->type) {
            case 'blueprint':
                $this->dispatch(new CreateBlueprintStats($this->resource));
                break;
            case 'park':
                $this->dispatch(new CreateParkStats($this->resource));
                break;
        }
    }
}
