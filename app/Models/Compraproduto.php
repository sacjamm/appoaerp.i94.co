<?php

namespace App\Models;

use CodeIgniter\Model;

class Compraproduto extends Model
{
    protected $table            = 'compraproduto';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'CodigoCompra',
        'CodigoProduto',
        'Quantidade',
        'ValorUnitario',
        'ValorTotal',
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
    
    // Método para adicionar produto na compra
    public function addProdutoCompra($data) {
        // Insere um novo produto na tabela relacionada
        return $this->insert($data);
    }

    // Método para listar produtos de uma compra
    public function getProdutosByCompraId($CodigoCompra) {
        // Recupera todos os produtos relacionados a uma compra específica
        return $this->where('CodigoCompra', $CodigoCompra)->findAll();
    }
    
    public function getProdutosByCompraJoin($CodigoCompra)
{
    // Realiza o LEFT JOIN entre 'compras_produtos' e 'produtos'
    return $this->select('compraproduto.*, produto.DescricaoProduto')
                ->join('produto', 'produto.CodigoProduto = compraproduto.CodigoProduto', 'left')
                ->where('compraproduto.CodigoCompra', $CodigoCompra)
                ->findAll();
}

    // Método para atualizar um produto na compra (caso seja necessário editar)
    public function updateProdutoCompra($id, $data) {
        return $this->update($id, $data);
    }

    // Método para deletar um produto da compra
    public function deleteProdutoCompra($id) {
        return $this->delete($id);
    }
    
}
