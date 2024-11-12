<?php

namespace App\Models;

use CodeIgniter\Model;

class Auth extends Model {

    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'Usuario',
        'SenhaUsuario',
        'EmailUsuario',
        'permissao_id',
        'TipoUsuario',
        'NivelUsuario',
        'permissoes'
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

    public function verifyUser($email, $senha) {
        return $this->where('Usuario', $email)
                        ->where('SenhaUsuario', ($senha)) // Assumindo que você está usando MD5 para senha
                        ->first();
    }
}
