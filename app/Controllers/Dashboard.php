<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController {
    
    protected $userPermissions;
    protected $userLogadoId;
    protected $userModel;
    protected $session; 
    
    public function __construct() {
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();

        $this->userLogadoId = session()->get('userId');
        if(!$this->userLogadoId){ 
            session()->setFlashdata('error', 'Você foi deslogado por inatividade');
            return redirect()->to(site_url('auth/login'));
        }
        $this->userModel = new \App\Models\User();
        $userLogado = $this->userModel->find($this->userLogadoId);

        // Verifique se $userLogado é um array ou objeto e acesse o valor de forma adequada
        if (is_array($userLogado)) {
            $this->userPermissions = isset($userLogado['permissoes']) ? $userLogado['permissoes'] : [];
        } elseif (is_object($userLogado)) {
            //$this->userPermissions = $userLogado->permissoes ?? [];
            $this->userPermissions = is_string($userLogado->permissoes) ? unserialize($userLogado->permissoes) : $userLogado->permissoes;
        } else {
            $this->userPermissions = [];
        }
    }
    public function index() {
        // Obter a URL atual
        $currentUrl = current_url();
        $params = separate_url_params($currentUrl);
        $data['segments'] = $params;
        return view(TEMPLATE . '/dashboard/dashboard',$data);
    }
}
