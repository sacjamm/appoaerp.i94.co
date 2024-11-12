<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Motivocancelamentos extends BaseController
{
    protected $userPermissions;
    protected $userLogadoId;
    protected $userModel;
    protected $motivocancelamentoModel;
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
        $this->motivocancelamentoModel = new \App\Models\Motivocancelamento();
    }

    public function index() {
        if (!hasPermission($this->userPermissions, 'lCancelamento')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar motivos de cancelamento.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        $data['cancelamentos'] = $this->motivocancelamentoModel->findAll();
        return view(TEMPLATE . '/cancelamentos/index', $data);
    }

    public function getTableData() {
        // Permissões do usuário logado        
        if (!hasPermission($this->userPermissions, 'lCancelamento')) {
            //session()->setFlashdata('error', 'Você não tem permissão para listar usuários.');
           //return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        // Busque os dados atualizados do banco de dados
        $data['cancelamentos'] = $this->motivocancelamentoModel->findAll();
        return view(TEMPLATE . '/cancelamentos/table', $data);
    }

    public function create() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'aCancelamento')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar motivos de cancelamento.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeMotivoCancel' => 'trim',
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
                if ($this->motivocancelamentoModel->insert($array)) {
                    session()->setFlashdata('success', 'Motivo de cancelamento adicionado com sucesso!');
                    log_message('info', 'Adicionou um motivo de cancelamento');
                    return redirect()->to(site_url('cancelamentos/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/cancelamentos/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eCancelamento')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar motivos de cancelamento.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        $data['cancelamento'] = $this->motivocancelamentoModel->find($id);

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeMotivoCancel' => 'trim',
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                $array = $this->request->getPost();
                // Adicionando permissão ao banco de dados
               
                if ($this->motivocancelamentoModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Motivo de cancelamento alterado com sucesso!');
                    log_message('info', 'Alterou um motivo de cancelamento');
                    return redirect()->to(site_url('cancelamentos/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/cancelamentos/edit', $data);
    }

    public function delete() {
        if (!hasPermission($this->userPermissions, 'dCancelamento')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar motivos de cancelamento.');
            return redirect()->to(site_url('dashboard'));
        }

        $id = $this->request->getPost('id');
        $centro = $this->motivocancelamentoModel->find($id);

        if ($centro && $this->motivocancelamentoModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Motivo de cancelamento deletado com sucesso.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar motivo de cancelamento.'], 400);
        }
    }
}
