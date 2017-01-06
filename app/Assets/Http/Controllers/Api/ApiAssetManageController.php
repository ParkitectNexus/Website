<?php

namespace PN\Assets\Http\Controllers\Api;


use PN\Foundation\Http\Controllers\Controller;

class ApiAssetManageController extends Controller
{
    public function uploadAsset()
    {
        $resource = \ResourceUtil::make('resource');

        $str = str_random();
        \Cache::put('resources.'.$str, $resource, 10);

        return route('assets.manage.create', [$str]);
    }
}
