<?php

namespace App\Models;

use CodeIgniter\Model;

class Compraparcela extends Model
{
    protected $table            = 'compraparcela';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'CodigoCompra',
        'CodigoParcela',
        'DataParcela',
        'ValorParcela',
        'DataCheque',
        'DataChequeComp',
        'DataParcelaPaga',
        'ValorParcelaPaga',
        'FormaPagto',
        'ReciboPagto',
        'SITUACAO_REGISTRO',
        'SITUACAO_REGISTRO1',
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
    
    // Método para adicionar produto na compra
    public function addParcelaCompra($data) {
        // Insere um novo produto na tabela relacionada
        return $this->insert($data);
    }

    // Método para listar produtos de uma compra
    public function getParcelaByCompraId($CodigoCompra) {
        // Recupera todos os produtos relacionados a uma compra específica
        return $this->where('CodigoCompra', $CodigoCompra)->findAll();
    }

    // Método para atualizar um produto na compra (caso seja necessário editar)
    public function updateParcelaCompra($id, $data) {
        return $this->update($id, $data);
    }

    // Método para deletar um produto da compra
    public function deleteParcelaCompra($id) {
        return $this->delete($id);
    }
}
