<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Centrodecustos extends BaseController
{
    protected $userPermissions;
    protected $userLogadoId;
    protected $userModel;
    protected $centrodecustoModel;
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
        $this->centrodecustoModel = new \App\Models\Centrodecusto();
    }

    public function index() {
        if (!hasPermission($this->userPermissions, 'lCentrodecusto')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar centro de custos.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        $data['centros'] = $this->centrodecustoModel->findAll();
        return view(TEMPLATE . '/centrodecustos/index', $data);
    }

    public function getTableData() {
        // Permissões do usuário logado        
        if (!hasPermission($this->userPermissions, 'lCentrodecusto')) {
            //session()->setFlashdata('error', 'Você não tem permissão para listar usuários.');
           //return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        // Busque os dados atualizados do banco de dados
        $data['centros'] = $this->centrodecustoModel->findAll();
        return view(TEMPLATE . '/centrodecustos/table', $data);
    }

    public function create() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'aCentrodecusto')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar centro de custos.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeCentroCusto' => 'trim',
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                // Coletando os dados do formulário

                $array = $this->request->getPost();
                // Preparando dados para inserção
                // Adicionando permissão ao banco de dados
                if ($this->centrodecustoModel->insert($array)) {
                    session()->setFlashdata('success', 'Centro de custo adicionado com sucesso!');
                    log_message('info', 'Adicionou um centro de custo');
                    return redirect()->to(site_url('centrodecustos/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/centrodecustos/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eCentrodecusto')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar centro de custos.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        $data['centro'] = $this->centrodecustoModel->find($id);

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeCentroCusto' => 'trim',
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                $array = $this->request->getPost();
                // Adicionando permissão ao banco de dados
               
                if ($this->centrodecustoModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Centro de custo alterado com sucesso!');
                    log_message('info', 'Alterou um centro de custo');
                    return redirect()->to(site_url('centrodecustos/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/centrodecustos/edit', $data);
    }

    public function delete() {
        if (!hasPermission($this->userPermissions, 'dCentrodecusto')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar centro de custo.');
            return redirect()->to(site_url('dashboard'));
        }

        $id = $this->request->getPost('id');
        $centro = $this->centrodecustoModel->find($id);

        if ($centro && $this->centrodecustoModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Centro de custo deletado com sucesso.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar centro de custo.'], 400);
        }
    }
}
