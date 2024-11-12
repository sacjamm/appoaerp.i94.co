<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Editoras extends BaseController
{
    protected $userPermissions;
    protected $userLogadoId;
    protected $userModel;
    protected $editoraModel;
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
        $this->editoraModel = new \App\Models\Editora();
    }

    public function index() {
        if (!hasPermission($this->userPermissions, 'lEditora')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar editoras.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        $data['editoras'] = $this->editoraModel->findAll();
        return view(TEMPLATE . '/editoras/index', $data);
    }

    public function getTableData() {
        // Permissões do usuário logado        
        if (!hasPermission($this->userPermissions, 'lEditora')) {
            //session()->setFlashdata('error', 'Você não tem permissão para listar usuários.');
           //return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        // Busque os dados atualizados do banco de dados
        $data['editoras'] = $this->editoraModel->findAll();
        return view(TEMPLATE . '/editoras/table', $data);
    }

    public function create() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'aEditora')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar editora.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeEditora' => 'trim',
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
                if ($this->editoraModel->insert($array)) {
                    session()->setFlashdata('success', 'Editora adicionada com sucesso!');
                    log_message('info', 'Adicionou uma editora');
                    return redirect()->to(site_url('editoras/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/editoras/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eEditora')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar editora.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        $data['editora'] = $this->editoraModel->find($id);

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeEditora' => 'trim',
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                $array = $this->request->getPost();
                // Adicionando permissão ao banco de dados
               
                if ($this->editoraModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Editora alterada com sucesso!');
                    log_message('info', 'Alterou uma editora');
                    return redirect()->to(site_url('editoras/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/editoras/edit', $data);
    }

    public function delete() {
        if (!hasPermission($this->userPermissions, 'dEditora')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar editoras.');
            return redirect()->to(site_url('dashboard'));
        }

        $id = $this->request->getPost('id');
        $centro = $this->editoraModel->find($id);

        if ($centro && $this->editoraModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Editora deletada com sucesso.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar editora.'], 400);
        }
    }
}
