<?php

namespace PN\Assets\Providers;


use Illuminate\Support\ServiceProvider;
use PN\Assets\Http\Controllers\Api\ApiAssetController;
use PN\Assets\Http\Controllers\Api\ApiAssetManageController;
use PN\Assets\Http\Controllers\Api\ApiAssetModController;
use PN\Assets\Http\Controllers\AssetController;
use PN\Assets\Http\Controllers\AssetManageController;
use PN\Assets\Repositories\AssetRepository;
use PN\Assets\Repositories\AssetRepositoryInterface;
use PN\Assets\Repositories\TagRepository;
use PN\Assets\Repositories\TagRepositoryInterface;
use PN\Foundation\Providers\CompileHelperTrait;
use Symfony\Component\Routing\Router;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $router = $this->app['router'];

        $router->group(['middleware' => ['web']], function() use ($router) {

            $router->group(['prefix' => 'assets', 'as' => 'assets.'], function () use ($router) {
                $router->get('manage/selectmod', [
                    'as' => 'manage.selectmod',
                    'uses' => AssetManageController::class . '@getSelectMod'
                ]);
                $router->post('manage/selectmod', [
                    'as' => 'manage.selectmod',
                    'uses' => AssetManageController::class . '@postSelectMod'
                ]);
                $router->get('manage/selectfile', [
                    'as' => 'manage.selectfile',
                    'uses' => AssetManageController::class . '@getSelectFile'
                ]);
                $router->post('manage/selectfile', [
                    'as' => 'manage.selectfile',
                    'uses' => AssetManageController::class . '@postSelectFile'
                ]);
                $router->get('manage/create', [
                    'as' => 'manage.create',
                    'uses' => AssetManageController::class . '@getCreate'
                ]);
                $router->post('manage/create', [
                    'as' => 'manage.create',
                    'uses' => AssetManageController::class . '@postCreate'
                ]);
                $router->get('manage/update/{identifier}', [
                    'as' => 'manage.update',
                    'uses' => AssetManageController::class . '@getUpdate'
                ]);
                $router->post('manage/update/{identifier}', [
                    'as' => 'manage.update',
                    'uses' => AssetManageController::class . '@postUpdate'
                ]);
                $router->delete('manage/delete/{id}', [
                    'as' => 'manage.delete',
                    'uses' => AssetManageController::class . '@deleteDelete'
                ]);
                $router->get('{type}', [
                    'as' => 'filter',
                    'uses' => AssetController::class . '@filterPage'
                ]);
                $router->get('download/{identifier}', [
                    'as' => 'download',
                    'uses' => AssetController::class . '@download'
                ]);
                $router->get('{type}/filter', [
                    'as' => 'filter.list',
                    'uses' => AssetController::class . '@filterAssets'
                ]);

                $router->get('{identifier}/{slug}', [
                    'as' => 'show',
                    'uses' => AssetController::class . '@getShow'
                ]);
            });

        });

        \Route::group(['prefix' => 'api/assets', 'as' => 'api.assets.'], function () {
            \Route::get('required', ['as' => 'required', 'uses' => ApiAssetController::class . '@required']);
            \Route::get('/', ['as' => 'index', 'uses' => ApiAssetController::class . '@index']);
            \Route::get('/{identifier}', ['as' => 'index', 'uses' => ApiAssetController::class . '@fetch']);
            \Route::get('/{identifier}/dependencies', ['as' => 'dependencies', 'uses' => ApiAssetController::class . '@dependencies']);

            \Route::group(['prefix' => 'manage', 'as' => 'manage.'], function () {
                \Route::post("upload-asset", ['as' => "upload", "uses" => ApiAssetManageController::class . "@uploadAsset"]);
            });

        });

        $this->app->singleton(AssetRepositoryInterface::class, AssetRepository::class);
        $this->app->singleton(TagRepositoryInterface::class, TagRepository::class);
    }

    public static function compiles()
    {
        $files = [];

        $files = array_merge($files, CompileHelperTrait::filesInFolder(app_path('Assets/Providers')));

        return $files;
    }
}
