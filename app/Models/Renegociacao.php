<?php

namespace App\Models;

use CodeIgniter\Model;

class Renegociacao extends Model
{
    protected $table            = 'renegociacao';
    protected $primaryKey       = 'CodigoRenegociacao';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'CodigoRenegociacao',
        'CodigoEmpresa',
        'CodigoAssoc',
        'DataInicial',
        'DataFinal',
        'ValorRenegociacao',
        'ValorRenegociacaoCor',
        'ObsRenegociacao',
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
}
