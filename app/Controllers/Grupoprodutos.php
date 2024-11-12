<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Grupoprodutos extends BaseController {

    protected $userPermissions;
    protected $userLogadoId;
    protected $userModel;
    protected $grupoprodutoModel;
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
        $this->grupoprodutoModel = new \App\Models\Grupoproduto();
    }
    
    public function index() {
        if (!hasPermission($this->userPermissions, 'lGrupodeproduto')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar grupo de produtos.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        $data['grupos'] = $this->grupoprodutoModel->findAll();
        return view(TEMPLATE . '/grupoprodutos/index', $data);
    }
    
    public function getTableData() {
        // Permissões do usuário logado        
        if (!hasPermission($this->userPermissions, 'lGrupodeproduto')) {
            //session()->setFlashdata('error', 'Você não tem permissão para listar usuários.');
           //return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        // Busque os dados atualizados do banco de dados
        $data['grupos'] = $this->grupoprodutoModel->findAll();
        return view(TEMPLATE . '/grupoprodutos/table', $data);
    }
    
    public function create() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'aGrupodeproduto')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar grupo de produtos.');
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
                if ($this->grupoprodutoModel->insert($array)) {
                    session()->setFlashdata('success', 'Grupo adicionado com sucesso!');
                    log_message('info', 'Adicionou um grupo de produto');
                    return redirect()->to(site_url('grupoprodutos/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/grupoprodutos/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eGrupodeproduto')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar grupo de produtos.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        $data['grupo'] = $this->grupoprodutoModel->find($id);

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
               
                if ($this->grupoprodutoModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Grupo alterado com sucesso!');
                    log_message('info', 'Alterou um grupo');
                    return redirect()->to(site_url('grupoprodutos/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/grupoprodutos/edit', $data);
    }

    public function delete() {
        if (!hasPermission($this->userPermissions, 'dGrupodeproduto')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar grupo de produtos.');
            return redirect()->to(site_url('dashboard'));
        }

        $id = $this->request->getPost('id');
        $centro = $this->grupoprodutoModel->find($id);

        if ($centro && $this->grupoprodutoModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Grupo deletado com sucesso.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar grupo de produto.'], 400);
        }
    }
}
