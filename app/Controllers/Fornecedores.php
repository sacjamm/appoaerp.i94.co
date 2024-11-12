<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Fornecedores extends BaseController {

    protected $userPermissions;
    protected $associadoModel;
    protected $userLogadoId;
    protected $userModel;
    protected $fornecedorModel;
    protected $bancoModel;
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
            $this->userPermissions = is_string($userLogado->permissoes) ? unserialize($userLogado->permissoes) : $userLogado->permissoes;
        } else {
            $this->userPermissions = [];
        }
        $this->fornecedorModel = new \App\Models\Fornecedor();
        $this->bancoModel = new \App\Models\Banco();
    }

    public function index() {
        if (!hasPermission($this->userPermissions, 'lFornecedor')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar Fornecedores.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        $data['fornecedores'] = $this->fornecedorModel->findAll();
        return view(TEMPLATE . '/fornecedores/index', $data);
    }

    private function fetchTableData($length, $start, $orderColumnName, $orderDirection,$search=null) {
        $data = $this->fornecedorModel->getData($length, $start, $orderColumnName, $orderDirection,$search);
        $totalRecords = $this->fornecedorModel->getTotalRecords();
        $filteredRecords = $this->fornecedorModel->getFilteredRecords($search);

        return [
            'data' => array_map(function ($row) {
                $button_edit = hasPermission($this->userPermissions, 'eFornecedor') ? '<a href="' . base_url('fornecedores/edit/' . $row['CodigoForn']) . '" class="btn btn-link text-primary"><i class="fas fa-edit"></i></a>' : '';
                $button_delete = hasPermission($this->userPermissions, 'dFornecedor') ? '<a href="#" class="btn btn-link text-danger delete-btn" data-id="' . $row['CodigoForn'] . '"><i class="fas fa-trash"></i></a>' : '';

                return [
            $row['CodigoForn'],
            $row['NomeForn'],
            $row['EMailForn'],
            $row['FoneForn'],
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
        if (!hasPermission($this->userPermissions, 'aFornecedor')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar Fornecedor.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeForn' => 'trim|required'
            ]);

            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                // Coletando os dados do formulário
                // Preparando dados para inserção
                $_POST['CNPJForn'] = PT_limpaCPF_CNPJ($_POST['CNPJForn']);
                $_POST['CICForn'] = PT_limpaCPF_CNPJ($_POST['CICForn']);
                $_POST['CEPForn'] = PT_limpaCPF_CNPJ($_POST['CEPForn']);
                $_POST['DataCadastro'] = date('Y-m-d');
                $array = $_POST;
                // Adicionando permissão ao banco de dados
                if ($this->fornecedorModel->insert($array)) {
                    session()->setFlashdata('success', 'Empresa adicionado com sucesso!');
                    log_message('info', 'Adicionou um Fornecedor');
                    return redirect()->to(site_url('fornecedores/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        $data['bancos'] = $this->bancoModel->findAll();
        // Carregando view
        return view(TEMPLATE . '/fornecedores/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eFornecedor')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar Fornecedor.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';
        $data['fornecedor'] = $this->fornecedorModel->find($id);

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeForn' => 'trim|required'
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                $_POST['CNPJForn'] = PT_limpaCPF_CNPJ($_POST['CNPJForn']);
                $_POST['CICForn'] = PT_limpaCPF_CNPJ($_POST['CICForn']);
                $_POST['CEPForn'] = PT_limpaCPF_CNPJ($_POST['CEPForn']);
                $array = $_POST;

                // Adicionando permissão ao banco de dados
                if ($this->fornecedorModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Fornecedor alterado com sucesso!');
                    log_message('info', 'Alterou um Fornecedor');
                    return redirect()->to(site_url('fornecedores/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        $data['bancos'] = $this->bancoModel->findAll();
        // Carregando view
        return view(TEMPLATE . '/fornecedores/edit', $data);
    }

    public function delete() {
        if (!hasPermission($this->userPermissions, 'dFornecedor')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar Fornecedor.');
            return redirect()->to(site_url('dashboard'));
        }

        $id = $this->request->getPost('id');
        $empresa = $this->fornecedorModel->find($id);

        if ($empresa && $this->fornecedorModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Fornecedor deletado com sucesso.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar o Fornecedor.'], 400);
        }
    }
}
