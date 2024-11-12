<?php

namespace App\Models;

use CodeIgniter\Model;

class Associado extends Model {

    protected $table = 'associado';
    protected $primaryKey = 'CodigoAssoc';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'CodigoAssoc',
        'NomeAssoc',
        'CICAssoc',
        'PISAssoc',
        'CRPAssoc',
        'DataNascAssoc',
        'EnderecoAssoc',
        'CodigoBairroAssoc',
        'CodigoCidadeAssoc',
        'CEPAssoc',
        'FoneAssoc',
        'FAXAssoc',
        'CelularAssoc',
        'EMailAssoc',
        'SiteAssoc',
        'EnderecoRemAssoc',
        'CodigoBairroRemAssoc',
        'CodigoCidadeRemAssoc',
        'CEPRemaAssoc',
        'CodigoBancoAssoc',
        'AtivoAssoc',
        'MalaAssoc',
        'DataCadastro',
        'PercINSS',
        'PercDesc',
        'TipoPagamento',
        'TipoEndRemAssoc',
        'RespAcolhimento',
        'USUARIO_REGISTRO',
        'SITUACAO_REGISTRO',
        'BairroAssoc',
        'CidadeAssoc',
        'BairroRemAssoc',
        'CidadeRemAssoc',
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
    public function getData($length = 10, $start = 0, $orderColumnName = 'CodigoAssoc', $orderDirection = 'asc',$search=null) {
        // Inicializa o builder
        $builder = $this->builder();

        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('CodigoAssoc', $search);
            $builder->orLike('NomeAssoc', $search);
            $builder->orLike('CICAssoc', $search);
            $builder->orLike('DataNascAssoc', $search);
            $builder->orLike('CEPAssoc', $search);
            $builder->orLike('EMailAssoc', $search);
            $builder->orLike('CelularAssoc', $search);
            $builder->orLike('TipoPagamento', $search);
            $builder->orLike('TipoEndRemAssoc', $search);
            $builder->orLike('RespAcolhimento', $search);
            $builder->groupEnd();
        }

        // Verifica se a coluna de ordenação é válida
        if (!in_array($orderColumnName, $this->allowedFields)) {
            $orderColumnName = 'CodigoAssoc'; // Default
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
            $builder->like('CodigoAssoc', $search);
            $builder->orLike('NomeAssoc', $search);
            $builder->orLike('CICAssoc', $search);
            $builder->orLike('DataNascAssoc', $search);
            $builder->orLike('CEPAssoc', $search);
            $builder->orLike('EMailAssoc', $search);
            $builder->orLike('CelularAssoc', $search);
            $builder->orLike('TipoPagamento', $search);
            $builder->orLike('TipoEndRemAssoc', $search);
            $builder->orLike('RespAcolhimento', $search);
            $builder->groupEnd();
        }
        return $builder->countAllResults();
    }

    // Função para contar o total de registros
    public function getTotalRecords() {
        return $this->builder()->countAllResults();
    }
}
