<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Bancos extends BaseController {

    protected $userPermissions;
    protected $associadoModel;
    protected $userLogadoId;
    protected $userModel;
    protected $bancoModel;
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
        $this->bancoModel = new \App\Models\Banco();
    }

    public function index() {
        if (!hasPermission($this->userPermissions, 'lBanco')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar bancos.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        $data['bancos'] = $this->bancoModel->findAll();
        return view(TEMPLATE . '/bancos/index', $data);
    }

    public function getTableData() {
        // Permissões do usuário logado        
        if (!hasPermission($this->userPermissions, 'lBanco')) {
            //session()->setFlashdata('error', 'Você não tem permissão para listar usuários.');
           //return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        // Busque os dados atualizados do banco de dados
        $data['bancos'] = $this->bancoModel->findAll();
        return view(TEMPLATE . '/bancos/table', $data);
    }

    public function create() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'aBanco')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar banco.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'CodigoBanco' => 'trim',
                'NomeBanco' => 'trim',
                'ConvenioBanco' => 'trim',
                'ConvenioBancoInstituto' => 'trim',
            ]);

            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                // Coletando os dados do formulário
                $nomePermissao = $this->request->getPost('Nome');
                $cadastro = date('Y-m-d');
                $situacao = $this->request->getPost('Status');

                $array = $this->request->getPost();
                // Preparando dados para inserção
                // Adicionando permissão ao banco de dados
                if ($this->bancoModel->insert($array)) {
                    session()->setFlashdata('success', 'Banco adicionado com sucesso!');
                    log_message('info', 'Adicionou um banco');
                    return redirect()->to(site_url('bancos/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/bancos/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eBanco')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar banco.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        $data['banco'] = $this->bancoModel->find($id);

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'CodigoBanco' => 'trim',
                'NomeBanco' => 'trim',
                'ConvenioBanco' => 'trim',
                'ConvenioBancoInstituto' => 'trim',
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                $array = $this->request->getPost();
                // Adicionando permissão ao banco de dados
                if ($this->bancoModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Banco alterado com sucesso!');
                    log_message('info', 'Alterou um banco');
                    return redirect()->to(site_url('bancos/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/bancos/edit', $data);
    }

    public function delete() {
        if (!hasPermission($this->userPermissions, 'dBanco')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar banco.');
            return redirect()->to(site_url('dashboard'));
        }

        $id = $this->request->getPost('id');
        $associado = $this->bancoModel->find($id);

        if ($associado && $this->bancoModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Banco deletado com sucesso.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar banco.'], 400);
        }
    }
}
