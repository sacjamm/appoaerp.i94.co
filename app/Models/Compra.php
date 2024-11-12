<?php

namespace App\Models;

use CodeIgniter\Model;

class Compra extends Model {

    protected $table = 'compra';
    protected $primaryKey = 'CodigoCompra';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'CodigoCompra',
        'TipoCompra',
        'CodigoForn',
        'CodigoAssoc',
        'CodigoCentroCusto',
        'DataCompra',
        'NumeroNotaCompra',
        'ValorTotal',
        'ValorBaseINSS',
        'ValorINSS',
        'ValorCompra',
        'DataInicial',
        'DataFinal',
        'ObservacoesCompra',
        'CodigoSelecionado',
        'CodigoEmpresa',
        'HistoricoCompra',
        'USUARIO_REGISTRO',
        'SITUACAO_REGISTRO',
    ];
    protected bool $allowEmptyInserts = false;
    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    // Função para obter dados com paginação e ordenação
    public function getData($length = 10, $start = 0, $orderColumnName = 'CodigoCompra', $orderDirection = 'asc', $search = null) {
        // Inicializa o builder
        $builder = $this->builder()->select('compra.*, fornecedor.NomeForn, empresa.NomeEmpresa')
                ->join('fornecedor', 'fornecedor.CodigoForn = compra.CodigoForn', 'left')
                ->join('empresa', 'empresa.CodigoEmpresa = compra.CodigoEmpresa', 'left');

        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('compra.CodigoCompra', $search);
            $builder->orLike('compra.TipoCompra', $search);
            $builder->orLike('compra.CodigoForn', $search);
            $builder->orLike('compra.CodigoAssoc', $search);
            $builder->orLike('compra.CodigoCentroCusto', $search);
            $builder->orLike('compra.DataCompra', $search);
            $builder->orLike('compra.NumeroNotaCompra', $search);
            $builder->orLike('compra.ValorTotal', $search);
            $builder->orLike('compra.DataInicial', $search);
            $builder->orLike('compra.ObservacoesCompra', $search);
            $builder->orLike('fornecedor.NomeForn', $search);
            $builder->orLike('empresa.NomeEmpresa', $search);
            $builder->groupEnd();
        }

        // Verifica se a coluna de ordenação é válida
        if (!in_array($orderColumnName, $this->allowedFields) && !in_array($orderColumnName, ['NomeForn', 'NomeEmpresa'])) {
            $orderColumnName = 'CodigoCompra'; // Default
        }

        // Adiciona a ordenação
        $builder->orderBy($orderColumnName, $orderDirection);

        // Retorna os dados paginados
        return $builder->get($length, $start)->getResultArray();
    }

    public function getFilteredRecords($search = null) {
        $builder = $this->builder()->join('fornecedor', 'fornecedor.CodigoForn = compra.CodigoForn', 'left')
                ->join('empresa', 'empresa.CodigoEmpresa = compra.CodigoEmpresa', 'left');
        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('compra.CodigoCompra', $search);
            $builder->orLike('compra.TipoCompra', $search);
            $builder->orLike('compra.CodigoForn', $search);
            $builder->orLike('compra.CodigoAssoc', $search);
            $builder->orLike('compra.CodigoCentroCusto', $search);
            $builder->orLike('compra.DataCompra', $search);
            $builder->orLike('compra.NumeroNotaCompra', $search);
            $builder->orLike('compra.ValorTotal', $search);
            $builder->orLike('compra.DataInicial', $search);
            $builder->orLike('compra.ObservacoesCompra', $search);
            $builder->orLike('fornecedor.NomeForn', $search);
            $builder->orLike('empresa.NomeEmpresa', $search);
            $builder->groupEnd();
        }
        return $builder->countAllResults();
    }

    // Função para contar o total de registros
    public function getTotalRecords() {
        return $this->builder()->countAllResults();
    }
}
