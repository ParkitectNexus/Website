<?php

namespace PN\Tracking\Console\Commands;

use Illuminate\Console\Command;
use PN\Tracking\view;

class RecalculateViews extends Command
{
    /**
     * @var string
     */
    protected $signature = 'views:recalculate';

    /**
     * @var string
     */
    protected $description = 'Recalculates the views on everything that is viewable';

    /**
     * @return mixed
     */
    public function handle()
    {
        $views = \DB::select('select count(id) as views, viewable_id, viewable_type from (select *, date(created_at) as d from views group by ip, d) as tmp group by viewable_type, viewable_id');

        foreach($views as $views) {
            $viewable = app($views->viewable_type)->find($views->viewable_id);

            $viewable->views = $views->views;

            $viewable->save();
        }
    }
}