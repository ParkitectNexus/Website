<?php


namespace PN\Assets\Http\Controllers\Api;


use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use PN\Assets\AssetFilter;
use PN\Assets\Http\Controllers\BaseAssetController;
use PN\Assets\Transformers\AssetTransformer;
use PN\Foundation\Http\Controllers\Controller;

class ApiAssetController extends BaseAssetController
{
    public function index()
    {
        // todo hotfix
        if (!\Request::has('sort')) {
            \Request::replace(array_merge(\Request::all(), ['sort' => 'hot_score']));
        }

        $onTags = $this->getOnTags(\Request::input('tags'));
        $offTags = $this->getOffTags(\Request::input('tags'));

        $assetFilter = (new AssetFilter())
            ->withNameLike(\Request::input('name', ''))
            ->withStats($this->getStats(\Request::input('stats', [])))
            ->withMaxAge($this->getMaxAge(\Request::has('range')))
            ->sortBy(request('sort', 'hot_score'));

        if (\Request::has('type')) {
            $type = \Request::input("type");
            if ($type == 'scenario') $type = 'park';
            $assetFilter->withType($type);

            if ($type == 'park' || $type == 'scenario') {
                if ($type == 'park') {
                    $offTags = $offTags->merge([\TagRepo::findByTagName('Scenario')]);
                } else {
                    $onTags = $onTags->merge([\TagRepo::findByTagName('Scenario')]);
                }
            }
        }

        $assetFilter->withTags($onTags);
        $assetFilter->withoutTags($offTags);

        $resource = new Collection($assetFilter->filter(), new AssetTransformer());
        $fractal = new Manager();
        $fractal->parseIncludes(request('include', []));
        return \Response::json($fractal->createData($resource)->toArray());

    }

    public function fetch($identifier)
    {
        $fractal = new Manager();

        $asset = \AssetRepo::findByIdentifier($identifier);

        $resource = new Item($asset, new AssetTransformer());

        $fractal->parseIncludes(request('include', []));

        return \Response::json($fractal->createData($resource)->toArray());
    }

    public function dependencies($identifier)
    {
        $asset = \AssetRepo::findByIdentifier($identifier)->getDependencies();

        $resource = new Collection($asset, new AssetTransformer());

        $fractal = new Manager();
        $fractal->parseIncludes(request('include', []));
        return \Response::json($fractal->createData($resource)->toArray());
    }

    public function required()
    {
        $optionRepo = \OptionRepo::find('required_assets');

        $ids = explode(',', $optionRepo->value);

        return \Response::json(['data' => $ids]);
    }

}