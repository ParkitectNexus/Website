<?php

namespace PN\Assets\Http\Controllers;


use PN\Assets\Exceptions\SessionExpired;
use PN\Assets\Http\Requests\CreateRequest;
use PN\Assets\Http\Requests\SelectFileRequest;
use PN\Assets\Http\Requests\SelectModRequest;
use PN\Assets\Jobs\CreateAsset;
use PN\Assets\Jobs\ParticipateInBuildOff;
use PN\Assets\Jobs\ResetDependencies;
use PN\Assets\Jobs\ResetThumbnail;
use PN\Assets\Jobs\SetAssetImage;
use PN\Assets\Jobs\SetYoutubeOnAsset;
use PN\Assets\Jobs\Tags\AttachTagToAsset;
use PN\Assets\Jobs\Tags\ResetSecondaryTags;
use PN\Assets\Jobs\UpdateAsset;
use PN\Foundation\Http\Controllers\Controller;
use PN\Media\Jobs\AddImageToAsset;
use PN\Media\Jobs\CreateImageFromRaw;
use PN\Resources\Exceptions\InvalidResource;
use PN\Resources\Jobs\StoreResource;

class AssetManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getSelectFile()
    {
        return view('assets/manage/select-file');
    }

    public function postSelectFile(SelectFileRequest $request)
    {
        $resource = \ResourceUtil::make('resource');

        \Session::set('resource', $resource);

        return redirect(route('assets.manage.create'));
    }

    public function getSelectMod()
    {
        return view('assets/manage/select-mod');
    }

    public function postSelectMod(SelectModRequest $request)
    {
        try {
            $resource = \ResourceUtil::make(request('resource'));
        } catch (InvalidResource $e) {
            return back()->withErrors("Please provided a valid Github repository.");
        }

        \Session::set('resource', $resource);

        return redirect(route('assets.manage.create'));
    }

    public function getCreate($id = null)
    {
        if ($id != null) {
            $resource = \Cache::get('resources.' . $id);

            \Session::set('resource', $resource);
        }

        $resource = \Session::get('resource');

        $mods = \AssetRepo::findByType('mod');
        $buildOffs = \BuildOffRepo::getEligibleForResource($resource);
        $primaryTags = \TagRepo::findByPrimaryTags($resource->getPrimaryTags()->toArray());
        $secondaryTags = \TagRepo::findSecondary($resource->getType());
        $type = $resource->getType();
        $name = $resource->getExtractor()->getName();

        if ($resource == null) {
            throw new SessionExpired();
        }

        return view('assets.manage.create', compact(
            'name',
            'resource',
            'type',
            'buildOffs',
            'primaryTags',
            'secondaryTags',
            'mods',
            'name'
        ));
    }

    public function postCreate(CreateRequest $request)
    {
        $resource = $this->dispatch(new StoreResource(\Session::get('resource')));

        \ResourceRepo::add($resource);

        $asset = $this->dispatch(new CreateAsset(
            $resource,
            \Auth::user(),
            \Request::get('name'),
            \Request::get('description')
        ));

        if (\Request::get('youtube', '') != '') {
            $this->dispatch(new SetYoutubeOnAsset($asset, \Request::get('youtube')));
        }

        if (\Request::hasFile('image')) {
            $image = $this->dispatch(new CreateImageFromRaw(file_get_contents(\Request::file('image')->getRealPath())));

            $this->dispatch(new SetAssetImage($asset, $image));
        }

        foreach (\Request::file('album', []) as $image) {
            if ($image != null) {
                $newImage = $this->dispatch(new CreateImageFromRaw(
                    file_get_contents($image->getRealPath())
                ));

                $this->dispatch(new AddImageToAsset($asset, $newImage));
            }
        }

        foreach (\Request::get('tags', []) as $tagId => $state) {
            $tag = \TagRepo::find($tagId);

            $this->dispatch(app(AttachTagToAsset::class, [$asset, $tag]));
        }

        if (request('buildoff', 0) != 0) {
            $buildOff = \BuildOffRepo::find(request('buildoff'));

            $this->dispatch(new ParticipateInBuildOff($asset, $buildOff));
        }

        foreach (request('dependencies', []) as $depencyId) {
            $dependency = \AssetRepo::findByIdentifier($depencyId);

            $asset->addDependency($dependency);
        }

        \Log::info(sprintf('Asset create! %s, ', $asset->name, $asset->getPresenter()->url()));

        \Session::remove('resource');

        return redirect(route('assets.show', [$asset->identifier, $asset->slug]));
    }

    public function getUpdate($identifier)
    {
        $asset = \AssetRepo::findByIdentifier($identifier);
        $resource = $asset->getResource();

        abort_if(\Gate::denies('update', $asset), 401);

        $mods = \AssetRepo::findByType('mod');
        $buildOffs = \BuildOffRepo::all();
        $primaryTags = \TagRepo::findByPrimaryTags($resource->getPrimaryTags()->toArray());
        $secondaryTags = \TagRepo::findSecondary($resource->getType());
        $type = $resource->getType();

        if ($resource == null) {
            throw new SessionExpired();
        }

        return view('assets.manage.update', compact(
            'asset',
            'resource',
            'type',
            'buildOffs',
            'primaryTags',
            'secondaryTags',
            'mods',
            'name'
        ));
    }

    public function postUpdate($identifier)
    {
        $asset = \AssetRepo::findByIdentifier($identifier);

        abort_if(\Gate::denies('update', $asset), 401);

        $asset = $this->dispatch(new UpdateAsset(
            $asset,
            request('name'),
            request('description')
        ));

        if (request('youtube', '') != '') {
            $this->dispatch(new SetYoutubeOnAsset($asset, request('youtube')));
        }

        if (request('reset-image', false) != false) {
            $this->dispatch(new ResetThumbnail($asset));
        } else {
            if (\Request::hasFile('image')) {
                $image = $this->dispatch(new CreateImageFromRaw(file_get_contents(\Request::file('image')->getRealPath())));

                $this->dispatch(new SetAssetImage($asset, $image));
            }
        }

        foreach (\Request::file('album', []) as $image) {
            if ($image != null) {
                $newImage = $this->dispatch(new CreateImageFromRaw(
                    file_get_contents($image->getRealPath())
                ));

                $this->dispatch(new AddImageToAsset($asset, $newImage));
            }
        }

        foreach (request('deletes', []) as $id) {
            $image = \ImageRepo::find($id);

            $asset->removeImage($image);
        }

        $this->dispatch(new ResetSecondaryTags($asset));

        foreach (\Request::get('tags', []) as $tagId => $state) {
            $tag = \TagRepo::find($tagId);

            $this->dispatch(app(AttachTagToAsset::class, [$asset, $tag]));
        }

        $this->dispatch(new ResetDependencies($asset));
        foreach (request('dependencies', []) as $depencyId) {
            $dependency = \AssetRepo::findByIdentifier($depencyId);

            $asset->addDependency($dependency);
        }

        return redirect(route('assets.show', [$asset->identifier, $asset->slug]));
    }

    public function deleteDelete($identifier)
    {
        $asset = \AssetRepo::findByIdentifier($identifier);

        abort_if(\Gate::denies('delete', $asset), 401);

        $asset->delete();

        return redirect(\Auth::user()->getPresenter()->url());
    }
}
