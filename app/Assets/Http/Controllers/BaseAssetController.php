<?php
/**
 * Created by PhpStorm.
 * User: michaelpollind
 * Date: 1/5/17
 * Time: 3:45 PM
 */

namespace PN\Assets\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use PN\Foundation\Http\Controllers\Controller;

class BaseAssetController extends Controller
{
    protected function getStats($stateKeyPairs): Collection
    {
        $stats = new Collection();

        foreach ($stateKeyPairs as $slug => $value) {
            $stat = \StatRepo::findBySlug($slug);

            if ($stat == null) {
                dd($slug);
            }
            $stats->put($stat->id, $value);
        }

        return $stats;
    }

    protected function getOnTags($tags): Collection
    {
        $onTags = Collection::make($tags)->filter(function ($state) {
            return $state == 'on';
        });

        if (!$onTags->count()) {
            return new Collection();
        }

        return \TagRepo::findBySlugs(array_keys($onTags->toArray()));
    }

    protected function getOffTags($tags): Collection
    {
        $offTags = Collection::make($tags)->filter(function ($state) {
            return $state == 'off';
        });

        if (!$offTags->count()) {
            return new Collection();
        }

        return \TagRepo::findBySlugs(array_keys($offTags->toArray()));
    }

    protected function getMaxAge($range): Carbon
    {
        if ($range) {
            if ($range == 'week') {
                return Carbon::now()->subWeek();
            }
            if ($range == 'month') {
                return Carbon::now()->subMonth();
            }
        }

        return Carbon::now()->subYears(10);
    }
}