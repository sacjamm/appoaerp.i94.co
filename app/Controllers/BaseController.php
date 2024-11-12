<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller {

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['form'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        // Do Not Edit This Line
        helper('permission');
        $currentUrl = current_url();
        $params = separate_url_params($currentUrl);

        if (!session()->get('loggedIn')) {
            if (isset($params[1]) && $params[1] === 'auth') {
                
            } else {
                return redirect()->to('/dashboard');
            }
        }
        parent::initController($request, $response, $logger);
        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = \Config\Services::session();
    }

    // Função para verificar se o usuário logado é admin
    protected function is_admin() {
        $tipoUsuario = session()->get('nivel');
        return ($tipoUsuario === 'A');
    }

    // Função para verificar se o usuário logado é usuário comum
    protected function is_user() {
        $tipoUsuario = session()->get('nivel');
        return ($tipoUsuario === 'U');
    }
}
