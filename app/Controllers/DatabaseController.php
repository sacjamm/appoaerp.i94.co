<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;

class DatabaseController extends BaseController {

    protected $forge;
    protected $db;

    public function __construct() {
        $this->forge = \Config\Database::forge();
        $this->db = \Config\Database::connect();
    }

    public function addColumn() {
        $tableName = 'usuario';

        // Primeiro, remova a coluna existente `AUTO_INCREMENT`, se necessário
        $fields = $this->db->getFieldData($tableName);
        foreach ($fields as $field) {
            if ($field->auto_increment) {
                $this->forge->dropColumn($tableName, $field->name);
                break;
            }
        }

        // Adicione a coluna `id` com AUTO_INCREMENT e defina-a como chave primária
        $this->forge->addColumn($tableName, [
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
                'null' => false,
            ],
        ]);

        // Adicione a chave primária
        $this->forge->addPrimaryKey('id');
        $this->forge->modifyTable($tableName);

        // Exibe uma mensagem de sucesso
        echo "Tabela alterada com sucesso!";
    }

    public function drop_primary_key($table, $chave) {
        $columnName = 'CodigoAcompanhamento';
        try {
            //$this->db->query("ALTER TABLE $table MODIFY $columnName INT NOT NULL");
            // Remover a chave primária da tabela, se existir
            //$this->db->query("ALTER TABLE $table DROP PRIMARY KEY");
            $this->db->query("ALTER TABLE $table MODIFY $columnName INT UNSIGNED NOT NULL");
            $this->db->query("ALTER TABLE $table MODIFY $columnName INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY");
            

            // Remover o índice específico, se existir
            //$this->db->query("ALTER TABLE $table DROP INDEX $chave");

            echo "AUTO_INCREMENT removido, chave primária e índice '$chave' removidos com sucesso!";
        } catch (DatabaseException $e) {
            echo "Erro ao remover chave primária ou índice: " . $e->getMessage();
        }
    }
}
