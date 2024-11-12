<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Associados extends BaseController {

    protected $session;
    protected $userPermissions;
    protected $associadoModel;
    protected $acompanhamentoModel;
    protected $tipoassociadoModel;
    protected $userLogadoId;
    protected $userModel;
    protected $bancoModel;

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

        $this->associadoModel = new \App\Models\Associado();
        $this->acompanhamentoModel = new \App\Models\Acompanhamento();
        $this->tipoassociadoModel = new \App\Models\TipoAssociado();
        $this->bancoModel = new \App\Models\Banco();
    }

    public function index() {
        if (!hasPermission($this->userPermissions, 'lAssociado')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar associados.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        return view(TEMPLATE . '/associados/index', $data);
    }

    private function fetchTableData($length, $start, $orderColumnName, $orderDirection, $search = null) {
        $data = $this->associadoModel->getData($length, $start, $orderColumnName, $orderDirection, $search);
        $totalRecords = $this->associadoModel->getTotalRecords();
        $filteredRecords = $this->associadoModel->getFilteredRecords($search);

        return [
            'data' => array_map(function ($row) {
                $button_acompanhamento = hasPermission($this->userPermissions, 'eAssociado') ? '<a href="' . base_url('associados/acompanhamentos/' . $row['CodigoAssoc']) . '" class="dropdown-item text-success"><i class="fas fa-th"></i> Acompanhamentos</a>' : '';
                $button_mensalidades = hasPermission($this->userPermissions, 'eAssociado') ? '<a href="' . base_url('associados/mensalidades/' . $row['CodigoAssoc']) . '" class="dropdown-item text-purple"><i class="fas fa-dollar-sign"></i> Mensalidades</a>' : '';
                $button_valores = hasPermission($this->userPermissions, 'eAssociado') ? '<a href="' . base_url('associados/valores/' . $row['CodigoAssoc']) . '" class="dropdown-item text-warning"><i class="fas fa-dollar-sign"></i> Valores</a>' : '';
                $button_pendencias = hasPermission($this->userPermissions, 'eAssociado') ? '<a href="' . base_url('associados/pendencias/' . $row['CodigoAssoc']) . '" class="dropdown-item text-info"><i class="fas fa-th-large"></i> Pendências</a>' : '';
                $button_grupos_estudos = hasPermission($this->userPermissions, 'eAssociado') ? '<a href="' . base_url('associados/grupos-estudo/' . $row['CodigoAssoc']) . '" class="dropdown-item text-danger"><i class="fas fa-th-large"></i> Grupos de Estudo</a>' : '';
                $button_eventos = hasPermission($this->userPermissions, 'eAssociado') ? '<a href="' . base_url('associados/eventos/' . $row['CodigoAssoc']) . '" class="dropdown-item text-primary"><i class="fas fa-calendar"></i> Eventos</a>' : '';
                $button_consignacoes = hasPermission($this->userPermissions, 'eAssociado') ? '<a href="' . base_url('associados/consignacoes/' . $row['CodigoAssoc']) . '" class="dropdown-item text-success"><i class="fas fa-th-large"></i> Consignações</a>' : '';
                $button_itens = hasPermission($this->userPermissions, 'eAssociado') ? '<a href="' . base_url('associados/itens/' . $row['CodigoAssoc']) . '" class="dropdown-item text-warning"><i class="fas fa-th-large"></i> Itens comprados</a>' : '';
                $button_atendimentos = hasPermission($this->userPermissions, 'eAssociado') ? '<a href="' . base_url('associados/atendimentos/' . $row['CodigoAssoc']) . '" class="dropdown-item text-dark"><i class="fas fa-phone-volume"></i> Atendimentos</a>' : '';
                $button_assinaturas = hasPermission($this->userPermissions, 'eAssociado') ? '<a href="' . base_url('associados/assinaturas/' . $row['CodigoAssoc']) . '" class="dropdown-item text-info"><i class="fas fa-align-left"></i> Assinaturas</a>' : '';
                $button_edit = hasPermission($this->userPermissions, 'eAssociado') ? '<a href="' . base_url('associados/edit/' . $row['CodigoAssoc']) . '" class="dropdown-item text-primary"><i class="fas fa-edit"></i> Editar</a>' : '';
                $button_delete = hasPermission($this->userPermissions, 'dAssociado') ? '<a href="#" class="dropdown-item text-danger delete-btn" data-id="' . $row['CodigoAssoc'] . '"><i class="fas fa-trash"></i> Excluir</a>' : '';

                $button_actions = '<div class="btn-group">
                    <button type="button" class="btn btn-info">Ações</button>
                    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu" style="">
                      ' . $button_acompanhamento . $button_mensalidades . $button_valores . $button_pendencias . $button_grupos_estudos . $button_eventos . $button_consignacoes . $button_itens . $button_atendimentos . $button_assinaturas . $button_edit . $button_delete . '
                    </div>
                  </div>';

                return [
            $row['CodigoAssoc'],
            $row['NomeAssoc'],
            $row['FoneAssoc'],
            $button_actions
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

        $tableData = $this->fetchTableData($length, $start, $orderColumnName, $orderDirection, $search);
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
        if (!hasPermission($this->userPermissions, 'aAssociado')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar associado.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeAssoc' => 'trim|required'
            ]);

            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                // Coletando os dados do formulário
                // Preparando dados para inserção
                $_POST['CICAssoc'] = PT_limpaCPF_CNPJ($_POST['CICAssoc']);
                $_POST['CEPAssoc'] = PT_limpaCPF_CNPJ($_POST['CEPAssoc']);
                $_POST['DataNascAssoc'] = \DateTime::createFromFormat('d/m/Y', $_POST['DataNascAssoc'])->format('Y-m-d');
                $_POST['CEPRemaAssoc'] = PT_limpaCPF_CNPJ($_POST['CEPRemaAssoc']);
                $array = $_POST;
                // Adicionando permissão ao banco de dados
                if ($this->associadoModel->insert($array)) {
                    session()->setFlashdata('success', 'Associado adicionada com sucesso!');
                    log_message('info', 'Adicionou um associado');
                    return redirect()->to(site_url('associados/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        $data['bancos'] = $this->bancoModel->findAll();
        // Carregando view
        return view(TEMPLATE . '/associados/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eAssociado')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar associado.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';
        $data['associado'] = $this->associadoModel->find($id);

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeAssoc' => 'trim|required'
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                $_POST['CICAssoc'] = PT_limpaCPF_CNPJ($_POST['CICAssoc']);
                $_POST['CEPAssoc'] = PT_limpaCPF_CNPJ($_POST['CEPAssoc']);
                $_POST['DataNascAssoc'] = \DateTime::createFromFormat('d/m/Y', $_POST['DataNascAssoc'])->format('Y-m-d');
                $_POST['CEPRemaAssoc'] = PT_limpaCPF_CNPJ($_POST['CEPRemaAssoc']);
                $array = $_POST;

                // Adicionando permissão ao banco de dados
                if ($this->associadoModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Associado alterada com sucesso!');
                    log_message('info', 'Alterou um associado');
                    return redirect()->to(site_url('associados/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        $data['bancos'] = $this->bancoModel->findAll();
        // Carregando view
        return view(TEMPLATE . '/associados/edit', $data);
    }

    public function acompanhamentos($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eAssociado')) {
            session()->setFlashdata('error', 'Você não tem permissão para acompanhar associado.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';
        $data['acompanhamentos'] = $this->acompanhamentoModel->where('CodigoAssoc', $id)->findAll();

        $data['button_edit_acompanhamento'] = hasPermission($this->userPermissions, 'eAssociado');
        $data['button_delete_acompanhamento'] = hasPermission($this->userPermissions, 'dAssociado');
        // Carregando view
        return view(TEMPLATE . '/associados/acompanhamentos', $data);
    }

    public function create_acompanhamento($id = null) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'aAssociado')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar acompanhamento.');
            return redirect()->to(site_url('dashboard'));
        }


        $data['id'] = $id;

        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';
        $associado = $this->associadoModel->find($id);
        $data['NomeAssoc'] = $associado['NomeAssoc'];
        if (!empty($_POST)) {
            $array = $_POST;

            if (empty($_POST['DataAcompanhamento'])) {
                $array['DataAcompanhamento'] = date('Y-m-d H:i:s');
            }
            $id = $_POST['CodigoAssoc'];
            $array['DATAGERACAOSISTEMA'] = date('Y-m-d H:i:s');
            // Adicionando permissão ao banco de dados
            if ($this->acompanhamentoModel->insert($array)) {
                session()->setFlashdata('success', 'Acompanhamento adicionado com sucesso!');
                log_message('info', 'Adicionou um Acompanhamento');
                return redirect()->to(site_url('associados/acompanhamentos/' . $id));
            } else {
                $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                session()->setFlashdata('error', $data['custom_error']);
            }
        }
        // Carregando view
        return view(TEMPLATE . '/associados/create_acompanhamento', $data);
    }

    public function edit_acompanhamento($id = null, $assocId = null) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eAssociado')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar acompanhamento.');
            return redirect()->to(site_url('dashboard'));
        }

        $data['id'] = $id;
        $data['CodigoAssoc'] = $assocId;

        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';
        $associado = $this->associadoModel->where('CodigoAssoc', $assocId)->first();
        $acompanhamento = $this->acompanhamentoModel->where('CodigoAcompanhamento', $id)->first();
        $data['NomeAssoc'] = $associado['NomeAssoc'];
        $data['ObservacaoAcompanhamento'] = $acompanhamento['ObservacaoAcompanhamento'];
        $data['DataAcompanhamento'] = $acompanhamento['DataAcompanhamento'];
        if (!empty($_POST)) {
            $array = $_POST;
             
            $update = $this->acompanhamentoModel->update($id,$array);    
            
            if ($update) {
                session()->setFlashdata('success', 'Acompanhamento alterado com sucesso!');
                log_message('info', 'Alterou um Acompanhamento');
                return redirect()->to(site_url('associados/acompanhamentos/' . $assocId));
            } else {  
                echo "Erro ao atualizar o registro: " . $this->acompanhamentoModel->errors();
                $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                session()->setFlashdata('error', $data['custom_error']);
            }
        }
        // Carregando view
        return view(TEMPLATE . '/associados/edit_acompanhamento', $data);
    }

    public function delete() {
        if (!hasPermission($this->userPermissions, 'dAssociado')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar associado.');
            return redirect()->to(site_url('dashboard'));
        }

        $id = $this->request->getPost('id');
        $associado = $this->associadoModel->find($id);

        if ($associado && $this->associadoModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Associado deletado com sucesso.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar o associado.'], 400);
        }
    }

    public function delete_acompanhamento() {
        if (!hasPermission($this->userPermissions, 'dAssociado')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar acompanhamento.');
            return redirect()->to(site_url('dashboard'));
        }

        $id = $this->request->getPost('id');
        $assocId = $this->request->getPost('assocId');

        $acompanhamento = $this->acompanhamentoModel->where('CodigoAcompanhamento', $id)
                ->where('CodigoAssoc', $assocId)
                ->first();

        if ($acompanhamento) {
            // Se o registro for encontrado, faz a exclusão
            if ($this->acompanhamentoModel->where('CodigoAcompanhamento', $id)->delete()) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Registro deletado com sucesso.', 'id' => $id]);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar o registro.']);
            }
        } else {
            // Registro não encontrado ou não pertence ao assocId informado
            return $this->response->setJSON(['status' => 'error', 'message' => 'Registro não encontrado ou não pertence ao associado.', 400]);
        }
    }

    /* Tipos de associados */

    public function tiposAssociados($associado_id = false) {
        //if (!hasPermission($this->userPermissions, 'lTiposAssociado')) {
        if (!hasPermission($this->userPermissions, 'lAssociado')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar tipos de associados.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        $data['tipos'] = $this->tipoassociadoModel->findAll();
        return view(TEMPLATE . '/associados/tipos', $data);
    }

    public function getTableDataTiposAssociado() {
        // Permissões do usuário logado        
        if (!hasPermission($this->userPermissions, 'lGrupodeproduto')) {
            //session()->setFlashdata('error', 'Você não tem permissão para listar usuários.');
            //return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        // Busque os dados atualizados do banco de dados
        $data['tipos'] = $this->tipoassociadoModel->findAll();
        return view(TEMPLATE . '/associados/table_tipos', $data);
    }

    public function create_tipos() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'aAssociado')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar tipos de associados.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeAssocTipo' => 'trim'
            ]);

            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                // Coletando os dados do formulário
                // Preparando dados para inserção

                $NomeAssocTipo = $this->request->getPost('NomeAssocTipo');
                $AssociacaoTipo = $this->request->getPost('AssociacaoTipo');
                $array = array(
                    'NomeAssocTipo' => $NomeAssocTipo,
                    'AssociacaoTipo' => $AssociacaoTipo,
                );
                // Adicionando permissão ao banco de dados
                if ($this->tipoassociadoModel->insert($array)) {
                    session()->setFlashdata('success', 'Tipo de associado adicionada com sucesso!');
                    log_message('info', 'Adicionou um tipo de associado');
                    return redirect()->to(site_url('associados/tipos'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/associados/create_tipo', $data);
    }

    public function edit_tipos($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eAssociado')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar tipos de associado.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';
        $data['tipo'] = $this->tipoassociadoModel->find($id);

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'NomeAssocTipo' => 'trim'
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                $NomeAssocTipo = $this->request->getPost('NomeAssocTipo');
                $AssociacaoTipo = $this->request->getPost('AssociacaoTipo');
                $array = array(
                    'NomeAssocTipo' => $NomeAssocTipo,
                    'AssociacaoTipo' => $AssociacaoTipo,
                );

                // Adicionando permissão ao banco de dados
                if ($this->tipoassociadoModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Tipo de associado alterada com sucesso!');
                    log_message('info', 'Alterou um tipo de associado');
                    return redirect()->to(site_url('associados/tipos'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/associados/edit_tipo', $data);
    }

    public function delete_tipo() {
        if (!hasPermission($this->userPermissions, 'dAssociado')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar associado.');
            return redirect()->to(site_url('dashboard'));
        }

        $id = $this->request->getPost('id');
        $associado = $this->tipoassociadoModel->find($id);

        if ($associado && $this->tipoassociadoModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Tipo de associado deletado com sucesso.', 'id' => $id]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar o tipo de associado.'], 400);
        }
    }

    /* Tipos de associados */
}
