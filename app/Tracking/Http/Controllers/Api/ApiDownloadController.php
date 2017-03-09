<?php

namespace PN\Tracking\Http\Controllers\Api;

use PN\Foundation\Http\Controllers\Controller;
use PN\Foundation\ModelTypeResolver;
use PN\Foundation\RepositoryResolver;
use PN\Tracking\Jobs\AddDownload;

class ApiDownloadController extends Controller
{
    public function addDownload($type, $id)
    {
        $model = ModelTypeResolver::resolveModel($type);

        $repo = RepositoryResolver::resolve($model);

        $downloadable = $repo->findByIdentifier($id);

        $this->dispatch(new AddDownload(\Auth::user(), $downloadable, \Request::ip()));
    }
}
