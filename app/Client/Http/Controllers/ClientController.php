<?php


namespace PN\Client\Http\Controllers;


use PN\Client\Jobs\RegisterLog;
use PN\Foundation\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateWin()
    {
        $this->dispatch(new RegisterLog(\Request::getClientIp(), 'check', \Request::header('X-ParkitectNexusInstaller-Version', '0')));

        return \Response::json([
            'version' => getenv('WIN_CLIENT_VERSION'),
            'download_url' => route('client.downloadwin')
        ]);
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOsx()
    {
        $this->dispatch(new RegisterLog(\Request::getClientIp(), 'check', \Request::header('X-ParkitectNexusInstaller-Version', '0')));

        return \Response::json([
            'version' => getenv('OSX_CLIENT_VERSION'),
            'download_url' => route('client.downloadosx')
        ]);
    }
    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadWin()
    {
        // check if the request is coming from the client with this header
        if (\Request::header('X-ParkitectNexusInstaller-Version', false) != false || !isset($_SERVER['HTTP_USER_AGENT'])) {
            $this->dispatch(new RegisterLog(\Request::getClientIp(), 'update', \Request::header('X-ParkitectNexusInstaller-Version', '1.0.0.0')));

            // client wants an uncompressed installer
            return \Response::download(storage_path('client/parkitectnexus-client-' . getenv('WIN_CLIENT_VERSION') . '.msi'));
        } else {
            $this->dispatch(new RegisterLog(\Request::getClientIp(), 'download', ''));

            return \Response::download(storage_path('client/zips/parkitectnexus-client-' . getenv('WIN_CLIENT_VERSION') . '.rar'),
                'parkitectnexus-client.rar');
        }
    }


    public function downloadLinuxTar()
    {
                // check if the request is coming from the client with this header
        if (\Request::header('X-ParkitectNexusInstaller-Version', false) != false || !isset($_SERVER['HTTP_USER_AGENT'])) {
            $this->dispatch(new RegisterLog(\Request::getClientIp(), 'update', \Request::header('X-ParkitectNexusInstaller-Version', '1.0.0.0')));

            // client wants an uncompressed installer
            return \Response::download(storage_path('client/parkitectnexus-client-' . getenv('LINUX_CLIENT_VERSION') . '.tar.gz'));
        } else {
            $this->dispatch(new RegisterLog(\Request::getClientIp(), 'download', ''));

            return \Response::download(storage_path('client/zips/parkitectnexus-client-' . getenv('LINUX_CLIENT_VERSION') . '.tar.gz'),
                'parkitectnexus-client.tar.gz');
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadOsx()
    {
        // check if the request is coming from the client with this header
        if (\Request::header('X-ParkitectNexusInstaller-Version', false) != false || !isset($_SERVER['HTTP_USER_AGENT'])) {
            $this->dispatch(new RegisterLog(\Request::getClientIp(), 'update', \Request::header('X-ParkitectNexusInstaller-Version', '1.0.0.0')));
        } else {
            $this->dispatch(new RegisterLog(\Request::getClientIp(), 'download', ''));
        }

        return \Response::download(storage_path('client/parkitectnexus-client-' . getenv('OSX_CLIENT_VERSION') . '.dmg'));
    }
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function downloadPage()
    {
        $page = \PageRepo::find('client');
        $change_log_repo = getenv('CHANGE_LOG_REPO');
        $change_log_user = getenv('CHANGE_LOG_USER');

        return view('client.index', compact('page','change_log_user','change_log_repo'));
    }
    /**
     * @param $username
     * @param $repo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect($username, $repo)
    {
        $mod = \ResourceRepo::findMod($username, $repo);

        if ($mod != null) {
            return redirect($mod->getAsset()->getPresenter()->url());
        }

        abort(404);
    }
}
