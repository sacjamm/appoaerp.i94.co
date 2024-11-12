<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Permissions extends BaseController {

    public $permissions = null;
    public $userPermissions = null;
    private $userModel = null;
    public $userLogadoId;

    public function __construct() {
        $this->userLogadoId = session()->get('userId');     
        if(!$this->userLogadoId){ 
            session()->setFlashdata('error', 'Você foi deslogado por inatividade');
            return redirect()->to(site_url('auth/login'));
        }
        $this->userModel = new \App\Models\User();
        $userLogado = $this->userModel->find($this->userLogadoId);        
        $this->userPermissions = $userLogado->permissoes;
                
        helper(['form', 'url', 'permission']);
        $this->permissions = new \App\Models\Permission();
    }

    public function index() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'lPermissao')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar níveis.');
            return redirect()->to(site_url('dashboard'));
            //return redirect()->back()->with('error', 'Você não tem permissão para visualizar associados.');
        }
        $data['userPermissions']=$this->userPermissions;
        $data['permissoes'] = $this->permissions->findAll();
        return view(TEMPLATE . '/permissions/index', $data);
    }
    
    public function getTableData() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'lPermissao')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar níveis.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions']=$this->userPermissions;
        // Busque os dados atualizados do banco de dados
        $data['permissoes'] = $this->permissions->findAll(); // Exemplo de uso de um modelo
        // Retorna a view com a tabela atualizada
        return view(TEMPLATE . '/permissions/table', $data);
        //return view('permissions/table', $data);
    }

    public function create() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'aPermissao')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar nível.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'Nome' => 'trim|required',
                'Status' => 'trim|required'
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

                // Preparando dados para inserção
                $array = [
                    'nome' => $nomePermissao,
                    'data' => $cadastro,
                    'situacao' => $situacao,
                ];
                // Adicionando permissão ao banco de dados
                if ($this->permissions->insert($array)) {
                    session()->setFlashdata('success', 'Permissão adicionada com sucesso!');
                    log_message('info', 'Adicionou uma permissão');
                    return redirect()->to(site_url('permissions/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/permissions/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'ePermissao')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar nível.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        $permission = $this->permissions->find($id);
        $permission['permissoes'] = unserialize($permission['permissoes']); // Desserializando permissões
        $data['permission'] = $permission;

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'Nome' => 'trim|required',
                'Status' => 'trim|required'
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                $nomePermissao = $this->request->getPost('Nome');
                $situacao = $this->request->getPost('Status');

                $array = [
                    'nome' => $nomePermissao,
                    'situacao' => $situacao,
                ];
                // Adicionando permissão ao banco de dados
                if ($this->permissions->update($id, $array)) {
                    session()->setFlashdata('success', 'Permissão alterada com sucesso!');
                    log_message('info', 'Alterou uma permissão');
                    return redirect()->to(site_url('permissions/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/permissions/edit', $data);
    }

    public function delete() {
        if (!hasPermission($this->userPermissions, 'dPermissao')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar nível.');
            return redirect()->to(site_url('dashboard'));
        }
        $request = service('request');
        $id = $this->request->getPost('id');
        
        $nivel = $this->permissions->find($id);

        if ($nivel) {
            if ($this->permissions->delete($id)) {
                return $this->response->setJSON(['status' => 'success','message'=> 'Nível deletado com sucesso.']);
            } else {
                return $this->response->setJSON(['status' => 'error','message'=> 'Erro ao deletar o nível.'], 400);
            }
        } else {
            return $this->response->setJSON(['status' => 'error','message'=> 'Nível não encontrado.'], 401);
        }
    }
}
