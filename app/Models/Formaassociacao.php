<?php

namespace App\Models;

use CodeIgniter\Model;

class Formaassociacao extends Model
{
    protected $table            = 'assocforma';
    protected $primaryKey       = 'CodigoAssocForma';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'CodigoAssocForma',
        'NomeAssocForma',
        'TipoPagamentoAssocForma',
        'DiaPagamentoAssocForma',
        'MesPagamentoAssocForma',
        'ValorPagamentoAssocForma',
        'PercDesconto',
        'USUARIO_REGISTRO',
        'SITUACAO_REGISTRO',
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
    
    public function getFormasWithGrupo()
    {
        // Utilize o Query Builder para fazer o LEFT JOIN
        /*return $this->select('produto.*, produtogrupo.NomeProdutoGrupo')
                    ->join('produtogrupo', 'produtogrupo.CodigoProdutoGrupo = produto.CodigoProdutoGrupo', 'left')
                    ->findAll();*/
    }
}
