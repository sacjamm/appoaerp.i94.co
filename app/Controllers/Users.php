<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Users extends BaseController { 

    private $db = null;
    private $forge = null;
    private $userModel = null;
    private $permissaoModel = null;
    public $userPermissions = null;
    public $userLogadoId;

    public function __construct() {
        $this->db = \Config\Database::connect();
        $this->forge = \Config\Database::forge();

        $this->userLogadoId = session()->get('userId');
        if(!$this->userLogadoId){
            session()->setFlashdata('error', 'Você foi deslogado por inatividade');
            return redirect()->to(site_url('auth/login'));
        }
        $this->userModel = new \App\Models\User();
        $userLogado = $this->userModel->find($this->userLogadoId);
        $this->userPermissions = $userLogado->permissoes;
        
        
        helper(['form', 'url', 'permission']);
        $this->telas = [
            'Cliente' => [
                's' => 'Status Cliente',
                'l' => 'Listar Clientes',
                'v' => 'Visualizar Cliente',
                'a' => 'Adicionar Cliente',
                'e' => 'Editar Cliente',
                'd' => 'Excluir Cliente',
            ],
            'Usuario' => [
                's' => 'Status Usuário',
                'l' => 'Listar Usuários',
                'v' => 'Visualizar Usuário',
                'a' => 'Adicionar Usuário',
                'e' => 'Editar Usuário',
                'd' => 'Excluir Usuário',
            ],
            'Permissao' => [
                's' => 'Status Nível',
                'l' => 'Listar Níveis',
                'v' => 'Visualizar Nível',
                'a' => 'Adicionar Nível',
                'e' => 'Editar Nível',
                'd' => 'Excluir Nível',
            ],
            'Associado' => [
                's' => 'Status Associado',
                'l' => 'Listar Associados',
                'v' => 'Visualizar Associado',
                'a' => 'Adicionar Associado',
                'e' => 'Editar Associado',
                'd' => 'Excluir Associado',
            ],
            'Produto' => [
                's' => 'Status Produto',
                'l' => 'Listar Produtos',
                'v' => 'Visualizar Produto',
                'a' => 'Adicionar Produto',
                'e' => 'Editar Produto',
                'd' => 'Excluir Produto',
            ],
            'Banco' => [
                's' => 'Status Banco',
                'l' => 'Listar Bancos',
                'v' => 'Visualizar Banco',
                'a' => 'Adicionar Banco',
                'e' => 'Editar Banco',
                'd' => 'Excluir Banco',
            ],
            'Empresa' => [
                's' => 'Status Empresa',
                'l' => 'Listar Empresas',
                'v' => 'Visualizar Empresa',
                'a' => 'Adicionar Empresa',
                'e' => 'Editar Empresa',
                'd' => 'Excluir Empresa',
            ],
            'Centrodecusto' => [
                's' => 'Status Centro de custo',
                'l' => 'Listar Centro de custos',
                'v' => 'Visualizar Centro de custo',
                'a' => 'Adicionar Centro de custo',
                'e' => 'Editar Centro de custo',
                'd' => 'Excluir Centro de custo',
            ],
            'Grupodeproduto' => [
                's' => 'Status Grupo de produto',
                'l' => 'Listar Grupo de produtos',
                'v' => 'Visualizar Grupo de produto',
                'a' => 'Adicionar Grupo de produto',
                'e' => 'Editar Grupo de produto',
                'd' => 'Excluir Grupo de produto',
            ],
            'Fornecedor' => [
                's' => 'Status Fornecedor',
                'l' => 'Listar Fornecedores',
                'v' => 'Visualizar Fornecedor',
                'a' => 'Adicionar Fornecedor',
                'e' => 'Editar Fornecedor',
                'd' => 'Excluir Fornecedor',
            ],
            'Formaassociacao' => [
                's' => 'Status Forma de Associação',
                'l' => 'Listar Formas de Associação',
                'v' => 'Visualizar Forma de Associação',
                'a' => 'Adicionar Forma de Associação',
                'e' => 'Editar Forma de Associação',
                'd' => 'Excluir Forma de Associação',
            ],
            'Cancelamento' => [
                's' => 'Status Motivo Cancelamento',
                'l' => 'Listar Motivos Cancelamento',
                'v' => 'Visualizar Motivo Cancelamento',
                'a' => 'Adicionar Motivo Cancelamento',
                'e' => 'Editar Motivo Cancelamento',
                'd' => 'Excluir Motivo Cancelamento',
            ],
            'Editora' => [
                's' => 'Status Editora',
                'l' => 'Listar Editoras',
                'v' => 'Visualizar Editora',
                'a' => 'Adicionar Editora',
                'e' => 'Editar Editora',
                'd' => 'Excluir Editora',
            ],
            'Tipopublicacao' => [
                's' => 'Status Tipo Publicação',
                'l' => 'Listar Tipos Publicação',
                'v' => 'Visualizar Tipo Publicação',
                'a' => 'Adicionar Tipo Publicação',
                'e' => 'Editar Tipo Publicação',
                'd' => 'Excluir Tipo Publicação',
            ],
            'Compra' => [
                's' => 'Status Compras',
                'l' => 'Listar Compras',
                'v' => 'Visualizar Compra',
                'a' => 'Adicionar Compra',
                'e' => 'Editar Compra',
                'd' => 'Excluir Compra',
            ],
                // Adicione novas telas e permissões aqui conforme necessário
        ];
        $this->permissaoModel = new \App\Models\Permission();
    }

    public function index() {
        // Permissões do usuário logado      
        
        if (!hasPermission($this->userPermissions, 'lUsuario')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar usuários.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions']=$this->userPermissions;
        // Verifica se a coluna 'EmailUsuario' existe na tabela 'usuario'
        $query = $this->db->query("SHOW COLUMNS FROM `usuario` LIKE 'EmailUsuario'");
        $result = $query->getRowArray();
        // Se a coluna não existir, ela será criada
        if (!$result) {
            // Adiciona o campo dinamicamente
            $this->forge->addField([
                'EmailUsuario' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => true,
                    'default' => null,
                ]
            ]);
            // Aplica a alteração à tabela 'usuario'
            $this->forge->addColumn('usuario', [
                'EmailUsuario' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => true,
                    'default' => null,
                ]
            ]);
            // Adiciona o campo dinamicamente
            $this->forge->addField([
                'NivelUsuario' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => true,
                    'default' => null,
                ]
            ]);
            // Aplica a alteração à tabela 'usuario'
            $this->forge->addColumn('usuario', [
                'NivelUsuario' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => true,
                    'default' => null,
                ]
            ]);
            $this->forge->addColumn('usuario', [
                'SenhaUsuario' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'default' => null,
                ]
            ]);
            // Aplica a alteração à tabela 'usuario'
            $this->forge->modifyColumn('usuario', [
                'SenhaUsuario' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'default' => null,
                ],
            ]);
            log_message('info', 'Campo EmailUsuario adicionado à tabela usuario no banco de dados.');
        }
        $data['users'] = $this->userModel->findAll();
        return view(TEMPLATE . '/usuarios/index', $data);
    }

    public function getTableData() {
        // Permissões do usuário logado        
        if (!hasPermission($this->userPermissions, 'lUsuario')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar usuários.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions']=$this->userPermissions;
        // Busque os dados atualizados do banco de dados
        $data['users'] = $this->userModel->findAll();
        return view(TEMPLATE . '/usuarios/table', $data);
    }

    public function create() {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'aUsuario')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar usuario.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['telas'] = $this->telas;
        $data['custom_error'] = '';

        $data['permissoes'] = $this->permissaoModel->findAll();

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'Usuario' => 'trim|required', // Campo 'Usuario' obrigatório e sem espaços em branco no início e no final
                'SenhaUsuario' => 'trim|required|min_length[6]|max_length[10]', // Campo 'SenhaUsuario' obrigatório e com no mínimo 6 caracteres
                'EmailUsuario' => 'trim|required|valid_email', // Campo 'EmailUsuario' obrigatório e deve ser um e-mail válido
                'permissao_id' => 'trim|required|integer'        // Campo 'permissao_id' obrigatório e deve ser um número inteiro
            ]);

            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run() || $validation->withRequest($this->request)->run() === false) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {

                $Usuario = $this->request->getPost('Usuario');
                $SenhaUsuario = $this->request->getPost('SenhaUsuario');
                $EmailUsuario = $this->request->getPost('EmailUsuario');
                $permissao_id = $this->request->getPost('permissao_id');

                $permissao = $this->permissaoModel->find($permissao_id);
                $TipoUsuario = 'U';
                $NivelUsuario = '';
                if ($permissao) {
                    $TipoUsuario = substr($permissao['nome'], 0, 1);
                    $NivelUsuario = $permissao['nome'];
                }
                $created_at = date('Y-m-d H:i:s');

                $permissoesPost = $this->request->getPost();
                unset($permissoesPost['Usuario'], $permissoesPost['SenhaUsuario'], $permissoesPost['EmailUsuario'], $permissoesPost['permissao_id'], $permissoesPost['marcarTodos']);
                $permissoesSerialized = serialize($permissoesPost);
                // Preparando dados para inserção
                $array = [
                    'Usuario' => $Usuario,
                    'SenhaUsuario' => $SenhaUsuario,
                    'EmailUsuario' => $EmailUsuario,
                    'permissao_id' => $permissao_id,
                    'TipoUsuario' => $TipoUsuario,
                    'NivelUsuario' => $NivelUsuario,
                    'created_at' => $created_at,
                ];
                if (!empty($permissoesSerialized)) {
                    $array['permissoes'] = $permissoesSerialized;
                }
                // Adicionando permissão ao banco de dados
                if ($this->userModel->insert($array)) {
                    session()->setFlashdata('success', 'Usuário adicionado com sucesso!');
                    log_message('info', 'Adicionou um usuário');
                    return redirect()->to(site_url('usuarios/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        return view(TEMPLATE . '/usuarios/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eUsuario')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar usuário.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['telas'] = $this->telas;

        $data['custom_error'] = '';

        $data['user'] = $this->userModel->find($id);

        $data['permissoes'] = $this->permissaoModel->findAll();

        // Desserializar permissões salvas no banco de dados
        if (!empty($data['user']->permissoes)) {
            $data['permission'] = $this->getPermissions($data['user']->permissoes);
        } else {
            $data['permission'] = []; // Se não houver permissões, iniciar array vazio
        }
        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'Usuario' => 'trim|required', // Campo 'Usuario' obrigatório e sem espaços em branco no início e no final
                'SenhaUsuario' => 'trim|permit_empty|min_length[6]|max_length[10]', // Campo 'SenhaUsuario' obrigatório e com no mínimo 6 caracteres
                'EmailUsuario' => 'trim|required|valid_email', // Campo 'EmailUsuario' obrigatório e deve ser um e-mail válido
                'permissao_id' => 'trim|required|integer'        // Campo 'permissao_id' obrigatório e deve ser um número inteiro
            ]);

            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {

                $Usuario = $this->request->getPost('Usuario');
                $SenhaUsuario = $this->request->getPost('SenhaUsuario');
                $EmailUsuario = $this->request->getPost('EmailUsuario');
                $permissao_id = $this->request->getPost('permissao_id');

                $permissao = $this->permissaoModel->find($permissao_id);
                $TipoUsuario = 'U';
                $NivelUsuario = '';
                if ($permissao) {
                    $TipoUsuario = substr($permissao['nome'], 0, 1);
                    $NivelUsuario = $permissao['nome'];
                }

                $permissoesPost = $this->request->getPost();
                unset($permissoesPost['Usuario'], $permissoesPost['SenhaUsuario'], $permissoesPost['EmailUsuario'], $permissoesPost['permissao_id'], $permissoesPost['marcarTodos']);
                $permissoesSerialized = serialize($permissoesPost);

                // Preparando dados para inserção
                $array = [
                    'Usuario' => $Usuario,
                    'EmailUsuario' => $EmailUsuario,
                    'NivelUsuario' => $NivelUsuario,
                    'permissao_id' => $permissao_id,
                    'TipoUsuario' => $TipoUsuario,
                ];
                if (!empty($SenhaUsuario)) {
                    $array['SenhaUsuario'] = $SenhaUsuario;
                }
                if (!empty($permissoesSerialized)) {
                    $array['permissoes'] = $permissoesSerialized;
                }
                // Adicionando permissão ao banco de dados
                if ($this->userModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Usuário alterado com sucesso!');
                    log_message('info', 'Alterou um usuário');
                    return redirect()->to(site_url('usuarios/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }
        // Carregando view
        return view(TEMPLATE . '/usuarios/edit', $data);
    }

    public function delete() {
        if (!hasPermission($this->userPermissions, 'dUsuario')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar usuário.');
            return redirect()->to(site_url('dashboard'));
        }
        $request = service('request');
        $id = $this->request->getPost('id');
        // Verifica se o usuário existe
        $user = $this->userModel->find($id);

        if ($user) {
            if ($this->userModel->delete($id)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Usuário deletado com sucesso.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar o usuário.'], 400);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Usuário não encontrado.'], 401);
        }
    }

    public function getPermissions($permissoes) {
        // Verifica se a permissao existe
        if ($permissoes) {
            return unserialize($permissoes);
        }
        // Retorna falso caso o usuário não exista ou não tenha permissões
        return false;
    }
}
