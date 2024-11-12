<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Compras extends BaseController {

    protected $session;
    protected $userPermissions;
    protected $userLogadoId;
    protected $userModel;
    protected $bancoModel;
    protected $compraModel;
    protected $associadoModel;
    protected $empresaModel;
    protected $centrodecustoModel;
    protected $fornecedorModel;
    protected $produtoModel;
    protected $compraprodutoModel;
    protected $compraparcelaModel;

    public function __construct() {
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();

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

        $this->compraModel = new \App\Models\Compra();
        $this->associadoModel = new \App\Models\Associado();
        $this->bancoModel = new \App\Models\Banco();
        $this->centrodecustoModel = new \App\Models\Centrodecusto();
        $this->empresaModel = new \App\Models\Empresa();
        $this->fornecedorModel = new \App\Models\Fornecedor();
        $this->produtoModel = new \App\Models\Produto();
        $this->compraprodutoModel = new \App\Models\Compraproduto();
        $this->compraparcelaModel = new \App\Models\Compraparcela();
    }

    public function index() {
        if (!hasPermission($this->userPermissions, 'lCompra')) {
            session()->setFlashdata('error', 'Você não tem permissão para listar compras.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['userPermissions'] = $this->userPermissions;
        return view(TEMPLATE . '/compras/index', $data);
    }

    private function fetchTableData($length, $start, $orderColumnName, $orderDirection,$search=null) {
        $data = $this->compraModel->getData($length, $start, $orderColumnName, $orderDirection,$search);
        $totalRecords = $this->compraModel->getTotalRecords();
        $filteredRecords = $this->compraModel->getFilteredRecords($search);

        
        return [
            'data' => array_map(function ($row) {
                $button_edit = hasPermission($this->userPermissions, 'eCompra') ? '<a href="' . base_url('compras/produtos/' . $row['CodigoCompra']) . '" class="btn btn-link text-info">
                                    <i class="fas fa-shopping-cart"></i> Produtos
                                </a>
                                <a href="' . base_url('compras/parcelas/' . $row['CodigoCompra']) . '" class="btn btn-link text-warning">
                                    <i class="fas fa-dollar-sign"></i> Parcelas
                                </a><a href="' . base_url('compras/edit/' . $row['CodigoCompra']) . '" class="btn btn-link text-primary"><i class="fas fa-edit"></i> Editar</a>' : '';
                $button_delete = hasPermission($this->userPermissions, 'dCompra') ? '<a href="#" class="btn btn-link text-danger delete-btn" data-id="' . $row['CodigoCompra'] . '"><i class="fas fa-trash"></i> Excluir</a>' : '';
                $nomeFornecedor = $row['NomeForn'];//'N/A';
                /*if (isset($row['CodigoForn'])) {
                    $forn = $this->fornecedorModel->find($row['CodigoForn']);
                    if ($forn) {
                        $nomeFornecedor = $forn['NomeForn'];
                    }
                }*/
                $nomeEmpresa = $row['NomeEmpresa'];//'N/A';
                /*if (isset($row['CodigoEmpresa'])) {
                    $emp = $this->empresaModel->find($row['CodigoEmpresa']);
                    if ($emp) { 
                        $nomeEmpresa = $emp['NomeEmpresa'];
                    }
                }*/
                return [
            $row['CodigoCompra'],
            $nomeFornecedor,
            $nomeEmpresa,
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
        //echo $search;

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
        if (!hasPermission($this->userPermissions, 'aCompra')) {
            session()->setFlashdata('error', 'Você não tem permissão para adicionar compra.');
            return redirect()->to(site_url('dashboard'));
        }
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'CodigoForn' => 'trim'
            ]);

            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {
                // Coletando os dados do formulário
                // Preparando dados para inserção

                $array = $this->request->getPost();

                // Adicionando permissão ao banco de dados
                if ($this->compraModel->insert($array)) {
                    session()->setFlashdata('success', 'Compra adicionada com sucesso!');
                    log_message('info', 'Adicionou uma compra');
                    return redirect()->to(site_url('compras/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }

        $data['bancos'] = $this->bancoModel->findAll();
        $data['centros'] = $this->centrodecustoModel->findAll();
        $data['empresas'] = $this->empresaModel->orderBy('NomeEmpresa', 'asc')->findAll();
        $data['fornecedores'] = $this->fornecedorModel->orderBy('NomeForn', 'asc')->findAll();
        // Carregando view
        return view(TEMPLATE . '/compras/create', $data);
    }

    public function edit($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eCompra')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar compra.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';
        $data['compra'] = $this->compraModel->find($id);

        if (!empty($_POST)) {
            // Definindo regras de validação
            $validation = \Config\Services::validation();
            $validation->setRules([
                'CodigoForn' => 'trim'
            ]);
            // Checando se a validação falhou
            if (!$validation->withRequest($this->request)->run()) {
                $data['custom_error'] = $validation->getErrors() ? '<div class="form_error">' . implode('<br>', $validation->getErrors()) . '</div>' : false;
                session()->setFlashdata('error', $data['custom_error']);
            } else {

                $array = $this->request->getPost();

                // Adicionando permissão ao banco de dados
                if ($this->compraModel->update($id, $array)) {
                    session()->setFlashdata('success', 'Compra alterada com sucesso!');
                    log_message('info', 'Alterou uma compra');
                    return redirect()->to(site_url('compras/index'));
                } else {
                    $data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                    session()->setFlashdata('error', $data['custom_error']);
                }
            }
        }

        $data['bancos'] = $this->bancoModel->findAll();
        $data['centros'] = $this->centrodecustoModel->findAll();
        $data['empresas'] = $this->empresaModel->findAll();
        $data['fornecedores'] = $this->fornecedorModel->findAll();
        // Carregando view
        return view(TEMPLATE . '/compras/edit', $data);
    }

    //deletar compra
    public function delete() {
        if (!hasPermission($this->userPermissions, 'dCompra')) {
            session()->setFlashdata('error', 'Você não tem permissão para deletar compra.');
            return redirect()->to(site_url('dashboard'));
        }

        $id = $this->request->getPost('id');
        $compra = $this->compraModel->find($id);

        if ($compra) {
            // Inicia uma transação para garantir que todas as operações sejam executadas com sucesso
            $this->db->transStart();
            // Remover produtos associados à compra
            $this->compraprodutoModel->where('CodigoCompra', $id)->delete();
            // Remover parcelas associadas à compra
            $this->compraparcelaModel->where('CodigoCompra', $id)->delete();
            // Remover a compra
            $this->compraModel->delete($id);
            // Finaliza a transação
            $this->db->transComplete();
            if ($this->db->transStatus() === FALSE) {
                // Se houver algum erro na transação, retornar uma mensagem de erro
                return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao deletar a compra e seus itens associados.'], 400);
            }
            // Se tudo correr bem, retornar uma mensagem de sucesso
            return $this->response->setJSON(['status' => 'success', 'message' => 'Compra e itens associados deletados com sucesso.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Compra não encontrada.'], 400);
        }
    }

    /* Gerenciamento de produtos */

    public function produtos($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eCompra')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar compra.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';
        $data['compra'] = $this->compraModel->find($id);

        $data['bancos'] = $this->bancoModel->findAll();
        $data['centros'] = $this->centrodecustoModel->findAll();
        $data['empresas'] = $this->empresaModel->findAll();
        $data['fornecedores'] = $this->fornecedorModel->findAll();
        $data['produtos'] = $this->produtoModel->orderBy('DescricaoProduto', 'asc')->findAll();
        // Carregando view
        return view(TEMPLATE . '/compras/produtos', $data);
    }

    public function listarProdutos($CodigoCompra) {
        $produtos = $this->compraprodutoModel->getProdutosByCompraJoin($CodigoCompra);
        return $this->response->setJSON($produtos);
    }

    // No seu controller
    public function addProdutoCompra($id = false) {

        $data = [
            'CodigoCompra' => $id,
            'CodigoProduto' => $this->request->getPost('Produtos'),
            'ValorUnitario' => $this->request->getPost('ValorUnitario'),
            'Quantidade' => $this->request->getPost('Quantidade'),
            'ValorTotal' => $this->request->getPost('ValorCompra')
        ];
        if ($this->compraprodutoModel->addProdutoCompra($data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Produto adicionado com sucesso']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Erro ao adicionar produto']);
        }
    }

    public function getProdutoCompra($idProduto) {


        // Buscar o produto pelo ID
        $produto = $this->compraprodutoModel->find($idProduto);

        if ($produto) {
            return $this->response->setJSON($produto);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Produto não encontrado.']);
        }
    }

    public function updateProdutoCompra($idProduto) {

        // Dados do formulário enviados via AJAX
        $data = [
            'CodigoProduto' => $this->request->getPost('CodigoProduto'),
            'ValorUnitario' => $this->request->getPost('ValorUnitario'),
            'Quantidade' => $this->request->getPost('Quantidade'),
            'ValorTotal' => $this->request->getPost('ValorTotal')
        ];

        // Atualizar o produto
        if ($this->compraprodutoModel->update($idProduto, $data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Produto atualizado com sucesso!']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao atualizar o produto.']);
        }
    }

    public function removeProdutoCompra($idProduto) {
        // Excluir o produto usando o ID
        if ($this->compraprodutoModel->delete($idProduto)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Produto removido com sucesso!']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao remover o produto.']);
        }
    }

    /* Gerenciamento de produtos */

    /* Gerenciamento de parcelas */

    public function parcelas($id = false) {
        // Permissões do usuário logado
        if (!hasPermission($this->userPermissions, 'eCompra')) {
            session()->setFlashdata('error', 'Você não tem permissão para editar compra.');
            return redirect()->to(site_url('dashboard'));
        }
        $data['id'] = $id;
        $data['LimiteMaximoParcelasDisponiveis'] = 60;
        helper(['form', 'url', 'permission']);
        $data['custom_error'] = '';
        $data['compra'] = $this->compraModel->find($id);

        $data['bancos'] = $this->bancoModel->findAll();
        $data['centros'] = $this->centrodecustoModel->findAll();
        $data['empresas'] = $this->empresaModel->findAll();
        $data['fornecedor'] = null;
        if (isset($data['compra']['CodigoForn'])) {
            $data['fornecedor'] = $this->fornecedorModel->find($data['compra']['CodigoForn']);
        }
        // Carregando view
        return view(TEMPLATE . '/compras/parcelas', $data);
    }

    public function listarParcelas($CodigoCompra) {
        $produtos = $this->compraparcelaModel->getParcelaByCompraId($CodigoCompra);
        return $this->response->setJSON($produtos);
    }

    // No seu controller
    public function addParcelaCompraOld($id = false) {
        $QtdParcela = $this->request->getPost('qtdParcela');
        $DataParcela = $this->request->getPost('dataParcela');
        $ValorParcela = $this->request->getPost('valorParcela');

        $dataVencimento = new \DateTime($DataParcela);

        if ($QtdParcela) {
            for ($i = 0; $i < $QtdParcela; $i++) {
                // Verifica se já existe uma parcela com a mesma data
                $parcelaExistente = $this->compraparcelaModel->where('DataParcela', $dataVencimento->format('Y-m-d'))->first();
                if ($parcelaExistente) {
                    // Se a parcela com a data já existir, pula para a próxima parcela
                    continue;
                }
                $data = [
                    'CodigoCompra' => $id,
                    'DataParcela' => $dataVencimento->format('Y-m-d'),
                    'ValorParcela' => $ValorParcela
                ];
                // Insere no banco de dados
                $idParcela = $this->compraparcelaModel->addParcelaCompra($data);
                // Incrementa o mês para a próxima parcela
                $dataVencimento->modify('+1 month');
                if ($idParcela) {
                    $dadosCompraParcela = [
                        'CodigoParcela' => $idParcela
                    ];
                    // Atualiza a tabela compraparcela (supondo que você tenha um campo que identifique a compra para atualização)
                    $this->compraparcelaModel->updateParcelaCompra($idParcela, $dadosCompraParcela);
                }
            }
            return $this->response->setJSON(['success' => true]);
        }
    }

    public function addParcelaCompra($id = false) {
        // Recebe os dados do formulário (quantidade, data inicial, valor)
        $QtdParcela = $this->request->getPost('qtdParcela');
        $DataParcela = $this->request->getPost('dataParcela');
        $ValorParcela = $this->request->getPost('valorParcela');

        // Converte a data de vencimento inicial para objeto DateTime
        $dataVencimento = new \DateTime($DataParcela);

        // Verifica se a quantidade de parcelas foi passada
        if ($QtdParcela) {
            $parcelasCadastradas = 0; // Contador de parcelas cadastradas

            for ($i = 0; $i < $QtdParcela; $i++) {
                // Verifica se já existe uma parcela com a mesma data
                $parcelaExistente = $this->compraparcelaModel
                        ->where('CodigoCompra', $id) // Garante que a verificação é para a compra correta
                        ->where('DataParcela', $dataVencimento->format('Y-m-d'))
                        ->first();

                if ($parcelaExistente) {
                    // Se a parcela com a data já existir, pula para a próxima parcela
                    $dataVencimento->modify('+1 month');
                    continue;
                }

                // Prepara os dados para a nova parcela
                $data = [
                    'CodigoCompra' => $id,
                    'DataParcela' => $dataVencimento->format('Y-m-d'),
                    'ValorParcela' => $ValorParcela
                ];

                // Insere no banco de dados a nova parcela
                $idParcela = $this->compraparcelaModel->addParcelaCompra($data);

                if ($idParcela) {
                    // Atualiza o campo CodigoParcela com o último ID registrado
                    $dadosCompraParcela = [
                        'CodigoParcela' => $idParcela
                    ];

                    // Atualiza a parcela no banco
                    $this->compraparcelaModel->updateParcelaCompra($idParcela, $dadosCompraParcela);

                    // Incrementa o contador de parcelas cadastradas
                    $parcelasCadastradas++;
                }

                // Incrementa o mês para a próxima parcela
                $dataVencimento->modify('+1 month');
            }

            // Retorna uma resposta em JSON com o número de parcelas cadastradas
            return $this->response->setJSON([
                        'success' => true,
                        'mensagem' => "$parcelasCadastradas parcelas foram cadastradas com sucesso."
            ]);
        }

        // Caso não tenha parcelas para cadastrar
        return $this->response->setJSON(['success' => false, 'mensagem' => 'Nenhuma parcela cadastrada.']);
    }

    public function getParcelaCompra($idProduto) {
        // Buscar o produto pelo ID
        $produto = $this->compraparcelaModel->find($idProduto);

        if ($produto) {
            return $this->response->setJSON($produto);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parcela não encontrada.']);
        }
    }

    public function updateParcelaCompra($idProduto) {
        // Dados do formulário enviados via AJAX

        $DataParcela = $this->request->getPost('dataParcela');
        $ValorParcela = $this->request->getPost('valorParcela');

        $data = [
            'DataParcela' => $DataParcela,
            'ValorParcela' => $ValorParcela
        ];
        // Atualizar o produto
        if ($this->compraparcelaModel->update($idProduto, $data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Parcela atualizada com sucesso!']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao atualizar a parcela.']);
        }
    }

    public function removeParcelaCompra($idProduto) {
        // Excluir o produto usando o ID
        if ($this->compraparcelaModel->delete($idProduto)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Parcela removida com sucesso!']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Erro ao remover a parcela.']);
        }
    }

    /* Gerenciamento de parcelas */
}
