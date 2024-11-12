<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Formasassociacao extends BaseController {

    protected $userPermissions;
    protected $userLogadoId;
    protected $userModel;
    protected $produtoModel;
    protected $formassociacaoModel;
    protected $session;

    public function __construct() {
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();

        $this->userLogadoId = session()->get('userId');
        if (!$this->userLogadoId) {
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
        $this->produtoModel = new \App\Models\Produto();
        $this->formassociacaoModel = new \App\Models\Formaassociacao();
    }

    public function index() {
        if (!hasPermission($this->userPermissions, 'lFormaassociacao')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar formas de associação.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        //$data['produtos'] = $this->produtoModel->getProdutosWithGrupo();
        $data['formas'] = $this->formassociacaoModel->findAll();

        return view(TEMPLATE . '/formasassociacao/index', $data);
    }

    public function getTableData() {
        // Permissões do usuário logado        
        if (!hasPermission($this->userPermissions, 'lFormaassociacao')) {
            //session()->setFlashdata('error', 'Você não tem permissão para listar usuários.');
            //return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        // Busque os dados atualizados do banco de dados
        $data['formas'] = $this->formassociacaoModel->findAll();
        return view(TEMPLATE . '/formasassociacao/index', $data);
    }

    public function create() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'aFormaassociacao')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar formas de associação.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeAssocForma' => 'trim|required',
                'ValorPagamentoAssocForma' => 'trim|required',
                'TipoPagamentoAssocForma' => 'trim|required',
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
                if ($this->formassociacaoModel->insert($array)) {
                    session()->setFlashdata('success', 'Forma de associação adicionado com sucesso!');
                    log_message('info', 'Adicionou uma forma de associação');
                    return redirect()->to(site_url('formasassociacao/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/formasassociacao/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eFormaassociacao')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar formas de associação.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        $data['forma'] = $this->formassociacaoModel->find($id);

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeAssocForma' => 'trim|required',
                'ValorPagamentoAssocForma' => 'trim|required',
                'TipoPagamentoAssocForma' => 'trim|required',
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                $array = $this->request->getPost();
                // Adicionando permissão ao banco de dados

                if ($this->formassociacaoModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Forma de associação alterado com sucesso!');
                    log_message('info', 'Alterou um produto');
                    return redirect()->to(site_url('formasassociacao/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/formasassociacao/edit', $data);
    }

    public function delete() {
        if (!hasPermission($this->userPermissions, 'dFormaassociacao')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar formas de associação.');
            return redirect()->to(site_url('dashboard'));
        }
        $id = $this->request->getPost('id');
        $centro = $this->formassociacaoModel->find($id);

        if ($centro && $this->formassociacaoModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Forma de associação deletado com sucesso.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar forma de associação.'], 400);
        }
    }
}
