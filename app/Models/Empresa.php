<?php

namespace App\Models;

use CodeIgniter\Model;

class Empresa extends Model
{
    protected $table            = 'empresa';
    protected $primaryKey       = 'CodigoEmpresa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'CodigoEmpresa',
        'NomeEmpresa',
        'CNPJEmpresa',
        'EnderecoEmpresa',
        'CodigoBairroEmpresa',
        'CodigoCidadeEmpresa',
        'CEPEmpresa',
        'FoneEmpresa',
        'EMailEmpresa',
        'SiteEmpresa',
        'NomeContato',
        'CelularContato',
        'NomeContato2',
        'CelularContato2',
        'DataCadastro',
        'SITUACAO_REGISTRO',
        'NumeroEmpresa',
        'ComplementoEmpresa',
        'BairroEmpresa',
        'CidadeEmpresa',
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = []; 
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    public function getAssociados($start, $length) {
        $builder = $this->builder();
        $totalRecords = $builder->countAllResults(false);

        $builder->limit($length, $start);
        $results = $builder->get()->getResultArray();

        return [
            'total' => $totalRecords,
            'records' => $results
        ];
    }

    // Função para obter dados com paginação e ordenação
    public function getData($length = 10, $start = 0, $orderColumnName = 'CodigoEmpresa', $orderDirection = 'asc',$search=null) {
        // Inicializa o builder
        $builder = $this->builder();
        
        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('NomeEmpresa', $search);
            $builder->orLike('CNPJEmpresa', $search);
            $builder->orLike('EnderecoEmpresa', $search);
            $builder->orLike('EMailEmpresa', $search);
            $builder->orLike('NomeContato', $search);
            $builder->orLike('CelularContato', $search);
            $builder->groupEnd();
        }

        // Verifica se a coluna de ordenação é válida
        if (!in_array($orderColumnName, $this->allowedFields)) {
            $orderColumnName = 'CodigoEmpresa'; // Default
        }

        // Adiciona a ordenação
        $builder->orderBy($orderColumnName, $orderDirection);

        // Retorna os dados paginados
        return $builder->get($length, $start)->getResultArray();
    } 
    
    public function getFilteredRecords($search = null) {
        $builder = $this->builder();
        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('NomeEmpresa', $search);
            $builder->orLike('CNPJEmpresa', $search);
            $builder->orLike('EnderecoEmpresa', $search);
            $builder->orLike('EMailEmpresa', $search);
            $builder->orLike('NomeContato', $search);
            $builder->orLike('CelularContato', $search);
            $builder->groupEnd();
        }
        return $builder->countAllResults();
    }

    // Função para contar o total de registros
    public function getTotalRecords() {
        return $this->builder()->countAllResults();
    }
}
