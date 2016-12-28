<?php


namespace PN\Client\Providers;


use Illuminate\Support\ServiceProvider;
use PN\Client\Http\Controllers\ClientController;
use PN\Client\Repositories\ClientRepository;
use PN\Client\Repositories\ClientRepositoryInterface;

class ClientLogServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ClientRepositoryInterface::class, ClientRepository::class);

        $router = $this->app['router'];
         $router->group(['middleware' => ['web']], function() use ($router){
            $router->get('download-client', [
                'uses' => ClientController::class.'@downloadPage',
                'as' => 'client.download'
            ]);
        });

        $router->get('update.json', ['uses' => ClientController::class.'@updateWin']);
        $router->get('update-osx.json', ['uses' => ClientController::class.'@updateOsx']);
        $router->get('download', ['as' => 'client.downloadwin', 'uses' => ClientController::class.'@downloadWin']);
        $router->get('download-osx', ['as' => 'client.downloadosx', 'uses' => ClientController::class.'@downloadOsx']);
        $router->get('download-linux-tar', ['as' => 'client.downloadlinuxtar', 'uses' => ClientController::class.'@downloadLinuxTar']);
        
        $router->get('redirect/{username}/{repo}', ['uses' => ClientController::class.'@redirect']);
//            $router->post('report/crash', ['uses' => 'Client\ReportController@crash']);
    }
}