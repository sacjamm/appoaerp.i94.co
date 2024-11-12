<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Empresas extends BaseController {

    protected $userPermissions;
    protected $associadoModel;
    protected $userLogadoId;
    protected $userModel;
    protected $empresaModel;
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
            $this->userPermissions = is_string($userLogado->permissoes) ? unserialize($userLogado->permissoes) : $userLogado->permissoes;
        } else {
            $this->userPermissions = [];
        }
        $this->empresaModel = new \App\Models\Empresa();
    }

    public function index() {
        if (!hasPermission($this->userPermissions, 'lEmpresa')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar Empresas.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        $data['empresas'] = $this->empresaModel->findAll();
        return view(TEMPLATE . '/empresas/index', $data);
    } 

    private function fetchTableData($length, $start, $orderColumnName, $orderDirection,$search=null) {
        $data = $this->empresaModel->getData($length, $start, $orderColumnName, $orderDirection,$search);
        $totalRecords = $this->empresaModel->getTotalRecords();
        $filteredRecords = $this->empresaModel->getFilteredRecords($search);

        return [
            'data' => array_map(function ($row) {
                $button_edit = hasPermission($this->userPermissions, 'eEmpresa') ? '<a href="' . base_url('empresas/edit/' . $row['CodigoEmpresa']) . '" class="btn btn-link text-primary"><i class="fas fa-edit"></i></a>' : '';
                $button_delete = hasPermission($this->userPermissions, 'dEmpresa') ? '<a href="#" class="btn btn-link text-danger delete-btn" data-id="' . $row['CodigoEmpresa'] . '"><i class="fas fa-trash"></i></a>' : '';

                return [
            $row['CodigoEmpresa'],
            $row['NomeEmpresa'],
            $row['EMailEmpresa'],
            $row['FoneEmpresa'],
            $button_edit . $button_delete
                ];
            }, $data),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
        ];
    }

    public function getData() {
        $length = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $draw = $this->request->getPost('draw');
        $orderColumnIndex = $this->request->getPost('order')[0]['column'];
        $orderDirection = $this->request->getPost('order')[0]['dir'];
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'];
        $search = $this->request->getPost('search')['value'];

        $tableData = $this->fetchTableData($length, $start, $orderColumnName, $orderDirection,$search);
        $output = [
            'draw' => intval($draw),
            'data' => $tableData['data'],
            'recordsTotal' => $tableData['recordsTotal'],
            'recordsFiltered' => $tableData['recordsFiltered'],
        ];

        return $this->response->setJSON($output);
    }
    
    public function create() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'aEmpresa')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar empresa.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeEmpresa' => 'trim|required'
            ]);

            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                // Coletando os dados do formulário
                // Preparando dados para inserção
                $_POST['CNPJEmpresa'] = PT_limpaCPF_CNPJ($_POST['CNPJEmpresa']);
                $_POST['CEPEmpresa'] = PT_limpaCPF_CNPJ($_POST['CEPEmpresa']);
                $_POST['DataCadastro'] = date('Y-m-d');
                $array = $_POST;
                // Adicionando permissão ao banco de dados
                if ($this->empresaModel->insert($array)) {
                    session()->setFlashdata('success', 'Empresa adicionada com sucesso!');
                    log_message('info', 'Adicionou uma empresa');
                    return redirect()->to(site_url('empresas/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        } 
         
        // Carregando view
        return view(TEMPLATE . '/empresas/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eEmpresa')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar empresa.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';
        $data['empresa'] = $this->empresaModel->find($id);

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeEmpresa' => 'trim|required'
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                $_POST['CNPJEmpresa'] = PT_limpaCPF_CNPJ($_POST['CNPJEmpresa']);
                $_POST['CEPEmpresa'] = PT_limpaCPF_CNPJ($_POST['CEPEmpresa']);
                $array = $_POST;

                // Adicionando permissão ao banco de dados
                if ($this->empresaModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Empresa alterada com sucesso!');
                    log_message('info', 'Alterou uma empresa');
                    return redirect()->to(site_url('empresas/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/empresas/edit', $data);
    }
    
    public function delete() {
        if (!hasPermission($this->userPermissions, 'dEmpresa')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar empresa.');
            return redirect()->to(site_url('dashboard'));
        }

        $id = $this->request->getPost('id');
        $empresa = $this->empresaModel->find($id);

        if ($empresa && $this->empresaModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Empresa deletado com sucesso.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar o empresa.'], 400);
        }
    }
}
