<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Produtos extends BaseController
{
    protected $userPermissions;
    protected $userLogadoId;
    protected $userModel;
    protected $produtoModel;
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
        $this->produtoModel = new \App\Models\Produto();
        $this->grupoprodutoModel = new \App\Models\Grupoproduto();
    }
    
    public function index() {
        if (!hasPermission($this->userPermissions, 'lProduto')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar produtos.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        $data['produtos'] = $this->produtoModel->getProdutosWithGrupo();
        
        return view(TEMPLATE . '/produtos/index', $data);
    }
    
    public function getTableData() {
        // Permissões do usuário logado        
        if (!hasPermission($this->userPermissions, 'lProduto')) {
            //session()->setFlashdata('error', 'Você não tem permissão para listar usuários.');
           //return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        // Busque os dados atualizados do banco de dados
        $data['produtos'] = $this->produtoModel->getProdutosWithGrupo();
        return view(TEMPLATE . '/produtos/index', $data); 
    }
    
    public function create() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'aProduto')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar produto.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'DescricaoProduto' => 'trim',
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
                if ($this->produtoModel->insert($array)) {
                    session()->setFlashdata('success', 'Produto adicionado com sucesso!');
                    log_message('info', 'Adicionou um produto');
                    return redirect()->to(site_url('produtos/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        $data['grupos']=$this->grupoprodutoModel->orderBy('NomeProdutoGrupo', 'asc')->findAll();
        // Carregando view
        return view(TEMPLATE . '/produtos/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eProduto')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar produto.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        $data['produto'] = $this->produtoModel->find($id);

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'DescricaoProduto' => 'trim',
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                $array = $this->request->getPost();
                // Adicionando permissão ao banco de dados
               
                if ($this->produtoModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Produto alterado com sucesso!');
                    log_message('info', 'Alterou um produto');
                    return redirect()->to(site_url('produtos/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        $data['grupos']=$this->grupoprodutoModel->orderBy('NomeProdutoGrupo', 'asc')->findAll();
        // Carregando view
        return view(TEMPLATE . '/produtos/edit', $data);
    }

    public function delete() {
        if (!hasPermission($this->userPermissions, 'dProduto')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar produto.');
            return redirect()->to(site_url('dashboard'));
        }

        $id = $this->request->getPost('id');
        $centro = $this->produtoModel->find($id);

        if ($centro && $this->produtoModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Produto deletado com sucesso.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar produto.'], 400);
        }
    }
}
