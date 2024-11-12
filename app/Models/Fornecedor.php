<?php

namespace App\Models;

use CodeIgniter\Model;

class Fornecedor extends Model
{
    protected $table            = 'fornecedor';
    protected $primaryKey       = 'CodigoForn';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'CodigoForn',
        
        'NomeForn',
        'CNPJForn',        
        'CICForn',        
        'PISForn',        
        'EnderecoForn',        
        'CodigoBairroForn',        
        'CodigoCidadeForn',        
        'CEPForn',        
        'FoneForn',        
        'EMailForn',        
        'SiteForn',        
        'NomeContato',        
        'CelularContato',        
        'NomeContato2',        
        'CelularContato2',        
        'DataCadastro',        
        'CodigoBancoForn',        
        'AgenciaForn',        
        'ContaForn',        
        'PercINSS',        
        'TipoPagto',        
        'SITUACAO_REGISTRO', 
        'CidadeForn', 
        'BairroForn', 
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
    
    public function getFornecedores($start, $length) {
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
    public function getData($length = 10, $start = 0, $orderColumnName = 'CodigoForn', $orderDirection = 'asc',$search=null) {
        // Inicializa o builder
        $builder = $this->builder();
        
        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('CodigoForn', $search);
            $builder->orLike('NomeForn', $search);
            $builder->orLike('CNPJForn', $search);
            $builder->orLike('CICForn', $search);
            $builder->orLike('EMailForn', $search);
            $builder->orLike('FoneForn', $search);
            $builder->orLike('NomeContato', $search);
            $builder->groupEnd();
        }

        // Verifica se a coluna de ordenação é válida
        if (!in_array($orderColumnName, $this->allowedFields)) {
            $orderColumnName = 'CodigoForn'; // Default
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
            $builder->like('CodigoForn', $search);
            $builder->orLike('NomeForn', $search);
            $builder->orLike('CNPJForn', $search);
            $builder->orLike('CICForn', $search);
            $builder->orLike('EMailForn', $search);
            $builder->orLike('FoneForn', $search);
            $builder->orLike('NomeContato', $search);
            $builder->groupEnd();
        }
        return $builder->countAllResults();
    }
    // Função para contar o total de registros
    public function getTotalRecords() {
        return $this->builder()->countAllResults();
    }
}
