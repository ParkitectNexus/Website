<?php

namespace PN\Assets\Http\Controllers;


use PN\Assets\AssetFilter;
use PN\Assets\Events\UserDownloadedAsset;
use PN\Assets\Events\UserViewingAsset;
use PN\Assets\Exceptions\AssetCantBeDownloadedException;
use PN\Assets\Repositories\AssetRepositoryInterface;
use PN\Foundation\StorageUtil;

class AssetController extends BaseAssetController
{
    /**
     * @var AssetRepositoryInterface
     */
    private $assetRepo;

    /**
     * AssetController constructor.
     * @param $assetRepo
     */
    public function __construct(AssetRepositoryInterface $assetRepo)
    {
        $this->assetRepo = $assetRepo;
    }

    public function getShow($identifier, $slug)
    {
        $asset = $this->assetRepo->findByIdentifier($identifier);

        abort_if($asset == null, 404);

        $comments = \CommentRepo::forAsset($asset);

        event(new UserViewingAsset($asset, \Auth::user()));

        return view('assets.show', compact(
            'asset',
            'comments'
        ));
    }

    public function filterPage($type)
    {
        $morpedType = $type;
        if ($morpedType == 'scenario') {
            $morpedType = 'park';
        }

        $filters = config('assetfilters.' . $morpedType, []);

        $tags = \TagRepo::findByCategory($type);

        if ($type == 'blueprint') {
            $contentTypeTags = \TagRepo::findByCategory('content-types');
            $coasterTypeTags = \TagRepo::findByCategory('coaster-types');
        } else {
            $contentTypeTags = [];
            $coasterTypeTags = [];
        }

        $assetList = $this->filterAssets($type)->render();

        return view('assets.filter', compact(
            'assetList',
            'filters',
            'tags',
            'contentTypeTags',
            'coasterTypeTags',
            'type'
        ));
    }

    public function filterAssets($type)
    {
        $morpedType = $type;
        if ($morpedType == 'scenario') {
            $morpedType = 'park';
        }

        // todo hotfix
        if (!\Request::has('sort')) {
            \Request::replace(array_merge(\Request::all(), ['sort' => 'hot_score']));
        }

        $onTags = $this->getOnTags(\Request::input('tags'));
        $offTags = $this->getOffTags(\Request::input('tags'));

        if ($type == 'park' || $type == 'scenario') {
            if ($type == 'park') {
                $offTags = $offTags->merge([\TagRepo::findByTagName('Scenario')]);
            } else {
                $onTags = $onTags->merge([\TagRepo::findByTagName('Scenario')]);
            }
        }

        $assetFilter = (new AssetFilter())
            ->withType($morpedType)
            ->withNameLike(\Request::input('name', ''))
            ->withTags($onTags)
            ->withoutTags($offTags)
            ->withStats($this->getStats(\Request::input('stats', [])))
            ->withMaxAge($this->getMaxAge(\Request::has('range')))
            ->sortBy(request('sort', 'hot_score'));

        $assets = $assetFilter->filterPaginated();

        $assets->setPath(route('assets.filter', [$type]));
        $assets->appends(\Request::all());

        return view('assets.partials.list', compact(
            'assets',
            'type'
        ));
    }


    public function download($identifier)
    {
        $asset = \AssetRepo::findByIdentifier($identifier);

        event(new UserDownloadedAsset($asset, \Auth::user()));

        $extension = pathinfo($asset->getResource()->source, PATHINFO_EXTENSION);

        if ($asset->type == 'blueprint') {
            $tempPath = StorageUtil::copyToTmp('blueprints', $asset->getResource()->source);

            $arguments = escapeshellarg(base_path('bin/ParkitectNexus.AssetTools.exe')) . " blueprint-convert " .
                "--input " . \ResourceUtil::escapeArgument($tempPath) . " " .
                "--background " . \ResourceUtil::escapeArgument(base_path('bin/blueprint_bg.png')) . " " .
                "--logo " . \ResourceUtil::escapeArgument(base_path('bin/logo.png')) . " " .
                "--font " . \ResourceUtil::escapeArgument(base_path('bin/Roboto-Regular.ttf')) . " " .
                "--draw-text " .
                \ResourceUtil::escapeArgument("175,450,#ffffffff,12 {$asset->name}") . " " .
                \ResourceUtil::escapeArgument("175,465,#ffffffff,12 By {$asset->getUser()->getPresenter()->displayName()}") . " " .
                \ResourceUtil::escapeArgument("175,480,#ffffffff,12 Downloaded from ParkitectNexus.com");

            $result = shell_exec("PATH=\$PATH:/usr/local/bin; mono $arguments 2>&1");

            return response(base64_decode($result))
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', "attachment; filename=\"{$asset->slug}.$extension\"");
        } else {
            if ($asset->type == 'park') {
                $tempPath = StorageUtil::copyToTmp('parks', $asset->getResource()->source);

                return \Response::download($tempPath, $asset->slug . '.' . $extension);
            } else {
                throw new AssetCantBeDownloadedException(sprintf("Asset identifier: %s", $identifier));
            }
        }
    }
}