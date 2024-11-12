<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Tipopublicacoes extends BaseController {

    protected $userPermissions;
    protected $userLogadoId;
    protected $userModel;
    protected $tipopublicacaoModel;
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
        $this->tipopublicacaoModel = new \App\Models\Tipopublicacao();
    }

    public function index() {
        if (!hasPermission($this->userPermissions, 'lTipopublicacao')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar tipo publicação.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        $data['tipos'] = $this->tipopublicacaoModel->findAll();
        return view(TEMPLATE . '/tipopublicacao/index', $data);
    }

    public function getTableData() {
        // Permissões do usuário logado        
        if (!hasPermission($this->userPermissions, 'lTipopublicacao')) {
            //session()->setFlashdata('error', 'Você não tem permissão para listar usuários.');
            //return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        // Busque os dados atualizados do banco de dados
        $data['tipos'] = $this->tipopublicacaoModel->findAll();
        return view(TEMPLATE . '/tipopublicacao/table', $data);
    }

    public function create() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'aTipopublicacao')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar tipo publicação.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        if (!empty($_POST)) {

            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomePublicacaoTipo' => 'trim',
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                // Coletando os dados do formulário
               $array = $this->request->getPost();
               if(isset($array['AssinaturaTipo'])){
                   $array['AssinaturaTipo']=1;
               }else{
                   $array['AssinaturaTipo']=0;
               }
                // Preparando dados para inserção
                // Adicionando permissão ao banco de dados
                if ($this->tipopublicacaoModel->insert($array)) {
                    session()->setFlashdata('success', 'Tipo publicação adicionado com sucesso!');
                    log_message('info', 'Adicionou um tipo publicação');
                    return redirect()->to(site_url('tipopublicacao/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/tipopublicacao/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eTipopublicacao')) {
            session()->setFlashdata('error', 'Você não tem permissão para tipo publicação.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        $data['tipo'] = $this->tipopublicacaoModel->find($id);

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomePublicacaoTipo' => 'trim',
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
               $array = $this->request->getPost();
                
               if(isset($array['AssinaturaTipo'])){
                   $array['AssinaturaTipo']=1;
               }else{
                   $array['AssinaturaTipo']=0;
               }
            
                if ($this->tipopublicacaoModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Tipo publicação alterada com sucesso!');
                    log_message('info', 'Alterou uma editora');
                    return redirect()->to(site_url('tipopublicacao/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/tipopublicacao/edit', $data);
    }

    public function delete() {
        if (!hasPermission($this->userPermissions, 'dTipopublicacao')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar tipo publicação.');
            return redirect()->to(site_url('dashboard'));
        }

        $id = $this->request->getPost('id');
        $centro = $this->tipopublicacaoModel->find($id);

        if ($centro && $this->tipopublicacaoModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Tipo publicação deletada com sucesso.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar tipo publicação.'], 400);
        }
    }
}
